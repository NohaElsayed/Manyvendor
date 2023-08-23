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

    <div class="ps-my-account">
        <div class="container">
            <div class="ps-form--account ps-tab-root">
                <div class="ps-tab-list">
                    <span class="p-2 fs-28  font-weight-bold"><a href="{{route('login')}}"
                                                                 class="{{request()->is('login') ? 'color-active' : null}}">@translate(Login)</a></span>
                    / <span class="p-2 fs-28 font-weight-bold"><a href="{{route('register')}}"
                                                                class="{{request()->is('register') ? 'color-active' : null}}" style="color: #ff5a5f">@translate(Register)</a></span>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body" id="register">
                        <div class="ps-form__content">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <h5>@translate(Register An Account)</h5>
                                <div class="form-group">
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                           name="name" placeholder="Full name" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
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
                                <div class="form-group submit">
                                    <button class="ps-btn ps-btn--fullwidth" type="submit">@translate(Register)</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@stop

@section('js')
    {{-- js goes here --}}
@stop
