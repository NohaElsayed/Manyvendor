@extends('backend.layouts.master')
@section('title') @translate(Affiliate Registration Requests)
@endsection
@section('parentPageTitle', 'All Brands')
@section('content')
	<div class="card m-2">
		<div class="card-header">
			<div class="float-left">
				<h2 class="card-title">@translate(Requested Users)</h2>
			</div>
			<div class="float-right">
				<div class="row">
					<div class="col-12">
						<form action="{{route('admins.affiliate.searchRequests')}}" method="get">
							@csrf
							<div class="input-group">
								<input type="text" name="searchRequests" class="form-control col-12"
								       placeholder="@translate(Name / Email / Contacts)" value="{{Request::get('searchRequests')}}">
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
						<th>@translate(Approve)</th>
						<th>@translate(Action)</th>
					</tr>
					</thead>
					<tbody>
					@if(count($users)>0)
						@foreach($users as $user)
							@php
								$single_user = \App\User::where('id',$user->user_id)->first();
							@endphp
						<tr>
							<td>{{$loop->index+1}}</td>
							<td class="text-left">{{$single_user->name}}</td>
							<td>{{$single_user->email}}</td>
							<td>{{$single_user->tel_number}}</td>
							<td>
								<button class="btn btn-outline-success btn-sm py-0 px-2">
									<a href="{{route('admins.affiliate.approveRequest',$user->id)}}" class="nav-item text-black"><i class="fa fa-check"></i> </a>
								</button>
							</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-info dropdown-toggle btn-sm"
									        data-toggle="dropdown" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											@if($user->is_blocked == false)
												<a  href="{{route('admins.affiliate.blockUnblockAffiliateAcc',$user->id)}}" class="nav-link text-danger">@translate(Block)</a>
												@else
												<a  href="{{route('admins.affiliate.blockUnblockAffiliateAcc',$user->id)}}" class="nav-link text-success">@translate(Unblock)</a>
											@endif
										</li>
										<li class="divider"></li>
										<li>
											<a href="#!" class="nav-link text-black"
											   onclick="confirm_modal('{{route('admins.affiliate.delete',$user->id)}}')">@translate(Delete)
											</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="6"><h3 class="text-center" >@translate(No Data Found)</h3></td>
						</tr>
					@endif
					</tbody>
					<tfoot>
						<tr>
							<th>@translate(S/L)</th>
							<th class="text-left">@translate(Name)</th>
							<th>@translate(Email)</th>
							<th>@translate(Contacts)</th>
							<th>@translate(Approve)</th>
							<th>@translate(Action)</th>
						</tr>
					</tfoot>
					<div class="float-left">
						{{ $users->links() }}
					</div>
				</table>
			</div>
		</div>
	</div>
@endsection
