@extends('frontend.master')

@section('title')@translate(Your order) @endsection

@section('content')
    <div class="ps-page--single">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                    <li><a href="{{ route('customer.orders') }}">@translate(Your order)</a></li>
                    <li>{{ Auth::user()->name }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ps-vendor-dashboard pro">
        <div class="container">
            <div class="ps-section__header">
                <h3>@translate(Customer Dashboard)</h3>
            </div>
            <div class="ps-section__content">
                <ul class="ps-section__links">
                    <li class="active"><a href="{{ route('customer.orders') }}">@translate(Your Order)</a></li>
                    <li><a href="{{ route('customer.index') }}">@translate(Your Profile)</a></li>
                    @if(affiliateRoute() && affiliateActive())
                    <li><a href="{{ route('customers.affiliate.registration') }}">@translate(Affiliate Marketing)</a></li>
                    @endif
                    <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            @translate(Sign Out)
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>


            {{-- Orders content goes here --}}
            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <figure class="ps-block--vendor-status">
                        <figcaption>@translate(Your Orders)({{ $orders->count() }})</figcaption>

                        <table class="table ps-table ps-table--vendor">
                            <thead>
                            <tr>
                                <th>@translate(Order ID)</th>
                                <th>@translate(Order Type)</th>
                                <th>@translate(Totals)</th>
                                <th>@translate(Actions)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('customer.order_details', $order->order_number) }}">{{ $order->order_number }}</a>
                                        <p>{{ $order->created_at->format('M d, Y') }}</p>
                                    </td>

                                    <td>
                                        <p>{{ $order->payment_type }}</p>
                                    </td>
                                    <td>
                                        <p>{{ formatPrice($order->pay_amount) }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.order_details', $order->order_number) }}"
                                           class="btn btn-warning text-dark">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="4">
                                        @translate(No Order Found)
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </figure>
                </div>

            </div>
            {{-- Orders content goes here::END --}}
        </div>
    </div>
@stop
