@extends('backend.layouts.master')
@section('title')
@endsection
<title>{{getSystemSetting('type_name')}} | @translate(Affiliate Settings)</title>
@section('content')
	<div class="row">
		<div class="col-md-8 offset-2">
			<div class="card m-2">
				<div class="card-header">
					<h2 class="card-title">@translate(Affiliate Settings)</h2>
				</div>
				<div class="card-body">
					<form method="post" action="{{route('admins.affiliate.storeSettings')}}" enctype="multipart/form-data">
					@csrf

						<!--commission-->
						<label class="label">@translate(Affiliate commission) %</label>
						<input type="number" step="0.01" value="{{getSystemSetting('affiliate_commission')}}" name="affiliate_commission"
						       class="form-control mb-2" placeholder="@translate(Enter commission in %)">

						<!--withdraw_limit-->
						<label class="label">@translate(Minimum withdrawal amount)</label>
						<input type="number" step="0.01"  value="{{getSystemSetting('affiliate_min_withdrawal')}}" name="affiliate_min_withdrawal"
						       class="form-control mb-2" placeholder="@translate(Enter the minimum withdrawal amount)">

						<!--cookies_limit-->
						<label class="label">@translate(Cookies lifetime of referral affiliation code)(@translate(in days))</label>
						<input type="number" value="{{getSystemSetting('affiliate_cookie_limit')}}" name="affiliate_cookie_limit"
						       class="form-control mb-2" placeholder="@translate(Enter the number of days)">


						<!--Payment methods-->
						@php
							$paymentMethods = explode(',',getSystemSetting('affiliate_payment'));
						@endphp
						<label>@translate(Payment options for affiliate user)</label>
						<select class="form-control select2" name="affiliate_payment[]" multiple>
							<option value="Bank" {{in_array('Bank',$paymentMethods) ? 'selected':''}}>@translate(Bank)</option>
							@if(env('PAYPAL_APP_SECRET'))
								<option value="PayPal" {{in_array('PayPal',$paymentMethods) ? 'selected':''}}>@translate(PayPal)</option>
								@endif

							@if(env('STRIPE_SECRET'))
								<option value="Stripe" {{in_array('Stripe',$paymentMethods) ? 'selected':''}}>@translate(Stripe)</option>
							@endif

							@if(env('PAYTM_ACTIVE')== "YES")
								<option value="PayTm" {{in_array('PayTm',$paymentMethods) ? 'selected':''}}>@translate(PayTm) (@translate(India))</option>
							@endif
							<option value="Bkash" {{in_array('Bkash',$paymentMethods) ? 'selected':''}}>@translate(Bkash) (@translate(Bangladesh))</option>
							<option value="Nagad" {{in_array('Nagad',$paymentMethods) ? 'selected':''}}>@translate(Nagad) (@translate(Bangladesh))</option>
							<option value="Rocket" {{in_array('Rocket',$paymentMethods) ? 'selected':''}}>@translate(Rocket) (@translate(Bangladesh))</option>
						</select>

						<div class="m-2 float-right">
							<button class="btn btn-primary" type="submit">@translate(Save)</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>


@endsection

@section('script')
@stop
