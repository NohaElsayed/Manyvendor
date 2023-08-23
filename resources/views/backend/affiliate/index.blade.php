@extends('backend.layouts.master')
@section('title') @translate(Affiliate Accounts)
@endsection
@section('parentPageTitle', 'All Brands')
@section('content')
	<div class="card m-2">
		<div class="card-header">
			<div class="float-left">
				<h2 class="card-title bg-success py-1 px-2 rounded-sm">@translate(Active Accounts)</h2>
			</div>
			<div class="float-right">
				<div class="row">
					<div class="col-12">
						<form action="{{route('admins.affiliate.searchActive')}}" method="get">
							@csrf
							<div class="input-group">
								<input type="text" name="searchActive" class="form-control col-12"
								       placeholder="@translate(Name or Email)" value="{{Request::get('searchActive')}}">
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
				<table class="table table-striped table-bordered table-hover text-center table-sm">
					<thead>
					<tr>
						<th>@translate(S/L)</th>
						<th class="text-left">@translate(Name)</th>
						<th>@translate(Email)</th>
						<th>@translate(Contacts)</th>
						<th>@translate(Action)</th>
					</tr>
					</thead>
					<tbody>
					@if(count($activeUsers)>0)
						@foreach($activeUsers as $user)
							@php
								$single_user = \App\User::where('id',$user->user_id)->first();
							@endphp
							<tr>
								<td>{{$loop->index+1}}</td>
								<td class="text-left">{{$single_user->name}}</td>
								<td>{{$single_user->email}}</td>
								<td>{{$single_user->tel_number}}</td>
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-info dropdown-toggle btn-sm"
										        data-toggle="dropdown" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a  href="{{route('admins.affiliate.blockUnblockAffiliateAcc',$user->id)}}" class="nav-link text-danger">@translate(Block)</a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5"><h3 class="text-center" >@translate(No Data Found)</h3></td>
						</tr>
					@endif
					</tbody>
					<tfoot>
					<tr>
						<th>@translate(S/L)</th>
						<th class="text-left">@translate(Name)</th>
						<th>@translate(Email)</th>
						<th>@translate(Contacts)</th>
						<th>@translate(Action)</th>
					</tr>
					</tfoot>
					<div class="float-left">
						{{ $activeUsers->links() }}
					</div>
				</table>
			</div>
		</div>
	</div>


	<div class="card m-2 mt-5 bg-gray-light">
		<div class="card-header">
			<div class="float-left">
				<h2 class="card-title bg-danger p-1 rounded-sm">@translate(Blocked Accounts)</h2>
			</div>
			<div class="float-right">
				<div class="row">
					<div class="col-12">
						<form action="{{route('admins.affiliate.searchBlocked')}}" method="get">
							@csrf
							<div class="input-group">
								<input type="text" name="searchBlocked" class="form-control col-12"
								       placeholder="@translate(Name or Email)" value="{{Request::get('searchBlocked')}}">
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
				<table class="table table-striped table-bordered table-hover text-center table-sm">
					<thead>
					<tr>
						<th>@translate(S/L)</th>
						<th class="text-left">@translate(Name)</th>
						<th>@translate(Email)</th>
						<th>@translate(Contacts)</th>
						<th>@translate(Action)</th>
					</tr>
					</thead>
					<tbody>
					@if(count($blockedUsers)>0)
						@foreach($blockedUsers as $user)
							@php
								$single_user = \App\User::where('id',$user->user_id)->first();
							@endphp
							<tr>
								<td>{{$loop->index+1}}</td>
								<td class="text-left">{{$single_user->name}}</td>
								<td>{{$single_user->email}}</td>
								<td>{{$single_user->tel_number}}</td>
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-info dropdown-toggle btn-sm"
										        data-toggle="dropdown" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a  href="{{route('admins.affiliate.blockUnblockAffiliateAcc',$user->id)}}" class="nav-link text-success">@translate(Unblock)</a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5"><h3 class="text-center" >@translate(No Data Found)</h3></td>
						</tr>
					@endif
					</tbody>
					<tfoot>
					<tr>
						<th>@translate(S/L)</th>
						<th class="text-left">@translate(Name)</th>
						<th>@translate(Email)</th>
						<th>@translate(Contacts)</th>
						<th>@translate(Action)</th>
					</tr>
					</tfoot>
					<div class="float-left">
						{{ $blockedUsers->links() }}
					</div>
				</table>
			</div>
		</div>
	</div>
@endsection
