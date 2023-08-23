<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ env("APP_NAME") }}</title>


        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('f.png') }}" rel="icon">
    </head>
    <body class="">
        <div class="container">
            <div class="col-md-10 offset-1">
                <div class="mt-5">
                    <div class="card p-lg-5 border-dark">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="{{asset('backend/plugins/jquery/jquery.js')}}"></script>
    <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.js')}}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</html>
