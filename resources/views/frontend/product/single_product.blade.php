@extends('frontend.master')

@section('keywords')
{{ $single_product->meta_desc }}
@stop

@section('css')
@stop

@section('title')
- {{ $single_product->name }}
@stop

@section('content')
    <nav class="navigation--mobile-product">
        @auth()
            <a class="ps-btn ps-btn--black" href="javascript:;" onclick="addToWishlist({{$single_product->id}})"><i
                        class="icon-heart"></i></a>
        @endauth
        @guest()
          

                        <a class="ps-btn ps-btn--black" href="javascript:void(0)" onclick="addProduct({{$single_product->id}})"><i
                        class="icon-heart"></i></a>

        @endguest
        <a class="ps-btn" href="javascript:;" onclick="addToCompare({{$single_product->id}})"><i class="fa fa-random"></i></a>
    </nav>
    <div class="ps-breadcrumb">
        <div class="ps-container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                
                <li>
                    <a href="{{ route('category.shop', $single_product->childcategory->name) }}">{{ $single_product->childcategory->name }}</a>
                </li>
                <li>{{ $single_product->name }}</li>
            </ul>
        </div>
    </div>
    <input id="productId" type="hidden" value="{{$single_product->id}}">
    <div class="ps-page--product">
        <div class="ps-container">
            <div class="ps-page__container">
                <div class="ps-page__left">
                    <div class="ps-product--detail ps-product--fullwidth">
                        <div class="ps-product__header">
                            <div class="ps-product__thumbnail" data-vertical="true">
                                <figure>
                                    <div class="ps-wrapper">
                                        <div class="ps-product__gallery" data-arrow="true">

                                            @if (count($single_product->images) > 0)

                                            @foreach ($single_product->images as $image)
                                                <div class="item">
                                                    <a href="{{filePath($image->image)}}">
                                                        <img src="{{filePath($image->image)}}" class="m-auto" alt="">
                                                    </a>
                                                </div>
                                            @endforeach

                                            @else

                                                <div class="item">
                                                    <a href="{{filePath($single_product->image)}}">
                                                        <img src="{{filePath($single_product->image)}}" class="m-auto" alt="{{ $single_product->name }}">
                                                    </a>
                                                </div>
                                                
                                            @endif
                                            

                                        </div>
                                    </div>
                                </figure>
                                <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4"
                                     data-arrow="false">
                                    @foreach ($single_product->images as $image)
                                        <div class="item"><img src="{{filePath($image->image)}}" alt=""></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="ps-product__info">
                                <h1>{{$single_product->name}}</h1>
                                <div class="ps-product__meta">
                                    <p>@translate(Brand):<a
                                                href="{{ route('brand.shop',$single_product->brand->slug) }}">{{$single_product->brand->name}}</a>
                                    </p>
                                </div>
                                <h4 class="ps-product__price text-left">
