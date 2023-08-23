@if(vendorActive())
<div class="p-30">
    <div class="container">
      <div class="row">
          <div class="col-8">
              <div class="ps-section__header">
          <h3 class="text-capitalize">@translate(Shop by Store)</h3>
      </div>
          </div>
          <div class="col-4 text-right">
              <a href="{{ route('vendor.shops') }}" class="h3">
                      View All
              </a>
          </div>
      </div>
        <div class="ps-section__content">
            <div class="ps-block--categories-tabs ps-tab-root store_section">
                <div class="ps-tabs">
                    <div class="ps-tabs">
                        <div class="ps-tab active p-0">

                        <div class="row">
                        @forelse ($shop_by_store = App\User::where('user_type','Vendor')->latest()->paginate(paginate()) as $store)
                       @if($store->vendor != null)
                        <div class="col-md-3 col-xl-2 t-mb-30">
                            <a href="{{ route('vendor.shop',$store->vendor->slug) }}" class="product-card store-product-card">

                                @if (empty($store->vendor->shop_logo))
                                <span class="product-card__img-wrapper store-product-card__img-wrapper">
                                    <img src="{{asset('vendor-store.jpg')}}" alt="{{ $store->vendor->shop_name }}" class="img-fluid mx-auto">
                                </span>
                                 @else

                                 <span class="product-card__img-wrapper store-product-card__img-wrapper">
                                    <img src="{{ asset($store->vendor->shop_logo) }}" alt="{{ $store->vendor->shop_name }}" class="img-fluid mx-auto">
                                </span>

                                 @endif


                                <span class="product-card__body">
                                    <span class="product-card__title text-center">
                                        {{ $store->vendor->shop_name }}
                                    </span>

                                </span>
                            </a>
                        </div>
                                @endif
                              @empty
                              <div class="col-md-12 col-sm-12">
                                <img src="{{ asset('shop-not-found.png') }}" alt="">
                            </div>
                              @endforelse
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
