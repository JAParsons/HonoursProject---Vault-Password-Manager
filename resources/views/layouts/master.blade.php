<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="images/favicon/favicon-32x32.png" sizes="32x32" />

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src={{asset('js/jQuery.js')}}></script>
{{--    <script src={{asset('js/notify.js')}}></script>--}}

    <!-- TRYING TO GET PRELOADER TO WORK -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>

    <script src={{asset('js/notify.js')}}></script>
    <script src={{asset('js/jquery.loading.js')}}></script>
    <script src={{asset('js/waitMe.js')}}></script>
    <link rel="stylesheet" href={{asset('css/waitMe.css')}}>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body id="page-container">



{{--    <div class="container-fluid">--}}
        @yield('content')
{{--    </div>--}}
<style>
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    .content {
        flex: 1 0 auto;
    }
    .footer {
        flex-shrink: 0;
    }

    /*loader css*/
    .no-js #loader { display: none; }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        {{--background: url({{asset('images/lock_transparent.gif')}}) center no-repeat #fff;--}}
        background: url({{asset('images/favicon/android-chrome-192x192.png')}}) center no-repeat #fff;
    }
</style>

<script>
    function notify(message = 'notification', type = 'success') {
        $.notify.defaults({ className: type });
        $.notify(
            message,
            { globalPosition:"top center" }
        );
    }

    // function toggleLoading(id = 'page-container', message = 'Loading...'){
    //     // if($('#' + id).is(':loading')){
    //     //     $('#' + id).loading('toggle');
    //     // }
    //     // else{ //else create new loader instance
    //         $('#' + id).loading({theme: 'dark', message: message, overlay: $("#custom")});
    //         document.getElementById(id + '_loading-overlay').style.zIndex = "9999"; //bring loading overlay in front of bootstrap modal
    //     //}
    // }
    function closeWaitMeLoader() {
        $('#page-container').removeClass('waitMe_container');
    }

    function toggleLoading(id = 'page-container', message = 'One moment...'){
        if(!$('#page-container').hasClass('waitMe_container')){
            $('#page-container').waitMe({
                effect : 'win8',
                text : message,
                bg : 'rgba(0,0,0,0.5)',
                color : '#fff',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '20px',
                source : '',
                onClose : function() {}
            });
        }
        else{
            closeWaitMeLoader();
        }
    }

    function toggleDiv(div) {
        div = document.getElementById(div);
        if (div.style.display === "none") {
            div.style.display = "block";
        } else {
            div.style.display = "none";
        }
    }

    function hideDiv(div) {
        div = document.getElementById(div);
        div.style.display = "none";
    }

    function showDiv(div) {
        div = document.getElementById(div);
        div.style.display = "block";
    }
</script>

<script>
    //wait for window load
    $(window).load(function() {
        //animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
</script>

<footer class="container py-5 border-top footer" style="">
    <br>
    <div class="row">
        <div class="col-12 col-md">
            <img class="mb-2" src="images/favicon/favicon-32x32.png" alt="" width="24" height="24">
            <small class="d-block mb-3 text-muted">&copy; 2019-2020</small>
        </div>
        <div class="col-6 col-md">
            <h5>Features</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Client-side Crypto</a></li>
                <li><a class="text-muted" href="#">QR Code Backups</a></li>
                <li><a class="text-muted" href="#">Accessible</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Help</a></li>
                <li><a class="text-muted" href="#">Resource name</a></li>
                <li><a class="text-muted" href="#">Another resource</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Business</a></li>
                <li><a class="text-muted" href="#">Education</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>About</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Team</a></li>
                <li><a class="text-muted" href="#">Locations</a></li>
                <li><a class="text-muted" href="#">Privacy</a></li>
                <li><a class="text-muted" href="#">Terms</a></li>
            </ul>
        </div>
    </div>
</footer>
</body>

{{--preloader div--}}
<div class="se-pre-con"></div>

</html>
