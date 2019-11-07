@extends('layouts.master')

@section('title')
    Shamir
@endsection

@section('content')

    <label for="text">Plaintext </label><input id="plaintext" type="text" value=""/><br />
    <label for="text">Shares </label><input id="shares" type="text" value=""/><br />
    <label for="text">Threshold </label><input id="threshold" type="text" value=""/><br />

    <br>
    <div class="row">
        <div class="col-md-4" id="qrcode"></div>
        <div class="col-md-4" id="qrcode2"></div>
        <div class="col-md-4" id="qrcode3"></div>
    </div>

    <script src={{asset('js/secrets.js')}}></script>
    <script src={{asset('js/qrcode.js')}}></script>

    <script type="text/javascript">
        var pw = "<<PassWord123>>";
        console.log(pw);
        // convert the text into a hex string
        var pwHex = secrets.str2hex(pw); // => hex string
        console.log(pwHex);
        // split into 3 shares, with a threshold of 2
        var shares = secrets.share(pwHex, 3, 2);
        console.log(shares);
        // combine 2 shares:
        var comb = secrets.combine(shares.slice(1, 2));
        console.log(comb);
        //convert back to UTF string:
        comb = secrets.hex2str(comb);

        // combine 2 shares:
        comb = secrets.combine([shares[1], shares[2]]);
        console.log(comb);
        //convert back to UTF string:
        comb = secrets.hex2str(comb);
        console.log(comb);
    </script>

    <script>
        function createQrCode(divId, text){
            var qrcode = new QRCode(divId, {
                width: 256,
                height: 256
            });
            qrcode.makeCode(text);
        }

        createQrCode('qrcode', shares[0]);
        createQrCode('qrcode2', shares[1]);
        createQrCode('qrcode3', shares[2]);
    </script>
@endsection
