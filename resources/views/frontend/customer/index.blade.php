@extends('frontend.master')

@section('title')
    @translate(Customer Dashboard)
@endsection

@section('content')
    <div class="ps-page--single">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                    <li><a href="javascript:void(0)">@translate(Profile)</a></li>
                    <li>{{ Auth::user()->name }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ps-vendor-dashboard pro">
        <div class="container">
            <div class="ps-section__header">
                <h3>@translate(Customer Dashboard)</h3>
            </div>
            <div class="ps-section__content">
                <ul class="ps-section__links">
                    <li><a href="{{ route('customer.orders') }}">@translate(Your Order)</a></li>
                    <li class="active"><a href="{{ route('customer.index') }}">@translate(Your Profile)</a></li>

                    @if(affiliateRoute() && affiliateActive())
                    <li><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate Marketing)</a></li>
                    @endif
                    
                    <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            @translate(Sign Out)
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <form action="{{route('customer.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                        <figure class="ps-block--vendor-status w-300 text-center">

                            @if (Str::substr(Auth::user()->avatar, 0, 7) == 'uploads')
                                <img src="{{ filePath($customer->avatar) }}" alt="{{ Auth::user()->name }}" class="w-70 rounded-circle">
                            @else
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-70 rounded-circle">
                            @endif

                        </figure>

                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                        <figure class="ps-block--vendor-status">
                            <figcaption>@translate(Profile Information)</figcaption>
                            <input type="hidden" name="slug" value="{{$customer->slug}}">

                            @if($errors->has('name'))
                                <div class="error text-danger">{{ $errors->first('name') }}</div>
                            @endif
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="@translate(Name)" name="name"
                                       value="{{$customer->name ?? ''}}">
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="email" placeholder="@translate(Email address)"
                                       name="email" value="{{$customer->email ?? ''}}" disabled>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="number" placeholder="@translate(Contact number)"
                                       name="phn_no" value="{{$customer->phn_no ?? ''}}">
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="@translate(Nationality)"
                                       name="nationality" value="{{ Auth::user()->nationality ?? ''}}">
                            </div>


                            <div class="form-group">
                                <textarea class="form-control" placeholder="@translate(Your address)"
                                          name="address">{{ $customer->address ?? '' }}</textarea>
                            </div>


                            @if($errors->has('avatar'))
                                <div class="error text-danger">{{ $errors->first('avatar') }}</div>
                            @endif
                            <div class="form-group">
                                <input type="hidden" name="oldAvatar" value="{{ $customer->avatar ?? '' }}">
                                <input class="form-control pt-3" type="file" name="avatar">
                            </div>


                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="@translate(Password)"
                                       name="password">
                            </div>

                            @if($errors->has('password'))
                                <div class="error text-danger">{{ $errors->first('password') }}</div>
                            @endif
                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="@translate(Confirm password)"
                                       name="password_confirmation">
                            </div>

                            <button type="submit" class="ps-btn">@translate(Save)</button>
                        </figure>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
