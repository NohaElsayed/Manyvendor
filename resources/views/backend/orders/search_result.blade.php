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
                                        <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
                                            <input type="text" name="start_date" value="{{Request::get('start_date')}}"
                                                class="form-control datetimepicker-input" data-target="#datetimepicker7"
                                                placeholder="@translate(Order From)"/>
                                            <div class="input-group-append form-group" data-target="#datetimepicker7"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label>@translate(Order To)</label>
                                        <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                                            <input type="text" name="end_date" value="{{Request::get('end_date')}}"
                                                class="form-control datetimepicker-input" data-target="#datetimepicker8"
                                                placeholder="@translate(Order To)"/>
                                            <div class="input-group-append form-group" data-target="#datetimepicker8"
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

                            @forelse ($getDatas as $getData)
                            <tr class="
                            {{ $getData->status === 'pending' ? 'bg-newOrder' : '' }}
                            {{ $getData->status === 'confirmed' ? 'bg-confirmed' : '' }}
                            {{ $getData->status === 'delivered' ? 'bg-delivered' : '' }}
                            {{ $getData->status === 'canceled' ? 'bg-canceled' : '' }}
                            {{ $getData->status === 'follow_up' ? 'bg-follow_up' : '' }}
                            {{ $getData->status === 'processing' ? 'bg-processing' : '' }}
                            {{ $getData->status === 'quality_check' ? 'bg-quality_check' : '' }}
                            {{ $getData->status === 'product_dispatched' ? 'bg-product_dispatched' : '' }}
                            ">
                                <th scope="row">{{ $loop->index++ + 1 }}</th>
                                <td>
                                    <span class="d-block">
                                        @translate(BK Code) - #{{ $getData->booking_code }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Order Number) - #{{ $getData->order_number }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Logistic) - {{ $getData->order->logistic->name }}
                                    </span>

                                </td>
                                <td>
                                    <span class="d-block text-uppercase">
                                       @translate(Payment) {{ $getData->payment_type }}
                                    </span>

                                    <span class="d-block">
                                        @translate(Coupon) - {{ $getData->order->applied_coupon ?? 'N/A'}}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shipping) - {{ formatPrice($getData->order->logistic_charge) }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Quantity) - {{$getData->quantity}}
                                        @translate(Total) - {{ formatPrice($getData->order->pay_amount) }}
                                    </span>
                                </td>
                                <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $getData->user->name ?? 'Guest Customer' }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Phone) - {{ $getData->order->phone }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Address) - {{ $getData->order->address }}, {{ $getData->order->area->thana_name }}, {{ $getData->order->division->district_name }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Note) - {{ $getData->order->note ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block">
                                        @translate(Shop Name) - {{ $getData->seller->shop_name }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Email) - {{ $getData->seller->email }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Phone) - {{ $getData->seller->phone }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Address) - {{ $getData->seller->adrress ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($getData->product->product->image) }}" class="w-25" alt="#{{ $getData->product->product->name }}">
                                    </span>
                                    <span class="d-block">
                                        @translate(Name) - {{ $getData->product->product->name }} - {{ $getData->vendor_product_stock->product_variants }}
                                    </span>
                                    <span class="d-block">
                                        @translate(SKU) - {{ $getData->product->product->sku }}
                                    </span>

                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        @if (isset($getData->comment) || isset($getData->commentedBy))
                                            {{ $getData->comment ?? 'N/A' }} @translate(By) {{ $getData->user->name ?? 'N/A' }}
                                        @else
                                        @translate(No Comment)
                                        @endif
                                    </span>
                                </td>
                                @canany('order-modify')

                            @if ($getData->status != 'delivered')


                            
                                <td>
                                    <a href="#!"
                                       onclick="forModal('{{route('order.followup', $getData->id)}}','@translate(Follow up comment)')"
                                       class="btn-sm btn-info d-block m-2 text-center">@translate(Follow Up)</a>

                                       @if (Auth::user()->user_type == 'Vendor')
                                           @if ($getData->status != 'processing'
                                    && $getData->status != 'quality_check'
                                    && $getData->status != 'product_dispatched'
                                    && $getData->status != 'delivered'
                                    && $getData->status != 'canceled'
                                    && $getData->status != 'confirmed'
                                    )
                                        <a href="{{ route('order.confirm', $getData->id) }}"
                                           class="btn-sm btn-success d-block m-2 text-center">@translate(Confirm)</a>
                                    @endif


                                    @if ($getData->status != 'processing' && $getData->status != 'quality_check' && $getData->status != 'product_dispatched')
                                        <a href="{{ route('order.processing', $getData->id) }}"
                                           class="btn-sm btn-processing d-block m-2 text-center">@translate(Processing)</a>
                                    @endif

                                    @if ($getData->status != 'quality_check' && $getData->status != 'product_dispatched')
                                        <a href="{{ route('order.quality_check', $getData->id) }}"
                                           class="btn-sm btn-qc d-block m-2 text-center">@translate(QC)</a>
                                    @endif

                                    @if ($getData->status != 'product_dispatched')
                                        <a href="{{ route('order.product_dispatched', $getData->id) }}"
                                           class="btn-sm btn-dispatched d-block m-2 text-center">@translate(Dispatched)</a>
                                    @endif
                                       @endif

                                    

                                    @if (Auth::user()->user_type != 'Vendor')
                                    {{-- Delivered and cancel permission --}}
                                        
                                        @if ($getData->status != 'delivered')
                                            <a href="{{ route('order.delivered', $getData->id) }}"
                                            class="btn-sm btn-delivered d-block m-2 text-center">@translate(Delivered)</a>
                                        @endif
                                        @if ($getData->status != 'canceled')
                                            <a href="{{ route('order.cancel', $getData->id) }}"
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

<script type="text/javascript">
        "use strict"
        $(function () {
            $('#datetimepicker7, #datetimepicker8').datetimepicker({
                pickTime: false
            });
        });
</script>

