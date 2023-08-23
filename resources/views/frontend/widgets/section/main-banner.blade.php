<div class="ps-home-banner pb-5">
    <div class="container">

        @include('frontend.include.sidebar.desktop.category-sidebar')

        <div class="ps-section__center">
            @if (getPromotions('mainSlider')->count() != 1)

                <div class="ps-carousel--dots owl-slider" data-owl-auto="true" data-owl-loop="true"
                     data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1"
                     data-owl-item-xs="1" data-owl-item-sm="1"
                     data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
                    @foreach(getPromotions('mainSlider') as $main_slider)
                        <a href="{{ $main_slider->link }}">
                            <img src="{{ filePath($main_slider->image) }}" alt="">
                        </a>
                    @endforeach
                </div>
            @else
                @foreach(getPromotions('mainSlider') as $main_slider)
                    <a href="{{ $main_slider->link }}">
                        <img src="{{ filePath($main_slider->image) }}" alt="">
                    </a>
                @endforeach

            @endif

        </div>

        <div class="ps-section__right">
            @foreach (promotionBanners('header') as $cat_header)
                <a href="{{ $cat_header->link }}">
                    <img src="{{ filePath($cat_header->image) }}" alt="#Header Category">
                </a>
            @endforeach
        </div>


    </div>
</div>
