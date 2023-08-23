@extends('frontend.master')

@section('css')
    {{-- css goes here --}}
@stop

@section('title') @translate(Reset Password) @stop

@section('content')

    <div class="ps-my-account">
        <div class="container">
            <div class="ps-form--account ps-tab-root">
                <div class="card auth-box-shadow">
                    <div class="card-header text-center fs-32 border-0">@translate(Confirm Password)</div>

                    <div class="card-body">
                        @translate(Please confirm your password before continuing)

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group">
                                <label for="password" class=" col-form-label text-md-right">@translate(Password)</label>

                                <div class="">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password" required
                                           autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <button type="submit" class="btn-block btn btn-primary">
                                        @translate(Confirm Password)
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            @translate(Forgot Your Password)
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
