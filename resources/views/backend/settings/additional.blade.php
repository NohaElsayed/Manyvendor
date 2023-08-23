@extends('backend.layouts.master')
@section('title') @translate(Setting)  @endsection
@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="card m-2">


                <div class="card-header">
                    <h2 class="card-title">@translate(Additional Setting)</h2>
                </div>

                {{-- Sidebar Additional Informations --}}
                <div class="card-body">
                    <h5>@translate(Sidebar Additional Information)</h5>
                    <form method="post" action="{{route('additional.setting.store')}}" enctype="multipart/form-data">
                    @csrf

                        <!--Shipping Boundary-->
                        <label class="label mt-3">@translate(Shipping Boundary)</label>
                        <input type="hidden" value="type_shipping" name="type_shipping">
                        <input type="text" value="{{getSystemSetting('type_shipping')}}" name="shipping_boundary"
                               class="form-control">

                        <!--Return-->
                        <label class="label mt-3">@translate(Return)</label>
                        <input type="hidden" value="type_return" name="type_return">
                        <input type="text" value="{{getSystemSetting('type_return')}}" name="return"
                               class="form-control">

                        <!--Payment system-->
                        <label class="label mt-3">@translate(Payment system)</label>
                        <input type="hidden" value="type_payment_system" name="type_payment_system">
                        <input type="text" value="{{getSystemSetting('type_payment_system')}}" name="payment_system"
                               class="form-control">


                        <div class="m-2 float-right">
                            <button class="btn btn-block btn-primary" type="submit">@translate(Save)</button>
                        </div>
                    </form>
                </div>

                {{-- Footer Additional Informations --}}
                 <div class="card-body">
                    <h5>@translate(Footer Additional Information)</h5>
                    <form method="post" action="{{route('additional.setting.store')}}" enctype="multipart/form-data">
                    @csrf

                        <!--Shipping Boundary-->
                        <label class="label mt-3">@translate(Delivery Rate)</label>
                        <input type="hidden" value="type_delivery" name="type_delivery">
                        <input type="text" value="{{getSystemSetting('type_shipping')}}" name="dalivery_rate"
                               class="form-control">


                        <!--Return-->
                        <label class="label mt-3">@translate(Return Policy)</label>
                        <input type="hidden" value="type_return_policy" name="type_return_policy">
                        <input type="text" value="{{getSystemSetting('type_return_policy')}}" name="return_policy"
                               class="form-control">

                        <!--Payment system-->
                        <label class="label mt-3">@translate(Payment Guarantee)</label>
                        <input type="hidden" value="type_payment_guarantee" name="type_payment_guarantee">
                        <input type="text" value="{{getSystemSetting('type_payment_guarantee')}}" name="payment_guarantee"
                               class="form-control">

                        <!--Payment system-->
                        <label class="label mt-3">@translate(Support)</label>
                        <input type="hidden" value="type_support" name="type_support">
                        <input type="text" value="{{getSystemSetting('type_support')}}" name="support"
                               class="form-control">


                        <div class="m-2 float-right">
                            <button class="btn btn-block btn-primary" type="submit">@translate(Save)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection




