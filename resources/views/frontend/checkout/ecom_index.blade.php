@extends('frontend.master')

@section('title')

@section('content')

    <div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                    <li><a href="{{ route('shopping.cart') }}">@translate(Carts)</a></li>
                    <li>@translate(Checkout)</li>
                </ul>
            </div>
        </div>
        <div class="ps-checkout ps-section--shopping">
            <div class="container">
                <div class="ps-section__header">
                    <h1>@translate(Checkout) </h1>
                </div>

                {{-- erroe messages --}}
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> <br>
                    @endforeach
                @endif

                {{-- success messages --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif


                {{-- Coupon Apply --}}
                @if(!Session::has('coupon'))
                    <form action="{{ route('checkout.coupon.store') }}" class="needs-validation" novalidate
                          method="post">
                        @csrf

                        <div class="ps-section__footer" data-select2-id="6">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                    <figure>
                                        <figcaption>@translate(Have coupon code? Apply here).</figcaption>
                                        <div class="form-group">
                                            <span class="coupon_sub_total_append">
												{{--data coming from ajax--}}
											</span>
                                            <input class="form-control" type="text" required name="code"
                                                   id="coupon_code" placeholder="@translate(Coupon code)">
                                            <div class="invalid-feedback">@translate(Please enter a coupon code).</div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="ps-btn ps-btn--outline">@translate(Apply)
                                            </button>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>

                    </form>

                @endif

                @php
                    if(Session::has('coupon')){
                          $coupon = session()->get('coupon')['name'];
                      }
                @endphp


                @if(Session::has('coupon'))
                <!-- coupon -->

                    <div class="ps-section__footer" data-select2-id="6">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                <figure>
                                    <figcaption>
                                        <h3>@translate(Coupon Code Applied): <span
                                                    class="badge badge-success">{{ $coupon }}</span></h3>
                                        <h3>@translate(Discount Amount): <span
                                                    class="badge badge-success item-six-append">{{--ajax item item[6] append--}}</span></h3>
                                    </figcaption>
                                    <form action="{{ route('checkout.coupon.destroy') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="coupon"
                                                   value="{{ $coupon }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="ps-btn ps-btn--outline">@translate(Try Another Coupon)
                                            </button>
                                        </div>
                                    </form>
                                </figure>
                            </div>
                        </div>
                    </div>

                    <!-- coupon END -->
                @endif


                <div class="ps-section__content">

                    @if (env('STRIPE_KEY') != "" && env('STRIPE_KEY') != "STRIPE_SECRET")
                        {{-- order form --}}
                        <form
                                class="ps-form--checkout require-validation"
                                id="orderForm"
                                action=""
                                method="post"
                                data-cc-on-file="false"
                                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-7 col-lg-8 col-md-6 col-sm-12  ">
                                    <div class="ps-form__billing-info">
                                        <h3 class="ps-form__heading">@translate(Billing Details)</h3>
                                        <div class="form-group">
                                            <label for="name">@translate(Name)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" id="name" type="text" name="name"
                                                       placeholder="@translate(Enter name)"
                                                       value="{{ Auth::user()->name }}" readonly>
                                                <p id="invalid-name" class="invalid"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">@translate(Email Address)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" id="email" type="email" name="email"
                                                       value="{{ Auth::user()->email }}"
                                                       placeholder="@translate(Enter email)" readonly>
                                                <p id="invalid-email" class="invalid"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country">@translate(Country)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" id="country" type="text" name="country"
                                                       value="{{ Auth::user()->nationality }}">
                                                <p id="invalid-country" class="invalid"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">@translate(Phone)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" id="phone" type="number"
                                                       value="{{ Auth::user()->tel_number ?? '' }}" name="phone">
                                                <p id="invalid-phone" class="invalid"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">@translate(Address)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" type="text" id="address" name="address"
                                                       value="{{ Auth::user()->customer->address ?? '' }}">
                                                <p id="invalid-address" class="invalid"></p>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="division">@translate(Division)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input type="hidden" class="getDivisionArea"
                                                       value="{{ route('get.division.area') }}">
                                                <select class="form-control division item-two-append" id="division" name="division_id">
                                                    {{--loop ajax item[2] and append--}}
                                                </select>
                                                <p id="invalid-division" class="invalid"></p>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="area">@translate(City)<sup>*</sup>
                                            </label>
                                            <div class="form-group">
                                                <input type="hidden" name="getLogistics" class="getLogistics"
                                                       value="{{ route('checkout.get.logistics') }}">
                                                <select class="form-control area" id="area" name="area_id">
                                                    {{--Data coming from ajax--}}
                                                </select>
                                                <p id="invalid-area" class="invalid"></p>
                                            </div>
                                        </div>

                                        <h3 class="mt-40">@translate(Addition information)</h3>
                                        <div class="form-group">
                                            <label for="note">@translate(Order Notes)</label>
                                            <div class="form-group__content">
                                            <textarea class="form-control" id="note" name="note" rows="7"
                                                      placeholder="@translate(Notes about your order, e.g. special notes for delivery)."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12  ">
                                    <div class="ps-form__total">
                                        <h3 class="ps-form__heading">@translate(Your Order)</h3>
                                        <div class="content">
                                            <div class="ps-block--checkout-total">
                                                <div class="ps-block__content">
                                                    <table class="table ps-block__products">
                                                        <tbody class="item-four-append">
                                                            {{--data coming from ajax--}}
                                                        </tbody>
                                                    </table>

                                                    <table class="table ps-block__products">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                @translate(Sub Total)
                                                            </td>
                                                            <td class="text-right item-three-seven-append">
                                                                {{--ajax item[7] append--}}
                                                                {{--ajax item[3] append in input tag value--}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @translate(Tax)
                                                            </td>
                                                            <td class="text-right item-five-eight-append">
                                                                {{--ajax item[8] append--}}
                                                                {{--ajax item[5] append in input tag value--}}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- AJax Query Shipping method -->
                                                    <div class="logistics">
                                                        <!-- Shipping  method goes here -->
                                                    </div>
                                                    <p id="invalid-logistic" class="invalid"></p>

                                                    <!-- AJax Query Shipping method::END -->

                                                @if(Session::has('coupon'))
                                                    <!-- coupon -->
                                                        {{-- applied_coupon --}}
                                                        <input type="hidden" name="applied_coupon" value="{{ $coupon }}">
                                                        {{-- applied_coupon::END --}}
                                                        {{-- pay_amount --}}
                                                        <span class="item-one-append">
														{{--ajax result item[1] append--}}
													</span>

                                                        <span class="item-nine-append">
														{{--ajax result item[9] append--}}
													</span>

                                                        {{-- pay_amount::END --}}
                                                        {{-- payable_amount --}}
                                                        <input class="newTotalWithOutFormat" type="hidden"
                                                               name="payable_amount" value="">
                                                        {{-- payable_amount::END --}}
                                                        {{-- logistic Info --}}
                                                        <input type="hidden" class="get_logistic_id" name="get_logistic_id"
                                                               value="">
                                                        <input type="hidden" class="get_shipping_value"
                                                               name="get_shipping_value" value="">
                                                        {{-- logistic Info::END --}}

                                                        <h3>@translate(Total)
                                                            <span class="newTotal item-ten-append mr-2">
															{{--ajax item[10] append--}}
														</span>
                                                            @if(Session::has('coupon'))
                                                                <span class="fs-12 text-danger">@translate(Coupon discount )</span>
                                                                <span class="ml-1 badge badge-success fs-12 item-six-append">{{--ajax item item[6] append--}}</span>
                                                            @endif
                                                        </h3>
                                                        <!-- coupon END -->
                                                    @else
                                                        {{-- applied_coupon --}}
                                                        <input type="hidden" name="applied_coupon"
                                                               value="{{ $applied_coupon ?? null }}">
                                                        {{-- applied_coupon::END --}}
                                                        {{-- logistic Info --}}
                                                        <input type="hidden" class="get_logistic_id" name="get_logistic_id"
                                                               value="">
                                                        <input type="hidden" class="get_shipping_value"
                                                               name="get_shipping_value" value="">
                                                        {{-- logistic Info::END --}}
                                                        {{-- pay_amount --}}

                                                        <span class="item-three-append-in-else-coupon">
														{{--ajax item[3] append--}}
													</span>

                                                        <span class="item-twelve-append-in-else-coupon">
														{{--ajax item[12] append--}}
													</span>
                                                        {{-- pay_amount::END --}}
                                                        {{-- payable_amount --}}
                                                        <input class="newTotalWithOutFormat" type="hidden"
                                                               name="payable_amount" value="">
                                                        {{-- payable_amount::END --}}
                                                        <h3>@translate(Total)
                                                            <span class="newTotal item-thirteen-else-coupon">
															{{--ajax result item[13] append--}}
														</span>
                                                        </h3>
                                                    @endif

                                                </div>
                                            </div>

                                            <h4 class="ps-form__heading mt-3">@translate(Select a payment method)</h4>


                                            <div class="card rounded-sm">
                                                <button type="button" class="ps-btn ps-btn--outline w-100" id="order_now_btn">
                                                    Order Now
                                                </button>
                                            </div>


                                            <div id="order_now" class="d-none">

                                                {{--Paypal--}}
                                                <div class="card rounded-sm">
                                                    <div id="paypal">
                                                    </div>
                                                </div>


                                                <input type="hidden" name="orderID" id="orderID">
                                                <input type="hidden" name="payerID" id="payerID">
                                                <input type="hidden" name="paymentID" id="paymentID">
                                                <input type="hidden" name="paymentToken" id="paymentToken">

                                                @if(Session::has('coupon'))
                                                    <span class="coupon-item-nine-append">
                                                {{--ajax item[9] append--}}
                                            </span>
                                                @else
                                                    <span class="coupon-item-eleven-append">
                                                {{--ajax item[11] append--}}
                                            </span>
                                                @endif

                                                {{--Paypal--}}


                                                {{--accordion--}}
                                                <div class="accordion my-2" id="paymentMethodExample">
                                                    {{-- Stripe --}}
                                                    <div class="card border-bottom-0 mt-2">
                                                        <div class="card-header" id="heading">
                                                            <div
                                                                    class="checkout-item d-flex align-items-center justify-content-between">
                                                                <label for="radio-8 stripe-label"
                                                                       class="radio-trigger collapsed mb-0 w-100 btn"
                                                                       data-toggle="collapse" data-target="#collapse"
                                                                       aria-expanded="false"
                                                                       aria-controls="collapse">
                                                    <span
                                                            class="widget-title font-size-18 stripe-btn d-block text-center font-weight-bold">
                                                            <img src="{{filePath('images/stripe.png')}}" height="18px"
                                                                 width="60px" alt="Stripe">
                                                    </span>
                                                                </label>

                                                            </div>
                                                        </div>
                                                        <div id="collapse" class="collapse border-bottom"
                                                             aria-labelledby="heading"
                                                             data-parent="#paymentMethodExample">
                                                            <div class="card-body mb-3">
                                                                <div class="contact-form-action">

                                                                    <div class="input-box">
                                                                        <label class="label-text">@translate(Name on Card) <span
                                                                                    class="primary-color-2 ml-1">*</span></label>
                                                                        <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                            <input class="form-control card-name"
                                                                                   placeholder="Card Name"
                                                                                   type="text" name="text"
                                                                                   required="" value="">
                                                                            <p id="card-name-mess" class="invalid"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="input-box">
                                                                        <label class="label-text">@translate(Card Number)<span
                                                                                    class="primary-color-2 ml-1">*</span></label>
                                                                        <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                            <input class="form-control card-number"
                                                                                   name="text"
                                                                                   placeholder="1234  5678  9876  5432"
                                                                                   required="" type="text" value="">
                                                                            <p id="card-number-mess" class="invalid"></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="input-box">
                                                                        <label class="label-text">@translate(CVC)<span
                                                                                    class="primary-color-2 ml-1">*</span></label>
                                                                        <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                            <input class="form-control card-cvc"
                                                                                   placeholder="CVC" required=""
                                                                                   name="text" type="text" value="">
                                                                            <p id="card-cvc-mess" class="invalid"></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="input-box">
                                                                        <label class="label-text">@translate(Expiry Month)<span
                                                                                    class="primary-color-2 ml-1">*</span></label>
                                                                        <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                            <input
                                                                                    class="form-control card-expiry-month"
                                                                                    placeholder="MM" required=""
                                                                                    name="text" type="text" value="">
                                                                            <p id="card-expiry-month-mess" class="invalid"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="input-box">
                                                                        <label class="label-text">@translate(Expiry Year)<span
                                                                                    class="primary-color-2 ml-1">*</span></label>
                                                                        <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                            <input
                                                                                    class="form-control card-expiry-year"
                                                                                    placeholder="YY" required=""
                                                                                    name="text" type="text" value="">
                                                                            <p id="card-expiry-year-mess" class="invalid"></p>
                                                                        </div>
                                                                    </div>


                                                                    @if(Session::has('coupon'))
                                                                        <span class="coupon-stripe-item-nine-append">
																			{{--ajax item[9] append--}}
																		</span>
                                                                    @else
                                                                        <span class="coupon-stripe-item-eleven-append">
																			{{--ajax item[9] append--}}
																		</span>
                                                                    @endif


                                                                    <button type="button" id="stripe_button"
                                                                            class="ps-btn ps-btn--fullwidth newTotal">
                                                                        @translate(Proceed)
                                                                        @if(Session::has('coupon'))
                                                                            <span class="item-stripe-ten-append">
																			{{--ajax item[10] append--}}
																		</span>
                                                                        @else
                                                                            <span class="item-stripe-twelve-append">
																			{{--ajax item[12] append--}}
																			</span>
                                                                        @endif
                                                                    </button>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--Stripe ends--}}
                                                </div>
                                                {{--Accordion ends--}}


                                                {{-- PAYTM PAYMENT --}}
								
											@if(env('PAYTM_MERCHANT_ID') != "" &&  env('PAYTM_MERCHANT_KEY') != "" &&  env('PAYTM_ACTIVE') != "NO" && paytmRouteForBlade())
												{{--PAYTM--}}

												<a href="javascript:void(0)" onclick="paytmPay()">
													<div class="card border-bottom-0 mt-2">
														<div class="card-header">
															<div class="checkout-item d-flex align-items-center justify-content-between">
																<span class="widget-title font-size-18 stripe-btn d-block text-center font-weight-bold m-auto">
																		<img src="{{ filePath('paytm.png') }}" height="25px"
																			width="80px" alt="Paytm">
																</span>
															</div>
														</div>
													</div>
												</a>
											
												{{--PAYTM ends--}}
											@endif

                                            {{-- PAYTM PAYMENT::END --}}
                                            
                                            {{-- SSL-COMMERZ PAYMENT --}}
								
											@if(env('STORE_ID') != "" &&  env('STORE_PASSWORD') != "" &&  env('SSL_COMMERZ_ACTIVE') != "NO")
												{{--SSL-COMMERZ--}}

												<a href="javascript:void(0)" onclick="sslPay()">
													<div class="card border-bottom-0 mt-2">
														<div class="card-header">
															<div class="checkout-item d-flex align-items-center justify-content-between">
																<span class="widget-title font-size-18 stripe-btn d-block text-center font-weight-bold m-auto">
																		<img src="{{ filePath('ssl-commerz.png') }}" height="25px"
																			width="80px" alt="#ssl-commerz">
																</span>
															</div>
														</div>
													</div>
												</a>
											
												{{--SSL-COMMERZ ends--}}
											@endif

											{{-- SSL-COMMERZ::END --}}

                                                {{-- Place Order --}}
                                                <div class="form-group">
                                                    <button type="button" id="placeOrder" class="ps-btn ps-btn--outline w-100">
                                                        @translate(Cash On Delivery)
                                                    </button>
                                                </div>

                                                {{-- Order form:END --}}

                                            </div>


                                            <div class="mt-5">
											<h5>We accept -</h5>

											<img src="{{ filePath('cod.png') }}" class="w-10 p-2" alt="#cash on delivery">

											@if (env('PAYPAL_CLIENT_ID') != NULL && env('PAYPAL_APP_SECRET') != NULL)
												<img src="{{ filePath('paypal.png') }}" class="w-20 p-2" alt="#paypal">
											@endif
											
											@if (env('PAYTM_ACTIVE') != 'NO' && env('PAYTM_MERCHANT_ID') != NULL  && env('PAYTM_MERCHANT_KEY') != NULL)
												<img src="{{ filePath('paytm.png') }}" alt="#paytm" class="w-15 p-2">
											@endif

											@if (env('STRIPE_KEY') != NULL && env('STRIPE_SECRET') != NULL)
												<img src="{{ filePath('stripe.png') }}" alt="#stripe" class="w-15 p-2">
											@endif

											@if (env('STORE_ID') != NULL && env('STORE_PASSWORD') != NULL && env('SSL_COMMERZ_ACTIVE') != 'NO')
												<img src="{{ filePath('ssl-commerz.png') }}" alt="#ssl-commerz" class="w-25 p-2">
											@endif

                                        </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        {{-- order form --}}
                        <form
                                class="ps-form--checkout require-validation"
                                id="orderForm"
                                action=""
                                method="post"
                                data-cc-on-file="false"
                                data-stripe-publishable-key="pk_test_Nr6hlHbDo44RWI4N6QhdYZNP00KS5i1lKX">
                            @csrf
                            <div class="row">
                                <div class="col-xl-7 col-lg-8 col-md-6 col-sm-12  ">
                                    <div class="ps-form__billing-info">
                                        <h3 class="ps-form__heading">@translate(Billing Details)</h3>
                                        <div class="form-group">
                                            <label for="name">@translate(Name)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" id="name" type="text" name="name"
                                                       placeholder="@translate(Enter name)"
                                                       value="{{ Auth::user()->name }}" readonly>
                                                <p id="invalid-name" class="invalid"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">@translate(Email Address)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" id="email" type="email" name="email"
                                                       value="{{ Auth::user()->email }}"
                                                       placeholder="@translate(Enter email)" readonly>
                                                <p id="invalid-email" class="invalid"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country">@translate(Country)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" id="country" type="text" name="country"
                                                       value="{{ Auth::user()->nationality }}">
                                                <p id="invalid-country" class="invalid"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">@translate(Phone)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" id="phone" type="number"
                                                       value="{{ Auth::user()->tel_number ?? '' }}" name="phone">
                                                <p id="invalid-phone" class="invalid"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">@translate(Address)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input class="form-control" type="text" id="address" name="address"
                                                       value="{{ Auth::user()->customer->address ?? '' }}">
                                                <p id="invalid-address" class="invalid"></p>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="division">@translate(Division)<sup>*</sup>
                                            </label>
                                            <div class="form-group__content">
                                                <input type="hidden" class="getDivisionArea"
                                                       value="{{ route('get.division.area') }}">
                                                <select class="form-control division item-two-append" id="division" name="division_id">
                                                    {{--loop ajax item[2] and append--}}
                                                </select>
                                                <p id="invalid-division" class="invalid"></p>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="area">@translate(City)<sup>*</sup>
                                            </label>
                                            <div class="form-group">
                                                <input type="hidden" name="getLogistics" class="getLogistics"
                                                       value="{{ route('checkout.get.logistics') }}">
                                                <select class="form-control area" id="area" name="area_id">
                                                    {{--Data coming from ajax--}}
                                                </select>
                                                <p id="invalid-area" class="invalid"></p>
                                            </div>
                                        </div>

                                        <h3 class="mt-40">@translate(Addition information)</h3>
                                        <div class="form-group">
                                            <label for="note">@translate(Order Notes)</label>
                                            <div class="form-group__content">
                                            <textarea class="form-control" id="note" name="note" rows="7"
                                                      placeholder="@translate(Notes about your order, e.g. special notes for delivery)."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12  ">
                                    <div class="ps-form__total">
                                        <h3 class="ps-form__heading">@translate(Your Order)</h3>
                                        <div class="content">
                                            <div class="ps-block--checkout-total">
                                                <div class="ps-block__content">
                                                    <table class="table ps-block__products">
                                                        <tbody class="item-four-append">
                                                            {{--data coming from ajax--}}
                                                        </tbody>
                                                    </table>

                                                    <table class="table ps-block__products">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                @translate(Sub Total)
                                                            </td>
                                                            <td class="text-right item-three-seven-append">
                                                                {{--ajax item[7] append--}}
                                                                {{--ajax item[3] append in input tag value--}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @translate(Tax)
                                                            </td>
                                                            <td class="text-right item-five-eight-append">
                                                                {{--ajax item[8] append--}}
                                                                {{--ajax item[5] append in input tag value--}}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- AJax Query Shipping method -->
                                                    <div class="logistics">
                                                        <!-- Shipping  method goes here -->
                                                    </div>
                                                    <p id="invalid-logistic" class="invalid"></p>

                                                    <!-- AJax Query Shipping method::END -->

                                                @if(Session::has('coupon'))
                                                    <!-- coupon -->
                                                        {{-- applied_coupon --}}
                                                        <input type="hidden" name="applied_coupon" value="{{ $coupon }}">
                                                        {{-- applied_coupon::END --}}
                                                        {{-- pay_amount --}}

                                                        <span class="item-one-append">
														{{--ajax result item[1] append--}}
													</span>


                                                        <span class="item-nine-append">
														{{--ajax result item[9] append--}}
													</span>

                                                        {{-- pay_amount::END --}}
                                                        {{-- payable_amount --}}
                                                        <input class="newTotalWithOutFormat" type="hidden"
                                                               name="payable_amount" value="">
                                                        {{-- payable_amount::END --}}
                                                        {{-- logistic Info --}}
                                                        <input type="hidden" class="get_logistic_id" name="get_logistic_id"
                                                               value="">
                                                        <input type="hidden" class="get_shipping_value"
                                                               name="get_shipping_value" value="">
                                                        {{-- logistic Info::END --}}

                                                        <h3>@translate(Total)
                                                            <span class="newTotal item-ten-append mr-2">
															{{--ajax item[10] append--}}
														</span>
                                                            @if(Session::has('coupon'))
                                                                <span class="fs-12 text-danger">@translate(Coupon discount )</span>
                                                                <span class="ml-1 badge badge-success fs-12 item-six-append">{{--ajax item item[6] append--}}</span>
                                                            @endif
                                                        </h3>
                                                        <!-- coupon END -->
                                                    @else
                                                        {{-- applied_coupon --}}
                                                        <input type="hidden" name="applied_coupon"
                                                               value="{{ $applied_coupon ?? null }}">
                                                        {{-- applied_coupon::END --}}
                                                        {{-- logistic Info --}}
                                                        <input type="hidden" class="get_logistic_id" name="get_logistic_id"
                                                               value="">
                                                        <input type="hidden" class="get_shipping_value"
                                                               name="get_shipping_value" value="">
                                                        {{-- logistic Info::END --}}
                                                        {{-- pay_amount --}}
                                                        <span class="item-three-append-in-else-coupon">
														{{--ajax item[3] append--}}
													</span>


                                                        <span class="item-twelve-append-in-else-coupon">
														{{--ajax item[12] append--}}
													</span>
                                                        {{-- pay_amount::END --}}
                                                        {{-- payable_amount --}}
                                                        <input class="newTotalWithOutFormat" type="hidden"
                                                               name="payable_amount" value="">
                                                        {{-- payable_amount::END --}}
                                                        <h3>@translate(Total)
                                                            <span class="newTotal item-thirteen-else-coupon">
															{{--ajax result item[13] append--}}
														</span>
                                                        </h3>
                                                    @endif

                                                </div>
                                            </div>

                                            <h4 class="ps-form__heading mt-3">@translate(Select a payment method)</h4>


                                            <div class="card rounded-sm">
                                                <button type="button" class="ps-btn ps-btn--outline w-100" id="order_now_btn">
                                                    Order Now
                                                </button>
                                            </div>


                                            <div id="order_now" class="d-none">

                                                {{--Paypal--}}
                                                <div class="card rounded-sm">
                                                    <div id="paypal">
                                                    </div>
                                                </div>


                                                <input type="hidden" name="orderID" id="orderID">
                                                <input type="hidden" name="payerID" id="payerID">
                                                <input type="hidden" name="paymentID" id="paymentID">
                                                <input type="hidden" name="paymentToken" id="paymentToken">

                                                @if(Session::has('coupon'))
                                                    <span class="coupon-item-nine-append">
                                        {{--ajax item[9] append--}}
                                    </span>
                                                @else
                                                    <span class="coupon-item-eleven-append">
                                        {{--ajax item[11] append--}}
                                    </span>
                                                @endif

                                                {{--Paypal--}}


                                                {{--accordion--}}
                                                <div class="accordion my-2" id="paymentMethodExample">
                                                    @if(env('STRIPE_KEY') != "" &&  env('STRIPE_SECRET') != "")
                                                        {{-- Stripe --}}
                                                        <div class="card border-bottom-0 mt-2">
                                                            <div class="card-header" id="heading">
                                                                <div
                                                                        class="checkout-item d-flex align-items-center justify-content-between">
                                                                    <label for="radio-8 stripe-label"
                                                                           class="radio-trigger collapsed mb-0 w-100 btn"
                                                                           data-toggle="collapse" data-target="#collapse"
                                                                           aria-expanded="false"
                                                                           aria-controls="collapse">
                                                    <span
                                                            class="widget-title font-size-18 stripe-btn d-block text-center font-weight-bold">
                                                            <img src="{{filePath('images/stripe.png')}}" height="18px"
                                                                 width="90px" alt="Stripe">
                                                    </span>
                                                                    </label>

                                                                </div>
                                                            </div>
                                                            <div id="collapse" class="collapse border-bottom"
                                                                 aria-labelledby="heading"
                                                                 data-parent="#paymentMethodExample">
                                                                <div class="card-body mb-3">
                                                                    <div class="contact-form-action">

                                                                        <div class="input-box">
                                                                            <label class="label-text">@translate(Name on Card) <span
                                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                            <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                                <input class="form-control card-name"
                                                                                       placeholder="Card Name"
                                                                                       type="text" name="text"
                                                                                       required="" value="" id="card-name">
                                                                                <p id="card-name-mess" class="invalid"></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-box">
                                                                            <label class="label-text">@translate(Card Number)<span
                                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                            <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                                <input class="form-control card-number"
                                                                                       name="text"
                                                                                       placeholder="1234  5678  9876  5432"
                                                                                       required="" type="text" value="" id="card-number">
                                                                                <p id="card-number-mess" class="invalid"></p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-box">
                                                                            <label class="label-text">@translate(CVC)<span
                                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                            <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                                <input class="form-control card-cvc"
                                                                                       placeholder="CVC" required=""
                                                                                       name="text" type="text" value="" id="card-cvc">
                                                                                <p id="card-cvc-mess" class="invalid"></p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-box">
                                                                            <label class="label-text">@translate(Expiry Month)<span
                                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                            <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                                <input
                                                                                        class="form-control card-expiry-month"
                                                                                        placeholder="MM" required=""
                                                                                        name="text" type="text" value="" id="card-month">
                                                                                <p id="card-expiry-month-mess" class="invalid"></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-box">
                                                                            <label class="label-text">@translate(Expiry Year)<span
                                                                                        class="primary-color-2 ml-1">*</span></label>
                                                                            <div class="form-group">
                                                                                <span
                                                                                        class="la la-pencil input-icon"></span>
                                                                                <input
                                                                                        class="form-control card-expiry-year"
                                                                                        placeholder="YY" required=""
                                                                                        name="text" type="text" value="" id="card-year">
                                                                                <p id="card-expiry-year-mess" class="invalid"></p>
                                                                            </div>
                                                                        </div>


                                                                        @if(Session::has('coupon'))
                                                                            <span class="coupon-stripe-item-nine-append">
																			{{--ajax item[9] append--}}
																		</span>
                                                                        @else
                                                                            <span class="coupon-stripe-item-eleven-append">
																			{{--ajax item[9] append--}}
																		</span>
                                                                        @endif


                                                                        <button type="button" id="stripe_button"
                                                                                class="ps-btn ps-btn--fullwidth newTotal">
                                                                            @translate(Proceed)
                                                                            @if(Session::has('coupon'))
                                                                                <span class="item-stripe-ten-append">
																			{{--ajax item[10] append--}}
																		</span>
                                                                            @else
                                                                                <span class="item-stripe-twelve-append">
																			{{--ajax item[12] append--}}
																			</span>
                                                                            @endif
                                                                        </button>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--Stripe ends--}}
                                                    @endif
                                                </div>
                                                {{--Accordion ends--}}

                                                {{-- Place Order --}}
                                                <div class="form-group">
                                                    <button type="button" id="placeOrder" class="ps-btn ps-btn--outline w-100">
                                                        @translate(Cash On Delivery)
                                                    </button>
                                                </div>

                                                {{-- Order form:END --}}

                                            </div>


                                            
                                        

                                        </div>

                                        

                                    </div>
                                  

                                </div>

                       
                            </div>
                       
                        </form>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="paypal_route" value="{{route('paypal.payment')}}">
    <input type="hidden" id="stripe_route" value="{{ route('stripe.post') }}">
    @if(env('STORE_ID') != "" &&  env('STORE_PASSWORD') != "" &&  env('SSL_COMMERZ_ACTIVE') != "NO")
		<input type="hidden" id="ssl_route" value="{{ route('ssl.pay') }}">
	@endif
    @if (env('PAYTM_MERCHANT_ID') != "" &&  env('PAYTM_MERCHANT_KEY') != "" &&  env('PAYTM_ACTIVE') != "NO" && paytmRouteForBlade())
		<input type="hidden" id="paytm_route" value="{{ route('paytm.payment') }}">{{-- paytm --}}
	@endif
    <input type="hidden" id="placeorder_route" value="{{ route('place.order') }}">
