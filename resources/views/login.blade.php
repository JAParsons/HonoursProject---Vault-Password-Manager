@extends('layouts.master')

@section('title')
    Login
@endsection

@section('content')

    <script src={{asset('js/secrets.js')}}></script>

    <br><br><br><br><br><br><br><br><br>

    <div class="container">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <input type="hidden" name="_token" value="{{Session::token()}}"> <?php //protection against CSRF by fetching session token?>
                </form>
            </div>

            <div class="col-md-5 offset-md-2">
                <h3>Register</h3>
                <form action="{{route('register')}}" method="post">
                    <div class="form-group"> <?php //add red outline to invalid form fields ?>
                        <label for="email">E-mail</label>
                        <input class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" type="text" name="email" id="email" value="{{Request::old('email')}}"> <?php //maintain old inputs if validation fails ?>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control form-control {{$errors->has('name') ? 'is-invalid' : ''}}" type="text" name="name" id="name" value="{{Request::old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control form-control {{$errors->has('password') ? 'is-invalid' : ''}}" type="password" name="password" id="reg_password" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <input type="hidden" name="enc_master_key" value="something" id="enc_master_key">
                    <input type="hidden" name="master_iv" value="something2" id="master_iv">
                    <input type="hidden" name="_token" value="{{Session::token()}}"> <?php //protection against CSRF by fetching session token?>
                </form>
            </div>
        </div>
    </div>

    <script>
        //generate a master key
        function generateMasterKey(){
            document.getElementById("enc_master_key").value = secrets.random(512);
            document.getElementById("master_iv").value = secrets.random(512);
            console.log("Master: " + document.getElementById("enc_master_key").value);
            console.log("IV: " + document.getElementById("master_iv").value);
        }

        //events for the reg_password input box
        $("#reg_password").
        on("blur", function () {
            generateMasterKey();
        }).
        on("keydown", function (e) {
            generateMasterKey();
        });
    </script>
@endsection
