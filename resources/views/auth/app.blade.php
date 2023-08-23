<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{getSystemSetting('type_name')}} | @yield('title')</title>


    @include('backend.layouts.includes.style')

    <link rel="stylesheet" href="{{ asset('css/app.css')  }}">


</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="limiter">
    <div class="container-login100">
        <div class="login100-more"></div>
        <div class="wrap-login100 p-l-50 p-r-50 p-t-100 p-b-50">
            <div class="mt-auto">
                @yield('content')
            </div>
        </div>
    </div>
</div>



@include('backend.layouts.includes.script')
@include('sweetalert::alert')
</body>

</html>
