@extends('frontend.master')

@section('keywords')
{{ $single_product->meta_desc }}
@stop

@section('content')
    <nav class="navigation--mobile-product">
        @auth()
            <a class="ps-btn ps-btn--black" href="#!" onclick="addToWishlist({{$single_product->id}})"><i
                        class="icon-heart"></i></a>
        @endauth
        @guest()
            <a class="ps-btn ps-btn--black" href="{{route('login-redirect')}}?url={{url()->current()}}"><i
                        class="icon-heart"></i></a>
        @endguest
        <a class="ps-btn" href="#!" onclick="addToCompare({{$single_product->id}})"><i class="fa fa-random"></i></a>
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
                                            <div class="item"><a href="{{filePath($single_product->image)}}"><img
                                                            src="{{filePath($single_product->image)}}" class="m-auto" alt=""></a></div>
                                            @foreach ($single_product->images as $image)

                                                <div class="item"><a href="{{filePath($image->image)}}"><img
                                                                src="{{filePath($image->image)}}" alt=""></a></div>
                                            @endforeach

                                        </div>
                                    </div>
                                </figure>
                                <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4"
                                     data-arrow="false">
                                    <div class="item"><img src="{{filePath($single_product->image)}}" alt=""></div>
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
                                <h4 class="ps-product__price">
                                    @if($single_product->is_discount)
                                        <p class="ps-product__price sale text-left">{{formatPrice($single_product->discount_price)}}
                                            <del>
                                                {{formatPrice($single_product->product_price)}}</del>
                                        </p>
                                    @else
                                        <p class="ps-product__price text-left">{{formatPrice($single_product->product_price)}}</p>
                                    @endif

                                </h4>
                                <div class="ps-product__desc">
                                    <p> {!! $single_product->short_desc!!}</p>
                                </div>
                                <div class="ps-product__variations">
                                    @if($product_variants->count() > 0)
                                        <span class="pl-0">@translate(Select Variations)</span>
                                        @endif
                                    <figure class="mt-2">
                                        <div class="form-row">
                                            {{--variants show--}}
                                            @foreach($product_variants as $variant)

                                                @if($variant->unit == 'Color')

                                                    <input type="radio" name="{{$variant->unit}}"
                                                           id="color{{ $variant->code }}" value="{{$variant->id}}"/>
                                                    <label for="color{{ $variant->code }}" class="variant_label"><span
                                                                class="variant_color card"
                                                                style="background: {{ $variant->code ?? '' }};"></span></label>

                                                @else

                                                    <label for="unit-{{$variant->variant}}" class="variant_unit">
                                                        <input type="radio" id="unit-{{$variant->variant}}"
                                                               name="{{$variant->unit}}"
                                                               value="{{$variant->id}}"
                                                               class="check-with-label">
                                                        {{$variant->variant}}
                                                    </label>

                                                @endif
                                            @endforeach
                                        </div>
                                    </figure>
                                    <div id="update_data">

                                    </div>

                                </div>
                                <div class="ps-product__shopping">
                                    <figure>
                                        <figcaption>@translate(Quantity)</figcaption>
                                        <div class="value-button" id="decrease" onclick="decreaseValue()"
                                             value="Decrease Value">-
                                        </div>

                                        <input type="number"
                                               id="number"
                                               value="1"
                                               min="0"
                                               max="10"
                                               class="cart-quantity input-number" readonly
                                        />
                                        <div class="value-button" id="increase" onclick="increaseValue()"
                                             value="Increase Value">+
                                        </div>

                                    </figure>
                                    @auth()
                                        <a class="ps-btn bookWithoutVariant" id="check_shop"
                                           onclick="addToCart('{{$stock_id}}',null)" href="javascript:void(0)"
                                           data-toggle="tooltip" data-placement="top"
                                           data-title="@translate(Please select the product variant)">
                                            @translate(Add to Cart)</a>
                                    @endauth
                                    @guest()
                                        <a class="ps-btn bookWithoutVariant" id="check_shop"
                                           onclick="addToGuestCart('{{$stock_id}}',null)" href="javascript:void(0)"
                                           data-toggle="tooltip" data-placement="top"
                                           data-title="@translate(Please select the product variant)">
                                            @translate(Add to Cart)</a>
                                    @endguest

                                    <div class="ps-product__actions active">
                                        @auth()
                                            <a href="#!" onclick="addToWishlist({{$single_product->id}})"data-toggle="tooltip" data-placement="top" data-title="@translate(Add to wishlist)"><i
                                                        class="icon-heart"></i></a>
                                        @endauth
                                        @guest()
                                            <a 
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
                                                                    <i class="fa fa-heart-o"></i>
                                                                </a>
                                        @endguest


                                                                


                                        <a href="#!" onclick="addToCompare({{$single_product->id}})"data-toggle="tooltip" data-placement="top" data-title="@translate(Add to comparison)"><i
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
                                {{-- fcaebook share SDK::END --}}

                            </div>
                        </div>


                        <div class="ps-product__content ps-tab-root">
                            <ul class="ps-tab-list">
                                <li class="active"><a href="#tab-1">@translate(Description)</a></li>
                                <li><a href="#tab-4">@translate(Reviews) ({{ $reviews_count = 0 ? 0 : $reviews_count }}) </a></li>

                            </ul>
                            <div class="ps-tabs">
                                <div class="ps-tab active" id="tab-1">
                                    <div class="ps-document">
                                        {!! $single_product->big_desc !!}
                                    </div>
                                </div>

                                <div class="ps-tab" id="tab-4">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="row">
                                                <div class="col-sm-7">
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

                    <aside class="widget widget_same-brand">
                        <h3>@translate(Same Brand)</h3>
                        <div class="widget__content">
                            @forelse($brand_products as $brand_product)

                                <a href="{{route('single.product',[$brand_product->sku,$brand_product->slug])}}"
                                   class="mb-3  product-card">
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
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                        @endguest


                                        

                                                                    
                                                                </span>
                                    <span class="product-card__img-wrapper">
                                        <img src="{{ filePath($brand_product->image) }}" alt="#{{$brand_product->name}}"
                                             class="img-fluid mx-auto">
                                    </span>
                                    <span class="product-card__body">
                                        <span class="product-card__title text-center">
                                            {{$brand_product->name}}
                                        </span>
                                        
                                        @if($brand_product->is_discount)
                                            <p class="ps-product__price sale">{{formatPrice($brand_product->discount_price)}}
                                            <del>
                                                {{formatPrice($brand_product->product_price)}}</del>
                                        </p>
                                        @else
                                            <p class="ps-product__price">{{formatPrice($brand_product->product_price)}}</p>
                                        @endif
                                       
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
                    <div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true"
                         data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true"
                         data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3"
                         data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">

                        @foreach($related_products as $single_product)

                            <div class="col t-mb-30">
                                <a href="{{route('single.product',[$single_product->sku,$single_product->slug])}}"
                                   class="product-card">
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
                                                                                                '-' .formatPrice(brandProductPrice($single_product->sellers)->max())}}'    
                                                                >
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                    @endguest



                                    


                                </span>
                                    <span class="product-card__img-wrapper">
                                    <img src="{{ filePath($single_product->image)}}" alt="#{{ $single_product->name }}"
                                         class="img-fluid mx-auto">
                                </span>
                                    <span class="product-card__body">
                                    <span class="product-card__title text-center">
                                       {{ $single_product->name }}
                                    </span>


                                    <span class="t-mt-10 d-block text-center">
