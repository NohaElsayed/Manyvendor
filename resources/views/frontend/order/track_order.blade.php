@extends('frontend.master')

@section('title') @translate(Track Order) @stop

@section('content')
    <div class="ps-page--single">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                    <li>@translate(Track Order)</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="ps-order-tracking">
            <div class="container">
                <div class="ps-section__header">
                    <h3>@translate(Order Tracking)</h3>
                    <p>@translate(To track your order please enter your Order ID in the box below and press the) "Track" @translate(button. This was given to you on your receipt and in the confirmation email you should have received).</p>
                </div>
                <div class="ps-section__content">
                    <form class="ps-form--order-tracking" id="trackForm" action="javascript.void(0)" method="GET">
                        @csrf
                        <input type="hidden" id="url" value="{{ route('customer.track.order.number') }}">
                        <div class="form-group">
                            <label>@translate(Order ID)</label>
                            <input class="form-control" id="order_number" value="{{ $code ?? '' }}" name="order_number" required type="text" placeholder="@translate(Found in your order confimation email)">
                        </div>
                        <div class="form-group">
                            <label>@translate(Billing Email)</label>
                            <input class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required type="email" placeholder="@translate(Enter Your Email Address)">
                        </div>
                        <div class="form-group">
                            <button class="ps-btn ps-btn--fullwidth" id="trackSubmit" onclick="trackOrder(this)" type="button">@translate(Track Your Order)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Order Track Result --}}

            <div class="container">
                <div id="loading" class="h2 text-center"></div>
                <div id="noResult" class="h2 text-center"></div>
                <div id="trackResult">
                    {{-- Track order result goes here --}}
                </div>
            </div>

@stop
