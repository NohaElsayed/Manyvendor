@extends('backend.layouts.master')
@section('title') @translate(Withdraw)
@endsection
@section('parentPageTitle', 'Withdraw')
@section('content')

    <div class="card card-blue card-outline p-3">
        <div class="card-header bg-white">
            <div class="float-left">
                <h2 class="card-title">@translate(Withdraw History )</h2>
            </div>
            <div class="float-right">

                <div class="row">
                    <div class="col">
                        <a href="#!"
                           onclick="forModal('{{route('payments.create')}}','@translate(Withdraw Request)')"
                           class="btn btn-primary">
                            <i class="la la-plus"></i>
                            @translate(Withdraw Request)
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body bg-white table-responsive p-0">
            <table class="table table-bordered table-hover text-center">
                <thead>
                <tr>
                    <th>S/L</th>
                    <th>@translate(Amount)</th>
                    <th>@translate(Description)</th>
                    <th>@translate(Requested On)</th>
                    <th>@translate(Info)</th>
                    <th>@translate(Status/Action)</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payments as  $item)
                    <tr>
                        <td>{{ ($loop->index+1) + ($payments->currentPage() - 1)*$payments->perPage() }}</td>
                        <td>{{formatPrice($item->amount)}} </td>

                        <td>
                            {!! $item->description !!}
                        </td>
                        <td>
                            {{date('d-M-y',strtotime($item->created_at)) ?? 'N/A'}}
                        </td>
                        <td>
                            {{$item->status}}<br>
                            @translate(Process) : {{$item->process}}<br>
                            {{date('d-M-y',strtotime($item->status_change_date)) ?? 'N/A'}}
                        </td>

                        @if($item->status != 'Confirm')
                            <td>
                                <a class="btn btn-warning"
                                   onclick="confirm_modal('{{ route('payments.destroy', $item->id) }}')"
                                   href="#!">
                                    <i class="fa fa-trash mr-2"></i>@translate(Delete)</a>
                            </td>
                        @else
                            <td title="payment done"><p class="text-success"><i
                                        class="fa fa-1x  fa-check-circle"></i></p></td>
                        @endif
                    </tr>
                @empty

                    <tr>
                        <td colspan="8"><h3 class="text-center">@translate(No Data Found)</h3></td>
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




