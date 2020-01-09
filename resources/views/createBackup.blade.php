@extends('layouts.master')

@section('title')
    Generate Backup
@endsection

@section('content')

    <script src={{asset('js/secrets.js')}}></script>
    <script src={{asset('js/crypto-js.js')}}></script> {{--core crypto library--}}
    <script src={{asset('js/pbkdf2.js')}}></script> {{--pbkdf2 implementation--}}
    <script src={{asset('js/qrcode.js')}}></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> {{--load jQuery--}}

    <br>

    <div class="text-center">
        <label for="text">Confirm Password </label>
        <input id="password" type="password" value=""/>
        <button id="verify" type="button" class="btn btn-primary">Submit</button>
    </div>

    <br>

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div>
                <div class="d-flex p-2" id="qrcode0"></div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary">Print</button>
                </div>
            </div>
            <div>
                <div class="d-flex p-2" id="qrcode1"></div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary">Print</button>
                </div>
            </div>
            <div>
                <div class="d-flex p-2" id="qrcode2"></div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary">Print</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateBackup() {
            //get php vars from user model
            var email = @json($user->email);
            var encMaster = @json($user->master_key);
            var masterIV = @json($user->master_iv);
            var kekSalt = @json($user->kek_salt);
            var masterHash = @json($user->master_hash);
            var token = @json($user->token);

            var password = document.getElementById('password').value;

            var hashedPassword = hashPassword(document.getElementById('password').value, @json($user->email));

            //derive kek
            var kek = deriveKey(password, kekSalt);
            console.log('kek: ' + kek);

            //decrypt master key
            var masterKey = aesDecrypt(encMaster, kek, masterIV);
            console.log('master: ' + masterKey);

            //construct json obj to store in QR code
            var data = {
                'token': token,
                'master': masterKey,
                'hash': masterHash
            };
            console.log(JSON.stringify(data));

            //generate QR code backups
            genShamir(JSON.stringify(data), 3, 2);
            generateCodes(3);
        }

        //onclick ajax request for verifying the user before generating backups
        $('#verify').on('click', function () {
            var hashedPassword = hashPassword(document.getElementById('password').value, @json($user->email));
            $.ajax({
                method: 'POST',
                url: '{{ route('verify') }}',
                data: {password: hashedPassword, _token: '{{ Session::token() }}'}
            })
            .done(function (msg) {
                console.log(msg);
                //todo if statement here
                generateBackup();
            });
        });
    </script>

    <script>
        function genShamir(text, fragments, threshold){
            var pw = text;
            console.log(pw);
            // convert the text into a hex string
            var pwHex = secrets.str2hex(pw); // => hex string
            console.log(pwHex);
            // split into 3 shares, with a threshold of 2
            shares = secrets.share(pwHex, fragments, threshold);
            console.log(shares);

            for(i=0; i<shares.length; i++){
                shares[i] = btoa(shares[i]); //todo use compression algo to reduce size of shares
            }
        }

        function createQrCode(divId, text){
            var qrcode = new QRCode(divId, {
                width: 400,
                height: 400,
                correctLevel : QRCode.CorrectLevel.L
            });
            qrcode.makeCode(text);
        }

        function generateCodes(num){
            for(i=0; i<num; i++){
                document.getElementById('qrcode'+i).innerHTML = "";
                createQrCode('qrcode'+i, shares[i]);
            }
        }

        //hash password client-side before posting
        function hashPassword(password, salt){
            return CryptoJS.PBKDF2(password, salt, { keySize: 16, iterations: 1000 }).toString(CryptoJS.enc.Hex);
        }

        //derive KEK (used to decrypt the master key)
        function deriveKey(password, salt){
            //derive key from password with PBKDF2
            return CryptoJS.PBKDF2(password, salt, { keySize: 16, iterations: 1000 }).toString(CryptoJS.enc.Hex);
        }

        function aesDecrypt(text, key, iv){
            return CryptoJS.AES.decrypt(text, key, { iv: iv, padding: CryptoJS.pad.Pkcs7, mode: CryptoJS.mode.CBC }).toString(CryptoJS.enc.Utf8);
        }
    </script>
@endsection
