@extends('backend.layouts.master')
@section('title') @endsection
<title>{{getSystemSetting('type_name')}} | @translate(Add Seller)</title>
@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="card card-primary m-2">
                <div class="card-header">
                    <h2 class="card-title">@translate(Add New Seller)</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('manual.vendor.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!--logo-->
                        <label class="label">@translate(Seller Shop Logo)</label>

                        <div class="avatar-upload">

                            <div class="avatar-edit">
                                <input type='file' name="shop_logo" id="imageUpload" accept=".png, .jpg, .jpeg"/>
                                <label for="imageUpload"></label>
                            </div>

                            <div class="avatar-preview">
                                <div id="imagePreview">
                                </div>
                            </div>


                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                                <label for="shop_name" class="col-sm-2 col-form-label">@translate(Shop Name)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ old('shop_name') }}"
                                           id="shop_name" placeholder="Shop Name" name="shop_name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="owner" class="col-sm-2 col-form-label">@translate(Owner name)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ old('name') }}" id="owner"
                                           placeholder="Shop owner name" name="name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">@translate(Email)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email" value="{{ old('email') }}"
                                           placeholder="Email" name="email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="number" class="col-sm-2 col-form-label">@translate(Number)</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="number" value="{{ old('number') }}"
                                           placeholder="Number" name="phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nationality" class="col-sm-2 col-form-label">@translate(Nationality)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nationality"
                                           value="{{ old('nationality') }}" placeholder="Nationality"
                                           name="nationality">
                                </div>
                            </div>

{{--                            <div class="form-group row">--}}
{{--                                <label class="col-sm-2 col-form-label">@translate(Gender)</label>--}}
{{--                                <label class="mr-2 ml-2" for="male"><input type="radio" id="male" name="genders"--}}
{{--                                                                      value="Male"> @translate(Male) </label>--}}
{{--                                <label class="mr-2" for="female"><input type="radio" id="female" name="genders"--}}
{{--                                                                        value="Female"> @translate(Female) </label>--}}
{{--                                <label for="other"><input type="radio" id="other" name="genders" value="Other">--}}
{{--                                    @translate(Other)</label>--}}
{{--                            </div>--}}

                            <div class="form-group row">
                                <label for="trade_licence" class="col-sm-2 col-form-label">@translate(Trade
                                    Licence)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="trade_licence"
                                           value="{{ old('trade_licence') }}" name="trade_licence"
                                           placeholder="Trade Licence">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-2 col-form-label">@translate(Address)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                                           id="address" placeholder="Address">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="about" class="col-sm-2 col-form-label">@translate(About)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="about" class="form-control" value="{{ old('about') }}"
                                           id="about" placeholder="About Your Shop">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="facebook" class="col-sm-2 col-form-label">@translate(Facebook)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="facebook" class="form-control"
                                           value="{{ old('facebook') }}" id="facebook" placeholder="Facebook Link">
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <button class="btn btn-primary" type="submit">@translate(Save)</button>
                            </div>

                        </div>
                        <!--logo end-->

                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection



