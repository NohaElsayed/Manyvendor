@if(subCategory()->count() >0)
    <div class="ps-search-trending">
        <div class="container">
            <div class="ps-section__header">
                <h3>@translate(Trending)<span></span></h3>
            </div>
            <div class="ps-section__content">
                <div class="ps-block--categories-tabs ps-tab-root">
                    <div class="ps-block__header">
                        <div class="ps-carousel--nav ps-tab-list owl-slider" data-owl-auto="false"
                             data-owl-speed="1000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true"
                             data-owl-item="8" data-owl-item-xs="3" data-owl-item-sm="4"
                             data-owl-item-md="6" data-owl-item-lg="6" data-owl-duration="500"
                             data-owl-mousedrag="on">
                            @foreach(subCategory() as $subCat)
                                <a href="#tab-{{$subCat->id}}">
                                    <i class="{{$subCat->icon}}"></i>
                                    <span class="{{$loop->index == 0 ? 'text-danger':''}}">{{$subCat->name}}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="ps-tabs">
                        <div class="ps-tabs">
                            @foreach(subCategory() as $subCat)
                                <div class="ps-tab {{$loop->index == 0 ? 'active':""}}" id="tab-{{$subCat->id}}">
                                    <div class="row">

                                        @php
                                            $trending_products = 0;
                                        @endphp

                                    @foreach($subCat->products as $product)

                                    <input type="hidden" value="{{ $trending_products++ }}">

                                        <div class="col-md-3 col-xl-2 t-mb-30">
                                            <a href="{{route('single.product',[$product->sku,$product->slug])}}" class="trending-product-card product-card">
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
                                                <span class="product-card__img-wrapper trending-product-card__img-wrapper">
                                                    <img src="{{ filePath($product->image)}}" alt="{{\Illuminate\Support\Str::limit($product->name,14)}}" class="img-fluid mx-auto">
                                                </span>
                                                <span class="product-card__body">
                                                    <span class="product-card__title">
                                                        {{\Illuminate\Support\Str::limit($product->name,14)}}
                                                    </span>

                                                    @if (vendorActive())

                                                        <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                        {{formatPrice(brandProductPrice($product->sellers)->min())
                                                                           == formatPrice(brandProductPrice($product->sellers)->max())
                                                                           ? formatPrice(brandProductPrice($product->sellers)->min())
                                                                           : formatPrice(brandProductPrice($product->sellers)->min()).
                                                                           '-' .formatPrice(brandProductPrice($product->sellers)->max())}}
                                                                    </span>
                                                        </span>

                                                    @else

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
                                                        
                                                    @endif
                                                    




                                            </a>

                                        </div>

                                        @if ($trending_products == 18)
                                                            @break
                                                        @endif

                                    @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
