@extends('frontend.master')


@section('title') @translate(Shops) @endsection

@section('content')

    <!-- breadcrumb:START -->
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                <li>@translate(Shops)</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb:END -->

    <!-- SHOP LIST:START -->
    <div class="ps-section--shopping ps-whishlist">
        <div class="container">
            <div class="ps-section__header">
                <h1>@translate(All Shop)</h1>
            </div>
            <div class="ps-section__content">
                <!-- all brand list -->
                <div class="container">
                    <form class="ps-form--newsletter" action="" method="get">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="ps-form__right">
                                    <div class="form-group--nest">
                                        <input class="form-control" name="search" value="{{Request::get('search')}}" type="text" id="myInput"
                                               placeholder="@translate(Search shop here)">
                                        <button class="ps-btn" type="submit">@translate(Search)</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="container" id="myShop">
                    <div class="row t-mt-30">
                        <!-- HERE GOES SHOPS -->
                        @forelse($seller_shops as $seller_shop)
                            @if($seller_shop->vendor != null)
                            <div class="col-md-3 col-xl-3 t-mb-30">
                                <a href="{{ route('vendor.shop',$seller_shop->vendor->slug) }}" class="product-card">

                                    @if (empty($seller_shop->vendor->shop_logo))
                                        <span class="product-card__img-wrapper">
                                            <img src="{{ asset('vendor-store.jpg') }}" alt="{{ $seller_shop->vendor->shop_name }}" class="img-fluid mx-auto">
                                        </span>
                                    @else

                                    <span class="product-card__img-wrapper">
                                            <img src="{{ filePath($seller_shop->vendor->shop_logo) }}" alt="{{ $seller_shop->vendor->shop_name }}" class="img-fluid mx-auto">
                                        </span>

                                    @endif


                                    <span class="product-card__body">
                                        <span class="product-card__title text-center h3 text-capitalize font-weight-bold">
                                            {{ $seller_shop->vendor->shop_name }}
                                        </span>
                                    </span>
                                </a>
                            </div>
                            @endif
                        @empty
                            <div class="col-md-12">
<img src="{{ asset('shop-not-found.png') }}" class="img-fluid" alt="#shop-not-found">
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- SHOP LIST:END -->


@stop
