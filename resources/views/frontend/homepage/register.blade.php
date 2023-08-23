@extends('frontend.master')

@section('title')

@section('content')
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('homepage')}}">@translate(Home)</a></li>
                <li>@translate(Be a deliver)</li>
            </ul>
        </div>
    </div>


    <div class="ps-my-account">
        <div class="container">

                <div class="card card-primary card-outline">
                    {{-- Flash message after successful registration --}}
                    <div class="m-4">
                        @if (Session::has('status'))
                            <div class="alert alert-info text-center">{{ Session::get('status') }}</div>
                        @endif
                        @if (Session::has('warning'))
                            <div class="alert alert-info text-center">{{ Session::get('warning') }}</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="ps-form__content">
                            <form method="POST" action="{{ route('deliver.register') }}" enctype="multipart/form-data">
                                @csrf
                                <h5>@translate(Register as a deliver men )</h5>
                                <div class="form-group">
                                    <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                           name="first_name" placeholder="First Name" required>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input class="form-control @error('last_name') is-invalid @enderror" type="text"
                                           name="last_name" placeholder="Last Name" required>
                                    @error('last_name')
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


                                <div class="form-group">
                                    <input class="form-control @error('phone_num') is-invalid @enderror" type="tel"
                                           name="phone_num" placeholder="Phone number" required>
                                    @error('phone_num')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select name="gender" class="form-control" required>
                                        <option value="">@translate(Select gender)</option>
                                        <option value="Male">@translate(Male)</option>
                                        <option value="Female">@translate(Female)</option>
                                        <option value="Other">@translate(Other)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input class="form-control @error('permanent_address') is-invalid @enderror" type="text"
                                           name="permanent_address" placeholder="Permanent Address" required>
                                    @error('permanent_address')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <input class="form-control @error('present_address') is-invalid @enderror" type="text"
                                           name="present_address" placeholder="Present Address" required>
                                    @error('present_address')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>


                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@translate(Additional Document)</label>
                                            <input class="form-control-file @error('document') is-invalid @enderror" type="file"
                                                   name="document" placeholder="Additional Document Required" required>
                                            @error('document')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>@translate(Profile picture)</label>
                                            <input class="form-control-file @error('pic') is-invalid @enderror" type="file"
                                                   name="pic" placeholder="Picture is Required" required>
                                            @error('pic')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group submtit">
                                    <button class="ps-btn ps-btn--fullwidth" type="submit">@translate(Submit)</button>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>


        </div>
    </div>
    {{-- site-search widgets --}}
    @include('frontend.widgets.popup.site-search')

@stop
