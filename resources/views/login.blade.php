@extends('layouts.master')

@section('title')
    Login
@endsection

@section('content')

    <script src={{asset('js/secrets.js')}}></script>
    <script src={{asset('js/crypto-js.js')}}></script> {{--core crypto library--}}
    <script src={{asset('js/pbkdf2.js')}}></script> {{--pbkdf2 implementation--}}

    <!-- Bootstrap NavBar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="{{URL::to('landing')}}">
            <img src="images/favicon/favicon-32x32.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <span class="menu-collapsed">Vault Password Manager</span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                @if(Auth::User())
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('dashboard')}}">My Vault <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item" style="padding-left: 5px">
                        <button class="btn btn-danger my-2 my-sm-0" onclick="location.href = '{{route('logout')}}'">Logout</button>
                    </li>
                @else
                    <li class="nav-item" style="padding-left: 5px">
                        <button class="btn btn-warning my-2 my-sm-0" onclick="location.href = '{{URL::to('/recover')}}'">Recover</button>
                    </li>
                    <li class="nav-item" style="padding-left: 5px">
                        <button class="btn btn-light my-2 my-sm-0" onclick="location.href = '{{URL::to('/login')}}'">Login</button>
                    </li>
                @endif
            </ul>
        </div>
    </nav><!-- NavBar END -->

    <br><br><br><br><br><br><br>

    <div class="container content">
        <div class="row">
            <div class="col-md-5">
                <h3>Login</h3>
                <form action="{{route('login')}}" method="post">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input class="form-control" type="text" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <button type="submit" class="btn btn-outline-primary pull-right">Submit</button>
                    <input type="hidden" name="_token" value="{{Session::token()}}"> <?php //protection against CSRF by fetching session token?>
                </form>
            </div>

            <div class="col-md-5 offset-md-2">
                <h3>Register</h3>
                <form action="{{route('register')}}" method="post">
                    <div class="form-group"> <?php //add red outline to invalid form fields ?>
                        <label for="email">E-mail</label>
                        <input class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" type="text" name="reg_email" id="reg_email" value="{{Request::old('email')}}"> <?php //maintain old inputs if validation fails ?>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control form-control {{$errors->has('name') ? 'is-invalid' : ''}}" type="text" name="name" id="name" value="{{Request::old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control form-control {{$errors->has('password') ? 'is-invalid' : ''}}" type="password" name="reg_password" id="reg_password" value="">
                    </div>
                    <button type="submit" class="btn btn-outline-primary pull-right">Submit</button>
                    <input type="hidden" name="enc_master_key" value="something" id="enc_master_key">
                    <input type="hidden" name="master_iv" value="something" id="master_iv">
                    <input type="hidden" name="kek_salt" value="something" id="kek_salt">
                    <input type="hidden" name="master_hash" value="something" id="master_hash">
                    <input type="hidden" name="_token" value="{{Session::token()}}"> <?php //protection against CSRF by fetching session token ?>
                </form>
            </div>
        </div>
        <br>
    </div>

    <script>
        //generate a master key on register
        function generateMasterKey(){
            var email = document.getElementById("reg_email").value;
            //generate a key and IV
            var masterKey = secrets.random(512);
            var masterIV = secrets.random(512);
            //get the user-entered password
            var password = document.getElementById("reg_password").value;
            //derive the KEK from the password
            var derivedKey = deriveKey(password);
            console.log('plain password: ' + document.getElementById("reg_password").value);

            //hash master with (hashed) fixed string as salt
            document.getElementById("master_hash").value = pbkdf2(masterKey, CryptoJS.SHA256('masterkey'));

            //hash the entered email address
            document.getElementById("reg_password").value = pbkdf2(password, email);
            console.log("Hashed Password: " + document.getElementById("reg_password").value);

            //encrypt the master key with the derived KEK
            var encryptedMaster = aesEncrypt(masterKey, derivedKey, masterIV);

            //set hidden form values
            document.getElementById("master_iv").value = masterIV;
            document.getElementById("enc_master_key").value = encryptedMaster;

            console.log("Master Key: " + masterKey);
            console.log("KEK: " + derivedKey);
            console.log("Encrypted Master: " + document.getElementById("enc_master_key").value);
            console.log("Master IV: " + document.getElementById("master_iv").value);
        }

        //derive KEK (used to encrypt the master key)
        function deriveKey(password){
            //generate new salt
            //var salt = CryptoJS.lib.WordArray.random(128/8); //this might be causing a problem
            var salt = secrets.random(128);
            console.log('salt: ' + salt);

            //set hidden form value
            document.getElementById("kek_salt").value = salt;
            //derive key from password with PBKDF2
            return pbkdf2(password, salt);
        }

        function aesEncrypt(text, key, iv){
            return CryptoJS.AES.encrypt(text, key, { iv: iv }).toString();
        }

        //hash password client-side before posting
        function pbkdf2(password, salt){
            return CryptoJS.PBKDF2(password, salt, { keySize: 16, iterations: 1000 }).toString(CryptoJS.enc.Hex);
        }

        //events for the reg_password input box
        $("#reg_password").
        on("blur", function () {
            generateMasterKey();
        });
        // on("keydown", function (e) {
        //     generateMasterKey();
        // });

        //events for the login password input box
        $("#password").
        on("blur", function () {
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            document.getElementById("password").value = pbkdf2(password, email);
            console.log(document.getElementById("password").value);
        });
    </script>
@endsection
