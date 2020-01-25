@extends('layouts.master')

@section('title')
    Generate Backup
@endsection

@section('content')

    <script src={{asset('js/secrets.js')}}></script>
    <script src={{asset('js/crypto-js.js')}}></script> {{--core crypto library--}}
    <script src={{asset('js/pbkdf2.js')}}></script> {{--pbkdf2 implementation--}}
    <script src={{asset('js/qrcode.js')}}></script>

    <br>

    <div class="text-center">
        <label for="text">Confirm Password </label>
        <input id="password" type="password" value=""/>
        <button id="verify" type="button" class="btn btn-primary">Submit</button>
    </div>

    <br>

    <div class="container content">
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
        <button type="button" class="btn btn-primary" onclick="location.href='{{url('dashboard')}}'">Continue</button>
    </div>

    <script>
        function generateBackup() {
            //get php vars from user model
            var email = @json($user->email);
            var encMaster = @json($user->master_key);
            var masterIV = @json($user->master_iv);
            var kekSalt = @json($user->kek_salt);
            var token = @json($user->token);

            var password = document.getElementById('password').value;

            var hashedPassword = pbkdf2(document.getElementById('password').value, @json($user->email));

            //derive kek
            var kek = pbkdf2(password, kekSalt);
            console.log('kek: ' + kek);
            console.log('kek salt: ' + kekSalt);

            //decrypt master key
            var masterKey = aesDecrypt(encMaster, kek, masterIV);
            console.log('master: ' + masterKey);
            console.log('master IV: ' + masterIV);

            //generate salt and compute master hash
            var masterSalt = CryptoJS.SHA256('masterkey');
            var masterHash = pbkdf2(masterKey, masterSalt);

            console.log('master salt: ' + masterSalt);
            console.log('master hash: ' + masterHash);

            //write master hash to db
            postMasterHash(masterHash);

            //concat strings to store in QR code
            //var data = token + masterKey + masterSalt;
            let data = token + masterKey;

            //generate QR code backups
            genShamir(data, 3, 2);
            generateCodes(3);
        }

        //onclick ajax request for verifying the user before generating backups
        $('#verify').on('click', function () {
            var hashedPassword = pbkdf2(document.getElementById('password').value, @json($user->email));
            $.ajax({
                method: 'POST',
                url: '{{route('verify')}}',
                data: {password: hashedPassword, _token: '{{Session::token()}}'}
            })
            .done(function (msg) {
                console.log(msg);
                //todo if statement here
                generateBackup();
            });
        });

        //ajax request to post hashed master to db
        function postMasterHash(masterHash){
            $.ajax({
                method: 'POST',
                url: '{{route('postMasterHash')}}',
                data: {masterHash: masterHash, _token: '{{Session::token()}}'}
            })
                .done(function (msg) {
                    console.log(msg);
                });
        }
    </script>

    <script>
        function genShamir(text, fragments, threshold){
            console.log('text: ' + text);
            //text = secrets.str2hex(text); //problems here
            console.log('converted: ' + text);
            // split into 3 shares, with a threshold of 2, text must be hex
            shares = secrets.share(text, fragments, threshold); //needs hex input hence compression or JSON would inflate the size - best solution is to concatenate the 3 existing hex components
            console.log(shares);

            console.log(secrets.combine(shares));

            // for(i=0; i<shares.length; i++){
            //     shares[i] = btoa(shares[i]);
            //     console.log(shares[i]);
            // }
        }

        function createQrCode(divId, text){
            var qrcode = new QRCode(divId, {
                width: 300,
                height: 300,
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

        //hash password or derive key
        function pbkdf2(password, salt){
            return CryptoJS.PBKDF2(password, salt, { keySize: 16, iterations: 1000 }).toString(CryptoJS.enc.Hex);
        }

        function aesDecrypt(text, key, iv){
            return CryptoJS.AES.decrypt(text, key, { iv: iv, padding: CryptoJS.pad.Pkcs7, mode: CryptoJS.mode.CBC }).toString(CryptoJS.enc.Utf8);
        }
    </script>
@endsection
