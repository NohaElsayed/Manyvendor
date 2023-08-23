@extends('frontend.master')

@section('title') @translate(order) @stop


@section('content')
    <div class="ps-page--single">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('homepage') }}">@translate(Home)</a></li>
                    <li><a href="{{ route('customer.orders') }}">@translate(Your order)</a></li>
                    <li>#{{ $order_detail->order_number }}</li>
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
                        <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>


            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">


                    <figure class="ps-block--vendor-status">
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <figcaption>@translate(Order) #{{ $order_detail->order_number }}</figcaption>
                                <p class="text-uppercase h3">
                                    @translate(Total): {{ formatPrice($order_detail->pay_amount) }}</p>
                                <p class="text-uppercase h4">@translate(Payment
                                    Type): {{ $order_detail->payment_type }}</p>
                                <p class="h4">@translate(Order date)
                                    : {{ $order_detail->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <figcaption>@translate(Delivery Information)</figcaption>
                                <p class="h3">@translate(Address): {{ $order_detail->address }}
                                </p>

                                <p class="h3">@translate(Shipping Via): {{ $order_detail->logistic->name }}
                                </p>

                                <p class="h3">@translate(Shipping
                                    Rate): {{ formatPrice($order_detail->logistic_charge) }}
                                </p>

                                <p class="h3">@translate(Shipping Zone):
                                    @translate(Division): {{ $order_detail->division->district_name }}
                                </p>
                                <p class="h3">
                                    @translate(Area): {{ $order_detail->area->thana_name }}
                                </p>
                            </div>
                        </div>


                        @foreach ($order_detail->order_product as $product)
                            <div class="_2oLsaWi9Nj">
                                <div class="_3wII7s9lsM">

                                    <img src="{{ filePath( $product->product->product->image ) }}" sizes="4vw"
                                         width="800" class="w-20">

                                    <div class="_3zeUfCZnvZ">
                                        <span
                                            class="_3IytpSfnoZ fs-30">{{ $product->product->product->name }}  {{\Illuminate\Support\Str::upper($product->vendor_product_stock->product_variants) }}</span>
                                        <p class="">@translate(Sold by) - {{ $product->shop->shop_name ?? '' }}</p>
                                        <p class="">Booking Code - #{{ $product->booking_code }}</p>
                                        <p class="">@translate(Status) -

                                            {{ $product->status === 'pending' ? 'pending' : '' }}
                                            {{ $product->status === 'canceled' ? 'cancel' : '' }}
                                            {{ $product->status === 'delivered' ? 'delivered' : '' }}
                                            {{ $product->status === 'follow_up' ? 'follow up' : '' }}

                                        </p>
                                        <a href="{{ route('customer.tracking.order.number', $product->booking_code) }}"
                                           class="badge badge-success">Track Order</a>

                                        @php
                                            $check_complain = App\Models\Complain::where('booking_code', $product->booking_code)->exists();
                                        @endphp

                                        @if ($product->status == 'delivered')
                                            @if (!$check_complain)
                                                <a href="javascript:void(0)"
                                                   onclick="forModal('{{ route('customer.complain.index', $product->booking_code) }}', '@translate(Product Complain)')"
                                                   class="badge badge-danger">Make Complain</a>
                                            @else
                                                <a href="javascript:void(0)"
                                                   onclick="forModal('{{ route('customer.complain.review', $product->booking_code) }}',' @translate(Product Complain)')"
                                                   class="badge badge-danger">View Complain</a>
                                            @endif
                                        @endif

                                        @if ($product->status == 'delivered')
                                            @if (empty($product->review))
                                                <a href="javascript:void(0)"
                                                   onclick="forModal('{{ route('customer.product.review', $product->booking_code) }}', '@translate(Product Review)')"
                                                   class="badge badge-primary">Give Review</a>
                                            @else
                                                <a href="javascript:void(0)"
                                                   onclick="forModal('{{ route('customer.product.review', $product->booking_code) }}', '@translate(Product Review)')"
                                                   class="badge badge-primary">Your Review</a>
                                            @endif
                                        @endif


                                    </div>
                                </div>
                                <div class="_3oGH8BD26C">
                                    <div class="_2qea2ZM2jo">
                                        <span class="_3hUqCdCiBb fs-22">@translate(Qty) :</span>
                                        <span class="_3hQCdklHSO fs-22">{{ $product->quantity }}</span>
                                    </div>
                                    <div class="_1SLnXV0Syg fs-22">{{ formatPrice($product->product_price) }}</div>
                                </div>
                            </div>
                        @endforeach

                    </figure>
                </div>


            </div>


        </div>
    </div>
@endsection
