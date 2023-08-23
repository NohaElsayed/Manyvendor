@extends('frontend.master')

@section('title')
	| @translate(Generate Product Link)
@endsection
@section('content')
	@include('frontend.affiliate.include.navbar')
		@csrf
		<div class="row">
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
				<figure class="text-center">
					@include('frontend.affiliate.include.aside')
				</figure>

			</div>
			<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
				<figure class="ps-block--vendor-status card px-4">
					<figcaption class="fs-10 text-center py-3 my-auto">@translate(Generate your affiliate link for any specific product)</figcaption>

					@if(affiliateNotBlockedUser())
						@php
							$affUser = \App\Models\AffiliateAccount::where('user_id', Auth::user()->id)->first();
						@endphp
					<div class="card px-5 pt-3 mb-4">
						<div class="pt-2">
							<p>@translate(Affiliate Commission) : <span class="font-weight-bold">{{getSystemSetting('affiliate_commission')!= null ?getSystemSetting('affiliate_commission'): '0'}}%</span></p>
							<p>@translate(Your affiliation Code is) : <span class="font-weight-bold">{{$affUser->affiliation_code}}</span></p>
							<p>@translate(Your Main URL is) : <span class="font-weight-bold">{{env('APP_URL').'?ref='.$affUser->affiliation_code}}</span></p>
							<h3>@translate(Affiliate URL Generator)</h3>
							<small>@translate(Enter Product URL from this website in the form below to generate a referral link!)</small>
						</div>
						<hr>
						<div class="row">
							<div class="form-group col-md-6 col-sm-12">
								<label>@translate(Enter Url)</label>
								<input type="text" class="form-control" id="url" value="" placeholder="https:://thisUrl.example/product/123/example-product">
								<input type="hidden" class="form-control" id="default_url" value="{{url('/').'?ref='.$affUser->affiliation_code}}">
							</div>
							<div class="form-group col-md-6 col-sm-12">
								<input type="hidden" name="ref" id="ref" value="?ref={{$affUser->affiliation_code}}">
								<label>@translate(Campaign Name )(@translate(optional))</label>
								<input type="text" class="form-control" name="campaign" id="campaign" placeholder="@translate(e.g. Super Dhamaka)">
							</div>
							<button class="ps-btn py-3 ml-4 mb-3" id="genurl">@translate(Generate URL)</button>

							<div class="form-group col-md-12 col-sm-12">
								<label>@translate(Referral Url)</label>
								<input type="text" class="form-control" value="" id="link" placeholder="@translate(Copy the link)">
								<small class="text-primary">*@translate(now copy this link and share it anywhere)</small>
							</div>
						</div>
					</div>
					@else
						<h4 class="text-danger card text-center py-5 px-3">@translate(You have been blocked by admin.)</h4>
					@endif
				</figure>
			</div>
		</div>
	</div>
	</div>
@stop
