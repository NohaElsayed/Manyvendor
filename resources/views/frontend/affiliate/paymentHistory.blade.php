@extends('frontend.master')

@section('title')
	| @translate(Payment Histories)
@endsection

@section('css')
	<link type="text/javascript" src="{{ asset('frontend/css/datepicker.css') }}"/>
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
					<figcaption class="fs-10 text-center py-3 my-auto">@translate(Payment Histories)</figcaption>
					<div class="table-responsive">
						<h5 class="text-center mt-2"><span class="bg-warning p-2 rounded">@translate(Pending Payments)</span></h5>
						<div  class="card card-body border-bottom-0">
							<small class="mb-2"><span class="bg-warning rounded p-2">@translate(Filter by Requested Date)</span></small>
							<form action="{{route('customers.affiliate.pendingPaymentHistoryFilter')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="row justify-content-around">
									<div class="col-md-5 form-group">
										<label>@translate(From)</label>

										<div class="form-group mb-4 affiliate-datapicker">
									<div class="datepicker date input-group p-0 shadow-sm">
										<input type="text" value="{{ old('pending_from') }}" required placeholder="Choose a date" class="form-control py-4 px-4" name="pending_from" required>
										<div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
									</div>
								</div>

									</div>
									<div class="col-md-5 form-group">
										<label>@translate(To)</label>

										<div class="form-group mb-4 affiliate-datapicker">
									<div class="datepicker date input-group p-0 shadow-sm">
										<input type="text" value="{{ old('pending_to') }}" required placeholder="Choose a date" class="form-control py-4 px-4" name="pending_to" required>
										<div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
									</div>
								</div>

									</div>
									<button type="submit" class="btn btn-primary px-5 py-2 my-auto">@translate(Filter)</button>
								</div>
							</form>
						</div>
						<table id="myTable" class="table table-bordered table-striped table-hover w-100">
							<thead>
							<tr class="fs-16 text-center">
								<th>@translate(S/L)</th>
								<th>@translate(Amount)</th>
								<th>@translate(Requested Date)</th>
								<th>@translate(Payment Method)</th>
								<th>@translate(Actions)</th>
							</tr>
							</thead>
							<tbody class="text-center">
							@forelse($pendingHistories as $history)
								<tr>
									<td>{{$loop->index+1}}</td>
									<td>{{formatPrice($history->amount)}}</td>
									<td>{{date('d M, Y',strtotime($history->created_at))}}</td>
									<td><span class="bg-warning rounded p-1">{{$history->payment_account}}</span></td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-info dropdown-toggle btn-sm"
											        data-toggle="dropdown" aria-expanded="false">
												<span class="caret"></span>
												<span class="sr-only">@translate(Toggle Dropdown)</span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li>
													<a href="#!" class="nav-link text-danger"
												       onclick="forModal('{{route('customers.affiliate.deleteRequestBlade',$history->id)}}','Delete Payment Request')">@translate(Delete)</a>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="5">@translate(No data found)</td>
								</tr>
							@endforelse
							</tbody>
						</table>
					</div>
					<div>
						{{ $pendingHistories->links() }}
					</div>

					<hr>
					<div class="table-responsive mt-3">
						<h5 class="text-center mt-2"><span class="bg-success text-white p-2 rounded">@translate(Paid Payments)</span></h5>
						<div  class="card card-body border-bottom-0">
							<small class="mb-2"><span class="bg-success text-white rounded p-2">@translate(Filter by Requested Date)</span></small>
							<form action="{{route('customers.affiliate.paidPaymentHistoryFilter')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="row justify-content-around">
									<div class="col-md-5 form-group">
										<label>@translate(From)</label>

										<div class="form-group mb-4 affiliate-datapicker">
									<div class="datepicker date input-group p-0 shadow-sm">
										<input type="text" value="{{ old('paid_from') }}" required placeholder="Choose a date" class="form-control py-4 px-4" name="paid_from" required>
										<div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
									</div>
								</div>

									</div>
									<div class="col-md-5 form-group">
										<label>@translate(To)</label>

										<div class="form-group mb-4 affiliate-datapicker">
									<div class="datepicker date input-group p-0 shadow-sm">
										<input type="text" value="{{ old('paid_to') }}" required placeholder="Choose a date" class="form-control py-4 px-4" name="paid_to" required>
										<div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
									</div>
								</div>

									</div>
									<button type="submit" class="btn btn-primary px-5 py-2 my-auto">@translate(Filter)</button>
								</div>
							</form>
						</div>
						<table id="myTable" class="table table-bordered table-striped table-hover w-100">
							<thead>
							<tr class="fs-16 text-center">
								<th>@translate(S/L)</th>
								<th>@translate(Amount)</th>
								<th>@translate(Requested Date)</th>
								<th>@translate(Payment Method)</th>
								<th>@translate(Paid Date)</th>
							</tr>
							</thead>
							<tbody class="text-center">
							@forelse($paidHistories as $paid_history)
								<tr>
									<td>{{$loop->index+1}}</td>
									<td>{{formatPrice($paid_history->amount)}}</td>
									<td>{{date('d M, Y',strtotime($paid_history->created_at))}}</td>
									<td><span class="bg-warning rounded p-1">{{$history->payment_account}}</span></td>
									<td><span class="text-success p-1">{{date('d M, Y',strtotime($paid_history->paid_date))}}</span></td>
								</tr>
							@empty
								<tr>
									<td colspan="5">@translate(No data found)</td>
								</tr>
							@endforelse
							</tbody>
						</table>
					</div>
					<div>
						{{ $paidHistories->links() }}
					</div>

					<hr>
					<div class="table-responsive mt-3">
						<h5 class="text-center mt-2"><span class="bg-danger text-white p-2 rounded">@translate(Cancelled Payments)</span></h5>
						<div  class="card card-body border-bottom-0">
							<small class="mb-2"><span class="bg-danger text-white rounded p-2">@translate(Filter by Requested Date)</span></small>
							<form action="{{route('customers.affiliate.cancelledPaymentHistoryFilter')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="row justify-content-around">
									<div class="col-md-5 form-group">
										<label>@translate(From)</label>

										<div class="form-group mb-4 affiliate-datapicker">
									<div class="datepicker date input-group p-0 shadow-sm">
										<input type="text" value="{{ old('cancelled_from') }}" required placeholder="Choose a date" class="form-control py-4 px-4" name="cancelled_from" required>
										<div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
									</div>
								</div>

									</div>
									<div class="col-md-5 form-group">
										<label>@translate(To)</label>

										<div class="form-group mb-4 affiliate-datapicker">
									<div class="datepicker date input-group p-0 shadow-sm">
										<input type="text" value="{{ old('cancelled_to') }}" required placeholder="Choose a date" class="form-control py-4 px-4" name="cancelled_to" required>
										<div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
									</div>
								</div>


									</div>
									<button type="submit" class="btn btn-primary px-5 py-2 my-auto">@translate(Filter)</button>
								</div>
							</form>
						</div>
						<table id="myTable" class="table table-bordered table-striped table-hover w-100">
							<thead>
							<tr class="fs-16 text-center">
								<th>@translate(S/L)</th>
								<th>@translate(Amount)</th>
								<th>@translate(Requested Date)</th>
								<th>@translate(Payment Method)</th>
								<th>@translate(Cancelled)</th>
							</tr>
							</thead>
							<tbody class="text-center">
							@forelse($cancelledHistories as $c_history)
								<tr>
									<td>{{$loop->index+1}}</td>
									<td>{{formatPrice($c_history->amount)}}</td>
									<td>{{date('d M, Y',strtotime($c_history->created_at))}}</td>
									<td><span class="bg-warning rounded p-1">{{$history->payment_account}}</span></td>
									<td><span class="text-danger p-1">{{date('d M, Y',strtotime($c_history->updated_at))}}</span></td>
								</tr>
							@empty
								<tr>
									<td colspan="5">@translate(No data found)</td>
								</tr>
							@endforelse
							</tbody>
						</table>
					</div>
					<div>
						{{ $cancelledHistories->links() }}
					</div>

				</figure>
			</div>
		</div>
	</div>
	</div>
@stop

@section('js')
<script src="{{ asset('frontend/js/datepicker.js') }}"></script>
<script type="text/javascript">
"use strict"
        $('.datepicker').datepicker({
        clearBtn: true,
		format: "dd/mm/yyyy",
    });
    </script>
@endsection
