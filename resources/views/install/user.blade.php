@extends('install.app')
@section('content')

    <div class="card-body m-5 py-3">
        <h3 class="text-lg-center px-3 pb-3 mb-3">@translate(Create Admin User)</h3>

        @if($message = Session::get('babiato'))
            <div class="alert alert-danger">{{Session::get('babiato')}}</div>
        @endif

        <form method="POST" action="{{ route('admin.store') }}">
            @csrf
            <div class="form-group">
                <label for="name" class="text-md-right">@translate(Name)</label>
                <input placeholder="Enter UserName" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="text-md-right">@translate(E-Mail Address)</label>
                <input id="email" placeholder="Enter Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="text-md-right">@translate(Password)</label>
                <input id="password" placeholder="Enter Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm" class="text-md-right">@translate(Confirm Password)</label>

                <input id="password-confirm" 
                placeholder="Re-type Password" 
                type="password" 
                class="form-control" 
                name="password_confirmation" 
                required autocomplete="new-password">
            </div>

          

            <div class="form-group mt-3">
                <label for="purchase_key" class="text-md-right">@translate(Purchase code)</label>
                <input placeholder="Enter purchase code" id="purchase_key" type="text" class="form-control" name="purchase_key" value="{{ old('purchase_key') }}" required>
            </div>
            <button type="submit" class="btn btn-block btn-primary">
                @translate(Register)
            </button>
        </form>
    </div>

@endsection
