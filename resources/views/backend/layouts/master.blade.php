<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> 
    <title>{{getSystemSetting('type_name')}} | @yield('title')</title>
    <link rel="icon" href="{{filePath(getSystemSetting('favicon_icon'))}}">

    
    @include('backend.layouts.includes.style')
    @yield('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    {{--  ajax url--}}
    @include('backend.layouts.includes.url')

<div class="wrapper">
    @include('backend.layouts.includes.navbar')
    @include('backend.layouts.includes.aside')

    <div class="content-wrapper">
        <div class="content-header">
            @include('backend.layouts.includes.breadcrumb')
            @include('backend.layouts.includes.error')
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!--/. container-fluid -->
        </section>
    </div>
    @include('backend.layouts.includes.footer')
    @include('backend.layouts.includes.model')
    @include('backend.layouts.includes.delete')
</div>
@include('backend.layouts.includes.script')
@yield('script')
@include('sweetalert::alert')
</body>
</html>