<span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                       {{formatPrice(brandProductPrice($single_product->sellers)->min())
                                                                           == formatPrice(brandProductPrice($single_product->sellers)->max())
                                                                           ? formatPrice(brandProductPrice($single_product->sellers)->min())
                                                                           : formatPrice(brandProductPrice($single_product->sellers)->min()).
                                                                           '-' .formatPrice(brandProductPrice($single_product->sellers)->max())}}
                                                                    </span>
                                                                    </span>

                                </h4>
                                <div class="ps-product__desc">
                                    <p>
                                        {!! $single_product->short_desc!!}
                                    </p>
                                </div>
                                <div class="ps-product__variations">
                                    <figure>
                                        <label for="d-block">
                                                Select Variation
                                            </label>
                                        <div class="form-row">
                                            {{--variants show--}}

                                            

                                            @foreach($product_variants as $variant)
                                                @if($variant->unit == 'Color')
                                                    <input type="radio" name="{{$variant->unit}}"
                                                           id="color{{ $variant->code }}" value="{{$variant->id}}"/>
                                                    <label for="color{{ $variant->code }}" class="variant_label">
                                                        <span class="variant_color card"
                                                              style="background: {{ $variant->code ?? '' }};"></span>
                                                    </label>
                                                @else
                                                    <input type="radio" id="unit-{{$variant->variant}}"
                                                           name="{{$variant->unit}}" value="{{$variant->id}}"/>
                                                    <label for="unit-{{$variant->variant}}"
                                                           class="variant_unit">{{$variant->variant}}</label>

                                                @endif
                                            @endforeach
                                        </div>
                                    </figure>
                                </div>
                                <div class="ps-product__shopping">
                                    <figure class="mb-sm-2">
                                        <figcaption>@translate(Quantity)</figcaption>


                                        <div class="value-button" id="decrease" onclick="decreaseValue()"
                                             value="Decrease Value">-
                                        </div>

                                        <input type="number"
                                               id="number"
                                               value="1"
                                               min="1"
                                               max="10"
                                               class="cart-quantity input-number"
                                               readonly
                                        />

                                        <div class="value-button" id="increase" onclick="increaseValue()"
                                             value="Increase Value">+
                                        </div>

                                    </figure>
                                    <a class="ps-btn bookWithoutVariant mt-3" id="check_shop" href="#shops"
                                       data-toggle="tooltip" data-placement="top"
                                       data-title="@translate(Please select the product variant)">@translate(Check available shop)</a>
                                    <div id="shops"></div>
                                    <div class="ps-product__actions active mt-2">

                                        @auth()
                                            <a href="javascript:;" onclick="addToWishlist({{$single_product->id}})"
data-toggle="tooltip" data-placement="top" data-title="@translate(Add to wishlist)"><i
                                                        class="icon-heart"></i></a>
                                        @endauth
                                        @guest()
                                            <a href="javascript:;"
                                        class="wishlist" 
                                        data-placement="top" 
                                        data-title="@translate(Add to wishlist)"
                                        data-toggle="tooltip" 
                                        data-product_name='{{ $single_product->name }}' 
                                        data-product_id='{{$single_product->id}}' 
                                        data-product_sku='{{$single_product->sku}}' 
                                        data-product_slug='{{$single_product->slug}}' 
                                        data-product_image='{{ filePath($single_product->image) }}' 
                                        data-app_url='{{ env('APP_URL') }}' 
                                        data-product_price='{{formatPrice(brandProductPrice($single_product->sellers)->min())
                                                                           == formatPrice(brandProductPrice($single_product->sellers)->max())
                                                                           ? formatPrice(brandProductPrice($single_product->sellers)->min())
                                                                           : formatPrice(brandProductPrice($single_product->sellers)->min()).
                                                                           '-' .formatPrice(brandProductPrice($single_product->sellers)->max())}}'
                                                    >
                                                    <i class="icon-heart"></i>
                                        </a>
                                        @endguest


                                        <a href="#!" onclick="addToCompare({{$single_product->id}})" 
