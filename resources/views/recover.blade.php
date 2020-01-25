@extends('layouts.master')

@section('title')
    Recover Account
@endsection

@section('content')

    <script src={{asset('js/secrets.js')}}></script>
    <script src={{asset('js/crypto-js.js')}}></script> {{--core crypto library--}}
    <script src={{asset('js/pbkdf2.js')}}></script> {{--pbkdf2 implementation--}}
    <script src={{asset('js/instascan.min.js')}}></script>

    <style>
        video {
            max-width: 40rem;
            width: 100%;
            height: auto;
        }
    </style>

    <!-- Bootstrap NavBar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="{{URL::to('landing')}}">
            <img src="images/favicon/favicon-32x32.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <span class="menu-collapsed">Vault Password Manager</span>
        </a>
    </nav><!-- NavBar END -->

    <br><br><br><br><br>

    <div class="container content">
        <div class="row d-flex justify-content-center" id="videoDiv">
            <video class="video" id="video"></video>
        </div>

        <!-- Modal for viewing and editing a stored password -->
        <div class="container col-8" id="form" style="display: none">
            <form>
                <h5>New Account Password</h5>
                <div class="form-group">
                    <label for="password" class="col-form-label">New Password:</label>
                    <input type="password" class="form-control" id="newPassword" required>
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label">Confirm New Password:</label>
                    <input type="password" class="form-control" id="confirmNewPassword" required>
                </div>
            </form>
            <div class="">
                <button type="button" class="btn btn-outline-secondary" onclick="back()">Back</button>
                <button type="button" class="btn btn-outline-primary" onclick="submitPassword()" id="submitButton">Submit</button>
            </div>
        </div>
        <br><br>
    </div>

    <script>
        //when all codes are read, parse components
        //compute master hash
        //log user in with master hash
        //open success modal
        //force password change
        //update master encryption/kek etc...
        //when proceed is clicked redirect to dashboard

        var readCodes = [];
        var threshold = 2;
        var masterKey = '';
        var kek = '';
        var kekSalt = '';
        var masterHash = '';
        var iv = '';
        var accountSalt = '';
        var masterIV = '';
        var email = '';

        let scanner = new Instascan.Scanner({video: document.getElementById('video')});

        //combine shares & compute master hash
        function reconstruct() {
            //combine shares
            let result = recoverShamir();

            //parse result into separate components
            let token = result.substring(0, 16);
            masterKey = result.substring(16, 144);
            //let masterSalt = result.substring(144, 176);

            masterHash = pbkdf2(masterKey, CryptoJS.SHA256('masterkey'));

            console.log('token: ' + token);
            console.log('masterKey: ' + masterKey);
            console.log('masterHash: ' + masterHash);

            postRecoveryLogin(token, masterHash);
        }

        function checkCodes(){
            if(readCodes.length === threshold){
                reconstruct();
            }
        }

        function recoverShamir(){
            // combine 2 shares:
            let comb = secrets.combine([readCodes[0], readCodes[1]]);
            console.log(comb);
            readCodes = [];

            return comb;
        }

        function submitPassword(user){
            //todo validation
            let newPassword = document.getElementById('newPassword').value;

            //derive kek
            let newKek = pbkdf2(newPassword, kekSalt);
            console.log('newKEK: ' + newKek);
            console.log('KEK salt: ' + kekSalt);
            console.log('IV: ' + masterIV);

            //encrypt master with newly derived kek
            let newEncryptedMaster = aesEncrypt(masterKey, newKek, masterIV);
console.log('newEncMaster: ' + newEncryptedMaster);
console.log('HERE: ' + aesDecrypt(newEncryptedMaster, newKek, masterIV));
            //hash new password
            newPassword = pbkdf2(newPassword, email);

            //post changes
            postChangePassword(newEncryptedMaster, newPassword);
        }

        function back(){
            $('#form').hide();
            $('#video').show();
        }

        //add scan event to the scanner obj
        scanner.addListener('scan', function (content) {
            console.log(content);
            if(!readCodes.includes(content)){
                readCodes.push(content)
            }
            checkCodes();
            console.log(readCodes);
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });

        //ajax request to update the user password and master key encryption
        function postChangePassword(master, password){
            $.ajax({
                method: 'POST',
                url: '{{route('postChangePassword')}}',
                data: {master: master, password: password, _token: '{{Session::token()}}'}
            })
                .done(function (msg) {
                    console.log(msg);

                    //if successful then redirect to dashboard
                    if(msg.success){
                        location.href = '{{url('dashboard')}}';
                    }
                });
        }

        //ajax request to log the user in with the provided master hash
        function postRecoveryLogin(token, hash){
            $.ajax({
                method: 'POST',
                url: '{{route('recoveryLogin')}}',
                data: {token: token, masterHash: hash, _token: '{{Session::token()}}'}
            })
                .done(function (msg) {
                    console.log(msg);

                    //if successful then...
                    if(msg.success){
                        $('#video').hide();
                        $('#form').show();
                        kekSalt = msg.user.kek_salt;
                        masterIV = msg.user.master_iv;
                        email = msg.user.email;
                    }
                });
        }
    </script>

    <script>
        function aesEncrypt(text, key, iv){
            return CryptoJS.AES.encrypt(text, key, { iv: iv }).toString();
        }

        function aesDecrypt(text, key, iv){
            return CryptoJS.AES.decrypt(text, key, { iv: iv, padding: CryptoJS.pad.Pkcs7, mode: CryptoJS.mode.CBC }).toString(CryptoJS.enc.Utf8);
        }

        //hash password client-side before posting
        function pbkdf2(password, salt){
            return CryptoJS.PBKDF2(password, salt, { keySize: 16, iterations: 1000 }).toString(CryptoJS.enc.Hex);
        }
    </script>
@endsection
