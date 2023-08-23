@extends('frontend.master')


@section('title','Search product')

@section('content')

    <div class="ps-breadcrumb">
        <div class="ps-container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                <li>@translate(Shop)</li>
            </ul>
        </div>
    </div>
    <div class="ps-page--shop mt-3">
        <div class="ps-container">
            <div class="ps-shop-banner d-none">
                <div class="ps-carousel--nav-inside owl-slider" data-owl-auto="true" data-owl-loop="true"
                     data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1"
                     data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1"
                     data-owl-duration="1000" data-owl-mousedrag="on">
                    @foreach (categories(10, null) as $home_category)
                        @foreach($home_category->promotionBanner as $banner)
                            <a href="{{ $banner->link }}"><img src="{{ filePath($banner->image) }}" alt=""></a>
                        @endforeach
                    @endforeach
                </div>
            </div>
            {{--brand--}}
            <div class="ps-section__content d-none">
                <div class="ps-block--categories-tabs ps-tab-root">
                    <div class="ps-tabs">
                        <div class="ps-tabs">
                            <div class="ps-tab active">
                                <div class="ps-block__item">
                                    @forelse (brands(16) as $brand)
                                        <a href="shop-default.html">
                                            @if (empty($brand->logo))
                                                <img src="{{ asset('vendor-store.jpg') }}" class="rounded"
                                                     alt="#{{ $brand->name }}">
                                            @else
                                                <img src="{{ filePath($brand->logo) }}" class="rounded"
                                                     alt="#{{ $brand->name }}">
                                            @endif
                                        </a>
                                    @empty
                                        @translate(No Brand Found)
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--category--}}
            <div class="ps-shop-categories d-none">
                <div class="row align-content-lg-stretch">
                    @foreach (categories(10, null) as $home_category)
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--category-2" data-mh="categories">
                                <div class="ps-block__thumbnail"><img src="{{ filePath($home_category->image) }}"
                                                                      alt=""></div>
                                <div class="ps-block__content">
                                    <h4>{{ $home_category->name }}</h4>
                                    <ul>
                                        @foreach($home_category->childrenCategories as $parent_Cat)
                                            @foreach($parent_Cat->childrenCategories as $sub_cat)
                                                <li>
                                                    <a href="{{ route('category.shop',$sub_cat->slug) }}">{{ $sub_cat->name }}</a>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="ps-layout--shop">
                <div class="ps-layout__left">
                    <aside class="widget widget_shop">
                        <h4 class="widget-title">@translate(Categories)</h4>
                        <ul class="ps-list--categories">

                            @foreach (categories(10, null) as $home_category)
                                <li class="current-menu-item menu-item-has-children"><a
                                            href="{{ route('category.shop', $home_category->slug) }}">{{ $home_category->name }}</a><span
                                            class="sub-toggle"><i class="fa fa-angle-down"></i></span>
                                    <ul class="sub-menu">
                                        @foreach($home_category->childrenCategories as $parent_Cat)
                                            @foreach($parent_Cat->childrenCategories as $sub_cat)
                                                <li class="current-menu-item "><a
                                                            href="{{ route('category.shop',$sub_cat->slug) }}">{{ $sub_cat->name }}
                                                        ({{ App\Models\Product::where('category_id', $sub_cat->id)->count() }})</a>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </aside>
                </div>
                <div class="ps-layout__right">
                    <div class="ps-block--shop-features d-none">
                        <div class="ps-block__header">
                            <h3>@translate(Best Sale Items)</h3>
                            <div class="ps-block__navigation"><a class="ps-carousel__prev" href="#recommended1"><i
                                            class="icon-chevron-left"></i></a><a class="ps-carousel__next"
                                                                                 href="#recommended1"><i
                                            class="icon-chevron-right"></i></a></div>
                        </div>
                        <div class="ps-block__content">
                            <div class="owl-slider" id="recommended1" data-owl-auto="true" data-owl-loop="true"
                                 data-owl-speed="10000" data-owl-gap="30" data-owl-nav="false" data-owl-dots="false"
                                 data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3"
                                 data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000"
                                 data-owl-mousedrag="on">
                                @foreach (sale_products(10) as $product)
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail">
                                            <a href="{{ route('single.product',[$product->sku,$product->slug]) }}">
                                                <img src="{{ filePath($product->image) }}"
                                                     alt="#{{ $product->name }}">
                                            </a>
                                            <div
                                                    class="ps-product__badge">
                                                @if($product->is_discount)
                                                    <p class="ps-product__price sale">{{formatPrice($product->discount_price)}} <del>
                                                            {{formatPrice($product->product_price)}}</del></p>
                                                @else
                                                    <p class="ps-product__price">{{formatPrice($product->product_price)}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title"
                                                                                href="{{ route('single.product',[$product->sku,$product->slug]) }}">{{ $product->name }}</a>
                                                @if($product->is_discount)
                                                    <p class="ps-product__price sale">{{formatPrice($product->discount_price)}} <del>
                                                            {{formatPrice($product->product_price)}}</del></p>
                                                @else
                                                    <p class="ps-product__price">{{formatPrice($product->product_price)}}</p>
                                                @endif
                                            </div>
                                            <div class="ps-product__content hover"><a class="ps-product__title"
                                                                                      href="{{ route('single.product',[$product->sku,$product->slug]) }}">{{ $product->name }}</a>
                                                @if($product->is_discount)
                                                    <p class="ps-product__price sale">{{formatPrice($product->discount_price)}} <del>
                                                            {{formatPrice($product->product_price)}}</del></p>
                                                @else
                                                    <p class="ps-product__price">{{formatPrice($product->product_price)}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="ps-shopping ps-tab-root">
                        <div class="ps-shopping__header">
                            <p><strong> {{$total_product}}</strong> @translate(Products found) <small>@translate(Search keyword) : {{$key}}</small></p>
                            <div class="ps-shopping__actions">
                                <div class="d-none">
                                    <select class="ps-select d-none" data-placeholder="Sort Items">
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
                        <div class="ps-tabs">
                            <div class="ps-tab active" id="tab-1">
                                <div class="ps-shopping-product">
                                    <div class="row">
                                        @foreach($results as $product)


                                            <div class="col-md-3 col-xl-2 t-mb-30">
                                                <a href="{{ route('single.product',[$product->sku,$product->slug]) }}" class="product-card">
                                                                <span class="product-card__action d-flex flex-column align-items-center ">
                                                                    <span class="product-card__action-is product-card__action-view"
                                                                          onclick="forModal('{{ route('quick.view',$product->slug) }}', '@translate(Product quick view)')">
                                                                    <i class="fa fa-eye"></i>
                                                                    </span>
                                                                    <span class="product-card__action-is product-card__action-compare"
                                                                          onclick="addToCompare({{$product->id}})">
                                                                    <i class="fa fa-random"></i>
                                                                    </span>
                                                                    @auth()
                                                                        <span class="product-card__action-is product-card__action-wishlist"
                                                                              onclick="addToWishlist({{$product->id}})">
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                                                    @endauth

                                                                    @guest()
                                                                        <span
                                                                                class="product-card__action-is product-card__action-wishlist wishlist"
                                                                                data-placement="top"
                                                                                data-title="@translate(Add to wishlist)"
                                                                                data-toggle="tooltip"
                                                                                data-product_name='{{ $product->name }}'
                                                                                data-product_id='{{$product->id}}'
                                                                                data-product_sku='{{$product->sku}}'
                                                                                data-product_slug='{{$product->slug}}'
                                                                                data-product_image='{{ filePath($product->image) }}'
                                                                                data-app_url='{{ env('APP_URL') }}'
                                                                                data-product_price='{{formatPrice(brandProductPrice($product->sellers)->min())
                                                                                                == formatPrice(brandProductPrice($product->sellers)->max())
                                                                                                ? formatPrice(brandProductPrice($product->sellers)->min())
                                                                                                : formatPrice(brandProductPrice($product->sellers)->min()).
                                                                                                '-' .formatPrice(brandProductPrice($product->sellers)->max())}}'
                                                                        >
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                                                    @endguest





                                                                </span>
                                                    <span class="product-card__img-wrapper">
                                                                    <img src="{{ filePath($product->image) }}" alt="manyvendor" class="img-fluid mx-auto">
                                                                </span>
                                                    <span class="product-card__body">
                                                                    <span class="product-card__title">
                                                                        {{ $product->name }}
                                                                    </span>

                                                                    <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                      @if($product->is_discount)
                                                                            <p class="ps-product__price sale">{{formatPrice($product->discount_price)}}
                                                                        <del>
                                                                            {{formatPrice($product->product_price)}}</del>
                                                                    </p>
                                                                        @else
                                                                            <p class="ps-product__price">{{formatPrice($product->product_price)}}</p>
                                                                        @endif
                                                                    </span>

                                                                    </span>

                                                                </span>
                                                </a>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal d-none" id="shop-filter-lastest" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="list-group d-none"><a class="list-group-item list-group-item-action" href="#">@translate(Sort by)</a>
                                <a class="list-group-item list-group-item-action" href="#">@translate(Sort by average rating)</a>
                                <a class="list-group-item list-group-item-action" href="#">@translate(Sort by latest)</a>
                                <a class="list-group-item list-group-item-action" href="#">@translate(Sort by price: low to high)</a>
                                <a class="list-group-item list-group-item-action" href="#">@translate(Sort by price: high to low)</a>
                                <a class="list-group-item list-group-item-action text-center" href="#" data-dismiss="modal"><strong>@translate(Close)</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

