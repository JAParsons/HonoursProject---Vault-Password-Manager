@extends('layouts.master')

@section('title')
    Shamir
@endsection

@section('content')

    <script src={{asset('js/secrets.js')}}></script>

    <script type="text/javascript">
        var pw = "<<PassWord123>>";
        console.log(pw);
        // convert the text into a hex string
        var pwHex = secrets.str2hex(pw); // => hex string
        console.log(pwHex);
        // split into 5 shares, with a threshold of 3
        var shares = secrets.share(pwHex, 5, 3);
        console.log(shares);
        // combine 2 shares:
        var comb = secrets.combine(shares.slice(1, 3));
        console.log(comb);
        //convert back to UTF string:
        comb = secrets.hex2str(comb);
        console.log(comb);
        // combine 3 shares:
        comb = secrets.combine([shares[1], shares[3], shares[4]]);
        console.log(comb);
        //convert back to UTF string:
        comb = secrets.hex2str(comb);
        console.log(comb);
    </script>
@endsection
