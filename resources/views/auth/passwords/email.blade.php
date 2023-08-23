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
                    <div class="card-header text-center fs-32 border-0">@translate(Reset Password)</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class=" col-form-label text-md-right">@translate(E-Mail Address)</label>

                                <div class="">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div class="">
                                    <button type="submit" class="btn-block text-uppercase btn btn-primary py-3">
                                        @translate(Send Password Reset Link)
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
