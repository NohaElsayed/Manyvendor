@extends('frontend.master')


@section('title') @translate(Campaigns) @stop

@section('content')
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{route('homepage')}}">@translate(Home)</a></li>
                <li><a href="{{route('customer.campaigns.index')}}">@translate(Campaigns)</a></li>
                <li>{{$campaign->title}}</li>
            </ul>
        </div>
    </div>

    <div class="mb-5">
        <div class="container">
            <div class="d-flex justify-content-center fs-32">
                <span>@translate(All products of) {{$campaign->title}}</span>
            </div>
            <div class="row mt-5">
                @forelse($product_list as $product)
                    <div class="col-md-3 mb-2">
                        <a href="#!" title="{{$product->name}}">
                            <div class="card card-body bd-light rounded-sm">
                                <div>
                                    <img src="{{$product->image}}" class="img-fluid rounded-sm"
                                         alt="{{$product->name}}"/>
                                </div>
                                <div class="text-center text-truncate fs-18 my-2">
                                    {{$product->name}}
                                </div>
                                <div class="text-center text-truncate d-none">
                                    <select class="ps-rating" data-read-only="true">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3" selected>3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="text-center text-truncate text-danger fs-18 my-2">
                                    {{$product->price}}
                                </div>

                                @if($product->have_variant)
                                    <div class="card-footer text-center border-top-0">
                                        <a href="#" class="btn btn-primary m-2 p-3 fs-12"
                                           onclick="forModal('{{route('product.with.variant',[$product->product_id,$product->campaign_id])}}',@translate('Select Variant'))">@translate(Buy Now)</a>
                                    </div>
                                @else
                                    @auth()
                                        <input class="cart-quantity-{{$product->product_variant_stock_id}}" type="hidden" value="1" min="1">
                                        <div class="card-footer text-center border-top-0">
                                            <a href="javascript:void(0)"
                                               class="btn btn-primary m-2 p-3 fs-12 addToCart-{{$product->product_variant_stock_id}}"
                                               onclick="addToCart('{{$product->product_variant_stock_id}}','{{$product->campaign_id}}')">@translate(Buy Now)</a>
                                        </div>
                                    @endauth
                                    @guest()
                                            <input class="cart-quantity-{{$product->product_variant_stock_id}}" type="hidden" value="1" min="1">
                                            <div class="card-footer text-center border-top-0">
                                                <a href="javascript:void(0)"
                                                   class="btn btn-primary m-2 p-3 fs-12 addToCart-{{$product->product_variant_stock_id}}"
                                                   onclick="addToGuestCart('{{$product->product_variant_stock_id}}','{{$product->campaign_id}}')">@translate(Buy Now)</a>
                                            </div>
                                    @endguest
                                @endif
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-md-12 text-center text-danger fs-18 py-5 card card-body">
                        @translate(There is no product available for this campaign now.)
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@stop