@stop

@section('js')

    <script>
        "use strict"
        $(document).ready(function () {
            $('#name').on('keyup', function () {
                $("#invalid-name").text("");
            });
            $('#email').on('keyup', function () {
                $("#invalid-email").text("");
            });
            $('#country').on('keyup', function () {
                $("#invalid-country").text("");
            });
            $('#phone').on('keyup', function () {
                $("#invalid-phone").text("");
            });
            $('#address').on('keyup', function () {
                $("#invalid-address").text("");
            });
            $('#division').on('change', function () {
                $("#invalid-division").text("");
            });
            $('#area').on('change', function () {
                $("#invalid-area").text("");
            });
            $('.logistic_id').on('click', function () {
                $("#invalid-logistic").text("");
            });

            $('#card-name').on('keyup', function () {
                $("#card-name-mess").text("");
            });

            $('#card-number').on('keyup', function () {
                $("#card-number-mess").text("");
            });

            $('#card-cvc').on('keyup', function () {
                $("#card-cvc-mess").text("");
            });

            $('#card-month').on('keyup', function () {
                $("#card-expiry-month-mess").text("");
            });

            $('#card-year').on('keyup', function () {
                $("#card-expiry-year-mess").text("");
            });

        });

        // order_now_btn
        $('#order_now_btn').on('click', function (e) {
            var name = $("#name").val();
            var email = $("#email").val();
            var country = $("#country").val();
            var phone = $("#phone").val();
            var address = $("#address").val();
            var division = $("#division").val();
            var area = $("#area").val();

            if (name.length == "") {
                $("#invalid-name").text("Please enter your name");
                $("#name").focus();
                return false;
                e.preventDefault();
            } else if (email.length == "") {
                $("#invalid-email").text("Please enter your email address");
                $("#email").focus();
                return false;
                e.preventDefault();
            } else if (country.length == "") {
                $("#invalid-country").text("Please enter your country name");
                $("#country").focus();
                return false;
                e.preventDefault();
            } else if (phone.length == "") {
                $("#invalid-phone").text("Please enter your phone number");
                $("#phone").focus();
                return false;
                e.preventDefault();
            } else if (address.length == "") {
                $("#invalid-address").text("Please enter your address");
                $("#address").focus();
                return false;
                e.preventDefault();
            } else if (division.length == "") {
                $("#invalid-division").text("Please select your division");
                $("#division").focus();
                return false;
                e.preventDefault();
            } else if (area.length == "") {
                $("#invalid-area").text("Please select your area");
                $("#area").focus();
                return false;
                e.preventDefault();
            } else if ($('input[name="logistic_id"]:checked').length == 0) {
                $("#invalid-logistic").text("Please select logistic");
                return false;
                e.preventDefault();
            } else {
                $('#order_now').removeClass('d-none');
            }
        });
        // order_now_btn::END


        $('#placeOrder').on('click', function (e) {
            var placeurl = $('#placeorder_route').val();
            var b = document.getElementById("orderForm");
            b.setAttribute('action', placeurl);
            var name = $("#name").val();
            var email = $("#email").val();
            var country = $("#country").val();
            var phone = $("#phone").val();
            var address = $("#address").val();
            var division = $("#division").val();
            var area = $("#area").val();

            if (name.length == "") {
                $("#invalid-name").text("Please enter your name");
                $("#name").focus();
                return false;
                e.preventDefault();
            } else if (email.length == "") {
                $("#invalid-email").text("Please enter your email address");
                $("#email").focus();
                return false;
                e.preventDefault();
            } else if (country.length == "") {
                $("#invalid-country").text("Please enter your country name");
                $("#country").focus();
                return false;
                e.preventDefault();
            } else if (phone.length == "") {
                $("#invalid-phone").text("Please enter your phone number");
                $("#phone").focus();
                return false;
                e.preventDefault();
            } else if (address.length == "") {
                $("#invalid-address").text("Please enter your address");
                $("#address").focus();
                return false;
                e.preventDefault();
            } else if (division.length == "") {
                $("#invalid-division").text("Please select your division");
                $("#division").focus();
                return false;
                e.preventDefault();
            } else if (area.length == "") {
                $("#invalid-area").text("Please select your area");
                $("#area").focus();
                return false;
                e.preventDefault();
            } else if ($('input[name="logistic_id"]:checked').length == 0) {
                $("#invalid-logistic").text("Please select logistic");
                return false;
                e.preventDefault();
            } else {
                $('#orderForm').submit();
            }
        });


    </script>

    {{--paypal--}}
    @if(env('PAYPAL_CLIENT_ID') != "" && env('PAYPAL_APP_SECRET') != "")
        <script src="https://www.paypalobjects.com/api/checkout.js"></script>
        <script>
            "use strict"
            paypal.Button.render({
                // Configure environment
                env: 'sandbox',
                client: {
                    sandbox: '{{env('PAYPAL_CLIENT_ID')}}',
                },
                // Customize button (optional)
                locale: 'en_US',
                style: {
                    size: 'responsive',
                    color: 'silver',
                    shape: 'rect',
                    label: 'paypal',
                    tagline: false,
                },

                // Enable Pay Now checkout flow (optional)
                commit: true,
                // Set up a payment
                payment: function (data, actions) {
                    return actions.payment.create({
                        transactions: [{
                            amount: {
                                total: $('.paypal_amount').val(),
                                currency: 'USD'
                            }
                        }]
                    });
                },
                // Execute the payment
                onAuthorize: function (data, actions) {
                    return actions.payment.execute().then(function () {
                        // Show a confirmation message to the buyer
                        var payurl = $('#paypal_route').val();
                        /*append paypar action */
                        var b = document.getElementById("orderForm");
                        b.setAttribute('action', payurl);
                        /*append data in input form*/
                        $('#orderID').val(data.orderID);
                        $('#payerID').val(data.payerID);
                        $('#paymentID').val(data.paymentID)
                        $('#paymentToken').val(data.paymentToken)
                        $('#orderForm').submit();
                    });
                }
            }, '#paypal');
        </script>
    @endif


    {{--stripe--}}
    @if(env('STRIPE_KEY') != "" &&  env('STRIPE_SECRET') != "")
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript">
            "use strict"

            /*stripe*/
            $('#stripe_button').on('click', function (e) {
                var stripeurl = $('#stripe_route').val();
                var b = document.getElementById("orderForm");
                b.setAttribute('action', stripeurl);

                var name = $("#name").val();
                var email = $("#email").val();
                var country = $("#country").val();
                var phone = $("#phone").val();
                var address = $("#address").val();
                var division = $("#division").val();
                var area = $("#area").val();
                var cardNumber = $(".card-number").val();
                var cardName = $(".card-name").val();
                var cardCvc = $(".card-cvc").val();
                var cardExpiryMonth = $(".card-expiry-month").val();
                var cardExpiryYear = $(".card-expiry-year").val();
                if (name.length == "") {
                    $("#invalid-name").text("Please enter your name");
                    $("#name").focus();
                    return false;
                    e.preventDefault();
                } else if (email.length == "") {
                    $("#invalid-email").text("Please enter your email address");
                    $("#email").focus();
                    return false;
                    e.preventDefault();
                } else if (country.length == "") {
                    $("#invalid-country").text("Please enter your country name");
                    $("#country").focus();
                    return false;
                    e.preventDefault();
                } else if (phone.length == "") {
                    $("#invalid-phone").text("Please enter your phone number");
                    $("#phone").focus();
                    return false;
                    e.preventDefault();
                } else if (address.length == "") {
                    $("#invalid-address").text("Please enter your address");
                    $("#address").focus();
                    return false;
                    e.preventDefault();
                } else if (division.length == "") {
                    $("#invalid-division").text("Please select your division");
                    $("#division").focus();
                    return false;
                    e.preventDefault();
                } else if (area.length == "") {
                    $("#invalid-area").text("Please select your area");
                    $("#area").focus();
                    return false;
                    e.preventDefault();
                } else if ($('input[name="logistic_id"]:checked').length == 0) {
                    $("#invalid-logistic").text("Please select logistic");
                    return false;
                    e.preventDefault();
                } else if (cardName.length == "") {
                    $("#card-name-mess").text("Please insert card name");
                    $(".card-name").focus();
                    return false;
                    e.preventDefault();
                } else if (cardNumber.length == "") {
                    $("#card-number-mess").text("Please Insert card number");
                    $(".card-number").focus();
                    return false;
                    e.preventDefault();
                } else if (cardCvc.length == "") {
                    $("#card-cvc-mess").text("Please Insert Card CVC");
                    $(".card-cvc").focus();
                    return false;
                    e.preventDefault();
                } else if (cardExpiryMonth.length == "") {
                    $("#card-expiry-month-mess").text("Please Insert card expiry month");
                    $(".card-expiry-month").focus();
                    return false;
                    e.preventDefault();
                } else if (cardExpiryYear.length == "") {
                    $("#card-expiry-year-mess").text("Please Insert Card Expiry Year");
                    $(".card-expiry-year").focus();
                    return false;
                    e.preventDefault();
                } else {
                    var $form = $(".require-validation");
                    $('form.require-validation').bind('submit', function (e) {
                        var $form = $(".require-validation"),
                                inputSelector = ['input[type=email]', 'input[type=password]',
                                    'input[type=text]', 'input[type=file]',
                                    'textarea'].join(', '),
                                $inputs = $form.find('.required').find(inputSelector),
                                $errorMessage = $form.find('div.error'),
                                valid = true;
                        $errorMessage.addClass('hide');

                        $('.has-error').removeClass('has-error');
                        $inputs.each(function (i, el) {
                            var $input = $(el);
                            if ($input.val() === '') {
                                $input.parent().addClass('has-error');
                                $errorMessage.removeClass('hide');
                                e.preventDefault();
                            }
                        });

                        if (!$form.data('cc-on-file')) {
                            e.preventDefault();
                            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                            Stripe.createToken({
                                number: $('.card-number').val(),
                                cvc: $('.card-cvc').val(),
                                exp_month: $('.card-expiry-month').val(),
                                exp_year: $('.card-expiry-year').val()
                            }, stripeResponseHandler);
                        }

                    });

                    function stripeResponseHandler(status, response) {
                        if (response.error) {
                            $('.error')
                                    .removeClass('hide')
                                    .find('.alert')
                                    .text(response.error.message);
                        } else {
// token contains id, last4, and card type
                            var token = response['id'];
// insert the token into the form so it gets submitted to the server
                            $form.find('input[type=text]').empty();
                            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                            $form.get(0).submit();
                        }
                    }

                    $('#orderForm').submit();
                }
            });

           

        </script>
    @endif


    {{-- STRIPE:END --}}


    {{-- PAYTM START --}}

		@if(env('PAYTM_MERCHANT_ID') != "" &&  env('PAYTM_MERCHANT_KEY') != "" &&  env('PAYTM_ACTIVE') != "NO" && paytmRouteForBlade())

		<script>
			function paytmPay(){
				var paytm_route = $('#paytm_route').val();
                var c = document.getElementById("orderForm");
				c.setAttribute('action', paytm_route);
				$('#orderForm').submit();
			}
		</script>

		@endif
		
        {{-- PAYTM END --}}
        

        {{-- SSL Commerz START --}}

		@if(env('STORE_ID') != "" &&  env('STORE_PASSWORD') != "" &&  env('SSL_COMMERZ_ACTIVE') != "NO")

		<script>
			function sslPay(){
				var ssl_route = $('#ssl_route').val();
                var c = document.getElementById("orderForm");
				c.setAttribute('action', ssl_route);
				$('#orderForm').submit();
			}
		</script>

		@endif
		
		{{-- SSL Commerz END --}}
    
    
    
    
    <script>

	    var checkout_data_url = $('.get-checkout-data').val();
            if (checkout_data_url != null && checkout_data_url != undefined && localStorage.getItem('guest_cart_items') !== null) {
                $.ajax({
	                url: checkout_data_url,
	                method:'GET',
	                data: {
	                    carts: JSON.parse(localStorage.getItem('guest_cart_items')),
	                },
	                success: function (result) {
               console.log(result);
	                    //discount
                        $('.item-six-append').empty();
	                    $('.item-six-append').append(result[6]);

	                    //districts
	                    var item_two_html = '<option value="">Select Division</option>';
                        result[2].forEach(function (item) {
	                        item_two_html += '<option value="'+item.id+'">'+item.district_name+'</option>'
	                    });
                        $('.item-two-append').empty();
                        $('.item-two-append').append(item_two_html);

                        //carts
		                var carts_html = '';
		                result[4].forEach(function (item) {
		                    carts_html += '<tr>' +
                                '<td>' +
                                '<a href="'+item.url+'"' +
                                'target="_blank">'+item.name+'' +
                                '× '+item.quantity+'</a>' +
                                '<input type="hidden" name="product_id[]"' +
                                'value="'+item.product_id+'">' +
                                '<input type="hidden" name="product_stock_id[]" value="'+item.product_stock_id+'">'+
                                '<input type="hidden" name="quantity[]"' +
                                'value="'+item.quantity+'">' +
                                '<input type="hidden" name="product_price[]"' +
                                'value="'+item.sub_price+'">' +
                                '<input type="hidden" name="sku[]"' +
                                'value="'+item.sku+'">' +
                                '</td>' +
                                '<div class="d-none">' +
                                ''+item.sub_price+'' +
                                '</div>' +
                                '<td class="text-right">' +
                                ''+item.format_sub_price+'' +
                                '</td>' +
                                '</tr>';
                        });
                        $('.item-four-append').empty();
                        $('.item-four-append').append(carts_html);


                        //sub_total
		                var sub_total_html = ''+result[7]+'' +
			                                 '<input type="hidden" value="'+result[3]+'" id="sub_total">';
                        $('.item-three-seven-append').empty();
                        $('.item-three-seven-append').append(sub_total_html);

                        //coupon form sub_total
                        var coupon_sub_total_html = '<input  id="coupon_sub_total" type="hidden" name="total" value="'+result[3]+'">';
                        $('.coupon_sub_total_append').empty();
                        $('.coupon_sub_total_append').append(coupon_sub_total_html);

                        //tax
                        var tax_html = ''+result[8]+'' +
                            '<input type="hidden" value="'+result[5]+'" id="sub_total">';
                        $('.item-five-eight-append').empty();
                        $('.item-five-eight-append').append(tax_html);

                        //hidden input newTotal
                        var hidden_newTotal_html = '<input type="hidden" class="amount" name="pay_amount" value="'+result[1]+'">';
                        $('.item-one-append').empty();
                        $('.item-one-append').append(hidden_newTotal_html);

                        //hidden input
                        var item_nine_html = '<input type="hidden" class="forLogisticsAmount" value="'+result[9]+'">';
                        $('.item-nine-append').empty();
                        $('.item-nine-append').append(item_nine_html);

                        //item 10
                        var item_ten_html = ''+result[10]+'';
                        $('.item-ten-append').empty();
                        $('.item-ten-append').append(item_ten_html);


                        //hidden input
                        var item_three_else_coupon_html = '<input class="amount" type="hidden" name="pay_amount" value="'+result[3]+'">';
                        $('.item-three-append-in-else-coupon').empty();
                        $('.item-three-append-in-else-coupon').append(item_three_else_coupon_html);

                        //hidden input
                        var item_twelve_else_coupon_html = '<input type="hidden" class="forLogisticsAmount" value="'+result[11]+'">';
                        $('.item-twelve-append-in-else-coupon').empty();
                        $('.item-twelve-append-in-else-coupon').append(item_twelve_else_coupon_html);

                        //grand total
                        var item_thirteen_html = ''+result[12]+'';
                        $('.item-thirteen-else-coupon').empty();
                        $('.item-thirteen-else-coupon').append(item_thirteen_html);


                        //paypal
                        //hidden input
                        var coupon_item_nine_append_html = '<input type="hidden" class="paypal_amount newTotalWithOutFormat" name="amount" id="amount" value="'+result[9]+'">';
                        $('.coupon-item-nine-append').empty();
                        $('.coupon-item-nine-append').append(coupon_item_nine_append_html);
                        //hidden input
                        var coupon_item_eleven_append_html = '<input type="hidden" class="paypal_amount newTotalWithOutFormat" name="amount" id="amount" value="'+result[11]+'">';
                        $('.coupon-item-eleven-append').empty();
                        $('.coupon-item-eleven-append').append(coupon_item_eleven_append_html);


                        //stripe
                        //hidden input
                        var coupon_stripe_item_nine_append_html = '<input type="hidden" name="amount" class="newTotalWithOutFormat" value="'+result[9]+'">';
                        $('.coupon-stripe-item-nine-append').empty();
                        $('.coupon-stripe-item-nine-append').append(coupon_stripe_item_nine_append_html);
                        //hidden input
                        var coupon_stripe_item_eleven_append_html = '<input type="hidden" name="amount" class="newTotalWithOutFormat" value="'+result[11]+'">';
                        $('.coupon-stripe-item-eleven-append').empty();
                        $('.coupon-stripe-item-eleven-append').append(coupon_stripe_item_eleven_append_html);


                        //stripe
                        var item_stripe_ten_html = ''+result[10]+'';
                        $('.item-stripe-ten-append').empty();
                        $('.item-stripe-ten-append').append(item_stripe_ten_html);

                        //stripe
                        var item_stripe_twelve_html = ''+result[12]+'';
                        $('.item-stripe-twelve-append').empty();
                        $('.item-stripe-twelve-append').append(item_stripe_twelve_html);
                    }
                })
            }
	</script>
@endsection