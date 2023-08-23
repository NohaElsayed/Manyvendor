@extends('frontend.master')


@section('title') @translate(Wishlist) @stop

@section('content')
    <div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                    <li>@translate(Wishlist)</li>
                </ul>
            </div>
        </div>
        <div class="ps-section--shopping ps-shopping-cart">
            <div class="container">
                <div class="ps-section__header">
                    <h1>@translate(Wishlist)</h1>
                </div>
                <div class="ps-section__content">
                    <div class="table-responsive">
                        @auth
                            @if($wishlist_list->count()>0)
                                <table class="table ps-table--shopping-cart">
                                    <thead>
                                    <tr>
                                        <th>@translate(Product Name)</th>
                                        <th>@translate(Price Range)</th>
                                        <th>@translate(Action)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($wishlist_list as $wishlist)
                                        <tr>
                                            <td>
                                                <div class="ps-product--cart">
                                                    <div class="ps-product__thumbnail"><a
                                                            href="{{route('single.product',[$wishlist->sku, $wishlist->slug])}}"><img
                                                                src="{{$wishlist->image}}" alt=""></a></div>
                                                    <div class="ps-product__content"><a
                                                            href="{{route('single.product',[$wishlist->sku, $wishlist->slug])}}">{{$wishlist->name}}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{$wishlist->range}}</td>
                                            <td class="text-center"><a
                                                    href="{{route('delete.from.wishlist',$wishlist->id)}}" method="POST"><i
                                                        class="icon-cross"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="card text-center text-danger py-5 fs-24">@translate(No data found)</div>
                            @endif
                        @endauth

                        @guest
                            <span class="show-all-wishlist">
                                {{-- data coming from ajax --}}
                                {{-- data coming from LocalStorage --}}
                            </span>
                        @endguest

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {{-- js goes here --}}
@stop
