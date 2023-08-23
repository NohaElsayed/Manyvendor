

@extends('frontend.master')

@section('css')
    {{-- css goes here --}}
@stop

@section('title') @translate(Register) @stop

@section('content')
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('homepage')}}">@translate(Home)</a></li>
                <li>@translate(My account)</li>
            </ul>
        </div>
    </div>
@if(env('APP_ENV') == 'local')
    <div class="ps-my-account">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="ps-form--account ps-tab-root mx-1 py-0">
                    <div class="ps-tab-list">
                        <span class="p-2 fs-28  font-weight-bold"></span>
                        <span class="p-2 fs-28 font-weight-bold"></span>
                    </div>
                    <div class="card card-primary card-outline pb-5" style="margin-top:35px;">

                        <div class="text-center">
                            <img src="{{filepath('logo.png')}}" class="bg-primary w-100 py-3 px-5"/>
                        </div>
                        <div class="card-body" id="sign-in">
                            <div class="ps-form__content pt-0">
                                <div class="text-center mb-2"><small>Click For Demo Login Credentials</small>
                                </div>

                                <div class="btn btn-warning btn-block fs-16 admin">Copy admin credentials</div>
                                @if(vendorActive())
                                <div class="btn btn-danger btn-block fs-16 seller">Copy seller credentials</div>
                                @endif
                                <div class="btn btn-success btn-block fs-16 mt-2 customer">Copy customer credentials</div>
                                <div class="btn btn-secondary btn-block fs-16 mt-2 deliver">Copy Deliveryman  credentials</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-form--account ps-tab-root pt-2 mx-1">
                    <div class="ps-tab-list">
                    <span class="p-2 fs-28  font-weight-bold"><a href="{{route('login')}}"
                                                                 class="{{request()->is('login') ? 'color-active' : null}}" style="color: #ff5a5f">@translate(Login)</a></span>
                        / <span class="p-2 fs-28 font-weight-bold"><a href="{{route('register')}}"
                                                                    class="{{request()->is('register') ? 'color-active' : null}}">@translate(Register)</a></span>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-body" id="sign-in">
                            <div class="ps-form__content">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <h5>@translate(Log In Your Account)</h5>
                                    <div class="form-group">
                                        <input class="form-control insertEmail @error('email') is-invalid @enderror" type="email" value="admin@mail.com"
                                               name="email" placeholder="Email address" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-forgot">
                                        <input class="form-control insertPw @error('password') is-invalid @enderror" type="password"  value="12345678"
                                               name="password" placeholder="Password" required>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <a href="{{ route('password.request') }}">@translate(Forgot)?</a>
                                    </div>
                                    <div class="form-group">
                                        <div class="ps-checkbox">
                                            <input class="form-control" type="checkbox" id="remember-me" name="remember">
                                            <label for="remember-me">@translate(Rememeber me)</label>
                                        </div>
                                    </div>
                                    <div class="form-group submtit">
                                        <button class="ps-btn ps-btn--fullwidth" id="loginBtn" type="submit">@translate(Login)</button>
                                    </div>
                                </form>
                            </div>


                            <div class="ps-form__footer">
                                @if(env('FACEBOOK_CLIENT_ID') != "" || env('GOOGLE_CLIENT_ID') != "")
                                    <p>@translate(Connect with):</p>
                                @endif
                                <ul class="ps-list--social">
                                    @if(!env('FACEBOOK_CLIENT_ID') == "" && !env('FACEBOOK_SECRET') == "" && !env('FACEBOOK_CALLBACK') == "")
                                        <li><a class="google" href="{{ url('/auth/redirect/google') }}"><i class="fa fa-google-plus"></i></a></li>
                                    @endif

                                    @if(!env('GOOGLE_CLIENT_ID') == "" && !env('GOOGLE_CALLBACK') == "" && !env('GOOGLE_SECRET') == "")
                                        <li><a class="facebook" href="{{ url('/auth/redirect/facebook') }}"><i
                                                        class="fa fa-facebook"></i></a></li>
                                    @endif

                                </ul>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@else
    <div class="ps-my-account">
        <div class="container">
            <div class="ps-form--account ps-tab-root">
                <div class="ps-tab-list">
                    <span class="p-2 fs-28  font-weight-bold"><a href="{{route('login')}}"
                                                                 class="{{request()->is('login') ? 'color-active' : null}}"  style="color: #ff5a5f">@translate(Login)</a></span>
                    / <span class="p-2 fs-28 font-weight-bold"><a href="{{route('register')}}"
                                                                class="{{request()->is('register') ? 'color-active' : null}}">@translate(Register)</a></span>
                </div>
                <div class="card card-primary card-outline">

                    <div class="m-4">
                        @if (Session::has('status'))
                            <div class="alert alert-info text-center">{{ Session::get('status') }}</div>
                        @endif
                        @if (Session::has('warning'))
                            <div class="alert alert-info text-center">{{ Session::get('warning') }}</div>
                        @endif
                    </div>
                    <div class="card-body" id="sign-in">
                        <div class="ps-form__content">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <h5>@translate(Log In Your Account)</h5>
                                <div class="form-group">
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                           name="email" placeholder="Email address" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group form-forgot">
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                           name="password" placeholder="Password" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                    <a href="{{ route('password.request') }}">@translate(Forgot)?</a>
                                </div>
                                <div class="form-group">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox" id="remember-me" name="remember">
                                        <label for="remember-me">@translate(Rememeber me)</label>
                                    </div>
                                </div>
                                <div class="form-group submtit">
                                    <button class="ps-btn ps-btn--fullwidth" type="submit">@translate(Login)</button>
                                </div>
                            </form>
                        </div>


                        <div class="ps-form__footer">
                            @if(env('FACEBOOK_CLIENT_ID') != "" || env('GOOGLE_CLIENT_ID') != "")
                                <p>@translate(Connect with):</p>
                            @endif
                            <ul class="ps-list--social">
                                @if(!env('FACEBOOK_CLIENT_ID') == "" && !env('FACEBOOK_SECRET') == "" && !env('FACEBOOK_CALLBACK') == "")

                                    <li><a class="facebook" href="{{ url('/auth/redirect/facebook') }}"><i
                                                    class="fa fa-facebook"></i></a></li>
                                @endif

                                @if(!env('GOOGLE_CLIENT_ID') == "" && !env('GOOGLE_CALLBACK') == "" && !env('GOOGLE_SECRET') == "")
                                    <li><a class="google" href="{{ url('/auth/redirect/google') }}"><i class="fa fa-google-plus"></i></a></li>
                                @endif

                            </ul>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endif
@stop

@section('js')
    {{-- js goes here --}}
    <script>
        $('.seller').click(function () {
            $('.insertEmail').val("seller@mail.com");
            $('.insertPw').val("12345678");
            $('.insertEmail').focus();
        })

        $('.customer').click(function () {
            $('.insertEmail').val("customer@mail.com");
            $('.insertPw').val("12345678");
            $('.insertEmail').focus();
        })

        $('.admin').click(function () {
            $('.insertEmail').val("admin@mail.com");
            $('.insertPw').val("12345678");
            $('.insertEmail').focus();
        })

        $('.deliver').click(function () {
            $('.insertEmail').val("m@m.com");
            $('.insertPw').val("12345678");
            $('.insertEmail').focus();
        })
    </script>
@stop




