<div class="card">
	<div class="card-header bg-warning">
		@translate(Name): {{$req->user->name}} <br>
		@translate(Balance): {{formatPrice($req->affUser->balance)}} <br>
		@translate(Email): {{$req->user->email}} <br>
		@translate(Contact Number): {{$req->user->tel_number}} <br>
	</div>
	<div class="card-body">

			<div class="form-group text-center ">
				<label>@translate(Withdrawal Amount)</label>
				<div class="fs-26">{{formatPrice($req->amount)}}</div>
			</div>

			<div class="form-group">
				<label class="mb-0">@translate(Rocket Number) <small class="text-danger">(@translate(Personal))</small></label>
				<div class="form-control">{{$req->account->rocket_number}}</div>


				@if(!$req->is_paid)<small class="text-primary">@translate(Please make the rocket payment in this number.)</small>@endif
			</div>

			@if(!$req->is_cancelled)
				@if(!$req->is_paid)
					<div class="text-center">
						<a href="{{route('admins.affiliate.cancelWithdrawAffiliatedMoney',$req->id)}}" class="btn btn-danger">@translate(Cancel Payment)</a>
						<a href="{{route('admins.affiliate.approveWithdrawAffiliatedMoney',$req->id)}}" class="btn btn-success ml-2">@translate(Confirm Payment)</a>
					</div>
					<div class="text-center"><small class="text-danger">@translate(If you cancel the payment, withdrawal amount will be added to the user's balance.)</small></div>
				@else
					<div class="">
						<a href="{{route('admins.affiliate.cancelWithdrawAffiliatedMoney',$req->id)}}" class="btn btn-danger">@translate(Cancel Payment)</a>
					</div>
					<small class="text-danger">@translate(Click here to cancel the payment, withdrawal amount will be added to the user's balance).</small>
				@endif

				@else
				<div class="text-center">
					<a href="{{route('admins.affiliate.approveWithdrawAffiliatedMoney',$req->id)}}" class="btn btn-success ml-2">@translate(Confirm Payment)</a>
				</div>
			<div class="text-center"><small class="text-danger">@translate(If you confirm the payment, withdrawal amount will be subtracted from the user's balance.)</small></div>
			@endif
	</div>
</div>
