@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')

    <script src={{asset('js/secrets.js')}}></script>
    <script src={{asset('js/crypto-js.js')}}></script> {{--core crypto library--}}
    <script src={{asset('js/pbkdf2.js')}}></script> {{--pbkdf2 implementation--}}
    <script src={{asset('js/qrcode.js')}}></script>

    <style>
        #body-row {
            margin-left:0;
            margin-right:0;
        }
        #sidebar-container {
            min-height: 100vh;
            background-color: #333;
            padding: 0;
        }

        /* Sidebar sizes when expanded and expanded */
        .sidebar-expanded {
            width: 230px;
        }
        .sidebar-collapsed {
            width: 60px;
        }

        /* Menu item*/
        #sidebar-container .list-group a {
            height: 50px;
            color: white;
        }

        /* Submenu item*/
        #sidebar-container .list-group .sidebar-submenu a {
            height: 45px;
            padding-left: 30px;
        }
        .sidebar-submenu {
            font-size: 0.9rem;
        }

        /* Separators */
        .sidebar-separator-title {
            background-color: #333;
            height: 35px;
        }
        .sidebar-separator {
            background-color: #333;
            height: 25px;
        }
        .logo-separator {
            background-color: #333;
            height: 60px;
        }

        /* Closed submenu icon */
        #sidebar-container .list-group .list-group-item[aria-expanded="false"] .submenu-icon::after {
            content: " \f0d7";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 10px;
        }
        /* Opened submenu icon */
        #sidebar-container .list-group .list-group-item[aria-expanded="true"] .submenu-icon::after {
            content: " \f0da";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 10px;
        }

        .clickableElement {
            cursor: pointer;
            text-decoration : none;
            color : #000000;
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
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" style="padding-left: 5px">
                    <button class="btn btn-warning my-2 my-sm-0" onclick="location.href = '{{route('dashboard')}}'">My Vault</button>
                </li>
                <li class="nav-item" style="padding-left: 5px">
                    <button class="btn btn-danger my-2 my-sm-0" onclick="location.href = '{{route('logout')}}'">Logout</button>
                </li>
            </ul>
        </div>
    </nav><!-- NavBar END -->

    <!-- Bootstrap row -->
    <div class="row content" id="body-row">
        <!-- Sidebar -->
        <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
            <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
            <!-- Bootstrap List Group -->
            <ul class="list-group">
                <!-- Separator with title -->
                <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                    <small>MAIN MENU</small>
                </li>
                <!-- /END Separator -->
                <!-- Menu with submenu -->
                <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center" onclick="toggleContent('dashboardContent')">
                        <span class="fa fa-dashboard fa-fw mr-3"></span>
                        <span class="menu-collapsed">DASHBOARD</span>
                    </div>
                </a>
                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center" onclick="toggleContent('profileContent')">
                        <span class="fa fa-user fa-fw mr-3"></span>
                        <span class="menu-collapsed">PROFILE</span>
                    </div>
                </a>
                <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-qrcode fa-fw mr-3"></span>
                        <span class="menu-collapsed">QR BACKUP</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu content -->
                <div id='submenu3' class="collapse sidebar-submenu">
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="toggleContent('backupContent')">
                        <span class="menu-collapsed">Generate Backup</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="toggleContent('validateQRContent')">
                        <span class="menu-collapsed">Validate QR Code</span>
                    </a>
                </div>
{{--                <!-- Separator with title -->--}}
{{--                <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">--}}
{{--                    <small>OPTIONS</small>--}}
{{--                </li>--}}
{{--                <!-- /END Separator -->--}}
{{--                <li>--}}
{{--                    <a href="#" class="bg-dark list-group-item list-group-item-action">--}}
{{--                        <div class="d-flex w-100 justify-content-start align-items-center">--}}
{{--                            <span class="fa fa-wrench fa-fw mr-3"></span>--}}
{{--                            <span class="menu-collapsed">SETTINGS</span>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <!-- Separator without title -->
                <li class="list-group-item sidebar-separator menu-collapsed"></li>
                <!-- /END Separator -->
                <li>
                    <a href="#submenu4" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-question fa-fw mr-3"></span>
                            <span class="menu-collapsed">HELP</span>
                            <span class="submenu-icon ml-auto"></span>
                        </div>
                    </a>
                    <!-- Submenu content -->
                    <div id='submenu4' class="collapse sidebar-submenu">
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="toggleContent('guideContent')">
                            <span class="menu-collapsed">Guides</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="toggleContent('faqContent')">
                            <span class="menu-collapsed">FAQ</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="toggleContent('aboutContent')">
                            <span class="menu-collapsed">About</span>
                        </a>
                    </div>
                    <a href="#top" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                            <span id="collapse-text" class="menu-collapsed"></span>
                        </div>
                    </a>
                </li>
            </ul><!-- List Group END-->
        </div><!-- sidebar-container END -->

        <!-- Dashboard content -->
        <div class="col p-4" id="dashboardContent">
            <h1 class="display-4 text-center">Password Dashboard</h1>
            <br>
            <div class="d-flex pl-1">
                <button type="button" class="btn btn-success" onclick=openModal('addModal')>Add</button>
            </div>
                <div class="card-deck" id="cardDeck">
                    @foreach($storedPasswords as $storedPassword)
                        <div class="d-flex p-1 pt-3" id="{{$storedPassword->id}}">
                           <div class="card" style="max-width: 18rem; min-width: 18rem;">
                                <div class="card-body">
                                    <div class="clickableElement" onclick="openModal('editModal', ['{{$storedPassword->id}}', '{{$storedPassword->website_url}}', '{{$storedPassword->website_name}}', '{{$storedPassword->email}}', '{{$storedPassword->password}}'])">
                                        <h5 class="card-title ">{{$storedPassword->website_name}} <img src="https://www.google.com/s2/favicons?domain_url={{$storedPassword->website_url}}"></h5>
                                        <p class="card-text">Email:   {{$storedPassword->email}}</p>
                                        <p class="card-text">Encrypted Password:   {{$storedPassword->password}}</p>
                                    </div>
                                    <input type="hidden" name="iv" value="{{$storedPassword->iv}}" id="{{$storedPassword->id}}IV">
                                    <br>
                                    <button class="btn btn-primary" onclick="decryptToClipboard('{{$storedPassword->id}}', '{{$storedPassword->iv}}', '{{$storedPassword->password}}')">Copy to Clipboard</button>
                                    <button class="btn btn-danger" onclick="confirmDeletePassword({{$storedPassword->id}})">Delete</button>
                                </div>
                                <div class="card-footer clickableElement" onclick="openModal('editModal', ['{{$storedPassword->id}}', '{{$storedPassword->website_url}}', '{{$storedPassword->website_name}}', '{{$storedPassword->email}}', '{{$storedPassword->password}}'])">
                                    <small class="text-muted">Last updated {{$storedPassword->updated_at->diffForHumans()}}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>

        <!-- Profile content -->
        <div class="col p-4" id="profileContent" style="display: none">
            <h1 class="display-4 text-center">Profile</h1>
            <br>

        </div>

        <!-- Generate QR content -->
        <div class="col p-4" id="backupContent" style="display: none">
            <h1 class="display-4 text-center">Generate Additional Backups</h1>
            <br>

        </div>

        <!-- Validate QR content -->
        <div class="col p-4" id="validateQRContent" style="display: none">
            <h1 class="display-4 text-center">Validate QR Backup</h1>
            <br>

        </div>

        <!-- Guide content -->
        <div class="col p-4" id="guideContent" style="display: none">
            <h1 class="display-4 text-center">Vault Guide</h1>
            <br>

        </div>

        <!-- FAQ content -->
        <div class="col p-4" id="faqContent" style="display: none">
            <h1 class="display-4 text-center">FAQ</h1>
            <br>

        </div>

        <!-- About content -->
        <div class="col p-4" id="aboutContent" style="display: none">
            <h1 class="display-4 text-center">About Vault</h1>
            <br>

        </div>

        <!-- Modal for confirming account password -->
        <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordModalLabel">Please confirm your Vault password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="password">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-primary" id="confirmPasswordButton" >Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for adding a new password to store -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add a new password to your vault</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Account Name:</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="url" class="col-form-label">URL:</label>
                                <input type="text" class="form-control" id="url">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="email">
                            </div>


                            <label for="password" class="col-form-label">Password:</label>
                            <div class="input-group mb-3" id="">
                                <input type="password" class="form-control" id="passwordToStore">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" id="generateButton" onclick="generatePassword('add')">Generate</button>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="" style="display: none">
                                <input type="text" class="form-control" id="passwordToStore">
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-form-label">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirmPasswordToStore">
                            </div>


{{--                            <div class="form-group">--}}
{{--                                <label for="password" class="col-form-label">Password:</label>--}}
{{--                                <input type="password" class="form-control" id="passwordToStore">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="password" class="col-form-label">Confirm Password:</label>--}}
{{--                                <input type="password" class="form-control" id="confirmPasswordToStore">--}}
{{--                            </div>--}}
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-primary" onclick="postAddPassword()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for confirming a delete -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to remove this password from your vault?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-outline-primary" id="confirm">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for viewing and editing a stored password -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Account Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Account Name:</label>
                                <input type="text" class="form-control" id="editName">
                            </div>
                            <div class="form-group">
                                <label for="url" class="col-form-label">URL:</label>
                                <input type="text" class="form-control" id="editUrl">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="editEmail">
                            </div>
                            <label for="password" class="col-form-label">Password:</label>
                            <div class="input-group mb-3" id="encryptedPasswordInputBox">
                                <input type="text" class="form-control" id="storedPassword" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" id="decryptButton">Decrypt</button>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="decryptedPasswordInputBox" style="display: none">
                                <input type="text" class="form-control" id="decryptedStoredPassword" readonly>
                            </div>
                            <br>
                            <h5>Update Password</h5>


                            <label for="password" class="col-form-label">New Password:</label>
                            <div class="input-group mb-3" id="">
                                <input type="password" class="form-control" id="newPasswordToStore">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" id="generateButton" onclick="generatePassword('edit')">Generate</button>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="decryptedPasswordInputBox" style="display: none">
                                <input type="text" class="form-control" id="newPasswordToStore">
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-form-label">Confirm New Password:</label>
                                <input type="password" class="form-control" id="confirmNewPasswordToStore">
                            </div>


{{--                            <div class="form-group">--}}
{{--                                <label for="password" class="col-form-label">New Password:</label>--}}
{{--                                <input type="password" class="form-control" id="newPasswordToStore">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="password" class="col-form-label">Confirm New Password:</label>--}}
{{--                                <input type="password" class="form-control" id="confirmNewPasswordToStore">--}}
{{--                            </div>--}}
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-primary" id="saveEditButton">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- body-row END -->

    <script>
        var password = '';
        var encMaster = '';
        var masterIV = '';
        var kekSalt = '';
        var kek = '';
        var masterKey = '';

        //open modal if password has been entered otherwise ask for password confirmation
        function openModal(id, data = []){
            if(checkIfPassword()){
                document.getElementById('passwordToStore').value = '';
                document.getElementById('confirmPasswordToStore').value = '';
                document.getElementById('newPasswordToStore').value = '';
                document.getElementById('confirmNewPasswordToStore').value = '';

                toggleModal(id, data);
            }
            else{
                data = data.map(function(x) { return x = '"' + x + '"'; });
                //set onclick event to be the verify password function with the desired modal as a param
                document.getElementById('confirmPasswordButton').setAttribute('onclick', 'verifyPassword(' + '"' + id + '"' + ',' + '[' + data + ']' + ')');
                $('#passwordModal').modal('toggle');
            }
        }

        function toggleModal(id, data = []){
            if(id === 'editModal' && data.length > 0){
                prepareEditModal(data);
            }
            $('#'+id).modal('toggle');
        }

        //set the data values in the modal before toggling
        //data in the form: [id, url, name, email, encryptedPassword]
        function prepareEditModal(data){
            let id = data[0];
            let url = data[1];
            let name = data[2];
            let email = data[3];
            let encryptedPassword = data[4];
            let iv = document.getElementById(id + 'IV').value;

            //set form values
            document.getElementById('editUrl').value = url;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('storedPassword').value = encryptedPassword;

            //set onclick event with data & id
            document.getElementById('saveEditButton').setAttribute('onclick', 'postEditPassword(' + '"' + id + '"' + ')');

            //set decrypt onclick event
            document.getElementById('decryptButton').setAttribute('onclick', 'decryptPassword(' + '"' + iv + '"' + ')');

            $('#encryptedPasswordInputBox').show();
            $('#decryptedPasswordInputBox').hide();
        }

        //decrypt password on the view/edit modal
        function decryptPassword(iv){
            let encryptedPassword = document.getElementById('storedPassword').value;

            //decrypt master key & password
            let masterKey = aesDecrypt(encMaster, kek, masterIV);
            let decryptedPassword = aesDecrypt(encryptedPassword, masterKey, iv);
console.log('kek: ' + kek);
console.log('encPass ' + encryptedPassword);
console.log('master ' + masterKey);
console.log('pass ' + decryptedPassword);
            document.getElementById('decryptedStoredPassword').value = decryptedPassword;
            $('#encryptedPasswordInputBox').hide();
            $('#decryptedPasswordInputBox').show();
        }

        function decryptToClipboard(id, iv, encPassword) {
            let data = [id, iv, encPassword];

            data = data.map(function(x) { return x = '"' + x + '"'; });

            //if password has already been verified, decrypt and copy to clipboard
            if (checkIfPassword()){
                //decrypt master key & password
                let masterKey = aesDecrypt(encMaster, kek, masterIV);
                let decryptedPassword = aesDecrypt(encPassword, masterKey, iv);

                copyToClipboard(decryptedPassword);
            }
            else{
                //set onclick event to be the verify password function with the desired modal param as a 'special case'
                document.getElementById('confirmPasswordButton').setAttribute('onclick', 'verifyPassword(' + '"clipboard"' + ',' + '[' + data + ']' + ')');

                toggleModal('passwordModal');
            }
        }

        //copy given decrypted password to the clipboard
        function copyToClipboard(text){
            var temp = document.createElement("textarea");
            // to avoid breaking origin page when copying more words
            // cant copy when adding below this code
            // temp.style.display = 'none'
            document.body.appendChild(temp);
            //Be careful if you use textarea. setAttribute('value', value), which works with "input" does not work with "textarea"
            temp.value = text;
            temp.select();
            document.execCommand("copy");
            document.body.removeChild(temp);

            notify('Copied to clipboard', 'success');
        }

        function generatePassword(modal){
            let password = secrets.random(64);

            if(modal === 'edit'){
                document.getElementById('newPasswordToStore').value = password;
                document.getElementById('confirmNewPasswordToStore').value = password;
            }
            else if(modal === 'add'){
                document.getElementById('passwordToStore').value = password;
                document.getElementById('confirmPasswordToStore').value = password;
            }

        }

        //check if the user has entered their password or not
        function checkIfPassword(){
            if(password){ return true; }
            else{ return false; }
        }

        //ajax request to verify a password to the logged in user
        function verifyPassword(desiredModal, data = []){
            var hashedPassword = pbkdf2(document.getElementById('password').value, @json($user->email));

            $.ajax({
                method: 'POST',
                url: '{{route('verify')}}',
                data: {password: hashedPassword, _token: '{{Session::token()}}'}
            })
                .done(function (msg) {
                    console.log(msg);

                    //if successful then get crypto components and derive the KEK
                    if(msg.success){
                        password = document.getElementById('password').value;
                        encMaster = @json($user->master_key);
                        masterIV = @json($user->master_iv);
                        kekSalt = @json($user->kek_salt);
                        kek = pbkdf2(password, kekSalt);
                        //close password modal & open the requested one
                        toggleModal('passwordModal');

                        //if copying to clipboard else open requested modal
                        if(desiredModal === 'clipboard') {
                            decryptToClipboard(data[0], data[1], data[2]);
                        }
                        else{
                            data = data.map(String);
                            toggleModal(desiredModal, data);
                        }
                    }
                    else{ //if unsuccessful, display error
                        notify(msg.msg, 'error');
                    }

                    document.getElementById('password').value = '';
                    toggleLoading();
                });

            toggleLoading();
        }

        function toggleContent(id){
            hideDiv('dashboardContent');
            hideDiv('profileContent');
            hideDiv('backupContent');
            hideDiv('validateQRContent');
            hideDiv('guideContent');
            hideDiv('faqContent');
            hideDiv('aboutContent');
            showDiv(id);
            console.log('toggle fired');
        }

        function confirmDeletePassword(id){
            //add delete event to confirm button
            document.getElementById('confirm').setAttribute('onclick', 'postDeletePassword(' + id + ')');
            toggleModal('deleteModal');
        }

        function postAddPassword(){
            //todo validation
            //decrypt master key
            masterKey = aesDecrypt(encMaster, kek, masterIV);

            var passwordIV = secrets.random(512);
            var passwordToStore = document.getElementById('passwordToStore').value;
            //encrypt the password with the master key
            var encryptedPassword = aesEncrypt(passwordToStore, masterKey, passwordIV);

            //get form values
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var url = document.getElementById('url').value;

            //clear form values
            document.getElementById('passwordToStore').value = '';
            document.getElementById('confirmPasswordToStore').value = '';

            $.ajax({
                method: 'POST',
                url: '{{route('postAddPassword')}}',
                data: {password: encryptedPassword, iv: passwordIV, email: email, name: name, url: url, _token: '{{Session::token()}}'}
            })
                .done(function (msg) {
                    console.log(msg);

                    if(msg.success){
                        toggleModal('addModal');

                        let favicon = 'https://www.google.com/s2/favicons?domain_url=' + url;
                        let data = [msg.id, url, name, email, encryptedPassword];
                        data = data.map(function(x) { return x = "'" + x + "'"; });

                        $('#cardDeck').append(
                            '                        <div class="d-flex p-1 pt-3" id=' + msg.id + '>\n' +
                            '                            <div class="card" style="max-width: 18rem; min-width: 18rem;">\n' +
                            '                                <div class="card-body">\n' +
                            '                                   <div class="clickableElement" onclick="openModal(\'editModal\',' + '[' + data + ']' + ')">\n' +
                            '                                       <h5 class="card-title">' + name + ' <img src=' + favicon + '></h5>\n' +
                            '                                       <p class="card-text">Email: ' + email + '</p>\n' +
                            '                                       <p class="card-text">Encrypted Password: ' + encryptedPassword + '</p>\n' +
                            '                                   </div>\n' +
                            '                               <input type="hidden" name="iv" value="' + passwordIV + '" id="' + msg.id + 'IV' + '">\n' +
                            '                               <br>\n' +
                            '                                       <button class="btn btn-primary" onclick="decryptToClipboard(\'editModal\',' + "'" + passwordIV + "'" + ',' + "'" + encryptedPassword + "'" + ')">Copy to Clipboard</button>\n' +
                            '                                       <button class="btn btn-danger" onclick=confirmDeletePassword(' + msg.id + ')>Delete</button>\n' +
                            '                               </div>\n' +
                            '                                <div class="card-footer clickableElement" onclick="openModal(\'editModal\',' + '[' + data + ']' + ')">\n' +
                            '                                    <small class="text-muted">Last updated just now</small>\n' +
                            '                                </div>\n' +
                            '                            </div>\n' +
                            '                        </div>'
                        );

                        notify('Password Added', 'success');

                        //clear form values
                        document.getElementById('name').value = '';
                        document.getElementById('url').value = '';
                        document.getElementById('email').value = '';
                        document.getElementById('passwordToStore').value = '';
                        document.getElementById('confirmPasswordToStore').value = '';
                    }
                    else{ //if unsuccessful, display error
                        notify(msg.msg, 'error');
                    }
                    toggleLoading();
                });
            toggleLoading();
        }

        function postDeletePassword(id){
            $.ajax({
                method: 'POST',
                url: '{{route('postDeletePassword')}}',
                data: {id: id, _token: '{{Session::token()}}'}
            })
                .done(function (msg) {
                    console.log(msg);

                    //if successful then remove the associated html
                    if(msg.success){
                        $('#'+id).remove();
                        toggleModal('deleteModal');
                        notify('Password Deleted', 'success');
                    }
                    else{ //if unsuccessful, display error
                        notify(msg.msg, 'error');
                    }
                    toggleLoading();
                });
            toggleLoading();
        }

        function postEditPassword(id){
            //collect form values
            let name = document.getElementById('editName').value;
            let url = document.getElementById('editUrl').value;
            let email = document.getElementById('editEmail').value;
            let newPassword = document.getElementById('newPasswordToStore').value;
            let confirmNewPassword = document.getElementById('confirmNewPasswordToStore').value;
            let newEncryptedPassword = document.getElementById('storedPassword').value;
            let iv = '';
            var data = {};

            //if password is changed
            if(newPassword || confirmNewPassword){
                if(newPassword === confirmNewPassword){
                    //decrypt master key
                    let masterKey = aesDecrypt(encMaster, kek, masterIV);
                    iv = secrets.random(512);
                    //encrypt updated password with master key
                    newEncryptedPassword = aesEncrypt(newPassword, masterKey, iv);
                    data = {id: id, name: name, url: url, email: email, newPassword: newEncryptedPassword, iv: iv, _token: '{{Session::token()}}'};
                }
                else {
                    data = {id: id, name: name, url: url, email: email, _token: '{{Session::token()}}'};
                    iv = document.getElementById(id+'IV').value;

                    //todo error message
                }

                //document.getElementById('storedPassword').value = newEncryptedPassword;
                document.getElementById('newPasswordToStore').value = '';
                document.getElementById('confirmNewPasswordToStore').value ='';
            }

            $.ajax({
                method: 'POST',
                url: '{{route('postEditPassword')}}',
                data: {id: id, name: name, url: url, email: email, newPassword: data.newPassword, iv: data.iv, _token: '{{Session::token()}}'}
            })
                .done(function (msg) {
                    console.log(msg);

                    if(msg.success){
                        let favicon = 'https://www.google.com/s2/favicons?domain_url=' + url;
                        let data = [id, url, name, email, newEncryptedPassword];
                        data = data.map(function(x) { return x = "'" + x + "'"; });

                        iv = iv ? iv : document.getElementById(id+'IV').value;

                        //remove old password html & replace with the updated version
                        $('#'+id).remove();
                        $('#cardDeck').append(
                            '                        <div class="d-flex p-1 pt-3" id=' + id + '>\n' +
                            '                            <div class="card" style="max-width: 18rem; min-width: 18rem;">\n' +
                            '                                <div class="card-body">\n' +
                            '                                   <div class="clickableElement" onclick="openModal(\'editModal\',' + '[' + data + ']' + ')">\n' +
                            '                                       <h5 class="card-title">' + name + ' <img src=' + favicon + '></h5>\n' +
                            '                                       <p class="card-text">Email: ' + email + '</p>\n' +
                            '                                       <p class="card-text">Encrypted Password: ' + newEncryptedPassword + '</p>\n' +
                            '                                   </div>\n' +
                            '                               <input type="hidden" name="iv" value="' + iv + '" id="' + id + 'IV' + '">\n' +
                            '                               <br>\n' +
                            '                                       <button class="btn btn-primary" onclick="decryptToClipboard(\'editModal\',' + "'" + iv + "'" + ',' + "'" + newEncryptedPassword + "'" + ')">Copy to Clipboard</button>\n' +
                            '                                       <button class="btn btn-danger" onclick=confirmDeletePassword(' + id + ')>Delete</button>\n' +
                            '                               </div>\n' +
                            '                                <div class="card-footer clickableElement" onclick="openModal(\'editModal\',' + '[' + data + ']' + ')">\n' +
                            '                                    <small class="text-muted">Last updated just now</small>\n' +
                            '                                </div>\n' +
                            '                            </div>\n' +
                            '                        </div>'
                        );

                        toggleModal('editModal');
                        notify('Password Updated', 'success');
                    }
                    else{ //if unsuccessful, display error
                        notify(msg.msg, 'error');
                    }
                    toggleLoading();
                });
            toggleLoading();
        }

        //hash password or derive key
        function pbkdf2(password, salt){
            return CryptoJS.PBKDF2(password, salt, { keySize: 16, iterations: 1000 }).toString(CryptoJS.enc.Hex);
        }

        function aesEncrypt(text, key, iv){
            return CryptoJS.AES.encrypt(text, key, { iv: iv }).toString();
        }

        function aesDecrypt(text, key, iv){
            return CryptoJS.AES.decrypt(text, key, { iv: iv, padding: CryptoJS.pad.Pkcs7, mode: CryptoJS.mode.CBC }).toString(CryptoJS.enc.Utf8);
        }
    </script>

    <script>
        // Hide submenus
        $('#body-row .collapse').collapse('hide');

        // Collapse/Expand icon
        $('#collapse-icon').addClass('fa-angle-double-left');

        // Collapse click
        $('[data-toggle=sidebar-colapse]').click(function() {
            SidebarCollapse();
        });

        function SidebarCollapse () {
            $('.menu-collapsed').toggleClass('d-none');
            $('.sidebar-submenu').toggleClass('d-none');
            $('.submenu-icon').toggleClass('d-none');
            $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');

            // Treating d-flex/d-none on separators with title
            var SeparatorTitle = $('.sidebar-separator-title');
            if ( SeparatorTitle.hasClass('d-flex') ) {
                SeparatorTitle.removeClass('d-flex');
            } else {
                SeparatorTitle.addClass('d-flex');
            }

            // Collapse/Expand icon
            $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
        }
    </script>
@endsection
