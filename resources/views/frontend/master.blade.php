<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="{{getSystemSetting('type_name') ?? 'Manyvendor'}}">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="{{getSystemSetting('type_name') ?? 'Manyvendor'}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ getSystemSetting('type_name') }} @yield('title')</title>
    <link rel="icon" href="{{filePath(getSystemSetting('favicon_icon'))}}">
    {{-- css goes here --}}
    @include('frontend.assets.css')

    {{-- custom css goes here --}}
    @yield('css')

</head>


<script>
  /**
 * Preloader
 */

 "use strict"

$(window).on("load", function () {
    var preLoder = $(".preloader");
    preLoder.fadeOut(1000);
});

</script>

<body>

  <!-- Preloader -->
  <div class="many-content preloader">
      <div class="loading">
          <p>Loading</p>
          <span></span>
      </div>
  </div>
  <!-- Preloader -->

  <div id="fb-root"></div>
  {{--this for facebook sdk--}}
 <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v7.0&appId=2307155716247033&autoLogAppEvents=1" nonce="TSPkAQLi"></script>


  {{--  ajax url--}}
  @include('frontend.assets.url')

  {{-- main header --}}
  @include('frontend.include.header.header')
  {{-- mobile header --}}
  @include('frontend.include.header.mobile-header')
  {{-- shopping cart --}}
  @include('frontend.include.cart.shopping-cart')
  {{-- mobile sidebar --}}
  @include('frontend.include.sidebar.mobile.mobile-sidebar')

    {{-- content goes here::START --}}
    @yield('content')
    {{-- content goes here::END --}}

  {{-- footer --}}
  @include('frontend.include.footer.footer')


  {{-- script goes here --}}
  @include('frontend.assets.js')

  {{-- custom js goes here --}}
  @yield('js')

  {{--login modal--}}
  @include('frontend.widgets.popup.login_modal')

  <div class="modal fade" id="product-quickview" tabindex="-1" role="dialog" aria-labelledby="product-quickview" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <a href="javascript:void(0)" id="modelClose" class="modal-close" data-dismiss="modal">
              <i class="icon-cross2"></i>
            </a>

          </div>
      </div>
  </div>

  @include('backend.layouts.includes.model')

@include('sweetalert::alert')

</body>


</html>
