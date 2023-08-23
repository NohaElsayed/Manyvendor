@extends('frontend.master')


@section('title')

@section('content')

    <!-- breadcrumb:START -->
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                <li>@translate(Brands)</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb:END -->

    <!-- SHOP LIST:START -->
    <div class="ps-section--shopping ps-whishlist">
        <div class="container">
            <div class="ps-section__header">
                <h1>@translate(All Brands)</h1>
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
                                               placeholder="@translate(Search brand here)">
                                        <button class="ps-btn" type="submit">@translate(Search)</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="container" id="myShop">
                    <div class="row mt-5">
                        <!-- HERE GOES SHOPS -->
                     
                        
                        
                                @forelse ($brands as $brand)
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
    <!-- SHOP LIST:END -->


@stop

