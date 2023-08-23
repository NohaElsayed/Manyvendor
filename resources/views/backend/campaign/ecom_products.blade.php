@extends('backend.layouts.master')
@section('title') @translate(Campaigns)
@endsection
@section('parentPageTitle', 'All Campaigns')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Add products to campaign)</h2>
            </div>
            <div class="float-right">
                <div class="row text-right">
                    <div class="col-12">
                        <form action="{{route('admin.campaign.products.search', $campaign->slug)}}" method="get">
                            @csrf
                            <input type="hidden" name="slug" value="{{$campaign->slug}}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12"
                                       placeholder="@translate(Name)" value="{{Request::get('search')}}">
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
            <div class="bg-secondary text-white text-center mx-4 py-2 rounded-sm">
                @translate(Campaign)- <span class="text-truncate">{{$campaign->title}}</span><br/>
                @translate(Sale)- {{$campaign->offer}}% @translate(Off)
            </div>

            <div class="text-center text-warning mx-4 py-2">
                *@translate(Showing products which are not live now in any other campaign.)
            </div>

            <input type="hidden" class="admin_campaign-list-url"
                   value="{{route('admin.campaign.products', $campaign->slug)}}">
            <div class="row mt-3 justify-content-center">
                @forelse($products as $product)
                    @if($campaign_products->where('product_id',$product->id)->count()>0)
                        @if($campaign_products->where('product_id',$product->id)->first()->campaign_id == $campaign->id)
                            <div class="card col-md-2 mx-3 p-0" title="{{$product->name}}">
                                <div class="card-header border-bottom-0 text-center pb-0 text-truncate">
                                    {{$product->name}}
                                </div>
                                <div class="card-body">
                                    <img src="{{filePath($product->image)}}" alt="image" class="img-fluid rounded-sm"/>
                                    <div class="text-center text-bold mt-2">
                                        {{$product->price}}
                                    </div>
                                </div>

                                @if(!is_null($campaign_products) && !is_null($campaign_products->where('product_id', $product->id)->first()))
                                    <div class="card-footer text-center ecom-campaign-add-btn-{{$product->id}}">
                                        <a href="#!"
                                           class="btn btn-danger px-3"
                                           onclick="removeFromEcomCampaign({{$product->id}},{{$campaign->id}})">@translate(Remove)</a>
                                    </div>
                                @else
                                    <div class="card-footer text-center ecom-campaign-add-btn-{{$product->id}}">
                                        <a href="#!"
                                           class="btn btn-success px-3"
                                           onclick="addToEcomCampaign({{$product->id}},{{$campaign->id}})">@translate(Add To Campaign)</a>
                                    </div>
                                @endif
                            </div>
                        @else
                        @endif
                    @else
                        <div class="card col-md-2 mx-3 p-0" title="{{$product->name}}">
                            <div class="card-header border-bottom-0 text-center pb-0 text-truncate">
                                {{$product->name}}
                            </div>
                            <div class="card-body">
                                <img src="{{filePath($product->image)}}" alt="image" class="img-fluid rounded-sm"/>
                                <div class="text-center text-bold mt-2">
                                    {{$product->price}}
                                </div>
                            </div>

                            @if(!is_null($campaign_products) && !is_null($campaign_products->where('product_id', $product->id)->first()))
                                <div class="card-footer text-center ecom-campaign-add-btn-{{$product->id}}">
                                    <a href="#!"
                                       class="btn btn-danger px-3"
                                       onclick="removeFromEcomCampaign({{$product->id}},{{$campaign->id}})">@translate(Remove)</a>
                                </div>
                            @else
                                <div class="card-footer text-center ecom-campaign-add-btn-{{$product->id}}">
                                    <a href="#!"
                                       class="btn btn-success px-3"
                                       onclick="addToEcomCampaign({{$product->id}},{{$campaign->id}})">@translate(Add To Campaign)</a>
                                </div>
                            @endif
                        </div>
                    @endif
                @empty
                    <div class="card-body col-md-12 text-center text-danger">
                        @translate(You do not have any products yet).
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
