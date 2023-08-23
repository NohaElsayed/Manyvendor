@extends('backend.layouts.master')
@section('title')
    @translate(User List)
@endsection
@section('content')
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">@translate(Create User)</h3>

                <div class="float-right">
                    <div class="">
                        <a class="btn btn-primary" href="{{ route("users.index") }}">
                            @translate(User List)
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-2">
                <form action="{{route('users.store')}}" method="post">
                    @csrf
                    <div class="">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-center text-justify">@translate(Name)</label>

                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="User Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-center text-justify">@translate(E-Mail Address)</label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="tel" class="col-md-4 col-form-label text-md-center text-justify">@translate(Phone Number)</label>

                            <div class="col-md-6">
                                <input id="tel" type="tel" placeholder="Phone Number" class="form-control @error('tel_number') is-invalid @enderror" name="tel_number" value="{{ old('tel_number') }}">

                                @error('tel_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="" class="col-md-4 col-form-label text-md-center text-justify">@translate(Gender)</label>

                            <div class="col-md-6  pr-0">
                                <select class="form-control select2 @error('genders') is-invalid @enderror" required name="genders">
                                    <option value="">@translate(Select Option)</option>
                                    <option value="Male">@translate(Male)</option>
                                    <option value="Female">@translate(Female)</option>
                                    <option value="Other">@translate(Other)</option>
                                </select>

                                @error('genders')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-center text-justify">@translate(Password)</label>

                            <div class="col-md-6">
                                <input id="password"  placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-center text-justify">@translate(Confirm Password)</label>

                            <div class="col-md-6">
                                <input id="password-confirm"  placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <input type="hidden" name="user_type" value="Admin">


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-center text-justify">@translate(Select Groups)</label>
                            <div class="col-md-6  pr-0">
                                <select class="form-control select2 w-100"  name="group_id[]"  multiple required>
                                    @foreach($groups as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="text-center"><button class="btn btn-primary px-5" type="submit">@translate(Save)</button></div>
                </form>
            </div>

        </div>
@endsection
