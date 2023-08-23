@extends('frontend.master')

@section('css')
    {{-- css goes here --}}
@stop

@section('title')

@section('content')
    {{-- content goes here --}}
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="text-center mt-5">
                    <img src="{{ asset('shopping_success.png') }}" class="w-50" alt="">
                </div>


                <p class="m-5 h2 text-center">
                    @auth
                    @translate(Dear) {{ Auth::user()->name }},
                    <br/>
                    @endauth
                    @translate(Thank you for your purchase.)
                    <br>
                    @translate(Your order has been successfully placed.)<br/>
                    @translate(Your Booking code) -

                        @if (session()->has('booking'))
                            @foreach ($booking_codes as $booking_code)
                                <strong>#{{ $booking_code }},</strong>
                            @endforeach
                            
                            @else
                            
                            @foreach ($order_booking_codes as $order_booking_code)
                                <strong>#{{ $order_booking_code->booking_code }},</strong>
                            @endforeach

                        @endif

                    
                    <br>
                    @translate(Please check your email for more details.)
                    <br>
                </p>

            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        "use strict"
        $(document).ready(function () {
            localStorage.removeItem('guest_cart_items');
            guestCartList();
        });
    </script>
@stop
