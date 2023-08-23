@extends('frontend.master')

@section('title')
	| @translate(Withdraw Money)
@endsection
@section('content')
	@include('frontend.affiliate.include.navbar')
		<div class="row">
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
				<figure class="text-center">
					@include('frontend.affiliate.include.aside')
				</figure>

			</div>
			<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
				<figure class="ps-block--vendor-status card px-4 pb-3">
					<figcaption class="fs-10 text-center py-3 my-auto">@translate(Make Withdrawal Request)</figcaption>
					<div class="card px-5 pt-3 mb-4">
						<div class="pt-2">
							@php
								$user = \App\Models\AffiliateAccount::where('user_id', Auth::id())->first();
							@endphp
							<h4>@translate(Your current balance is) : <span class="font-weight-bold">{{formatPrice($user->balance)}}</span></h4>
							<h4>@translate(Minimum withdrawal amount is) : <span class="font-weight-bold">{{formatPrice(getSystemSetting('affiliate_min_withdrawal'))}}</span></h4>
							</div>
						<hr>
						@if(affiliateNotBlockedUser())
						<form method="post" action="{{route('customers.affiliate.storeWithdrawAffiliatedMoney')}}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="form-group col-md-6 col-sm-12">
									<label>@translate(Enter Withdrawal Amount)</label>
									<input type="number" step="0.01" class="form-control" name="amount" placeholder="Enter Withdrawal Amount" required>
								</div>
								<div class="form-group col-md-6 col-sm-12">
									<!--Payment methods-->
									@php
										$paymentMethods = explode(',',getSystemSetting('affiliate_payment'));
									@endphp
									<label>
										@if(
    										$user->paymentAccount->account_number != null
										 || $user->paymentAccount->paypal_acc_email != null
										 || $user->paymentAccount->stripe_card_number != null
										 || $user->paymentAccount->PayTm_number != null
										 || $user->paymentAccount->bKash_number != null
										 || $user->paymentAccount->nagad_number != null
										 || $user->paymentAccount->rocket_number != null
											)
											@translate(Select Payment Account)
											@else
											<a class="text-danger" href="{{ route('customers.affiliate.setPaymentAccounts') }}">@translate(Please set your payment account)</a>
										@endif
									</label>
									<select class='form-control' name='payment_account' required>
										<option value="">@translate(Please select a payment account)</option>

										@if(in_array('Bank',$paymentMethods) && $user->paymentAccount->account_number != null)
												<option value="Bank">@translate(Bank)</option>
										@endif

										@if(in_array('PayPal',$paymentMethods) && $user->paymentAccount->paypal_acc_email != null)
											<option value="PayPal">@translate(Paypal)</option>
										@endif

										@if(in_array('Stripe',$paymentMethods) && $user->paymentAccount->stripe_card_number != null)
											<option value="Stripe">@translate(Stripe)</option>
										@endif

										@if(in_array('PayTm',$paymentMethods) && $user->paymentAccount->PayTm_number != null)
											<option value="PayTm">@translate(PayTm)</option>
										@endif

										@if(in_array('Bkash',$paymentMethods) && $user->paymentAccount->bKash_number != null)
											<option value="Bkash">@translate(Bkash)</option>
										@endif

										@if(in_array('Nagad',$paymentMethods) && $user->paymentAccount->nagad_number != null)
											<option value="Nagad">@translate(Nagad)</option>
										@endif

										@if(in_array('Rocket',$paymentMethods) && $user->paymentAccount->rocket_number != null)
											<option value="Rocket">@translate(Rocket)</option>
										@endif

									</select>
								</div>
								<button class="ps-btn py-3 ml-4 mb-3">@translate(Make Withdrawal Request)</button>
							</div>
						</form>
						@else
							<h4 class="text-danger card text-center py-5 px-3">@translate(You have been blocked by admin.)</h4>
						@endif
					</div>
				</figure>
			</div>
		</div>
	</div>
	</div>
@stop
