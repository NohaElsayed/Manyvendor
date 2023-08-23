@extends('frontend.master')

@section('title') @translate(Brand Products) @stop

@section('content')

    <div class="ps-breadcrumb">
        <div class="ps-container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                <li>@translate(Brand Products)</li>
            </ul>
        </div>
    </div>
    <div class="ps-page--shop mt-3">
        <div class="ps-container">

            {{--brand--}}
            <div class="ps-section__content d-none">
                <div class="ps-block--categories-tabs ps-tab-root">
                    <div class="ps-tabs">
                        <div class="ps-tabs">
                            <div class="ps-tab active">
                                <div class="ps-block__item">
                                    @forelse (brands(16) as $brand)
                                        <a href="{{ route('brand.shop', $brand->slug) }}">
                                            @if (empty($brand->logo))
                                                <img src="{{ asset('vendor-store.jpg') }}" class="rounded" width="133" height="133"
                                                     alt="#{{ $brand->name }}">
                                            @else
                                                <img src="{{ filePath($brand->logo) }}" class="rounded" width="133" height="133"
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
                        <h4 class="widget-title">@translate(Brands)</h4>
                        <ul class="ps-list--categories">

                            @foreach ($brand_products as $brand)
                                <li>
                                    <a href="{{ route('brand.shop', $brand->slug) }}">
                                        {{ $brand->name }}({{ $total_brand_product }})
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </aside>
                </div>
                <div class="ps-layout__right">

                    <div class="ps-shopping ps-tab-root">
                        <div class="ps-shopping__header">
                            <p><strong> {{$total_brand_product}}</strong> @translate(Products found)</p>
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

                                        @foreach($brand_products as $brand_product)
                                            @forelse($brand_product->products as $product)

                                                <div class="col-md-3 col-xl-2 t-mb-30">
                                                    <a href="{{ route('single.product',[$product->sku,$product->slug]) }}"
                                                       class="product-card">
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
                                                                    <img src="{{ filePath($product->image) }}"
                                                                         alt="manyvendor" class="img-fluid mx-auto">
                                                                </span>
                                                        <span class="product-card__body">
                                                                    <span class="product-card__title">
                                                                        {{ $product->name }}
                                                                    </span>


                                                                    <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                                                                {{formatPrice(brandProductPrice($product->sellers)->min())
                                                                                                                  == formatPrice(brandProductPrice($product->sellers)->max())
                                                                                                                  ? formatPrice(brandProductPrice($product->sellers)->min())
                                                                                                                  : formatPrice(brandProductPrice($product->sellers)->min()).
                                                                                                                  '-' .formatPrice(brandProductPrice($product->sellers)->max())}}
                                                                                                           </span>
                                                                                                           </span>

                                                                    </span>

                                                    </a>
                                                </div>

                                                @empty

                                                <img src="{{ asset('no-product-found.png') }}" class="img-fluid" alt="#no-product-found">

                                            @endforelse
                                        @endforeach

                                    </div>
                                </div>


                            </div>
                            <div class="ps-tab" id="tab-2">
                                <div class="ps-shopping-product">

                                    @foreach($brand_products as $brand_product)



                                        @forelse($brand_product->products as $product)
                                            <div class="ps-product ps-product--wide">
                                                <div class="ps-product__thumbnail"><a
                                                            href="{{ route('single.product',[$product->sku,$product->slug]) }}">
                                                        <img src="{{ filePath($product->image) }}" class="rounded"
                                                             alt="#{{ $product->name }}"></a>
                                                </div>
                                                <div class="ps-product__container">
                                                    <div class="ps-product__content"><a class="ps-product__title"
                                                                                        href="{{ route('single.product',[$product->sku,$product->slug]) }}">{{ $product->name }}</a>

                                                        {!! $product->short_desc !!}
                                                    </div>
                                                    <div class="ps-product__shopping">
                                                               <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                                                               {{formatPrice(brandProductPrice($product->sellers)->min())
                                                                                                                  == formatPrice(brandProductPrice($product->sellers)->max())
                                                                                                                  ? formatPrice(brandProductPrice($product->sellers)->min())
                                                                                                                  : formatPrice(brandProductPrice($product->sellers)->min()).
                                                                                                                  '-' .formatPrice(brandProductPrice($product->sellers)->max())}}
                                                                                                           </span>
                                                                                                           </span>


                                                        <a class="ps-btn"
                                                           href="{{ route('single.product',[$product->sku,$product->slug]) }}">Buy
                                                            Now</a>
                                                        <ul class="ps-product__actions">

                                                            <li>
                                                                @auth()
                                                                    <a data-toggle="tooltip" data-placement="top"
                                                                       title="Add to Whishlist" href="#!"
                                                                       onclick="addToWishlist({{$product->id}})"><i
                                                                                class="icon-heart"></i></a>
                                                                @endauth
                                                                @guest()
                                                                    <a 
                                                                class="wishlist"
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
                                                                </a>
                                                                @endguest

                                                                


                                                            </li>
                                                            <li>
                                                                <a href="#!" onclick="addToCompare({{$product->id}})"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   title="Compare"><i class="fa fa-random"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            @empty
                                            <div class="col-md-12 col-xl-12 t-mb-30">
                                                <img src="{{ asset('no-product-found.png') }}" alt="#no-product-found">
                                            </div>
                                        @endforelse

                                    @endforeach
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
                            <div class="list-group d-none">
                                <a class="list-group-item list-group-item-action" href="#">Sort
                                    by</a><a class="list-group-item list-group-item-action" href="#">Sort by average
                                    rating</a><a class="list-group-item list-group-item-action" href="#">Sort by
                                    latest</a><a class="list-group-item list-group-item-action" href="#">Sort by price:
                                    low to high</a><a class="list-group-item list-group-item-action" href="#">Sort by
                                    price: high to low</a><a class="list-group-item list-group-item-action text-center"
                                                             href="#" data-dismiss="modal"><strong>Close</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
