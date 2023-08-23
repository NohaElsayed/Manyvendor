@if(vendorActive())
<div class="p-30">
    <div class="container">
      <div class="row">
          <div class="col-8">
              <div class="ps-section__header">
          <h3 class="text-capitalize">@translate(Shop by Brand)</h3>
      </div>
          </div>
          <div class="col-4 text-right">
              <a href="{{ route('brands') }}" class="h3">
                      View All
              </a>
          </div>
      </div>
        <div class="ps-section__content">
            <div class="ps-block--categories-tabs ps-tab-root">
                <div class="ps-tabs">
                    <div class="ps-tabs">
                        <div class="ps-tab active">

                        <div class="row">
                                    @forelse (brands(16) as $brand)
                                    <div class="col-md-3 col-xl-2 t-mb-30">
                                        <a href="{{ route('brand.shop', $brand->slug) }}" class="brand-product-card">

                                            @if (empty($brand->logo))
                                            <span class="product-card__img-wrapper brand-product-card__img-wrapper">
                                                <img src="{{asset('vendor-store.jpg')}}" alt="{{ $brand->name }}" width="133" height="133" class="img-fluid mx-auto">
                                            </span>
                                             @else

                                                <span class="product-card__img-wrapper brand-product-card__img-wrapper">
                                                <img src="{{ filePath($brand->logo) }}" alt="{{ $brand->name }}" class="img-fluid mx-auto">
                                            </span>

                                             @endif



                                            <span class="product-card__body">
                                                <span class="product-card__title text-center">
                                                    {{\Illuminate\Support\Str::limit($brand->name,14)}}
                                                </span>

                                            </span>
                                        </a>
                                    </div>
                              @empty
                                <img src="{{ asset('No-Brand-Found.jpg') }}" class="img-fluid" alt="#no-brand-found">
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
