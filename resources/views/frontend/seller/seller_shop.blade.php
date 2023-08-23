@extends('frontend.master')



@section('title'){{ $seller_store->shop_name }}@stop

@section('content')

    <!-- breadcrumb:START -->
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                <li><a href="#">{{ $seller_store->shop_name }}</a></li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb:END -->

    <!-- SHOP:START -->
    <div class="ps-vendor-store">
        <div class="container">
            <div class="ps-section__container">
                <div class="ps-section__right">
                    <!-- SELLER PRODUCTS -->
                    <div class="ps-shopping ps-tab-root">
                        <div class="ps-shopping__header">
                            <p><strong> {{ $products->count() }}</strong> @translate(Products found)</p>
                            <div class="ps-shopping__actions">
                                <div class="d-none">
                                    <select class="ps-select" data-placeholder="Sort Items">
                                        <option>Sort by latest</option>
                                        <option>Sort by popularity</option>
                                        <option>Sort by average rating</option>
                                        <option>Sort by price: low to high</option>
                                        <option>Sort by price: high to low</option>
                                    </select>
                                </div>
                                <div class="ps-shopping__view">
                                    <p>@translate(View)</p>
                                    <ul class="ps-tab-list">
                                        <li class="active"><a href="#tab-1"><i class="icon-grid"></i></a></li>
                                        <li><a href="#tab-2"><i class="icon-list4"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="ps-tabs" id="myStore">
                            <div class="ps-tab active" id="tab-1">
                                <div class="row">

                                    @forelse($products as $product)
                                        <div class="col-md-3 col-xl-4 t-mb-30">
                                            <a href="{{ route('single.product',[$product->product->sku,$product->product->slug]) }}"
                                               class="product-card">
                                                                <span class="product-card__action d-flex flex-column align-items-center ">
                                                                    <span class="product-card__action-is product-card__action-view"
                                                                          onclick="forModal('{{ route('quick.view',$product->product->slug) }}', '@translate(Product quick view)')">
                                                                    <i class="fa fa-eye"></i>
                                                                    </span>
                                                                    <span class="product-card__action-is product-card__action-compare"
                                                                          onclick="addToCompare({{$product->product->id}})">
                                                                    <i class="fa fa-random"></i>
                                                                    </span>

                                                                </span>
                                                <span class="product-card__img-wrapper">
                                                                    <img src="{{ filePath($product->product->image) }}"
                                                                         alt="manyvendor" class="img-fluid mx-auto">
                                                                </span>
                                                <span class="product-card__body">
                                                                    <span class="product-card__title">
                                                                        {{ $product->product->name }}
                                                                    </span>

                                                        <span class="t-mt-10 d-block">
                                                        @if($product->is_discount == 1)
                                                            <span class="product-card__discount-price t-mr-5">
                                                                {{formatPrice($product->discount_price)}}
                                                            </span>
                                                            <del>
                                                            {{formatPrice($product->product_price)}}
                                                            </del>
                                                            @else
                                                            <span class="product-card__discount-price t-mr-5">
                                                                {{formatPrice($product->product_price)}}
                                                            </span>
                                                            @endif
                                                        </span>
                                                    </span>
                                            </a>
                                        </div>

                                    @empty
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                            <img src="{{ asset('no-product-found.png') }}" alt="#no-product-found">
                                        </div>
                                    @endforelse


                                </div>
                                <div class="ps-pagination">
                                    <ul class="pagination">
                                        {{ $products->links() }}
                                    </ul>
                                </div>
                            </div>
                            <div class="ps-tab" id="tab-2">

                            @forelse($products as $product)

                                <!-- TODO::OLD -->
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail">
                                            <a href="{{ route('single.product',[$product->product->sku,$product->product->slug]) }}">
                                                <img src="{{ filePath($product->product->image) }}"
                                                     alt="{{ $product->product->name }}"></a>
                                            <div class="ps-product__badge">{{ $product->product->discount_percentage - 100 }}
                                                %
                                            </div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title"
                                                                                href="{{ route('single.product',[$product->product->sku,$product->product->slug]) }}">
                                                    {{ $product->product->name }}
                                                </a>

                                                <p>
                                                    {!! $product->product->short_desc!!}
                                                </p>
                                            </div>
                                            <div class="ps-product__shopping">
                                                 <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                        {{formatPrice(brandProductSalePrice($product->product->sellers)->min())
                                                                            == formatPrice(brandProductSalePrice($product->product->sellers)->max())
                                                                            ? formatPrice(brandProductSalePrice($product->product->sellers)->min())
                                                                            : formatPrice(brandProductSalePrice($product->product->sellers)->min()).
                                                                            '-' .formatPrice(brandProductSalePrice($product->product->sellers)->max())}}
                                                                    </span>
                                                                    <del class="product-card__price">
                                                                        {{formatPrice(brandProductPrice($product->product->sellers)->min())
                                                                           == formatPrice(brandProductPrice($product->product->sellers)->max())
                                                                           ? formatPrice(brandProductPrice($product->product->sellers)->min())
                                                                           : formatPrice(brandProductPrice($product->product->sellers)->min()).
                                                                           '-' .formatPrice(brandProductPrice($product->product->sellers)->max())}}
                                                                    </del>
                                                                    </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TODO::OLD END-->
                                @empty
                                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                            <img src="{{ asset('no-product-found.png') }}" alt="#no-product-found">
                                        </div>
                                @endforelse

                                <div class="ps-pagination">
                                    <ul class="pagination">
                                        {{ $products->links() }}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-section__left">
                    <div class="ps-block--vendor">
                        <div class="ps-block__thumbnail">
                            @if (empty($seller_store->shop_logo))
                                <img src="{{ asset('vendor-store.jpg') }}" alt="#{{ $seller_store->shop_name }}">
                            @else
                                <img src="{{ filePath($seller_store->shop_logo) }}"
                                     alt="#{{ $seller_store->shop_name }}">
                            @endif
                        </div>
                        <div class="ps-block__container">
                            <div class="ps-block__header">
                                <h4>{{ $seller_store->shop_name }}</h4>

                                @php

                                    $stars_count = App\Models\OrderProduct::where('shop_id', $seller_store->id)
                                                ->whereNotNull('review_star')
                                                ->select('review_star')
                                                ->get()
                                                ->toArray();

                                    $shop_stars_count = App\Models\OrderProduct::where('shop_id', $seller_store->id)
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
                                        @for ($i = 0; $i < $result; $i++)
                                            <a href="javascript:void(0)" data-rating-value="1" data-rating-text="1"
                                               class="br-selected br-current"></a>
                                        @endfor
                                    </div>
                                </div>

                                <p>
                                    <strong>{{ ($result/5) * 100 }}% @translate(Positive)</strong>
                                    ({{ $shop_stars_count }}
                                    @translate(rating))
                                </p>
                            </div>
                            <span class="ps-block__divider"></span>
                            <div class="ps-block__content">
                                <p>
                                    <strong>{{ $seller_store->shop_name }}</strong>, {{ $seller_store->about }}.
                                </p>
                                <span class="ps-block__divider"></span>
                                <p>
                                    <strong>@translate(Address)</strong> {{ $seller_store->address }}
                                </p>

                                @if (!empty($seller_store->facebook))
                                    <figure>
                                        <figcaption>@translate(Follow us on social)</figcaption>
                                        <ul class="ps-list--social-color">
                                            <li>
                                                <a class="facebook" href="{{ $seller_store->facebook }}">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </figure>

                                @endif


                            </div>
                            <div class="ps-block__footer">
                                <p>@translate(Call us directly)
                                    <strong>{{ $seller_store->phone }}</strong>
                                </p>
                                <p>@translate(Or if you have any question)</p>
                                <a class="ps-btn ps-btn--fullwidth" href="mailto:{{ $seller_store->email }}">@translate(Contact
                                    Seller)</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- SHOP:END -->


@stop
