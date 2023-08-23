@extends('backend.layouts.master')
@section('title') @translate(Affiliate Payments)
@endsection
@section('parentPageTitle', 'All Brands')
@section('content')
	<div class="card m-2">
		<div class="card-header">
			<div class="float-left">
				<h2 class="card-title bg-warning py-1 px-2 rounded-sm">@translate(Payment Requests)</h2>
			</div>
			<div class="float-right">
				<div class="row">
					<div class="col-12">
						<form action="{{route('admins.affiliate.searchReqPayments')}}" method="get">
							@csrf
							<div class="input-group">
								<input type="text" name="searchReqPayments" class="form-control col-12"
								       placeholder="@translate(Name)" value="{{Request::get('searchReqPayments')}}">
								<div class="input-group-append">
									<button class="btn btn-secondary" type="submit">@translate(Search)</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table id="myTable" class="table table-bordered table-striped table-hover w-100">
					<thead>
					<tr class="fs-16 text-center">
						<th>@translate(S/L)</th>
						<th>@translate(Requested by)</th>
						<th>@translate(Amount)</th>
						<th>@translate(Requested date)</th>
						<th>@translate(Payment method)</th>
						<th>@translate(Actions)</th>
					</tr>
					</thead>
					<tbody class="text-center">
					@forelse($requests as $req)
						<tr>
							<td>{{$loop->index+1}}</td>
							<td>{{$req->user->name}}</td>
							<td>{{formatPrice($req->amount)}}</td>
							<td>{{date('d M, Y',strtotime($req->created_at))}}</td>
							<td><span class="bg-warning rounded-sm px-2">{{$req->payment_account}}</span> </td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-info dropdown-toggle btn-sm"
									        data-toggle="dropdown" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#!" class="nav-link text-success"
										       onclick="forModal('{{route('admins.affiliate.withdrawalDetails',$req->id)}}','Confirm / Cancel Payment')">@translate(Confirm) / <span class="text-danger">@translate(Cancel)</span> </a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6">@translate(No data found)</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>
			<div>
				{{ $requests->links() }}
			</div>
			</div>
		</div>


	<div class="card m-2 mt-5 bg-gray-light">
		<div class="card-header">
			<div class="float-left">
				<h2 class="card-title bg-success py-1 px-4 rounded-sm">@translate(Paid Payments)</h2>
			</div>
			<div class="float-right">
				<div class="row">
					<div class="col-12">
						<form action="{{route('admins.affiliate.searchPaidPayments')}}" method="get">
							@csrf
							<div class="input-group">
								<input type="text" name="searchPaidPayments" class="form-control col-12"
								       placeholder="@translate(Name)" value="{{Request::get('searchPaidPayments')}}">
								<div class="input-group-append">
									<button class="btn btn-secondary" type="submit">@translate(Search)</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table id="myTable" class="table table-bordered table-striped table-hover w-100">
					<thead>
					<tr class="fs-16 text-center">
						<th>@translate(S/L)</th>
						<th>@translate(Requested by)</th>
						<th>@translate(Amount)</th>
						<th>@translate(Requested date)</th>
						<th>@translate(Paid date)</th>
						<th>@translate(Confirmed By)</th>
						<th>@translate(Payment method)</th>
						<th>@translate(Actions)</th>
					</tr>
					</thead>
					<tbody class="text-center">
					@forelse($paid as $paid_payments)
						<tr>
							<td>{{$loop->index+1}}</td>
							<td>{{$paid_payments->user->name}}</td>
							<td>{{formatPrice($paid_payments->amount)}}</td>
							<td>{{date('d M, Y',strtotime($paid_payments->created_at))}}</td>
							<td>{{date('d M, Y',strtotime($paid_payments->paid_date))}}</td>
							<td class="text-success">{{$paid_payments->adminUser->name}}</td>
							<td><span class="bg-warning rounded-sm px-2">{{$paid_payments->payment_account}}</span></td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-info dropdown-toggle btn-sm"
									        data-toggle="dropdown" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#!" class="nav-link text-success"
										       onclick="forModal('{{route('admins.affiliate.withdrawalDetails',$paid_payments->id)}}','payment Details')">@translate(Payment Details)</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="8">@translate(No data found)</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>
			<div>
				{{ $paid->links() }}
			</div>
			</div>
		</div>


	<div class="card m-2">
		<div class="card-header">
			<div class="float-left">
				<h2 class="card-title bg-danger py-1 px-2 rounded-sm">@translate(Cancelled Payments)</h2>
			</div>
			<div class="float-right">
				<div class="row">
					<div class="col-12">
						<form action="{{route('admins.affiliate.searchCancelledPayments')}}" method="get">
							@csrf
							<div class="input-group">
								<input type="text" name="searchCancelledPayments" class="form-control col-12"
								       placeholder="@translate(Name)" value="{{Request::get('searchCancelledPayments')}}">
								<div class="input-group-append">
									<button class="btn btn-secondary" type="submit">@translate(Search)</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table id="myTable" class="table table-bordered table-striped table-hover w-100">
					<thead>
					<tr class="fs-16 text-center">
						<th>@translate(S/L)</th>
						<th>@translate(Requested by)</th>
						<th>@translate(Amount)</th>
						<th>@translate(Requested date)</th>
						<th>@translate(Cancelled date)</th>
						<th>@translate(Cancelled by)</th>
						<th>@translate(Payment method)</th>
						<th>@translate(Actions)</th>
					</tr>
					</thead>
					<tbody class="text-center">
					@forelse($cancelled as $c_req)
						<tr>
							<td>{{$loop->index+1}}</td>
							<td>{{$c_req->user->name}}</td>
							<td>{{formatPrice($c_req->amount)}}</td>
							<td>{{date('d M, Y',strtotime($c_req->created_at))}}</td>
							<td class="text-danger">{{date('d M, Y',strtotime($c_req->updated_at))}}</td>
							<td class="text-danger">{{$c_req->adminUser->name}}</td>
							<td><span class="bg-warning rounded-sm px-2">{{$c_req->payment_account}}</span></td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-info dropdown-toggle btn-sm"
									        data-toggle="dropdown" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#!" class="nav-link text-success"
										       onclick="forModal('{{route('admins.affiliate.withdrawalDetails',$c_req->id)}}','Confirm Payment')">@translate(Confirm Payment)</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="8">@translate(No data found)</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>
			<div>
				{{ $cancelled->links() }}
			</div>
		</div>
	</div>
@endsection
