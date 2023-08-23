@extends('backend.layouts.master')
@section('title') Order Management @endsection
@section('content')

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="text-center">
                        <a class="btn btn-success mt-2" href="{{ route('orders.index') }}">@translate(Total Order)({{ orderCount('count') }})</a>
                        <a class="btn btn-yellow mt-2" href="{{ route("find.filter", 'pending') }}">@translate(Pending)({{ orderCount('pending') }})</a>
                        <a class="btn btn-info mt-2" href="{{ route("find.filter", 'follow_up') }}">@translate(Follow Up)({{ orderCount('follow_up') }})</a>
                        <a class="btn btn-confirm mt-2" href="{{ route("find.filter", 'confirmed') }}">@translate(Confirmed)({{ orderCount('confirmed') }})</a>
                        <a class="btn btn-delivered mt-2" href="{{ route("find.filter", 'delivered') }}">@translate(Delivered)({{ orderCount('delivered') }})</a>
                        <a class="btn btn-danger mt-2" href="{{ route("find.filter", 'canceled') }}">@translate(Canceled)({{ orderCount('canceled') }})</a>
                        <a class="btn btn-processing mt-2" href="{{ route("find.filter", 'processing') }}">@translate(Processing)({{ orderCount('processing') }})</a>
                        <a class="btn btn-qc mt-2" href="{{ route("find.filter", 'quality_check') }}">@translate(Quality Check)({{ orderCount('quality_check') }})</a>
                        <a class="btn btn-dispatched mt-2" href="{{ route("find.filter", 'product_dispatched') }}">@translate(Dispatched)({{ orderCount('product_dispatched') }})</a>
                    </div>
                </div>

                {{-- Find Order --}}

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="m-3" action="{{ route('find.order') }}" method="GET">
                                <div class="form-row mt-3">
                                    <div class="col">
                                        <label for="start_date">@translate(Order From)</label>
                                        <input type="date" id="start_date" value="{{Request::get('start_date') == null ? date('dd/mm/yyyy',strtotime(Request::get('start_date'))) : null}}" name="start_date" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="end_date">@translate(Order To)</label>
                                        <input type="date" id="end_date" value="{{Request::get('end_date') == null ? date('dd/mm/yyyy',strtotime(Request::get('end_date'))) : null}}" name="end_date" class="form-control">
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
                <div class="card-body p-2">

                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">@translate(SL)</th>
                                <th scope="col">@translate(Booking Code)</th>
                                <th scope="col">@translate(Payment Status)</th>
                                <th scope="col">@translate(Delivery Address)</th>
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
                                        @translate(Logistic) - {{ $getOrder->logistic->name ?? null }}
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
                                         @translate(Product price) - {{ formatPrice($getOrder->order->product_price) }}<br>
                                         @translate(Quantity) - {{$getOrder->order->quantity}}<br>
                                        @translate(Total) - {{ formatPrice($getOrder->order->pay_amount) }}
                                    </span>
                                </td>
                                <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $getOrder->user ?$getOrder->user->name: 'Guest Order' }}
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
                                <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($getOrder->product->image) }}" class="w-25" alt="#{{ $getOrder->product->name }}">
                                    </span>
                                    <span class="d-block">
                                        @translate(Name) - {{ $getOrder->product->name }} - {{ $getOrder->product_stock->product_variants }}
                                    </span>
                                    <span class="d-block">
                                        @translate(SKU) - {{ $getOrder->product->sku }}
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
                                @if ($getOrder->status != 'delivered' && $getOrder->status != 'canceled')
                                    <td>
                                    <a href="#!" onclick="forModal('{{route('order.followup', $getOrder->id)}}','@translate(Follow up comment)')" class="btn-sm btn-info d-block m-2 text-center">@translate(Follow Up)</a>

                                    @if ($getOrder->status != 'processing'
                                    && $getOrder->status != 'quality_check'
                                    && $getOrder->status != 'product_dispatched'
                                    && $getOrder->status != 'delivered'
                                    && $getOrder->status != 'canceled'
                                    && $getOrder->status != 'confirmed'
                                    )
                                    <a href="{{ route('order.confirm', $getOrder->id) }}" class="btn-sm btn-success d-block m-2 text-center">@translate(Confirm)</a>
                                    @endif


                                        @if ($getOrder->status != 'processing' && $getOrder->status != 'quality_check' && $getOrder->status != 'product_dispatched')
                                       <a href="{{ route('order.processing', $getOrder->id) }}" class="btn-sm btn-processing d-block m-2 text-center">@translate(Processing)</a>
                                        @endif

                                        @if ($getOrder->status != 'quality_check' && $getOrder->status != 'product_dispatched')
                                        <a href="{{ route('order.quality_check', $getOrder->id) }}" class="btn-sm btn-qc d-block m-2 text-center">@translate(QC)</a>
                                        @endif

                                        @if ($getOrder->status != 'product_dispatched')
                                        <a href="{{ route('order.product_dispatched', $getOrder->id) }}" class="btn-sm btn-dispatched d-block m-2 text-center">@translate(Dispatched)</a>
                                        @endif

                                        @if ($getOrder->status != 'confirmed')
                                            <a href="{{ route('order.confirm', $getOrder->id) }}" class="btn-sm btn-confirmed d-block m-2 text-center">@translate(Confirm for Dliver)</a>
                                        @endif

                                        @if ($getOrder->status != 'delivered')
                                        <a href="{{ route('order.delivered', $getOrder->id) }}" class="btn-sm btn-delivered d-block m-2 text-center">@translate(Delivered)</a>
                                        @endif

                                        @if ($getOrder->status != 'canceled')
                                            <a href="{{ route('order.cancel', $getOrder->id) }}" class="btn-sm btn-danger d-block m-2 text-center">@translate(Cancel)</a>
                                        @endif

                                </td>
                                    @else

                                    <td>

                                        @if ($getOrder->status == 'delivered')
                                        @translate(Delivered)
                                        @else
                                        @translate(Canceled)
                                        @endif

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

