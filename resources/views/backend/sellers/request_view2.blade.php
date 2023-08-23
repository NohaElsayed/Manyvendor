@extends('backend.layouts.master')
@section('title')
    @translate(Seller Details)
@endsection
@section('content')

    <div class="card card-primary mx-3">
        <div class="card-header">
            <h3 class="card-title">{{$single_request_vendor->name}}</h3>

            <!-- there are the main content-->
            <div class="float-right">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-2">
            @if($single_request_vendor->approve_status == 0)

                <form action="{{route('vendor.requests.accept',$single_request_vendor->id)}}" method="post">
                    @csrf
                    @endif

                    <div class="">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@translate(Name)</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $single_request_vendor->name}}" readonly autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">@translate(Email)</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $single_request_vendor->email}}" readonly autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group row">
                            <label for="shop_name" class="col-md-4 col-form-label text-md-right">@translate(Shop Name)</label>
                            <div class="col-md-6">
                                <input id="shop_name" type="text" class="form-control @error('shop_name') is-invalid @enderror" name="shop_name" value="{{ $single_request_vendor->shop_name}}" readonly autocomplete="shop_name" autofocus>

                                @error('shop_name')
                                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">@translate(Phone)</label>
                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $single_request_vendor->phone}}" readonly autocomplete="phone" autofocus>

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group row">
                            <label for="trade_licence" class="col-md-4 col-form-label text-md-right">@translate(Trade Licence)</label>
                            <div class="col-md-6">
                                <input id="trade_licence" type="number" class="form-control @error('trade_licence') is-invalid @enderror" name="trade_licence" value="{{ $single_request_vendor->trade_licence}}" readonly autocomplete="trade_licence" autofocus>

                                @error('trade_licence')
                                <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    @if($single_request_vendor->approve_status == 0)

                        <div class="">
                            <div class="form-group row">
                                <div class="col-md-3 offset-md-9">
                                    <button type="submit" class="btn btn-success">@translate(Approve)</button>
                                </div>
                            </div>
                        </div>
                </form>
            @endif


        </div>

    </div>

@endsection

