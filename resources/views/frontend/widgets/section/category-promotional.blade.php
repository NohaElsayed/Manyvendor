@foreach (categories(10, 'is_popular') as $home_category)
    @if(vendorActive())
        @if ($home_category->is_popular == 1)
            <div class="ps-product-box">
                <div class="container">
                    <div class="ps-block--product-box">
                        <div class="ps-block__header">
                            <h3>
                                <i class="{{ $home_category->icon }}"></i> {{ $home_category->name }}
                            </h3>
                            <ul>

                                @php
                                    $category_child_limit = 0;
                                @endphp

                                @foreach($home_category->childrenCategories as $parent_Cat)
                                    @foreach($parent_Cat->childrenCategories as $sub_cat)

                                    <input type="hidden" value="{{ $category_child_limit++ }}">
                                        <li>
                                            <a
                                                href="{{ route('category.shop',$sub_cat->slug) }}">{{ $sub_cat->name }}
                                            </a>
                                        </li>

                                        @if ($category_child_limit == 8)
                                            @break
                                        @endif

                                    @endforeach

                                    @if ($category_child_limit == 8)
                                            @break
                                        @endif

                                @endforeach
                            </ul>
                        </div>

                        <div class="ps-carousel--nav-inside owl-slider px-5 pt-5" data-owl-auto="true"
                                     data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0"
                                     data-owl-nav="true" data-owl-dots="true" data-owl-item="1"
                                     data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1"
                                     data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">

                                    @foreach($home_category->promotionBanner as $banner)
                                        <a href="{{ $banner->link }}">
                                            <img src="{{ filePath($banner->image) }}" alt="">
                                        </a>
                                    @endforeach

                                </div>


                        <div class="ps-block__content">
                            <div class="ps-block__left">
                                <div class="ps-block__products ps-tab-root">
                                    <ul class="ps-tab-list">
                                        <li class="current"><a
                                                href="#product-box-{{ $home_category->id }}">
                                                @translate(New Items)
                                            </a></li>
                                        <li>
                                            <a
                                                href="#product-box-{{ $home_category->id}}-sale">@translate(Discount)</a>
                                        </li>
                                    </ul>
                                    <div class="ps-tabs">
                                                    @php
                                                        $product_limit = 0;
                                                        $sale_product_limit = 0;
                                                        $related_product_limit = 0;
                                                    @endphp
                                        <div class="ps-tab active"
                                             id="product-box-{{ $home_category->id }}">
                                            <div class="row">
                                                @foreach($home_category->childrenCategories as $subcategory)

                                                    @foreach($subcategory->childrenCategories as $cat)

                                                        @forelse($cat->products as $product)

                                                        <input type="hidden" value="{{ $product_limit++ }}">

                                                        <div class="col-md-3 col-xl-3 t-mb-30">
                                                            <a href="{{route('single.product',[$product->sku,$product->slug])}}" class="product-card">
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
                                                                    <img src="{{ filePath($product->image)}}" alt="manyvendor" class="img-fluid mx-auto">
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


                                                        @if ($product_limit == 8)
                                                            @break
                                                        @endif

                                                        @endforeach
                                                        @if ($product_limit == 8)
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if ($product_limit == 8)
                                                            @break
                                                        @endif
                                                @endforeach

                                            </div>
                                        </div>

                                        <div class="ps-tab" id="product-box-{{ $home_category->id}}-sale">
                                            <div class="row">
                                                @foreach($home_category->childrenCategories as $subcategory)
                                                    @foreach($subcategory->childrenCategories as $cat)
                                                        @foreach($cat->products as $product)
                                                            @forelse ($product->vendorProduct as $sale_item)
                                                                @if($sale_item->is_discount != null)
                                                                    <input type="hidden" value="{{ $sale_product_limit++ }}">
                                                                    @if ($sale_product_limit <= 8)
                                                                        <div class="col-md-3 col-xl-3 t-mb-30">
                                                                            <a href="{{route('single.product',[$product->sku,$product->slug])}}" class="product-card">
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
                                                                                <img src="{{ filePath($product->image)}}" alt="manyvendor" class="img-fluid mx-auto">
                                                                            </span>
                                                                                            <span class="product-card__body">
                                                                                <span class="product-card__title">
                                                                                    {{ $product->name }}
                                                                                </span>

                                                                                <span class="t-mt-10 d-block">

                                                                                <div class="ps-product__badge out-stock">
                                                                                    @translate(Discount) {{ number_format(doubleval($sale_item->discount_percentage - 100), 2, '.', '')}}%
                                                                                </div>
                                                                                <span class="product-card__discount-price t-mr-5">
                                                                                    {{formatPrice($sale_item->discount_price)}}
                                                                                </span>
                                                                                    <del>
                                                                                    {{formatPrice($sale_item->product_price)}}
                                                                                    </del>
                                                                                </span>

                                                                            </span>
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @empty
                                                            @endforelse
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-block__right">
                                <figure>
                                    <figcaption>@translate(You may like)
                                    </figcaption>
                                    @foreach($home_category->childrenCategories as $subcategory)
                                        @foreach($subcategory->childrenCategories as $cat)
                                            @foreach($cat->recommended->shuffle() as $product)

                                            <input type="hidden" value="{{ $related_product_limit++ }}">
                                                                    @if ($related_product_limit <= 8)
                                                <div class="ps-product--horizontal">
                                                    <div class="ps-product__thumbnail">
                                                        <a
                                                            href="{{ route('single.product',[$product->sku,$product->slug]) }}"><img
                                                                src="{{ filePath($product->image)}}" class="rounded"
                                                                alt="#{{ $product->name }}"></a>
                                                    </div>
                                                    <div class="ps-product__content">
                                                        <a class="ps-product__title"
                                                           href="{{ route('single.product',[$product->sku,$product->slug]) }}">{{ $product->name }}</a>

                                                        <p class="ps-product__price may-like">

                                                            <span class="product-card__discount-price t-mr-5">
                                                                        {{formatPrice(brandProductPrice($product->sellers)->min())
																   == formatPrice(brandProductPrice($product->sellers)->max())
																   ? formatPrice(brandProductPrice($product->sellers)->min())
																   : formatPrice(brandProductPrice($product->sellers)->min()).
																   '-' .formatPrice(brandProductPrice($product->sellers)->max())}}
                                                                    </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </figure>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif

    @else
        @if ($home_category->is_popular == 1)
            <div class="ps-product-box">
                <div class="container">
                    <div class="ps-block--product-box">
                        <div class="ps-block__header">
                            <h3>
                                <i class="{{ $home_category->icon }}"></i> {{ $home_category->name }}
                            </h3>
                            <ul>

                                @php
                                    $category_child_limit = 0;
                                @endphp

                                @foreach($home_category->childrenCategories as $parent_Cat)
                                    @foreach($parent_Cat->childrenCategories as $sub_cat)

                                    <input type="hidden" value="{{ $category_child_limit++ }}">

                                        <li>
                                            <a
                                                href="{{ route('category.shop',$sub_cat->slug) }}">{{ $sub_cat->name }}</a>
                                        </li>

                                        @if ($category_child_limit == 8)
                                            @break
                                        @endif

                                    @endforeach

                                    @if ($category_child_limit == 8)
                                        @break
                                    @endif

                                @endforeach
                            </ul>
                        </div>

                        <div class="ps-carousel--nav-inside owl-slider" data-owl-auto="true"
                             data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0"
                             data-owl-nav="true" data-owl-dots="true" data-owl-item="1"
                             data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1"
                             data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">

                            @foreach($home_category->promotionBanner as $banner)
                                <a href="{{ $banner->link }}">
                                    <img src="{{ filePath($banner->image) }}" alt="">
                                </a>
                            @endforeach

                        </div>

                        <div class="ps-block__content">
                            <div class="ps-block__left">
                                <div class="ps-block__products ps-tab-root">
                                    <ul class="ps-tab-list">
                                        <li class="current"><a
                                                href="#product-box-{{ $home_category->id }}">
                                                @translate(New Items)</a></li>
                                        <li>
                                            <a
                                                href="#product-box-{{ $home_category->id}}-sale">@translate(Discount)</a>
                                        </li>
                                    </ul>
                                    <div class="ps-tabs">
                                         New arrival


                                        @php
                                            $product_limit = 0;
                                            $sale_product_limit = 0;
                                            $related_product_limit = 0;
                                        @endphp

                                        <div class="ps-tab active"
                                             id="product-box-{{ $home_category->id }}">
                                            <div class="row">
                                                @foreach($home_category->childrenCategories as $subcategory)
                                                    @foreach($subcategory->childrenCategories as $cat)
                                                        @foreach($cat->products as $product)

                                                        <input type="hidden" value="{{ $product_limit++ }}">

                                                            <div class="col-md-3 col-xl-3 t-mb-30">
                                                                <a href="{{route('single.product',[$product->sku,$product->slug])}}" class="product-card">
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
                                                                    <img src="{{ filePath($product->image)}}" alt="manyvendor" class="img-fluid mx-auto">
                                                                </span>
                                                                    <span class="product-card__body">
                                                                    <span class="product-card__title">
                                                                        {{ $product->name }}
                                                                    </span>

                                                                    <span class="t-mt-10 d-block">
                                                                        @if($product->is_discount)
                                                                            <span class="product-card__discount-price t-mr-5">
                                                                            {{formatPrice($product->discount_price)}}
                                                                        </span>
                                                                            <del class="product-card__price">
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

                                                                @if ($product_limit == 8)
                                                                    @break
                                                                @endif

                                                             @endforeach
                                                        @if ($product_limit == 8)
                                                            @break
                                                        @endif
                                                    @endforeach

                                                    @if ($product_limit == 8)
                                                            @break
                                                        @endif
                                                @endforeach

                                            </div>
                                        </div>

                                         Sale
                                        <div class="ps-tab" id="product-box-{{ $home_category->id}}-sale">
                                            <div class="row">
                                                @foreach($home_category->childrenCategories as $subcategory)
                                                    @foreach($subcategory->childrenCategories as $cat)
                                                        @foreach($cat->products as $product)
                                                            @if($product->is_discount)

                                                                <input type="hidden" value="{{ $sale_product_limit++ }}">

                                                                <div class="col-md-3 col-xl-3 t-mb-30">
                                                                    <a href="{{route('single.product',[$product->sku,$product->slug])}}" class="product-card">
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
                                                                            <img src="{{ filePath($product->image)}}" alt="manyvendor" class="img-fluid mx-auto">
                                                                        </span>
                                                                        <span class="product-card__body">
                                                                        <span class="product-card__title">
                                                                            {{ $product->name }}
                                                                        </span>

                                                                        <span class="t-mt-10 d-block">
                                                                            @if($product->is_discount)
                                                                                <span class="product-card__discount-price t-mr-5">
                                                                                {{formatPrice($product->discount_price)}}
                                                                            </span>
                                                                                <del class="product-card__price">
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
                                                            @endif
                                                        @if ($sale_product_limit == 8)
                                                                    @break
                                                                @endif

                                                             @endforeach
                                                        @if ($sale_product_limit == 8)
                                                            @break
                                                        @endif
                                                    @endforeach

                                                    @if ($sale_product_limit == 8)
                                                            @break
                                                        @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-block__right">
                                <figure>
                                    <figcaption>@translate(You may like)
                                    </figcaption>
                                    @foreach($home_category->childrenCategories as $subcategory)
                                        @foreach($subcategory->childrenCategories as $cat)
                                            @foreach($cat->recommended->shuffle() as $product)

                                            <input type="hidden" value="{{ $related_product_limit++ }}">

                                                <div class="ps-product--horizontal">
                                                    <div class="ps-product__thumbnail">
                                                        <a
                                                            href="{{ route('single.product',[$product->sku,$product->slug]) }}"><img
                                                                src="{{ filePath($product->image)}}" class="rounded"
                                                                alt="#{{ $product->name }}"></a>
                                                    </div>
                                                    <div class="ps-product__content">
                                                        <a class="ps-product__title"
                                                           href="{{ route('single.product',[$product->sku,$product->slug]) }}">{{ $product->name }}</a>

                                                        <p class="ps-product__price may-like">
                                                            @if($product->is_discount === 1)
                                                                <span>{{ formatPrice($product->discount_price) }}</span>
                                                                <del>{{ formatPrice($product->product_price) }}</del>
                                                            @else
                                                                {{ formatPrice($product->product_price) }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @if ($related_product_limit == 6)
                                                                    @break
                                                                @endif

                                                             @endforeach
                                                        @if ($related_product_limit == 6)
                                                            @break
                                                        @endif
                                                    @endforeach

                                                    @if ($related_product_limit == 6)
                                                            @break
                                                        @endif
                                                @endforeach
                                </figure>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    @endif
@endforeach
