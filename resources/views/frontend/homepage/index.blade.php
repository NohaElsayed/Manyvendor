@extends('frontend.master')

@section('title')

@section('content')
    <div id="homepage-5">

        @foreach($sections as $section)

            @if($section->blade_name == "shop-store")
                @if(sellerStatus())
                    @includeWhen($section->active,'frontend.widgets.section.'.$section->blade_name)
                @endif
            @else
                @includeWhen($section->active,'frontend.widgets.section.'.$section->blade_name)
            @endif

        @endforeach

@if (getPromotions('popup')->count() > 0)
    {{-- popup widgets --}}
   @include('frontend.widgets.popup.popup')
@endif

    {{-- site-search widgets --}}
    @include('frontend.widgets.popup.site-search')

@stop
