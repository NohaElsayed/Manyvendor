@extends('frontend.master')


@section('title') @translate(Campaigns) @stop

@section('content')
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('homepage')}}">@translate(Home)</a></li>
                <li>@translate(Campaigns)</li>
            </ul>
        </div>
    </div>

    <div class="mb-5">
        <div class="container">
            <div class="d-flex justify-content-center fs-32 mt-5">
                <span><b>{{getSystemSetting('type_name')}} @translate(Campaigns)</b></span>
            </div>

            <div class="row mt-5">
                @forelse($campaigns as $campaign)
                    <div class="col-md-4 mb-4">
                        <a href="{{route('customer.campaign.products', $campaign->slug)}}" title="{{$campaign->title}}">
                            <div class="card card-body bd-light rounded-sm">
                                <img src="{{$campaign->banner}}" class="img-fluid rounded-sm campaign-img" alt="{{$campaign->title}}"/>
                                <span class="bg-danger p-2 text-white rounded-pill live-now">@translate(Live now)</span>
                            </div>
                        </a>
                    </div>

                    @empty
                    <div class="col-md-12 text-center text-danger fs-18 py-5 card card-body">
                        <img src="{{ asset('no-campaign.png') }}" class="w-50 m-auto" alt="#no-campaign">
                        @translate(There is no campaign live now.)
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@stop


