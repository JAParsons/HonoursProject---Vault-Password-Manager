@extends('layouts.master')

@section('title')
    Vault Password Manager
@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<script src={{asset('js/particles.js')}}></script>

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
    <div class="curved-div" id="particles-js">

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
                        <li class="nav-item" style="padding-left: 5px">
                            <button class="btn btn-warning my-2 my-sm-0" onclick="location.href = '{{route('dashboard')}}'">My Vault</button>
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

        <br><br><br><br>
      <h1>Vault Security</h1>
      <h4>
          The password manager with a difference
      </h4>
      <br><br>
      <svg viewBox="0 0 1440 319">
        <path fill="#fff" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,64C384,85,480,139,576,149.3C672,160,768,128,864,101.3C960,75,1056,53,1152,58.7C1248,64,1344,96,1392,112L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </svg>
    </div>

<!-- Icons Grid -->
<div class="features-icons text-center" style="margin-top: -2rem; margin-bottom: 6rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3" style="font-size: 5rem;">
                    <div class="features-icons-icon d-flex">
                        <i class="fas fa-shield-alt m-auto" style="color: #5267f4"></i>
                    </div>
                    <h3>Secure Storage</h3>
                    <p class="lead mb-0">Vault securely encrypts your password data so that only you can access it.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3" style="font-size: 5rem">
                    <div class="features-icons-icon d-flex">
                        <i class="fas fa-qrcode m-auto" style="color: #5267f4"></i>
                    </div>
                    <h3>QR Code Backups</h3>
                    <p class="lead mb-0">Featuring a unique approach to backing up your account.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-0 mb-lg-3" style="font-size: 5rem">
                    <div class="features-icons-icon d-flex">
                        <i class="fas fa-cloud m-auto" style="color: #5267f4"></i>
                    </div>
                    <h3>Accessible</h3>
                    <p class="lead mb-0">Access your Vault data from any browser right when you need it most.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Showcases -->
{{--<section class="showcase container">--}}

<h2 class="text-center">How it works</h2>
<br>
    <div class="container p-0">
        <div class="row no-gutters">
            <div class="col-lg-6 my-auto showcase-text text-white" style="background: linear-gradient(to bottom right, #4377f1, #5267f4, #5f57f8, #654ff9, #7042fc, #7c35ff); padding: 2rem; border-radius: 50px;">
                <h2>Sign Up</h2>
                <p class="lead mb-0">Put all of your passwords right where you need them. Simplicity. Convenience. Register for free and start storing passwords in your own personal Vault. </p>
            </div>
            <div class="col-lg-6 order-lg-2 showcase-img"></div>
        </div>
        <div class="row no-gutters">
            <div class="col-lg-6 showcase-img"></div>
            <div class="col-lg-6 my-auto showcase-text text-white" style="background: linear-gradient(to bottom right, #4377f1, #5267f4, #5f57f8, #654ff9, #7042fc, #7c35ff); padding: 2rem; border-radius: 50px;">
                <h2>Manage</h2>
                <p class="lead mb-0">Manage your passwords from any browser knowing that they are securely encrypted and only accessible by you. Vault strongly believes that you should have control over your data. That’s why your stored passwords can only be decrypted with cryptographic components derived from your unique credentials.</p>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-lg-6 my-auto showcase-text text-white" style="background: linear-gradient(to bottom right, #4377f1, #5267f4, #5f57f8, #654ff9, #7042fc, #7c35ff); padding: 2rem; border-radius: 50px;">
                <h2>Recover</h2>
                <p class="lead mb-0">Vault provides backups in the form of QR codes. Data is fragmented across a number of these. Each code is designed to be totally useless individually unless all fragments are brought together at once. Keep these somewhere safe and rest easy knowing that if you forget your account password then it can always be recovered in an emergency. </p>
            </div>
            <div class="col-lg-6 order-lg-2 showcase-img"></div>
        </div>
    </div>
{{--</section>--}}

<div class="row">

</div>

    <div class="container" style="padding-top: 5rem; padding-bottom: 2rem;">
        <h2 class="text-center">Pricing Plans</h2>
        <br>
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Free</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">£0 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>1 user included</li>
                        <li>Store up to 20 passwords</li>
                        <br>
                        <br>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-outline-primary" onclick="location.href = '{{route('login')}}'">Sign up for free</button>
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Pro</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">£5 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>3 users included</li>
                        <li>Store unlimited passwords</li>
                        <br>
                        <br>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Get started</button>
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Enterprise</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">£30 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>25 users included</li>
                        <li>Store unlimited passwords</li>
                        <li>Phone and email support</li>
                        <li>Help center access</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Contact us</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // particlesJS.load('particles-js', 'public/json/particlejs-config.json', function() {
            //     console.log('callback - particles.js config loaded');
            // });
            console.log('ready!');
        });
    </script>
@endsection
