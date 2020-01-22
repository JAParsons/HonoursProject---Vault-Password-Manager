@extends('layouts.master')

@section('title')
    Vault Password Manager
@endsection

<style>
    /*body {*/
    /*    width: 100vw;*/
    /*    height: 100vh;*/
    /*    margin: 0;*/
    /*    overflow: hidden;*/
    /*}*/
    .curved-div {
        position: relative;
        background: linear-gradient(to bottom right, #4377f1, #5267f4, #5f57f8, #654ff9, #7042fc, #7c35ff);
        color: #FFF;
        text-align: center;
        /*overflow: hidden;*/
    }
    .curved-div svg {
        display: block;
    }
    .curved-div.upper {
        background: #fff;
    }
    .curved-div h1 {
        font-size: 6rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        margin-top: 0rem;
    }
    .curved-div p {
        font-size: 1rem;
        margin: 0 5rem 0rem 5rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    /*.flip {*/
    /*    -moz-transform: scale(-1, -1);*/
    /*    -webkit-transform: scale(-1, -1);*/
    /*    -o-transform: scale(-1, -1);*/
    /*    -ms-transform: scale(-1, -1);*/
    /*    transform: scale(-1, -1);*/

    /*    background: linear-gradient(to bottom left, #4377f1, #5267f4, #5f57f8, #654ff9, #7042fc, #7c35ff);*/
    /*}*/

    .navbar-inner {
        background:transparent;
    }
</style>



@section('content')
{{--    <div class="curved-div flip">--}}
{{--        <svg viewBox="0 0 1440 319">--}}
{{--            <path fill="#fff" fill-opacity="1" d="M0,32L48,80C96,128,192,224,288,224C384,224,480,128,576,90.7C672,53,768,75,864,96C960,117,1056,139,1152,149.3C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>--}}
{{--        </svg>--}}
{{--    </div>--}}
    <div class="curved-div">

        <!-- Bootstrap NavBar -->
        <nav class="navbar navbar-expand-md navbar-dark navbar-inner">
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
                        <li class="nav-item active">
                            <a class="nav-link" href="#top">Recover <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('login')}}">Login <span class="sr-only">(current)</span></a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav><!-- NavBar END -->

        <br><br><br><br><br><br>
      <h1>Vault Security</h1>
      <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. In orci lorem, porttitor nec vulputate sit amet, fermentum a purus. Curabitur ullamcorper tellus orci, vel mattis sapien pretium eget.
      </p>
      <br><br>
      <svg viewBox="0 0 1440 319">
        <path fill="#fff" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,64C384,85,480,139,576,149.3C672,160,768,128,864,101.3C960,75,1056,53,1152,58.7C1248,64,1344,96,1392,112L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </svg>
    </div>

    <div class="container">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Free</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>10 users included</li>
                        <li>2 GB of storage</li>
                        <li>Email support</li>
                        <li>Help center access</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button>
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Pro</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>20 users included</li>
                        <li>10 GB of storage</li>
                        <li>Priority email support</li>
                        <li>Help center access</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Get started</button>
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Enterprise</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$29 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>30 users included</li>
                        <li>15 GB of storage</li>
                        <li>Phone and email support</li>
                        <li>Help center access</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Contact us</button>
                </div>
            </div>
        </div>
    </div>
@endsection
