@extends('backend.layouts.master')
@section('title') Order Management @endsection

@section('css')
    <script type="text/javascript" src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <link type="text/javascript" src="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}"/>
@endsection

@section('content')

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="text-center">
                        <a class="btn btn-primary mt-2" href="{{ route('orders.index') }}">@translate(Total Order)({{ orderCount('count') }})</a>
                        <a class="btn btn-yellow mt-2" href="{{ route("find.filter", 'pending') }}">@translate(Pending)({{ orderCount('pending') }})</a>
                        <a class="btn btn-danger mt-2" href="{{ route("find.filter", 'canceled') }}">@translate(Canceled)({{ orderCount('canceled') }})</a>
                        <a class="btn btn-delivered mt-2" href="{{ route("find.filter", 'confirmed') }}">@translate(Confirmed)({{ orderCount('confirmed') }})</a>
                        <a class="btn btn-processing text-white mt-2" href="{{ route("find.filter", 'processing') }}">@translate(Processing)({{ orderCount('processing') }})</a>
                        <a class="btn btn-qc mt-2" href="{{ route("find.filter", 'quality_check') }}">@translate(Quality Check)({{ orderCount('quality_check') }})</a>
                        <a class="btn btn-dispatched mt-2" href="{{ route("find.filter", 'product_dispatched') }}">@translate(Dispatched)({{ orderCount('product_dispatched') }})</a>
                        <a class="btn btn-info mt-2" href="{{ route("find.filter", 'follow_up') }}">@translate(Follow Up)({{ orderCount('follow_up') }})</a>
                        <a class="btn btn-success mt-2" href="{{ route("find.filter", 'delivered') }}">@translate(Delivered)({{ orderCount('delivered') }})</a>
                    </div>
                </div>

                {{-- Find Order --}}

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="m-3" action="{{ route('find.order') }}" method="GET">
                                <div class="form-row mt-3">
                                    <div class="col">
                                        <label>@translate(Order From)</label>
                                        <div class="input-group date" id="datetimepicker9" data-target-input="nearest">
                                            <input type="text" name="start_date" value="{{Request::get('start_date')}}"
                                                class="form-control datetimepicker-input" data-target="#datetimepicker9"
                                                placeholder="@translate(Order From)"/>
                                            <div class="input-group-append form-group" data-target="#datetimepicker9"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label>@translate(Order To)</label>
                                        <div class="input-group date" id="datetimepicker10" data-target-input="nearest">
                                            <input type="text" name="end_date" value="{{Request::get('end_date')}}"
                                                class="form-control datetimepicker-input" data-target="#datetimepicker10"
                                                placeholder="@translate(Order To)"/>
                                            <div class="input-group-append form-group" data-target="#datetimepicker10"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col">
                                        <label for="email">@translate(Customer Email)</label>
                                        <input type="email" id="email" name="email" value="{{Request::get('email')?? null}}" class="form-control" placeholder="@translate(Customer Email)">
                                    </div>


                                </div>
                                <div class="form-row mt-3">

                                    <div class="col">
                                        <label for="order_number">@translate(Order Number)</label>
                                        <input type="number" id="order_number" name="order_number" value="{{Request::get('order_number') ?? null}}" class="form-control" placeholder="@translate(Order Number)">
                                    </div>
                                    <div class="col">
                                        <label for="booking_code">@translate(Booking Code)</label>
                                        <input type="number" id="booking_code" name="booking_code" value="{{Request::get('booking_code') ?? null}}" class="form-control" placeholder="@translate(Booking Code)">
                                    </div>
                                    <div class="col">
                                        <label for="phone">@translate(Customer Phone)</label>
                                        <input type="number" id="phone" name="phone" value="{{Request::get('phone') ?? null}}" class="form-control" placeholder="@translate(Customer Phone)">
                                    </div>

                                </div>

                                <div class="form-row mt-3">

                                    <div class="col-md-6 offset-md-5">
                                        <button class="btn btn-primary" type="submit">@translate(FIND ORDER)</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body p-2 table-responsive">

                    <table class="table table-bordered border">
                        <thead>
                            <tr>
                                <th scope="col">@translate(SL)</th>
                                <th scope="col">@translate(Booking Code)</th>
                                <th scope="col">@translate(Payment Status)</th>
                                <th scope="col">@translate(Delivery Address)</th>
                                <th scope="col">@translate(Seller Address)</th>
                                <th scope="col">@translate(Product)</th>
                                <th scope="col">@translate(Comment)</th>
                                @canany('order-modify')
                                <th scope="col">@translate(Actions)</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($getOrders as $getOrder)
                            <tr class="
                            {{ $getOrder->status === 'pending' ? 'bg-newOrder' : '' }}
                            {{ $getOrder->status === 'confirmed' ? 'bg-confirmed' : '' }}
                            {{ $getOrder->status === 'delivered' ? 'bg-delivered' : '' }}
                            {{ $getOrder->status === 'canceled' ? 'bg-canceled' : '' }}
                            {{ $getOrder->status === 'follow_up' ? 'bg-follow_up' : '' }}
                            {{ $getOrder->status === 'processing' ? 'bg-processing' : '' }}
                            {{ $getOrder->status === 'quality_check' ? 'bg-quality_check' : '' }}
                            {{ $getOrder->status === 'product_dispatched' ? 'bg-product_dispatched' : '' }}
                            ">
                                <th scope="row">{{ $loop->index++ + 1 }}</th>
                                <td>
                                    <span class="d-block">
                                        @translate(BK Code) - #{{ $getOrder->booking_code }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Order Number) - #{{ $getOrder->order_number }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Logistic) - {{ $getOrder->order->logistic->name ?? null }}
                                    </span>

                                </td>
                                <td>
                                    <span class="d-block text-uppercase">
                                       @translate(Payment) {{ $getOrder->payment_type }}
                                    </span>

                                    <span class="d-block">
                                        @translate(Coupon) - {{ $getOrder->order->applied_coupon ?? 'N/A'}}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shipping) - {{ formatPrice($getOrder->order->logistic_charge) }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Quantity) - {{$getOrder->quantity}}
                                        @translate(Total) - {{ formatPrice($getOrder->order->pay_amount) }}
                                    </span>
                                </td>
                                <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $getOrder->user ? $getOrder->user->name: 'Guest Order' }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Phone) - {{ $getOrder->order->phone }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Address) - {{ $getOrder->order->address }}, {{ $getOrder->order->area->thana_name }}, {{ $getOrder->order->division->district_name }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Note) - {{ $getOrder->order->note ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block">
                                        @translate(Shop Name) - {{ $getOrder->seller->shop_name }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Email) - {{ $getOrder->seller->email }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Phone) - {{ $getOrder->seller->phone }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Address) - {{ $getOrder->seller->adrress ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($getOrder->product->product->image) }}" class="w-25" alt="#{{ $getOrder->product->product->name }}">
                                    </span>
                                    <span class="d-block">
                                        @translate(Name) - {{ $getOrder->product->product->name }} - {{ $getOrder->vendor_product_stock->product_variants }}
                                    </span>
                                    <span class="d-block">
                                        @translate(SKU) - {{ $getOrder->product->product->sku }}
                                    </span>

                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        @if (isset($getOrder->comment) || isset($getOrder->commentedBy))
                                            {{ $getOrder->comment ?? 'N/A' }} By {{ $getOrder->user->name ?? 'N/A' }}
                                        @else
                                        @translate(No Comment)
                                        @endif
                                    </span>
                                </td>

                               @canany('order-modify')

                            @if ($getOrder->status != 'delivered')
                                <td>
                                    <a href="#!"
                                       onclick="forModal('{{route('order.followup', $getOrder->id)}}','@translate(Follow up comment)')"
                                       class="btn-sm btn-info d-block m-2 text-center">@translate(Follow Up)</a>

                                       @if (Auth::user()->user_type == 'Vendor')
                                           @if ($getOrder->status != 'processing'
                                    && $getOrder->status != 'quality_check'
                                    && $getOrder->status != 'product_dispatched'
                                    && $getOrder->status != 'delivered'
                                    && $getOrder->status != 'canceled'
                                    && $getOrder->status != 'confirmed'
                                    )
                                        <a href="{{ route('order.confirm', $getOrder->id) }}"
                                           class="btn-sm btn-success d-block m-2 text-center">@translate(Confirm)</a>
                                    @endif


                                    @if ($getOrder->status != 'processing' && $getOrder->status != 'quality_check' && $getOrder->status != 'product_dispatched')
                                        <a href="{{ route('order.processing', $getOrder->id) }}"
                                           class="btn-sm btn-processing d-block m-2 text-center">@translate(Processing)</a>
                                    @endif

                                    @if ($getOrder->status != 'quality_check' && $getOrder->status != 'product_dispatched')
                                        <a href="{{ route('order.quality_check', $getOrder->id) }}"
                                           class="btn-sm btn-qc d-block m-2 text-center">@translate(QC)</a>
                                    @endif

                                    @if ($getOrder->status != 'product_dispatched')
                                        <a href="{{ route('order.product_dispatched', $getOrder->id) }}"
                                           class="btn-sm btn-dispatched d-block m-2 text-center">@translate(Dispatched)</a>
                                    @endif
                                       @endif

                                    

                                    @if (Auth::user()->user_type != 'Vendor')
                                    {{-- Delivered and cancel permission --}}
                                        
                                        @if ($getOrder->status != 'delivered')
{{--                                            <a href="{{ route('order.delivered', $getOrder->id) }}"--}}
{{--                                            class="btn-sm btn-delivered d-block m-2 text-center">@translate(Delivered)</a>--}}
                                            <a href="{{ route('order.confirm', $getOrder->id) }}"
                                               class="btn-sm btn-success d-block m-2 text-center">@translate(Confirm)</a>
                                        @endif
                                        @if ($getOrder->status != 'canceled')
                                            <a href="{{ route('order.cancel', $getOrder->id) }}"
                                            class="btn-sm btn-danger d-block m-2 text-center">@translate(Cancel)</a>
                                        @endif

                                    @endif


                                </td>
                            @else
                                <td>
                                    @translate(Delivered)
                                </td>
                            @endif
                        @endcanany

                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                   <h4>@translate(NO ORDER FOUND)</h4>
                                </td>
                            </tr>
                            @endforelse


                        </tbody>
                        </table>

                </div>

            </div>


@endsection

@section('script')
    <script type="text/javascript">
        "use strict"
        $(function () {
            $('#datetimepicker9, #datetimepicker10').datetimepicker();
        });
    </script>
@endsection

