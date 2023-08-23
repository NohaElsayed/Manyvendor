@extends('frontend.master')

@section('title')
	| @translate(Earning Histories)
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
					<figcaption class="fs-10 text-center py-3 my-auto">@translate(Earning Histories)</figcaption>
					<div  class="card card-body border-bottom-0">
						<small class="mb-2"><span class="bg-warning rounded p-2">@translate(Filter by Requested Date)</span></small>
						<form action="{{route('customers.affiliate.earningHistoryFilter')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="row justify-content-around">
								<div class="col-md-5 form-group">
									<label>@translate(From)</label>

								<div class="form-group mb-4 affiliate-datapicker">
									<div class="datepicker date input-group p-0 shadow-sm">
										<input type="text" value="{{ old('earning_from') }}" placeholder="Choose a date" class="form-control py-4 px-4" name="earning_from" required>
										<div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
									</div>
								</div>
								

								</div>
								<div class="col-md-5 form-group">
									<label>@translate(To)</label>
									<div class="form-group mb-4 affiliate-datapicker">
									<div class="datepicker date input-group p-0 shadow-sm">
										<input type="text" placeholder="Choose a date" value="{{ old('earning_to') }}" class="form-control py-4 px-4" name="earning_to" required>
										<div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-clock-o"></i></span></div>
									</div>
								</div>

								</div>
								<button type="submit" class="btn btn-primary px-5 py-3 my-auto">@translate(Filter)</button>
							</div>
						</form>
					</div>
					<div class="table-responsive">
						<table id="myTable" class="table table-bordered table-striped table-hover w-100">
							<thead>
								<tr class="fs-16 text-center">
									<th>@translate(S/L)</th>
									<th>@translate(Product Price)</th>
									<th>@translate(Affiliate Commission)</th>
									<th>@translate(Sold On)</th>
								</tr>
							</thead>
							<tbody class="text-center">
								@forelse($histories as $history)
									<tr>
										<td>{{$loop->index+1}}</td>
										<td>{{formatPrice($history->order_amount)}}</td>
										<td>{{formatPrice($history->amount)}}</td>
										<td>{{date('d M, Y',strtotime($history->updated_at))}}</td>
									</tr>
									@empty
									<tr>
										<td colspan="4">@translate(No data found)</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
					<div>
						{{ $histories->links() }}
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