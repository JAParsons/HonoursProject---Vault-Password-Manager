@extends('layouts.master')

@section('title')
    Login
@endsection

@section('content')

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
                        <input class="form-control form-control {{$errors->has('password') ? 'is-invalid' : ''}}" type="password" name="password" id="password" value="{{Request::old('password')}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <input type="hidden" name="_token" value="{{Session::token()}}"> <?php //protection against CSRF by fetching session token?>
                </form>
            </div>
        </div>
    </div>
@endsection
