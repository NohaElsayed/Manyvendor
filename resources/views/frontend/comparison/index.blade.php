@extends('frontend.master')



@section('title')

@section('content')
    <div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                    <li>@translate(Comparison)</li>
                </ul>
            </div>
        </div>
        <div class="ps-section--shopping ps-shopping-cart">
            <div class="mx-5 margin-compare">
                <div class="ps-section__header">
                    <h1>@translate(Comparison)</h1>
                </div>

                <div class="ps-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered ps-table--shopping-cart text-center">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td>@translate(Name)</td>
                                    @foreach($comparison_list as $item)
                                    <td class="text-danger text-center">
                                        <a href="{{route('single.product',[$item->sku,$item->slug])}}">
                                            {{$item->name}}
                                        </a>
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>@translate(Image)</td>
                                    @foreach($comparison_list as $item)
                                        <td class="text-center">
                                            <img src="{{filePath($item->image)}}" class="img-fluid table-compare-img rounded-sm"/>
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td>@translate(Price Range)</td>
                                    @foreach($comparison_list as $item)
                                        <td class="text-center">
                                            {{$item->range}}
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td>@translate(Brand)</td>
                                    @foreach($comparison_list as $item)
                                        <td class="text-center">
                                            {{$item->brand}}
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td>@translate(Category)</td>
                                    @foreach($comparison_list as $item)
                                        <td class="text-center">
                                            {{$item->category}}
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td>@translate(Overview)</td>
                                    @foreach($comparison_list as $item)
                                        <td class="text-center">
                                           {!! $item->short_desc !!}
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td>@translate(Description)</td>
                                    @foreach($comparison_list as $item)
                                        <td>
                                            {!! $item->big_desc !!}
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td></td>
                                    @foreach($comparison_list as $item)
                                        <td class="text-center">
                                            <a href="{{route('single.product',[$item->sku,$item->slug])}}" class="ps-btn">@translate(Add to cart)</a>
                                        </td>
                                    @endforeach
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop


