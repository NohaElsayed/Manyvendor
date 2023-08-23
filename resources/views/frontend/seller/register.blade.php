@extends('frontend.master')

@section('title') @translate(Seller Registration) @endsection

@section('content')
    <div class="ps-contact-form">
        <div class="container">


            <form class="ps-form--contact-us needs-validation" novalidate action="{{ route('vendor.store') }}"
                  method="post" enctype="multipart/form-data">
                @csrf
                <h3>@translate(SELLER REGISTRATION)</h3>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><i class="icon-remove-sign"></i> {{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                    @endforeach
                @endif
                <div class="row">


                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                        <h5>@translate(PERSONAL INFORMATION)</h5>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">

                        <div class="form-group">
                            <input class="form-control" name="name" required value="{{ old('name') }}" type="text"
                                   placeholder="@translate(Name) *">

                            <div class="invalid-feedback">
                                @translate(Name is required).
                            </div>

                            <div class="valid-feedback">
                                @translate(Looks good!)
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                        <div class="form-group">
                            <input class="form-control" name="email" value="{{ old('email') }}" type="text" required
                                   placeholder="@translate(Email) *">

                            <div class="invalid-feedback">
                                @translate(Email is required.)
                            </div>

                            <div class="valid-feedback">
                                @translate(Looks good!)
                            </div>

                        </div>
                    </div>


                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                        <h5>@translate(SHOP INFORMATION)</h5>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                        <div class="form-group">
                            <input class="form-control" name="shop_name" value="{{ old('shop_name') }}" type="text"
                                   required placeholder="@translate(Shop Name) *">

                            <div class="invalid-feedback">
                                @translate(Shop name is required.)
                            </div>

                            <div class="valid-feedback">
                                @translate(Looks good!)
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                        <div class="form-group">
                            <input class="form-control" name="trade_licence" value="{{ old('trade_licence') }}"
                                   type="text" required placeholder="@translate(Trade Licence) *">

                            <div class="invalid-feedback">
                                @translate(Trade licence is required.)
                            </div>

                            <div class="valid-feedback">
                                @translate(Looks good!)
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                        <div class="form-group">
                            <input class="form-control" name="phone" value="{{ old('phone') }}" type="number" required
                                   placeholder="@translate(Shop Phone Number) *">

                            <div class="invalid-feedback">
                                @translate(Shop phone number is required.)
                            </div>

                            <div class="valid-feedback">
                                @translate(Looks good!)
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                        <div class="form-group">
                            <input class="form-control" name="address" type="text" value="{{ old('address') }}" required
                                   placeholder="@translate(Shop Address) *">

                            <div class="invalid-feedback">
                                @translate(Shop address is required.)
                            </div>

                            <div class="valid-feedback">
                                @translate(Looks good!)
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                        <div class="form-group">
                            <input class="pt-3 form-control" required name="shop_logo" value="{{ old('shop_logo') }}"
                                   type="file">
                            <small>@translate(Owner Logo) *</small>

                            <div class="invalid-feedback">
                                @translate(Shop Logo is required.)
                            </div>

                            <div class="valid-feedback">
                                @translate(Looks good!)
                            </div>
                        </div>

                    </div>

                </div>
                <div class="form-group submit">
                    <button class="ps-btn">@translate(Apply For Seller)</button>
                </div>
            </form>
        </div>
    </div>
@stop