@if($single_product->is_discount)
                                            <p class="ps-product__price sale">{{formatPrice($single_product->discount_price)}}
                                            <del>
                                                {{formatPrice($single_product->product_price)}}</del>
                                        </p>
                                        @else
                                            <p class="ps-product__price">{{formatPrice($single_product->product_price)}}</p>
                                        @endif



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

    {{--here the all url for ajax--}}
    <input id="variantUrl" value="{{route('ecommerce.product.variant')}}" type="hidden">
    <input id="stock_id" value="" type="hidden">
    <input id="sellerFound" value="@translate(No Shop Available)" type="hidden">
    <input id="productFound" value="@translate(No Product Available)" type="hidden">
    <input id="redirectRoute" value="{{route('login-redirect')}}?url={{url()->current()}}" type="hidden">
    <input id="title" value="@translate(Please select the product variant)" type="hidden">
@stop

@section('js')
    <script>
        "use strict"
        /*check have variant*/
        $(document).ready(function () {
            $('#stock_id').val('');
            @if($units_array != null)
            $('[data-toggle="tooltip"]').tooltip({delay: {"show": 500, "hide": 100}})
            $('#check_shop').removeAttr('href');
            $('.bookWithoutVariant').removeAttr('onclick');
            @else
            $('.bookWithoutVariant').removeAttr('data-title');
            $('[data-toggle="tooltip"]').tooltip('disable')
            @endif
        })

        //published the all
        $('input[type="radio"]').on('click',(function () {

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
            console.log(variants_id);
            if (url != null && variants_id != null) {
                $.ajax({
                    url: url,
                    data: {id: variants_id, productId: pId},
                    method: "get",
                    success: function (result) {
                        console.log(result)
                        $('#update_data').empty();
                        if (result.data.variant_str != undefined) {
                            $('#update_data').append("<span>" + result.data.extra_price_format + "</span></br><span>" + result.data.total_price_format + "</span></br><span>" + result.data.variant_str + "</span>");
                            if (result.data.stock) {
                                document.getElementById('stock_id').value = result.data.product_stock_id;
                                document.getElementById('check_shop').text(result.data.stock_out);
                            } else {
                                $('#stock_id').val();
                                outOfStock(result.data.stock_out)
                            }
                        } else {
                            $('#stock_id').val('');
                            var notFound = $('#productFound').val();
                            $('#update_data').append("<span>" + notFound + "</span>");
                            outOfStock(notFound);
                        }
                    },
                });
            }

        }));

        $('#check_shop').on('click',(function () {

            var stokid = $('#stock_id').val();

            if (stokid != "" && stokid != null) {


                @auth()
                    addToCart(stokid, null);
                @endauth


                    @guest()
                        addToGuestCart(stokid, null);
                    @endguest

            } else {

                @if($units_array != null)
                    var notFound = $('#productFound').val();
                    outOfStock(notFound);
                @endif

            }
        }));

        function outOfStock(message) {
            toastr.warning(message, toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "30000",
                "hideDuration": "1000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
        };

    </script>
@stop
