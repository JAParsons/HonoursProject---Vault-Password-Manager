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
        <a class="navbar-brand" href="{{URL::to('')}}">
            <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            <span class="menu-collapsed">Vault Password Manager</span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#top">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#top">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#top">Pricing</a>
                </li>
                <!-- This menu is hidden in bigger devices with d-sm-none.
               The sidebar isn't proper for smaller screens imo, so this dropdown menu can keep all the useful sidebar items exclusively for smaller screens  -->
                <li class="nav-item dropdown d-sm-block d-md-none">
                    <a class="nav-link dropdown-toggle" href="#" id="smallerscreenmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Menu </a>
                    <div class="dropdown-menu" aria-labelledby="smallerscreenmenu">
                        <a class="dropdown-item" href="#top">Dashboard</a>
                        <a class="dropdown-item" href="#top">Profile</a>
                        <a class="dropdown-item" href="#top">Tasks</a>
                        <a class="dropdown-item" href="#top">Etc ...</a>
                    </div>
                </li><!-- Smaller devices menu END -->
            </ul>
        </div>
    </nav><!-- NavBar END -->

    <!-- Bootstrap row -->
    <div class="row" id="body-row">
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
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-dashboard fa-fw mr-3"></span>
                        <span class="menu-collapsed">DASHBOARD</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu content -->
                <div id='submenu1' class="collapse sidebar-submenu">
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">Stored Passwords</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">Reports</span>
                    </a>
                </div>
                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-user fa-fw mr-3"></span>
                        <span class="menu-collapsed">PROFILE</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu content -->
                <div id='submenu2' class="collapse sidebar-submenu">
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">Edit Details</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">Account Password</span>
                    </a>
                </div>
                <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-qrcode fa-fw mr-3"></span>
                        <span class="menu-collapsed">QR BACKUP</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu content -->
                <div id='submenu3' class="collapse sidebar-submenu">
                    <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                        <span class="menu-collapsed">Generate Backup</span>
                    </a>
                </div>
                <!-- Separator with title -->
                <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                    <small>OPTIONS</small>
                </li>
                <!-- /END Separator -->
                <li>
                    <a href="#" class="bg-dark list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-envelope-o fa-fw mr-3"></span>
                            <span class="menu-collapsed">NOTIFICATIONS <span class="badge badge-pill badge-primary ml-2">5</span></span>
                        </div>
                    </a>
                    <a href="#" class="bg-dark list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-wrench fa-fw mr-3"></span>
                            <span class="menu-collapsed">SETTINGS</span>
                        </div>
                    </a>
                </li>
                <!-- Separator without title -->
                <li class="list-group-item sidebar-separator menu-collapsed"></li>
                <!-- /END Separator -->
                <li>
                    <a href="#" class="bg-dark list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-question fa-fw mr-3"></span>
                            <span class="menu-collapsed">HELP</span>
                        </div>
                    </a>
                    <a href="#top" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                            <span id="collapse-text" class="menu-collapsed"></span>
                        </div>
                    </a>
                </li>
            </ul><!-- List Group END-->
        </div><!-- sidebar-container END -->

        <!-- MAIN -->
        <div class="col p-4">
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
                                    <div class="clickableElement" onclick="openModal('editModal')">
                                        <h5 class="card-title ">{{$storedPassword->website_name}} <img src="https://www.google.com/s2/favicons?domain_url={{$storedPassword->website_url}}"></h5>
                                        <p class="card-text">Email:   {{$storedPassword->email}}</p>
                                        <p class="card-text">Encrypted Password:   {{$storedPassword->password}}</p>
                                    </div>
                                    <br>
                                    <button class="btn btn-primary">Copy to Clipboard</button>
                                    <button class="btn btn-danger" onclick="confirmDeletePassword({{$storedPassword->id}})">Delete</button>
                                </div>
                                <div class="card-footer clickableElement" onclick="openModal('editModal')">
                                    <small class="text-muted">Last updated {{$storedPassword->updated_at->diffForHumans()}}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div><!-- Main Col END -->

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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirmPasswordButton" >Submit</button>
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
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="passwordToStore">
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirmPasswordToStore">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="postAddPassword()">Submit</button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" id="confirm">Confirm</button>
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
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="text" class="form-control" id="storedPassword" readonly>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">New Password:</label>
                                <input type="password" class="form-control" id="newPasswordToStore">
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Confirm New Password:</label>
                                <input type="password" class="form-control" id="confirmNewPasswordToStore">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="">Save Changes</button>
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
        function openModal(id){
            if(checkIfPassword()){
                $('#'+id).modal('toggle');
            }
            else{
                //set onclick event to be the verify password function with the desired modal as a param
                document.getElementById('confirmPasswordButton').setAttribute('onclick', 'verifyPassword(' + '"' + id + '"' + ')');
                $('#passwordModal').modal('toggle');
            }
        }

        function toggleModal(id){
            $('#'+id).modal('toggle');
        }

        //check if the user has entered their password or not
        function checkIfPassword(){
            if(password){ return true; }
            else{ return false; }
        }

        //ajax request to verify a password to the logged in user
        function verifyPassword(desiredModal){
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
                        toggleModal('passwordModal');
                        console.log('HERE: ' + desiredModal);
                        toggleModal(desiredModal);
                    }

                    document.getElementById('password').value = '';
                });
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
                        var favicon = 'https://www.google.com/s2/favicons?domain_url=' + url;
                        $('#cardDeck').append(
                            '                        <div class="d-flex p-1 pt-3" id=' + msg.id + '>\n' +
                            '                            <div class="card" style="max-width: 18rem; min-width: 18rem;">\n' +
                            '                                <div class="card-body">\n' +
                            '                                    <h5 class="card-title">' + name + ' <img src=' + favicon + '></h5>\n' +
                            '                                    <p class="card-text">Email: ' + email + '</p>\n' +
                            '                                    <p class="card-text">Encrypted Password: ' + encryptedPassword + '</p>\n' +
                            '                                    <button class="btn btn-primary">Copy to Clipboard</button>\n' +
                            '                                    <button class="btn btn-danger" onclick=confirmDeletePassword(' + msg.id + ')>Delete</button>\n' +
                            '                                </div>\n' +
                            '                                <div class="card-footer">\n' +
                            '                                    <small class="text-muted">Last updated just now</small>\n' +
                            '                                </div>\n' +
                            '                            </div>\n' +
                            '                        </div>'
                        );

                        //clear form values
                        document.getElementById('name').value = '';
                        document.getElementById('url').value = '';
                        document.getElementById('email').value = '';
                        document.getElementById('passwordToStore').value = '';
                        document.getElementById('confirmPasswordToStore').value = '';
                    }
                });
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
                    }
                });
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
