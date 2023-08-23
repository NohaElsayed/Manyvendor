@extends('frontend.master')

@section('css')
    {{-- css goes here --}}
@stop

@section('title') @translate(Reset Password) @stop

@section('content')

    <div class="ps-my-account">
        <div class="container">
            <div class="ps-form--account ps-tab-root">
                <div class="card  auth-box-shadow">
                    <div class="card-header text-center fs-32 border-0">@translate(Reset Password)</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email" class="col-form-label text-md-right">@translate(E-Mail Address)</label>

                                <div class="">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                           autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">@translate(Password)</label>

                                <div class="">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password" required
                                           autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-form-label text-md-right">@translate(Confirm Password)</label>

                                <div class="">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                           required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div class="">
                                    <button type="submit" class="btn-block  btn btn-primary">
                                        @translate(Reset Password)
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
