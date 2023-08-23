<article class="ps-product--detail ps-product--fullwidth ps-product--quickview">
    <div class="ps-product__header">
        <div class="ps-product__thumbnail" data-vertical="false">
            <div class="ps-product__images d-none" data-arrow="true">
                @foreach($quick_product->images as $image)
                    <div class="item">
                        <img src="{{ filePath($quick_product->image) }}" alt="#{{ $quick_product->name }}">
                    </div>
                @endforeach
            </div>

            <div class="ps-product__images" data-arrow="true">
                <div class="item">
                    <img src="{{ filePath($quick_product->image) }}" alt="#{{ $quick_product->name }}">
                </div>
            </div>

        </div>
        <div class="ps-product__info">
            <h1>{{ $quick_product->name }}</h1>
                <div class="ps-product__meta border-0 mb-1">
                    <p>@translate(Brand): <a
                                href="{{ route('single.product',[$quick_product->sku,$quick_product->slug]) }}">{{ $quick_product->brand->name }}</a>
                    </p>
                </div>
                @if(vendorActive())
                <h4 class="ps-product__price d-none">
                    <span class="t-mt-10 d-block">
                        <span class="product-card__discount-price t-mr-5">
                            {{formatPrice(brandProductPrice($quick_product->sellers)->min())
                               == formatPrice(brandProductPrice($quick_product->sellers)->max())
                               ? formatPrice(brandProductPrice($quick_product->sellers)->min())
                               : formatPrice(brandProductPrice($quick_product->sellers)->min()).
                               '-' .formatPrice(brandProductPrice($quick_product->sellers)->max())}}
                        </span>
                    </span>
                </h4>
                @else
                <h4 class="ps-product__price">
                    @if($quick_product->is_discount)
                        <p class="ps-product__price sale">{{formatPrice($quick_product->discount_price)}}
                            <del>
                                {{formatPrice($quick_product->product_price)}}</del>
                        </p>
                    @else
                        <p class="ps-product__price">{{formatPrice($quick_product->product_price)}}</p>
                    @endif
                </h4>
                @endif
            <div class="ps-product__desc">
                {!! $quick_product->short_desc !!}
            </div>
        </div>
    </div>
</article>
 