data-toggle="tooltip" data-placement="top" data-title="@translate(Add to comparison)"><i
                                                    class="fa fa-random"></i></a>
                                    </div>
                                </div>
                                <div class="ps-product__specification">
                                    <p><strong>SKU:</strong> {{ $single_product->sku }}</p>
                                    <p class="categories"><strong> @translate(Categories):</strong>
                                        
                                        <a href="{{ route('category.shop',$single_product->childcategory->slug) }}"> {{ $single_product->childcategory->name }}</a>
                                    </p>
                                    <p class="tags"><strong> @translate(Tags)</strong>
                                        @foreach(json_decode($single_product->tags) as $data)
                                            <a href="javascript:void(0)">{{$data}}</a>,
                                        @endforeach

                                    </p>
                                </div>


                                {{-- fcaebook share SDK --}}
                                <div class="fb-share-button" data-href="{{ url()->full() }}" data-layout="button"
                                     data-size="small">
                                    <a target="_blank"
                                       href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F127.0.0.1%3A8000%2F&amp;src=sdkpreparse"
                                       class="fb-xfbml-parse-ignore">
                                        @translate(Share)
                                    </a>
                                </div>
                            </div>
                        </div>


                        <!-- Vendor Shop -->


                        <div class="section__header">
                            <h3>@translate(Available Shop(s))</h3>
                        </div>
                        <div class="row p-lr-20 seller-div">
                            @forelse($single_product->sellers as $seller)
                                @php
                                    $vps = \App\Models\VendorProductVariantStock::where('user_id',$seller->user_id)->
                                    where('vendor_product_id',$seller->id)->where('product_id',$seller->product_id)->first();
                                @endphp
                                @if($seller != null && $vps != null)
                                    <div class="col-md-3">
                                        <aside class="widget widget_same-brand widget_vendor-shop">
                                            <div class="widget__content widget_vendor-shop-content">
                                                <div class="ps-product">
                                                    <div class="ps-product__thumbnail">
                                                        @if (empty($seller->user->vendor->shop_logo))
                                                            <a href="{{ route('vendor.shop',$seller->user->vendor->slug) }}">
                                                                <img src="{{ asset('vendor-store.jpg') }}"
                                                                     class="rounded"
                                                                     alt="#{{$seller->user->vendor->shop_name}}">
                                                            </a>
                                                        @else
                                                            <a href="{{ route('vendor.shop',$seller->user->vendor->slug) }}">
                                                                <img
                                                                        src="{{ filePath($seller->user->vendor->shop_logo) }}"
                                                                        class="rounded"
                                                                        alt="#$seller->user->vendor->shop_name">
                                                            </a>
                                                        @endif

                                                    </div>
                                                    <div class="ps-product__container text-center">
                                                        <div class="ps-product__content">
                                                            <a class="ps-product__title"
                                                               href="{{ route('vendor.shop',$seller->user->vendor->slug) }}">{{ $seller->user->vendor->shop_name }}</a>

                                                            @php

                                                                $stars_count = App\Models\OrderProduct::where('shop_id', $seller->user->vendor->id)
                                                                            ->whereNotNull('review_star')
                                                                            ->select('review_star')
                                                                            ->get()
                                                                            ->toArray();

                                                                $shop_stars_count = App\Models\OrderProduct::where('shop_id', $seller->user->vendor->id)
                                                                            ->whereNotNull('review_star')
                                                                            ->select('review_star')
                                                                            ->count();

                                                                $rateArray =[];
                                                                foreach ($stars_count as $star_count)
                                                                {
                                                                    $rateArray[]= $star_count['review_star'];
                                                                }
                                                                $sum = array_sum($rateArray);
                                                                

                                                                $customer_count = App\Models\OrderProduct::where('shop_id', 1)
                                                                                    ->whereNotNull('review_star')
                                                                                    ->count();
                                                                if ($customer_count > 0) {
                                                                    $result= round($sum/$customer_count);
                                                                }else {
                                                                    $result= round($sum/1);
                                                                }

                                                            @endphp


                                                            <div class="br-wrapper br-theme-fontawesome-stars">
                                                                <div class="br-widget br-readonly">
                                                                    @if ($result > 0)
                                                                        @for ($i = 0; $i < $result; $i++)
                                                                            <a href="javascript:void(0)"
                                                                               data-rating-value="1"
                                                                               data-rating-text="1"
                                                                               class="br-selected br-current"></a>
                                                                        @endfor
                                                                    @else
                                                                        <span>@translate(No Rating)</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <p class="ps-product__price sale">
                                                                @if($seller->is_discount === 1)
                                                                    <span>{{ formatPrice($seller->discount_price) }}</span>
                                                                    <del>{{ formatPrice($seller->product_price) }}</del>
                                                                @else
                                                                    {{ formatPrice($seller->product_price) }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                        @auth()
                                                            {{-- here get vendor prodcut variant stock id--}}
                                                            @if($vps->quantity <= 1)
                                                                <a href="#!"
                                                                   class="btn btn-danger m-2 p-3 fs-12  bookWithoutVariant"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   data-title="@translate(Please select the product variant)">@translate(Out of stock)</a>
                                                            @else
                                                                <a href="#!"
                                                                   class="btn btn-primary m-2 p-3 fs-12 addToCart-{{$vps->id}} bookWithoutVariant"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   data-title="@translate(Please select the product variant)"
                                                                   onclick="addToCart({{$vps->id}})">@translate(Buy Now)</a>
                                                            @endif
                                                        @endauth
                                                        @guest()
                                                            {{-- here get vendor prodcut variant stock id--}}
                                                            @if($vps->quantity <= 1)
                                                                <a href="#!"
                                                                   class="btn btn-danger m-2 p-3 fs-12  bookWithoutVariant"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   data-title="@translate(Please select the product variant)">@translate(Out of stock)</a>
                                                            @else
                                                                <a href="#!"
                                                                   class="btn btn-primary m-2 p-3 fs-12 addToGuestCart-{{$vps->id}} bookWithoutVariant"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   data-title="@translate(Please select the product variant)"
                                                                   onclick="addToGuestCart({{$vps->id}})">@translate(Buy Now)</a>
                                                            @endif
                                                        @endguest
                                                    </div>
                                                </div>
                                            </div>
                                        </aside>
                                    </div>
                                @endif

                            @empty

                                <img src="{{ asset('shop-not-found.png') }}" alt="">

                            @endforelse

                        </div>

                        <!-- Vendor Shop END -->

                        <div class="ps-product__content ps-tab-root">
                            <ul class="ps-tab-list">
                                <li class="active"><a href="#tab-1">@translate(Description)</a></li>
                                <li>
                                    <a href="#tab-4">Reviews ({{ $reviews_count = 0 ? 0 : $reviews_count }})
                                    </a>
                                </li>
                            </ul>
                            <div class="ps-tabs">
                                <div class="ps-tab active" id="tab-1">
                                    <div class="ps-document">
                                        {!! $single_product->big_desc!!}
                                    </div>
                                </div>

                                <div class="ps-tab" id="tab-4">
                                    <div class="row">

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <hr/>
                                                    <div class="review-block">
                                                        @forelse ($order_products as $order_product)
                                                            @if (!empty($order_product->review))
                                                                <div class="row">
                                                                    <div class="col-sm-3">
                                                                        <img
                                                                                src="{{ filePath($order_product->user->avatar ) }}"
                                                                                class="img-rounded">
                                                                        <div
                                                                                class="review-block-name">{{ $order_product->user->name }}</div>
                                                                        <div
                                                                                class="review-block-date">{{ $order_product->updated_at->format('M d, Y') }}
                                                                            <br/>{{ $order_product->updated_at->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="review-block-rate">

                                                                            @for ($i = 0; $i < $order_product->review_star; $i++)
                                                                                <button type="button"
                                                                                        class="btn btn-warning btn-xs"
                                                                                        aria-label="Left Align">
                                                                                    <span class="fa fa-star"
                                                                                          aria-hidden="true"></span>
                                                                                </button>
                                                                            @endfor

                                                                        </div>

                                                                        <div
                                                                                class="review-block-description">{{ $order_product->review }}</div>
                                                                    </div>
                                                                </div>
                                                                <hr/>
                                                            @endif
                                                        @empty

                                                            <img src="{{ asset('no-review.jpg') }}" alt="#no-review">

                                                        @endforelse


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-page__right">
                    @if(infopage('top',4)->count() > 0)
                    <aside class="widget widget_product widget_features">
                        @foreach(infopage('top',4) as $p)
                            <p>
                                @if($p->icon != null)
                                    <i class="{{$p->icon}}"></i>
                                @endif
                                @if($p->page != null)
                                    <a href="{{route('frontend.page',$p->page->slug)}}">
                                        @endif
                                        @if($p->header != null)
                                            {{$p->header}}
                                        @endif
                                        @if($p->page != null)
                                    </a>
                                @endif
                            </p>
                        @endforeach
                    </aside>
                    @endif
                    <aside class="widget widget_sell-on-site">
                        <p><i class="icon-store"></i> @translate(Sell on) {{ getSystemSetting('type_name') }}?<a
                                    href="{{ route('vendor.signup') }}"> @translate(Register Now) !</a></p>
                    </aside>
                    <aside class="widget widget_ads"><a href="#"><img src="img/ads/product-ads.png" alt=""></a></aside>


                    <aside class="widget widget_same-brand">
                        <h3>@translate(Same Brand)</h3>
                        <div class="widget__content">
                            @forelse($brand_products as $brand_product)

                                <a  href="{{route('single.product',[$brand_product->sku,$brand_product->slug])}}"
                                   class="mb-3 product-card">
                                    <span class="product-card__action d-flex flex-column align-items-center ">
                                                                    <span class="product-card__action-is product-card__action-view"
                                                                          onclick="forModal('{{ route('quick.view',$brand_product->slug) }}', '@translate(Product quick view)')">
                                                                    <i class="fa fa-eye"></i>
                                                                    </span>
                                                                    <span class="product-card__action-is product-card__action-compare"
                                                                          onclick="addToCompare({{$brand_product->id}})">
                                                                    <i class="fa fa-random"></i>
                                                                    </span>
                                                                    @auth()
                                            <span class="product-card__action-is product-card__action-wishlist"
                                                  onclick="addToWishlist({{$brand_product->id}})">
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                        @endauth

                                        @guest()
                                            <span 
                                                                class="product-card__action-is product-card__action-wishlist wishlist"
                                                                data-placement="top" 
                                                                data-title="@translate(Add to wishlist)"
                                                                data-toggle="tooltip" 
                                                                data-product_name='{{ $brand_product->name }}' 
                                                                data-product_id='{{$brand_product->id}}' 
                                                                data-product_sku='{{$brand_product->sku}}' 
                                                                data-product_slug='{{$brand_product->slug}}' 
                                                                data-product_image='{{ filePath($brand_product->image) }}' 
                                                                data-app_url='{{ env('APP_URL') }}' 
                                                                data-product_price='{{formatPrice(brandProductPrice($brand_product->sellers)->min())
                                                                                                == formatPrice(brandProductPrice($brand_product->sellers)->max())
                                                                                                ? formatPrice(brandProductPrice($brand_product->sellers)->min())
                                                                                                : formatPrice(brandProductPrice($brand_product->sellers)->min()).
                                                                                                '-' .formatPrice(brandProductPrice($brand_product->sellers)->max())}}'>
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                        @endguest
                                                                </span>
                                    <span class="product-card__img-wrapper">
                                        <img src="{{ filePath($brand_product->image) }}" alt="#{{$brand_product->name}}"
                                             class="img-fluid mx-auto">
                                    </span>
                                    <span class="product-card__body">
                                        <span class="product-card__title">
                                            {{$brand_product->name}}
                                        </span>
                                        
                                        <span class="t-mt-10 d-block">
                                   <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                                                               {{formatPrice(brandProductPrice($brand_product->sellers)->min())
                                                                                                                  == formatPrice(brandProductPrice($brand_product->sellers)->max())
                                                                                                                  ? formatPrice(brandProductPrice($brand_product->sellers)->min())
                                                                                                                  : formatPrice(brandProductPrice($brand_product->sellers)->min()).
                                                                                                                  '-' .formatPrice(brandProductPrice($brand_product->sellers)->max())}}
                                                                                                           </span>
                                                                                                           </span>
                                    
                                    </span>
                                       
                                    </span>
                                </a>
                            @empty
                                @translate(No Product Available)
                            @endforelse

                        </div>
                    </aside>
                </div>
            </div>

            <div class="ps-section--default">
                <div class="ps-section__header">
                    <h3>@translate(Related products)</h3>
                </div>
                <div class="ps-section__content">

                    @if ($products_count < 0)

                        <div class="row">
                            <div class="col-md-2 t-mb-30">
                                <a href="{{route('single.product',[$single_product->sku,$single_product->slug])}}"
                                   class="product-card text-center">
                                <span class="product-card__action d-flex flex-column align-items-center ">
                                    <span class="product-card__action-is product-card__action-view"
                                          onclick="forModal('{{ route('quick.view',$single_product->slug) }}', '@translate(Product quick view)')">
                                    <i class="fa fa-eye"></i>
                                    </span>
                                    <span class="product-card__action-is product-card__action-compare"
                                          onclick="addToCompare({{$single_product->id}})">
                                    <i class="fa fa-random"></i>
                                    </span>
                                    @auth()
                                        <span class="product-card__action-is product-card__action-wishlist"
                                              onclick="addToWishlist({{$single_product->id}})">
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                    @endauth

                                    @guest()
                                        <span 
                                                                class="product-card__action-is product-card__action-wishlist wishlist"
                                                                data-placement="top" 
                                                                data-title="@translate(Add to wishlist)"
                                                                data-toggle="tooltip" 
                                                                data-product_name='{{ $single_product->name }}' 
                                                                data-product_id='{{$single_product->id}}' 
                                                                data-product_sku='{{$single_product->sku}}' 
                                                                data-product_slug='{{$single_product->slug}}' 
                                                                data-product_image='{{ filePath($single_product->image) }}' 
                                                                data-app_url='{{ env('APP_URL') }}' 
                                                                data-product_price='{{formatPrice(brandProductPrice($single_product->sellers)->min())
                                                                                                == formatPrice(brandProductPrice($single_product->sellers)->max())
                                                                                                ? formatPrice(brandProductPrice($single_product->sellers)->min())
                                                                                                : formatPrice(brandProductPrice($single_product->sellers)->min()).
                                                                                                '-' .formatPrice(brandProductPrice($single_product->sellers)->max())}}'>
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                    @endguest
                                </span>
                                    <span class="product-card__img-wrapper m-auto text-center w-50">
                                    <img src="{{filePath($single_product->image) }}" alt="#{{ $single_product->name }}"
                                         class="img-fluid mx-auto w-50">
                                </span>
                                    <span class="product-card__body">
                                    <span class="product-card__title text-center">
                                        {{ $single_product->name }}
                                    </span>

                                    <span class="t-mt-10 d-block">
                                   <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                        {{formatPrice(brandProductPrice($single_product->sellers)->min())
                                                                                                                                                   == formatPrice(brandProductPrice($single_product->sellers)->max())
                                                                                                                                                   ? formatPrice(brandProductPrice($single_product->sellers)->min())
                                                                                                                                                   : formatPrice(brandProductPrice($single_product->sellers)->min()).
                                                                                                                                                   '-' .formatPrice(brandProductPrice($single_product->sellers)->max())}}
                                                                                                                                            </span>
                                                                                                                                            </span>

                                    </span>

                                </span>
                                </a>
                            </div>
                        </div>


                    @else

                        <div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true"
                             data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true"
                             data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3"
                             data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">
                             <div class="row">
                            @foreach($related_products as $related_product)

                                    <div class="col-md-3 t-mb-30">
                                        <a href="{{route('single.product',[$related_product->sku,$related_product->slug])}}"
                                           class="product-card">
                                <span class="product-card__action d-flex flex-column align-items-center ">
                                    <span class="product-card__action-is product-card__action-view"
                                          onclick="forModal('{{ route('quick.view',$related_product->slug) }}', '@translate(Product quick view)')">
                                    <i class="fa fa-eye"></i>
                                    </span>
                                    <span class="product-card__action-is product-card__action-compare"
                                          onclick="addToCompare({{$related_product->id}})">
                                    <i class="fa fa-random"></i>
                                    </span>
                                    
                                    
                                    @auth()
                                        <span class="product-card__action-is product-card__action-wishlist"
                                              onclick="addToWishlist({{$related_product->id}})">
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                    @endauth

                                    @guest()
                                        <span 
                                                                class="product-card__action-is product-card__action-wishlist wishlist"
                                                            
                                                                data-placement="top" 
                                                                data-title="@translate(Add to wishlist)"
                                                                data-toggle="tooltip" 
                                                                data-product_name='{{ $related_product->name }}' 
                                                                data-product_id='{{$related_product->id}}' 
                                                                data-product_sku='{{$related_product->sku}}' 
                                                                data-product_slug='{{$related_product->slug}}' 
                                                                data-product_image='{{ filePath($related_product->image) }}' 
                                                                data-app_url='{{ env('APP_URL') }}' 
                                                                data-product_price='{{formatPrice(brandProductPrice($related_product->sellers)->min())
                                                                                                == formatPrice(brandProductPrice($related_product->sellers)->max())
                                                                                                ? formatPrice(brandProductPrice($related_product->sellers)->min())
                                                                                                : formatPrice(brandProductPrice($related_product->sellers)->min()).
                                                                                                '-' .formatPrice(brandProductPrice($related_product->sellers)->max())}}'    
                                                                >
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                    @endguest


                                                                




                                </span>
                                            <span class="product-card__img-wrapper text-center w-50">
                                    <img src="{{ filePath($related_product->image)}}" alt="#{{ $related_product->name }}"
                                         class="img-fluid mx-auto">
                                </span>
                                            <span class="product-card__body">
                                    <span class="product-card__title text-center">
                                       {{ $related_product->name }}
                                    </span>


                                    <span class="t-mt-10 d-block text-center">

                                                                    <span class="product-card__discount-price t-mr-5">
                                                                        {{formatPrice(brandProductPrice($related_product->sellers)->min())
                                                                           == formatPrice(brandProductPrice($related_product->sellers)->max())
                                                                           ? formatPrice(brandProductPrice($related_product->sellers)->min())
                                                                           : formatPrice(brandProductPrice($related_product->sellers)->min()).
                                                                           '-' .formatPrice(brandProductPrice($related_product->sellers)->max())}}
                                                                    </span>
                                                                    </span>



                                </span>
                                        </a>
                                    </div>

                                    @endforeach
                                </div>

                        </div>
                    @endif


                </div>
            </div>

        </div>
    </div>

    {{--here the all url for ajax--}}
    <input id="variantUrl" value="{{route('product.variant.seller')}}" type="hidden">
    <input id="sellerFound" value="<img src='{{ asset('shop-not-found.png') }}'>" type="hidden">
    <input id="title" value="@translate(Please select the product variant)" type="hidden">
