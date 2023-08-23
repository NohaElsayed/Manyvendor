<div class="ps-page--single">
	<div class="ps-breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
				<li><a href="javascript:void()">@translate(Profile)</a></li>
				<li>@translate(Affiliate Marketing)</li>
			</ul>
		</div>
	</div>
</div>

<div class="ps-vendor-dashboard pro pb-5">
	<div class="container">
		<div class="ps-section__header">
			<h3>@translate(Affiliate Marketing)</h3>
		</div>
		<div class="ps-section__content">
			<ul class="ps-section__links">
				<li><a href="{{ route('customer.orders') }}">@translate(Your Order)</a></li>
				<li><a href="{{ route('customer.index') }}">@translate(Your Profile)</a></li>
				@if(affiliateRoute() && affiliateActive())
					<li class="active"><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate Marketing)</a></li>
				@endif
				<li>
					<a href="{{ route('logout') }}"
					   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
						@translate(Sign Out)
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</li>
			</ul>
		</div>