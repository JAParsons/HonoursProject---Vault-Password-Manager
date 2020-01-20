@extends('layouts.master')

@section('title')
    Vault Password Manager
@endsection

<style>
    body {
        width: 100vw;
        height: 100vh;
        margin: 0;
        overflow: hidden;
    }
    .curved-div {
        position: relative;
        background: linear-gradient(to bottom right, #4377f1, #5267f4, #5f57f8, #654ff9, #7042fc, #7c35ff);
        color: #FFF;
        text-align: center;
        overflow: hidden;
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

    gradinetFill {
        cursor: pointer;
        shape-rendering: crispEdges;
        fill: url(#MyGradient);
    }
</style>

@section('content')
    <div class="curved-div upper">
      <svg viewBox="0 0 1440 319">
        <path fill="#ff3c00" fill-opacity="1" d="M0,32L48,80C96,128,192,224,288,224C384,224,480,128,576,90.7C672,53,768,75,864,96C960,117,1056,139,1152,149.3C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </svg>
    </div>
    <div class="curved-div">
      <h1>Vault Security</h1>
      <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. In orci lorem, porttitor nec vulputate sit amet, fermentum a purus. Curabitur ullamcorper tellus orci, vel mattis sapien pretium eget.
      </p>
      <svg viewBox="0 0 1440 319">
        <path fill="#fff" fill-opacity="1" d="M0,32L48,80C96,128,192,224,288,224C384,224,480,128,576,90.7C672,53,768,75,864,96C960,117,1056,139,1152,149.3C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </svg>
    </div>
@endsection
