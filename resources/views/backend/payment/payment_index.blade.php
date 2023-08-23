@extends('backend.layouts.master')
@section('title') @translate(Payments)
@endsection
@section('parentPageTitle', 'Withdraw')
@section('content')

    <div class="card p-3">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col-md-2">
                    <h2 class="card-title">@translate(Payment History )</h2>
                </div>
                <div class="col-md-4 offset-md-6">
                    <div class="row">
                        <div class="col-md-4 text-right my-auto"><span>@translate(Filter by Seller)</span></div>
                        <div class="col-md-8">
                            <form href="{{route('admin.payments.index')}}" id="ins_search" method="get">
                        <div class="form-group-inline">
                            <select class="select2 form-control" name="id" required id="instructorSelect">
                                <option value="">@translate(Select Seller)</option>
                                @foreach($seller as $item)
                                <option
                                    value="{{$item->user_id}}" {{Request::get('id') == $item->user_id ? 'selected' : null}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                        </div>





                    </div>

                </div>
            </div>

        </div>

        <div class="card-body bg-white table-responsive p-0">
            <table class="table table-bordered table-hover text-center">
                <thead>
                <tr>
                    <th>S/L</th>
                    <th>@translate(Requested User)</th>
                    <th>@translate(Amount)</th>
                    <th>@translate(Description)</th>
                    <th>@translate(Requested On)</th>
                    <th>@translate(Info)</th>
                    <th>@translate(Process)</th>

                </tr>
                </thead>
                <tbody>
                @forelse($payments as  $item)
                    <tr>
                        <td>{{ ($loop->index+1) + ($payments->currentPage() - 1)*$payments->perPage() }}</td>
                        <td><a href="{{route('vendor.requests.view2',$item->user->id)}}"
                               target="_blank">{{$item->user->name}}</a></td>
                        <td>{{formatPrice($item->amount)}} </td>

                        <td>
                            {{$item->description}}
                        </td>
                        <td>
                            {{date('d-M-y',strtotime($item->created_at)) ?? 'N/A'}}
                        </td>
                        <td>
                            {{$item->status}}<br>
                            {{date('d-M-y',strtotime($item->status_change_date)) ?? 'N/A'}}
                        </td>
                        @if(\Illuminate\Support\Facades\Auth::user()->user_type == "Admin")
                            <td>
                                @if(\Illuminate\Support\Facades\Auth::user()->user_type == "Admin" && $item->status != "Confirm")
                                    <a href="#!"
                                       onclick="forModal('{{route('account.details',[$item->account_id,$item->user_id,$item->process,$item->id])}}','@translate(Withdrawal Method)')"
                                       class="btn btn-warning">{{$item->process ?? 'N/A'}}
                                        @translate(Payment)
                                    </a>
                                @else
                                    <a href="#!"
                                       onclick="forModal('{{route('account.details',[$item->account_id,$item->user_id,$item->process,$item->id])}}','@translate(Withdrawal Method)')"
                                       class="btn btn-success">@translate(Paid on)
                                        {{$item->process ?? 'N/A'}}
                                    </a>
                                @endif


                            </td>
                        @endif
                    </tr>
                @empty

                    <tr>
                        <td colspan="7"><h3 class="text-centers">@translate(No Data Found)</h3></td>
                    </tr>

                @endforelse
                </tbody>
                <div class="float-left">
                    {{ $payments->links() }}
                </div>
            </table>
        </div>
    </div>



@endsection






