@extends('layouts.master')

@section('title')
    Generate Backup
@endsection

@section('content')

    <script src={{asset('js/secrets.js')}}></script>
    <script src={{asset('js/crypto-js.js')}}></script> {{--core crypto library--}}
    <script src={{asset('js/pbkdf2.js')}}></script> {{--pbkdf2 implementation--}}
    <script src={{asset('js/qrcode.js')}}></script>

    <br>

    <div class="text-center">
        <label for="text">Enter Password </label>
        <input id="plaintext" type="password" value=""/>
    </div>

    <br>

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div>
                <div class="d-flex p-2" id="qrcode0"></div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary">Print</button>
                </div>
            </div>
            <div>
                <div class="d-flex p-2" id="qrcode1"></div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary">Print</button>
                </div>
            </div>
            <div>
                <div class="d-flex p-2" id="qrcode2"></div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary">Print</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $( document ).ready(function() {
            genShamir(document.getElementById('plaintext').value, 3, 2);
            generateCodes(3);
        });

        //events
        $("#plaintext").
        on("blur", function () {
            genShamir(document.getElementById('plaintext').value, 3, 2);
            generateCodes(3);
        }).
        on("keydown", function (e) {
            if (e.keyCode === 13) {
                genShamir(document.getElementById('plaintext').value, 3, 2);
                generateCodes(3);
            }
        });
    </script>

    <script>
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

        function createQrCode(divId, text){
            var qrcode = new QRCode(divId);
            qrcode.makeCode(text);
        }

        function generateCodes(num){
            for(i=0; i<num; i++){
                document.getElementById('qrcode'+i).innerHTML = "";
                createQrCode('qrcode'+i, shares[i]);
            }
        }
    </script>
@endsection
