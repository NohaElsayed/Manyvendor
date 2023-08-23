<div id="list-example" class="list-group">
    @if(affiliateRoute() && affiliateActive())
		@if(affiliateUser())
			@if(!affiliateApprovedUser())
				{{--If user is not approved--}}
				<a class="list-group-item list-group-item-action mb-2 pb-3 {{Route::is('customers.affiliate.registration')?'active':''}}" href="{{ route('customers.affiliate.registration') }}">@translate(Account Registration)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.productLink')?'active':''}}" href="javascript:void();">@translate(Generate Product Link)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.earningHistory')?'active':''}}" href="javascript:void();">@translate(Earning Histories)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.paymentHistory')?'active':''}}" href="javascript:void();">@translate(Payment Histories)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.setPaymentAccounts')?'active':''}}" href="javascript:void();">@translate(Payment Accounts)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.withdrawAffiliatedMoney')?'active':''}}" href="javascript:void();">@translate(Withdraw Money)</a>
			@else
				{{--If user is approved--}}
				<a class="list-group-item list-group-item-action mb-2 py-3 {{Route::is('customers.affiliate.productLink')?'active':''}}" href="{{ route('customers.affiliate.productLink') }}">@translate(Generate Product Link)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 {{Route::is('customers.affiliate.earningHistory')?'active':''}}" href="{{ route('customers.affiliate.earningHistory') }}">@translate(Earning Histories)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 {{Route::is('customers.affiliate.paymentHistory')?'active':''}}" href="{{ route('customers.affiliate.paymentHistory') }}">@translate(Payment Histories)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 {{Route::is('customers.affiliate.setPaymentAccounts')?'active':''}}" href="{{ route('customers.affiliate.setPaymentAccounts') }}">@translate(Payment Accounts)</a>
				<a class="list-group-item list-group-item-action my-2 py-3 {{Route::is('customers.affiliate.withdrawAffiliatedMoney')?'active':''}}" href="{{ route('customers.affiliate.withdrawAffiliatedMoney') }}">@translate(Withdraw Money)</a>
			@endif
		@else
			{{--If affiliate user is not registered--}}
			<a class="list-group-item list-group-item-action mb-2 pb-3 {{Route::is('customers.affiliate.registration')?'active':''}}" href="{{ route('customers.affiliate.registration') }}">@translate(Account Registration)</a>
			<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.productLink')?'active':''}}" href="javascript:void();">@translate(Generate Product Link)</a>
			<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.earningHistory')?'active':''}}" href="javascript:void();">@translate(Earning Histories)</a>
			<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.paymentHistory')?'active':''}}" href="javascript:void();">@translate(Payment Histories)</a>
			<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.setPaymentAccounts')?'active':''}}" href="javascript:void();">@translate(Payment Accounts)</a>
			<a class="list-group-item list-group-item-action my-2 py-3 disable-pointer {{Route::is('customers.affiliate.withdrawAffiliatedMoney')?'active':''}}" href="javascript:void();">@translate(Withdraw Money)</a>
		@endif
		@endif
</div>