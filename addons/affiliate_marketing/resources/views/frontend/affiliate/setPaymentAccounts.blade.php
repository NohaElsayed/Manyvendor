@extends('frontend.master')

@section('title')
	| @translate(Set Payment Accounts)
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
				<figure class="ps-block--vendor-status card px-4">
					<figcaption class="fs-10 text-center py-3 my-auto">@translate(Set your account to withdraw money)</figcaption>
					@if(affiliateNotBlockedUser())
					<form method="post" action="{{route('customers.affiliate.storePaymentAccounts')}}" enctype="multipart/form-data">
						@csrf
						<div class="accordion" id="accordionPaymentAccounts">
							@php
								$paymentMethods = explode(',',getSystemSetting('affiliate_payment'));
							@endphp

							@if(in_array('Bank',$paymentMethods))
							<div class="card m-3">
								<div class="card-header" id="headingBank">
									<p class="font-weight-bold fs-16 btn btn-link text-primary collapsed" data-toggle="collapse" data-target="#collapseBank" aria-expanded="true" aria-controls="collapseBank">@translate(Bank Account)</p>
								</div>
								<div id="collapseBank" class="collapse show" aria-labelledby="headingBank" data-parent="#accordionPaymentAccounts">
									<div class="card-body border-bottom">
										<div class="form-group m-2">
											<label class="label">@translate(Bank Name)</label>
											<input type="text" placeholder="@translate(Enter Bank Name)"
											       value="{{$account->bank_name ?? ''}}" name="bank_name"
											       class="form-control">
										</div>


										<div class="form-group m-2">
											<label class="label">@translate(Account Name)</label>
											<input type="text" placeholder="@translate(Enter Account Name)"
											       value="{{$account->account_name ?? ''}}" name="account_name"
											       class="form-control">
										</div>

										<div class="form-group m-2">
											<label class="label">@translate(Account Number)</label>
											<input type="text" placeholder="@translate(Enter Account Number)"
											       value="{{$account->account_number ?? ''}}" name="account_number"
											       class="form-control">
										</div>
										<div class="form-group m-2">
											<label class="label">@translate(Routing Number)</label>
											<input type="number" placeholder="@translate(Enter Routing Number)"
											       value="{{$account->routing_number ?? ''}}" name="routing_number"
											       class="form-control">
										</div>
									</div>
								</div>
							</div>
							@endif

							@if(in_array('PayPal',$paymentMethods))
							<div class="card m-3">
								<div class="card-header" id="headingPayPal">
									<p class="font-weight-bold btn btn-link text-primary collapsed fs-16" data-toggle="collapse" data-target="#collapsePayPal" aria-expanded="true" aria-controls="collapsePayPal">@translate(PayPal Account) </p>
								</div>
								<div id="collapsePayPal" class="collapse" aria-labelledby="headingPayPal" data-parent="#accordionPaymentAccounts">
									<div class="card-body border-bottom">
										<div class="form-group m-2">
											<label class="label">@translate(Paypal Account Name)</label>
											<input type="text" placeholder="@translate(Enter Paypal Acc Name)"
											       value="{{$account->paypal_acc_name ?? ''}}" name="paypal_acc_name"
											       class="form-control">
										</div>
										<div class="form-group m-2">
											<label class="label">@translate(Paypal Account Email)</label>
											<input type="email" placeholder="@translate(Enter Paypal Acc Email)"
											       value="{{$account->paypal_acc_email ?? ''}}" name="paypal_acc_email"
											       class="form-control">
										</div>
									</div>
								</div>
							</div>
							@endif

							@if(in_array('Stripe',$paymentMethods))
							<div class="card m-3">
								<div class="card-header" id="headingStripe">
									<p class="font-weight-bold btn btn-link text-primary collapsed fs-16" data-toggle="collapse" data-target="#collapseStripe" aria-expanded="true" aria-controls="collapseStripe">@translate(Stripe Account)</p>
								</div>
								<div id="collapseStripe" class="collapse" aria-labelledby="headingStripe" data-parent="#accordionPaymentAccounts">
									<div class="card-body border-bottom">
										<div class="form-group m-2">
											<label class="label">@translate(Stripe Account Name)</label>
											<input type="text" placeholder="@translate(Enter Stripe Acc Name)"
											       value="{{$account->stripe_acc_name ?? ''}}" name="stripe_acc_name"
											       class="form-control">
										</div>
										<div class="form-group m-2">
											<label class="label">@translate(Stripe Account Email)</label>
											<input type="email" placeholder="@translate(Enter Stripe Acc Email)"
											       value="{{$account->stripe_acc_email ?? ''}}" name="stripe_acc_email"
											       class="form-control">
										</div>
										<div class="form-group m-2">
											<label class="label">@translate(Stripe Card Holder Name)</label>
											<input type="text" placeholder="@translate(Enter Stripe Card Holder Name)"
											       value="{{$account->stripe_card_holder_name ?? ''}}"
											       name="stripe_card_holder_name"
											       class="form-control">
										</div>
										<div class="form-group m-2">
											<label class="label">@translate(Stripe Card Number)</label>
											<input type="number" placeholder="@translate(Enter Stripe Card Number)"
											       value="{{$account->stripe_card_number ?? ''}}" name="stripe_card_number"
											       class="form-control">
										</div>
									</div>
								</div>
							</div>
							@endif

							@if(in_array('PayTm',$paymentMethods))
							<div class="card m-3">
								<div class="card-header" id="headingPayTm">
									<p class="font-weight-bold btn btn-link text-primary collapsed fs-16" data-toggle="collapse" data-target="#collapsePayTm" aria-expanded="true" aria-controls="collapsePayTm">@translate(PayTm Account) </p>
								</div>
								<div id="collapsePayTm" class="collapse" aria-labelledby="headingPayTm" data-parent="#accordionPaymentAccounts">
									<div class="card-body border-bottom">
										<div class="form-group m-2">
											<label class="label">@translate(PayTm Account Number)</label>
											<input type="text" placeholder="@translate(Enter PayTm Acc Number)"
											       value="{{$account->payTm_number ?? ''}}" name="PayTm_number"
											       class="form-control">
										</div>
									</div>
								</div>
							</div>
							@endif

							@if(in_array('Bkash',$paymentMethods))
							<div class="card m-3">
								<div class="card-header" id="heading">
									<p class="font-weight-bold btn btn-link text-primary collapsed fs-16" data-toggle="collapse" data-target="#collapseBkash" aria-expanded="true" aria-controls="collapseBkash">@translate(Bkash Account) </p>
								</div>
								<div id="collapseBkash" class="collapse" aria-labelledby="headingBkash" data-parent="#accordionPaymentAccounts">
									<div class="card-body border-bottom">
										<div class="form-group m-2">
											<label class="label">@translate(Bkash Account Number) <small class="text-danger">(@translate(Personal))</small></label>
											<input type="text" placeholder="@translate(Enter Bkash Acc Number)"
											       value="{{$account->bKash_number ?? ''}}" name="bKash_number"
											       class="form-control">
										</div>
									</div>
								</div>
							</div>
							@endif

							@if(in_array('Nagad',$paymentMethods))
							<div class="card m-3">
								<div class="card-header" id="headingNagad">
									<p class="font-weight-bold btn btn-link text-primary collapsed fs-16" data-toggle="collapse" data-target="#collapseNagad" aria-expanded="true" aria-controls="collapseNagad">@translate(Nagad Account) </p>
								</div>
								<div id="collapseNagad" class="collapse" aria-labelledby="headingNagad" data-parent="#accordionPaymentAccounts">
									<div class="card-body border-bottom">
										<div class="form-group m-2">
											<label class="label">@translate(Nagad Account Number) <small class="text-danger">(@translate(Personal))</small></label>
											<input type="text" placeholder="@translate(Enter Nagad Acc Number)"
											       value="{{$account->nagad_number ?? ''}}" name="nagad_number"
											       class="form-control">
										</div>
									</div>
								</div>
							</div>
							@endif

							@if(in_array('Rocket',$paymentMethods))
							<div class="card m-3">
								<div class="card-header" id="headingRocket">
									<p class="font-weight-bold btn btn-link text-primary collapsed fs-16" data-toggle="collapse" data-target="#collapseRocket" aria-expanded="true" aria-controls="collapseRocket">@translate(Rocket Account) </p>
								</div>
								<div id="collapseRocket" class="collapse" aria-labelledby="headingRocket" data-parent="#accordionPaymentAccounts">
									<div class="card-body border-bottom">
										<div class="form-group m-2">
											<label class="label">@translate(Rocket Account Number) <small class="text-danger">(@translate(Personal))</small></label>
											<input type="text" placeholder="@translate(Enter Rocket Acc Number)"
											       value="{{$account->rocket_number ?? ''}}" name="rocket_number"
											       class="form-control">
										</div>
									</div>
								</div>
							</div>
							@endif
							<button class="ps-btn py-3 ml-3 mb-3" type="submit">@translate(Save)</button>
					</form>
					@else
						<h4 class="text-danger card text-center py-5 px-3">@translate(You have been blocked by admin.)</h4>
					@endif
				</figure>
			</div>
		</div>
	</div>
	</div>
@stop
