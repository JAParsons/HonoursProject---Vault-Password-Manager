@extends('layouts.master')

@section('title')
    Shamir
@endsection

@section('content')

    <label for="text">Plaintext </label><input id="plaintext" type="text" value="John"/><br />
    <label for="text">Shares </label><input id="shares" type="text" value="3"/><br />
    <label for="text">Threshold </label><input id="threshold" type="text" value="2"/><br />

    <br>
    <div class="row">
        <div class="col-md-4" id="qrcode0"></div>
        <div class="col-md-4" id="qrcode1"></div>
        <div class="col-md-4" id="qrcode2"></div>
    </div>

    <script src={{asset('js/secrets.js')}}></script>
    <script src={{asset('js/qrcode.js')}}></script>
    <script src={{asset('js/instascan.min.js')}}></script>

    <br>
    <br>
    <br>
    <div class="row">
        <div class="container text-center">
            <video id="preview"></video>
        </div>
    </div>

    <script type="text/javascript">

        var shares;
        var scanned = [];

        function genShamir(text, fragments, threshold){
            var pw = text;
            console.log(pw);
            // convert the text into a hex string
            var pwHex = secrets.str2hex(pw); // => hex string

            // split into 3 shares, with a threshold of 2
            shares = secrets.share(pwHex, fragments, threshold);
            console.log(shares);

            for(i=0; i<shares.length; i++){
                shares[i] = btoa(shares[i]);
            }
        }

        function recoverShamir(text, fragments, threshold){
            //decode shares from base64
            for(i=0; i<scanned.length; i++){
                scanned[i] = atob(scanned[i]);
            }

            // combine shares:
            var comb = secrets.combine(scanned.slice(1, 2));

            //convert back to UTF string:
            comb = secrets.hex2str(comb);

            // combine 2 shares:
            comb = secrets.combine([scanned[0], scanned[1]]);

            //convert back to UTF string:
            comb = secrets.hex2str(comb);
            console.log(comb);
            scanned = [];
        }
    </script>

    <script>

        genShamir(document.getElementById('plaintext').value, 3, 2);
        generateCodes();

        function createQrCode(divId, text){
            var qrcode = new QRCode(divId);
            qrcode.makeCode(text);
        }

        function generateCodes(num = document.getElementById('shares').value){
            for(i=0; i<num; i++){
                document.getElementById('qrcode'+i).innerHTML = "";
                createQrCode('qrcode'+i, shares[i]);
            }
        }

        $("#plaintext").
        on("blur", function () {
            genShamir(document.getElementById('plaintext').value, 3, 2);
            generateCodes();
        }).
        on("keydown", function (e) {
            if (e.keyCode === 13) {
                genShamir(document.getElementById('plaintext').value, 3, 2);
                generateCodes();
            }
        });

    </script>

    <script type="text/javascript">
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
            console.log(content);
            if (scanned.length < document.getElementById('threshold').value){
                scanned.push(content);
                console.log(scanned);
                if (scanned.length == document.getElementById('threshold').value) {
                    recoverShamir();
                }
            }

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
    </script>
@endsection
