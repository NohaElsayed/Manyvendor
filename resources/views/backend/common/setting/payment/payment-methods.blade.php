@extends('backend.layouts.master')
@section('title')@endsection
<title>{{getSystemSetting('type_name')}} | @translate(Payment Methods)</title>
@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">
        <form method="post" action="{{route('payment.method.store')}}">
        @csrf
            <div class="card mt-2">
                <div class="card-header">
                    <h2 class="card-title"><i class="fa fa-money text-warning mr-2"></i>@translate(Setup Payment Methods)</h2>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="card-title">@translate(Paypal)</h2> <br/>
                    <div class="fs-12 text-warning">@translate(You need paypal merchant account to integrate paypal for your business.)</div>
                </div>
                <div class="card-body">
                    <label class="label">@translate(PAYPAL ENVIRONMENT)</label>
                    <input type="hidden" name="types[]" value="PAYPAL_ENVIRONMENT">
                    <select class="form-control" name="PAYPAL_ENVIRONMENT">
                        <option value="sandbox"
                                @if (env('PAYPAL_ENVIRONMENT') == "sandbox") selected @endif>
                            Sandbox
                        </option>
                        <option value="production" @if (env('PAYPAL_ENVIRONMENT') == "production") selected @endif>Production
                        </option>
                    </select>

                    <label class="label">@translate(PAYPAL CLIENT ID)</label>
                    <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                    <input type="text" placeholder="@translate(Enter the data)" value="{{env('PAYPAL_CLIENT_ID')}}"
                           name="PAYPAL_CLIENT_ID"
                           class="form-control mb-2">

                    <label class="label">@translate(PAYPAL APP SECRET)</label>
                    <input type="hidden" name="types[]" value="PAYPAL_APP_SECRET">
                    <input type="text" placeholder="@translate(Enter the data)" value="{{env('PAYPAL_APP_SECRET')}}"
                           name="PAYPAL_APP_SECRET"
                           class="form-control mb-2">
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="card-title">@translate(Stripe)</h2>
                </div>
                <div class="card-body">
                    <label class="label">@translate(STRIPE KEY)</label>
                    <input type="hidden" name="types[]" value="STRIPE_KEY">
                    <input type="text" placeholder="@translate(Enter stripe publishable key)" value="{{env('STRIPE_KEY')}}"
                           name="STRIPE_KEY"
                           class="form-control mb-2">

                    <label class="label">@translate(STRIPE SECRET)</label>
                    <input type="hidden" name="types[]" value="STRIPE_SECRET">
                    <input type="text" placeholder="@translate(Enter stripe secret key)" value="{{env('STRIPE_SECRET')}}"
                           name="STRIPE_SECRET"
                           class="form-control mb-2">
                </div>
            </div>

            @if(env('PAYTM_ACTIVE') != "NO") 
         <div class="card mt-4">
                <div class="card-header">
                    <h2 class="card-title">@translate(Paytm)</h2>
                </div>

             <div class="card-body">

                        <label class="label">@translate(PAYTM_ENVIRONMENT)(Production Environment Only) <a href="https://developer.paytm.com/" target="_blank"><i class="fa fa-info text-warning"></i></a></label>
                        <input type="hidden" name="types[]" value="PAYTM_ENVIRONMENT">
                        <input type="text" placeholder="@translate(Enter the data)" value="{{env('PAYTM_ENVIRONMENT')}}"
                               name="PAYTM_ENVIRONMENT"
                               class="form-control mb-2">

                        <label class="label">@translate(PAYTM_MERCHANT_ID)</label>
                        <input type="hidden" name="types[]" value="PAYTM_MERCHANT_ID">
                        <input type="text" placeholder="@translate(Enter the data)" value="{{env('PAYTM_MERCHANT_ID')}}"
                               name="PAYTM_MERCHANT_ID"
                               class="form-control mb-2">

                        <label class="label">@translate(PAYTM_MERCHANT_KEY)</label>
                        <input type="hidden" name="types[]" value="PAYTM_MERCHANT_KEY">
                        <input type="text" placeholder="@translate(Enter the data)" value="{{env('PAYTM_MERCHANT_KEY')}}"
                               name="PAYTM_MERCHANT_KEY"
                               class="form-control mb-2">

                        <label class="label">@translate(PAYTM_MERCHANT_WEBSITE)</label>
                        <input type="hidden" name="types[]" value="PAYTM_MERCHANT_WEBSITE">
                        <input type="text" placeholder="@translate(Enter the data)" value="{{env('PAYTM_MERCHANT_WEBSITE')}}"
                               name="PAYTM_MERCHANT_WEBSITE"
                               class="form-control mb-2">

                        <label class="label">@translate(PAYTM_CHANNEL)</label>
                        <input type="hidden" name="types[]" value="PAYTM_CHANNEL">
                        <input type="text" placeholder="@translate(Enter the data)" value="{{env('PAYTM_CHANNEL')}}"
                               name="PAYTM_CHANNEL"
                               class="form-control mb-2">

                        <label class="label">@translate(PAYTM_INDUSTRY_TYPE)</label>
                        <input type="hidden" name="types[]" value="PAYTM_INDUSTRY_TYPE">
                        <input type="text" placeholder="@translate(Enter the data)" value="{{env('PAYTM_INDUSTRY_TYPE')}}"
                               name="PAYTM_INDUSTRY_TYPE"
                               class="form-control mb-2">

                               
                            </div>
                        </div>
                        @endif 

                        @if(env('SSL_COMMERZ_ACTIVE') != "NO") 
           <div class="card mt-4">
                <div class="card-header">
                    <h2 class="card-title">@translate(SSL Commerz)</h2>
                </div>

                 <div class="card-body">


                        <label class="label">@translate(STORE_ID) <a href="https://developer.sslcommerz.com/" target="_blank"><i class="fa fa-info text-warning"></i></a></label>
                        <input type="hidden" name="types[]" value="STORE_ID">
                        <input type="text" placeholder="@translate(Enter the data)" value="{{env('STORE_ID')}}"
                               name="STORE_ID"
                               class="form-control mb-2">

                        <label class="label">@translate(STORE_PASSWORD)</label>
                        <input type="hidden" name="types[]" value="STORE_PASSWORD">
                        <input type="text" placeholder="@translate(Enter the data)" value="{{env('STORE_PASSWORD')}}"
                               name="STORE_PASSWORD"
                               class="form-control mb-2">
                            </div>
                        </div>
                        @endif 
                        
            <div class="text-center">
                <button class="btn btn-primary px-5" type="submit">@translate(Save)</button>
            </div>

        </form>

            <hr>
            <form method="post" action="{{route('payment.logo.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card mt-2">
                    <div class="card-header">
                        <h2 class="card-title">@translate(Payment  method logos)</h2>
                    </div>

                @if(getSystemSetting('payment_logo') != null)
                    <img src="{{filePath(getSystemSetting('payment_logo'))}}" class="img-size-64 center m-3">
                @endif

                <div class="m-2 mr-4">
                    <input type="file" class="form-control" name="payment_logo">
                </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary px-5 mb-3" type="submit">@translate(Save)</button>
                </div>


            </form>
    </div>
</div>


@endsection
