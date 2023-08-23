@extends('backend.layouts.master')
@section('title') Profile  @endsection
@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="card m-2">
                <div class="card-header">
                    <h2 class="card-title">{{ $seller_profile->shop_name }} Profile</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('vendor.update') }}" enctype="multipart/form-data">
                    @csrf

                    <!--logo-->
                        <label class="label">@translate(Seller Shop Logo)</label>

                        <div class="avatar-upload">

                            <div class="avatar-edit">
                                <input type='file' name="shop_logo" id="imageUpload" accept=".png, .jpg, .jpeg"/>
                                <label for="imageUpload"></label>
                            </div>

                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{filePath($seller_profile->vendor->shop_logo)}});">
                                </div>
                            </div>



                        </div>

                        <div class="card-body">

                                <div class="form-group row">
                                    <label for="owner" class="col-sm-2 col-form-label">@translate(Shop owner)</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ $seller_profile->vendor->shop_name }}" id="owner" placeholder="Shop owner" name="shop_name" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">@translate(Shop email)</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email" placeholder="email" value="{{ $seller_profile->vendor->email }}" name="email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="number" class="col-sm-2 col-form-label">@translate(Shop number)</label>
                                    <div class="col-sm-10">
                                    <input type="number" class="form-control" value="{{ $seller_profile->vendor->phone }}" id="number" placeholder="Number" name="phone">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nationality" class="col-sm-2 col-form-label">@translate(Nationality)</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ $seller_profile->nationality }}" id="nationality" placeholder="Nationality" name="nationality">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">@translate(Gender)</label>
                                    <label for="male"  class="mr-2"><input type="radio" id="male" name="genders" value="Male" @if($seller_profile->genders === 'Male') checked @endif> @translate(Male)</label>
                                    <label for="female"  class="mr-2"><input type="radio" id="female" name="genders" value="Female" @if($seller_profile->genders === 'Female') checked @endif>  @translate(Female)</label>
                                    <label for="other"><input type="radio" id="Other" name="genders" value="Other" @if($seller_profile->genders === 'Other') checked @endif>  @translate(Other)</label>

                                </div>

                                <div class="form-group row">
                                    <label for="trade_licence" class="col-sm-2 col-form-label">@translate(Trade Licence)</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="trade_licence" value="{{ $seller_profile->vendor->trade_licence }}" name="trade_licence" placeholder="Trade Licence" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">@translate(Address)</label>
                                    <div class="col-sm-10">
                                    <input type="text" name="address" class="form-control" id="address" value="{{ $seller_profile->vendor->address }}" placeholder="Address">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="about" class="col-sm-2 col-form-label">@translate(About)</label>
                                    <div class="col-sm-10">
                                    <input type="text" name="about" class="form-control" id="about" value="{{ $seller_profile->vendor->about }}" placeholder="About Your Shop">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="facebook" class="col-sm-2 col-form-label">@translate(Facebook)</label>
                                    <div class="col-sm-10">
                                    <input type="text" name="facebook" class="form-control" id="facebook" value="{{ $seller_profile->vendor->facebook }}" placeholder="Facebook Link">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">@translate(Password)</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-2 col-form-label">@translate(Password)</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm password" name="password_confirmation">
                                    </div>
                                </div>

                                <div class="form-group row">
                                   <button class="btn btn-primary" type="submit">@translate(Save changes)</button>
                                </div>

                                </div>
                        <!--logo end-->

                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection



@section('js-link')

@stop

@section('page-script')
@stop
