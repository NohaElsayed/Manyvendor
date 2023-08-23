@extends('frontend.master')

@section('title')
	| @translate(Affiliate Registration)
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
					<figcaption class="fs-10 text-center py-3 my-auto">@translate(Apply Here)</figcaption>
					@if(affiliateUser())
						@if(affiliateNotBlockedUser())
							@if(!affiliateApprovedUser())
								{{--If user is not approved--}}
								<h4 class="text-danger card text-center py-5 px-3">@translate(You have already applied to be an affiliate user, please wait until admin approves your request.)</h4>
							@endif
							@else
							<h4 class="text-danger card text-center py-5 px-3">@translate(You have been blocked by admin.)</h4>
						@endif
					@else
					<div class="pb-3 fs-15">@translate(If you want to do affiliate marketing, please click the button bellow to request an account.)</div>
					<form action="{{route('customers.affiliate.store')}}" method="post" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
						<div class="text-center">
							<button type="submit" class="ps-btn">@translate(Apply for an affiliate account)</button>
						</div>
					</form>
					@endif
				</figure>
			</div>
		</div>
	</div>
	</div>
@stop
