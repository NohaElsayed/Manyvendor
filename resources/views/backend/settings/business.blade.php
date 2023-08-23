@extends('backend.layouts.master')
@section('title')
@endsection
<title>{{getSystemSetting('type_name')}} | @translate(System Settings)</title>
@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="card m-2">
                <div class="card-header">
                    <h2 class="card-title">@translate(System Setting)</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('business.setting.store')}}" enctype="multipart/form-data">
                    @csrf
                    <!--seller-->
                        <label class="label d-none">@translate(Seller status)</label>
                        <input type="hidden" value="seller" name="seller">
                        <select name="seller_status" class="form-control d-none">
                            <option value="enable" {{getSystemSetting('seller') == 'enable' ? 'selected':null}}>
                                @translate(Enable)
                            </option>
                            <option value="disable" {{getSystemSetting('seller') == 'disable' ? 'selected':null}}>
                                @translate(disable)
                            </option>
                        </select>


                        @if(sellerStatus())
                            <label class="label">@translate(Publish Mode)</label>
                            <input type="hidden" value="seller_mode" name="seller_mode">
                            <select name="mode_status" class="form-control select2">
                                <option
                                        value="request" {{getSystemSetting('seller_mode') == 'request' ? 'selected':null}}>
                                    @translate(Seller can request)
                                </option>
                                <option
                                        value="freedom" {{getSystemSetting('seller_mode') == 'freedom' ? 'selected':null}}>
                                    @translate(Seller can publish)
                                </option>
                            </select>
                        @endif


                    <!--Primary Color Picker -->
                        <div class="form-group mt-2 d-none">
                            <label>@translate(Primary Color)</label>
                            <input type="hidden" value="primary_color" name="primary_color">
                            <div class="input-group my-colorpicker2">
                                <input type="text" class="form-control" name="p_color"
                                       value="{{getSystemSetting('primary_color')}}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"
                                                                      style="color: {{getSystemSetting('primary_color')}}"></i></span>
                                </div>
                            </div>
                        </div>

                        {{--Secondary color picker--}}
                        <div class="form-group d-none">
                            <label>@translate(Secondary Color)</label>
                            <input type="hidden" value="secondary_color" name="secondary_color">
                            <div class="input-group my-colorpicker3">
                                <input type="text" class="form-control" name="s_color"
                                       value="{{getSystemSetting('secondary_color')}}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"
                                                                      style="color: {{getSystemSetting('secondary_color')}}"></i></span>
                                </div>
                            </div>
                        </div>

                        <!--verifications--->
                        <label class="label mt-2">@translate(Email Verifications)</label>
                        <input type="hidden" value="verification" name="verification">
                        <select name="verification_status" class="form-control select2">
                            <option value="on" {{getSystemSetting('verification') == 'on' ? 'selected':null}}>
                                @translate(on)
                            </option>
                            <option value="off" {{getSystemSetting('verification') == 'off' ? 'selected':null}}>
                                @translate(off)
                            </option>
                        </select>

                        <!--Guest checkout--->
                        <label class="label mt-2">@translate(Allow Guest Checkout) ?</label>
                        <input type="hidden" value="checkout" name="checkout">
                        <select name="guest_status" class="form-control select2">
                            <option value="YES" {{env('GUEST_CHECKOUT') == 'YES' ? 'selected':null}}>
                                @translate(Active)
                            </option>
                            <option value="NO" {{env('GUEST_CHECKOUT') == 'NO' ? 'selected':null}}>
                                @translate(Block)
                            </option>
                        </select>

                        {{--Logistic --}}
                        <label class="label mt-2">@translate(Logistic Activation)</label>
                        <select name="logistic_active" class="form-control select2">
                            <option value="YES" {{env('LOGISTIC_ACTIVE') == 'YES' ? 'selected':null}}>
                                @translate(Active)
                            </option>
                            <option value="NO" {{env('LOGISTIC_ACTIVE') == 'NO' ? 'selected':null}}>
                                @translate(Deactivate)
                            </option>
                        </select>

                        {{--Deliver--}}
                        <label class="label mt-2">@translate(Deliver Activation)</label>
                        <select name="deliver_active" class="form-control select2">
                            <option value="YES" {{env('DELIVER_ACTIVE') == 'YES' ? 'selected':null}}>
                                @translate(Active)
                            </option>
                            <option value="NO" {{env('DELIVER_ACTIVE') == 'NO' ? 'selected':null}}>
                                @translate(Deactivate)
                            </option>
                        </select>

{{--                        @if(deliverActive())--}}
{{--                            <label class="label mt-2">@translate(Deliver Process)</label>--}}
{{--                            <select name="deliver_process" class="form-control select2">--}}
{{--                                <option value="YES" {{env('DELIVER_PROCESS') == 'YES' ? 'selected':null}}>--}}
{{--                                    @translate(Deliveryman Can Pick the order)--}}
{{--                                </option>--}}
{{--                                <option value="NO" {{env('DELIVER_PROCESS') == 'NO' ? 'selected':null}}>--}}
{{--                                    @translate(Admin Assign the Orders in Deliveryman)--}}
{{--                                </option>--}}
{{--                            </select>--}}
{{--                        @endif--}}


                        <label class="label mt-2">@translate(Time Zone)</label>
                        <input type="text" name="TIME_ZONE" value="{{env('TIME_ZONE')}}" class="form-control">

                        <!--verifications--->
{{--                        <label class="label d-none">@translate(Customer Login Mode)</label>--}}
{{--                        <input type="hidden" value="login_modal" name="login_modal">--}}
{{--                        <div class="d-none">--}}
{{--                            <select name="login_status" class="form-control select2  d-none">--}}
{{--                                <option value="on" {{getSystemSetting('login_modal') == 'on' ? 'selected':null}}>--}}
{{--                                    @translate(On Modal)--}}
{{--                                </option>--}}
{{--                                <option value="off" {{getSystemSetting('login_modal') == 'off' ? 'selected':null}}>--}}
{{--                                    @translate(off Modal)--}}
{{--                                </option>--}}
{{--                            </select>--}}
{{--                        </div>--}}



                        <div class="m-2 float-right">
                            <button class="btn btn-block btn-primary" type="submit">@translate(Save)</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection



@section('script')
@stop