@stop

@section('js')
    <script>
        "use strict"

        /*check have variant*/
        $(document).ready(function () {
            @if($units_array != null)
            $('[data-toggle="tooltip"]').tooltip({delay: {"show": 500, "hide": 100}})
            $('#check_shop').removeAttr('href');
            $('.bookWithoutVariant').removeAttr('onclick');
            @else

            $('.bookWithoutVariant').removeAttr('data-title');

            $('[data-toggle="tooltip"]').tooltip('disable')
            $('#check_shop').attr('href', '#shops');
            // alert();
            @endif
        })

        //published the all
        $('input[type="radio"]').on('click',(function () {

            //radio check uncheck

            $('#check_shop').attr('href', '#shops');
            $('[data-toggle="tooltip"]').tooltip('disable')
            var previousValue = $(this).attr('previousValue');
            var name = $(this).attr('name');

            if (previousValue == 'checked') {
                $(this).removeAttr('checked');
                $(this).attr('previousValue', false);


            } else {
                $("input[name=" + name + "]:radio").attr('previousValue', false);
                $(this).attr('previousValue', 'checked');
            }


            var variants_id = [];
            @foreach($units_array as $u)
            var v = $("input[name='{{$u}}']:checked").val();
            if (v != null) {
                variants_id.push(v);
            }
            @endforeach
            var url = $('#variantUrl').val();
            var pId = $('#productId').val();
            var sellerFound = $('#sellerFound').val();


            if (url != null && variants_id != null) {
                $.ajax({
                    url: url,
                    data: {id: variants_id, productId: pId},
                    method: "get",
                    success: function (result) {
                        $('.seller-div').empty();
                        if (result.data.length > 0) {
                            result.data.forEach(sellerShow);
                        } else {
                            $('.seller-div').append(sellerFound)
                        }
                    },
                });
            }

        }));

        /*seller show*/
        function sellerShow(item, index) {
            $(".seller-div").append('<div class="col-md-3">\n' +
            '                                    <aside class="widget widget_same-brand widget_vendor-shop ' + item.stock_out + '">\n' +
            '                                        <div class="widget__content widget_vendor-shop-content">\n' +
            '                                            <div class="ps-product">\n' +
            '                                                <div class="ps-product__thumbnail">\n' +
            '                                                            <a href="' + item.vendor_link + '">\n' +
            '                                                                <img\n' +
            '                                                                    src="' + item.shop_logo + '"\n' +
            '                                                                    class="rounded"\n' +
            '                                                                    alt="#$seller->user->vendor->shop_name">\n' +
            '                                                            </a></div>\n' +
            '                                                <div class="ps-product__container text-center">\n' +
            '                                                    <div class="ps-product__content">\n' +
            '                                                        <p class="ps-product__price sale mb-0">' + item.price_format + '</p>\n' +
            '                                                        <p class="ps-product__price sale mb-0">' + item.discount_text + '</p>\n' +
            '                                                        <p class="ps-product__price sale mb-0">' + item.extra_price_format + '</p>\n' +
            '                                                        <p class="ps-product__price sale mb-0">' + item.total_price_format + '</p>\n' +
            '                                                        <p class="ps-product__price">' + item.variant + '</p>\n' +
            '                                                    </div>\n' +
            '                                                    @auth()\n' +
            '                                                        <a href="#!"\n' +
            '                                                           class="btn btn-primary m-2 p-3 fs-12 ' + item.display + '  addToCart-' + item.vendor_stock_id + '"\n' +
            '                                                           onclick="addToCart(' + item.vendor_stock_id + ')">@translate(Buy Now)</a>\n' +
            '                                                        <a href="#!"\n' +
            '                                                           class="btn btn-danger m-2 p-3 fs-12 ' + item.reverse_display + '">@translate(Out Of Stock)</a>\n' +
            '                                                    @endauth\n' +
            '                                                    @guest()\n' +
                                                    //    todo::akash guest add to cart in available shop
            '                                                        <a href="#!"\n' +
            '                                                           class="btn btn-primary m-2 p-3 fs-12 ' + item.display + '  addToGuestCart-' + item.vendor_stock_id + '"\n' +
            '                                                           onclick="addToGuestCart(' + item.vendor_stock_id + ')">@translate(Buy Now)</a>\n' +
            '                                                        <a href="#!"\n' +
            '                                                           class="btn btn-danger m-2 p-3 fs-12 ' + item.reverse_display + '">@translate(Out Of Stock)</a>\n' +
            '                                                    @endguest\n' +
            '                                                </div>\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                    </aside>\n' +
            '                                </div>');
        }




    </script>
@stop
