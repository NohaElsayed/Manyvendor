@extends('backend.layouts.master')
@section('title') @translate(Campaigns)
@endsection
@section('parentPageTitle', 'All Campaigns')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Campaigns List)</h2>
            </div>
            <div class="float-right">
                <div class="row text-right">
                    <div class="col-12">
                        <form action="{{route('seller.campaign.search')}}" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12"
                                       placeholder="@translate(Title / Offer)" value="{{Request::get('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">@translate(Search)</button>
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
                        <th>@translate(Title)</th>
                        <th>@translate(Offer)</th>
                        <th>@translate(Duration)</th>
                        <th>@translate(Action)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($campaigns as $item)
                        <tr>
                            <td>{{ ($loop->index+1) + ($campaigns->currentPage() - 1)*$campaigns->perPage() }}</td>
                            <td>{{$item->title}}</td>


                            <td>{{$item->offer}}%</td>
                            <td>({{\Carbon\Carbon::parse($item->start_from)->format('d F, Y')}})  -  ({{\Carbon\Carbon::parse($item->end_at)->format('d F, Y')}})</td>

                            <td>
                                <a href="{{route('seller.campaign.products.index',$item->slug)}}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus text-success"></i> @translate(Your Products) <i class="fa fa-times text-danger"></i> </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"><h3 class="text-center" >@translate(No Data Found)</h3></td>
                        </tr>
                    @endforelse
                    </tbody>
                    <div class="float-left">
                        {{ $campaigns->links() }}
                    </div>
                </table>
            </div>
        </div>
    </div>

@endsection
