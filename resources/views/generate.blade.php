@extends('layouts.master')

@section('title')
    Generate QR Code
@endsection

@section('content')

    <script src={{asset('js/qrcode.js')}}></script>

    <input id="text" type="text" value="john"/><br />
    <div id="qrcode"></div>

    <script>
        var qrcode = new QRCode("qrcode");

        function makeCode () {
            var elText = document.getElementById("text");

            if (!elText.value) {
                alert("Input a text");
                elText.focus();
                return;
            }

            qrcode.makeCode(elText.value);
        }

        makeCode();

        $("#text").
        on("blur", function () {
            makeCode();
        }).
        on("keydown", function (e) {
            if (e.keyCode === 13) {
                makeCode();
            }
        });
    </script>

@endsection
