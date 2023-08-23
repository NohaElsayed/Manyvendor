@extends('backend.layouts.master')
@section('title') @translate(Fullfillment Management) @endsection
@section('css')
    <script type="text/javascript" src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <link type="text/javascript" src="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}"/>
@endsection
@section('content')

            <div class="card">

                <div class="card-header">
                    <div class="text-center">
                        @foreach ($logistics as $logistic)
                            <a class="btn btn-warning" href="{{ route("fullfillment.logistic", $logistic->id) }}">{{ $logistic->name }}</a>
                        @endforeach
                    </div>
                </div>

                {{-- Find Order --}}
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="m-3" action="{{ route('find.order') }}" target="_blank" method="GET">
                                @csrf
                                <div class="form-row mt-3">

                                    <div class="col">
                                        <label>@translate(Order From)</label>
                                        <div class="input-group date" id="datetimepicker113" data-target-input="nearest">
                                            <input type="text" name="start_date" value="{{Request::get('start_date')}}"
                                                class="form-control datetimepicker-input" data-target="#datetimepicker113"
                                                placeholder="@translate(Order From)"/>
                                            <div class="input-group-append form-group" data-target="#datetimepicker113"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col">
                                    <label>@translate(Order To)</label>
                                        <div class="input-group date" id="datetimepicker114" data-target-input="nearest">
                                            <input type="text" name="end_date" value="{{Request::get('end_date')}}"
                                                class="form-control datetimepicker-input" data-target="#datetimepicker114"
                                                placeholder="@translate(Order To)"/>
                                            <div class="input-group-append form-group" data-target="#datetimepicker114"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                    <div class="col">
                                        <label for="email">@translate(Customer Email)</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="@translate(Customer Email)">
                                    </div>


                                </div>
                                <div class="form-row mt-3">

                                    <div class="col">
                                        <label for="order_number">@translate(Order Number)</label>
                                    <input type="number" id="order_number" name="order_number" class="form-control" placeholder="@translate(Order Number)">
                                    </div>
                                    <div class="col">
                                        <label for="booking_code">@translate(Booking Code)</label>
                                    <input type="number" id="booking_code" name="booking_code" class="form-control" placeholder="@translate(Booking Code)">
                                    </div>
                                    <div class="col">
                                        <label for="phone">@translate(Customer Phone)</label>
                                    <input type="number" id="phone" name="phone" class="form-control" placeholder="@translate(Customer Phone)">
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

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">@translate(SL).</th>
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

                            @forelse ($logistic_orders as $order)
                            <tr class="
                            {{ $order->status === 'pending' ? 'bg-newOrder' : '' }}
                            {{ $order->status === 'confirmed' ? 'bg-confirmed' : '' }}
                            {{ $order->status === 'delivered' ? 'bg-delivered' : '' }}
                            {{ $order->status === 'canceled' ? 'bg-canceled' : '' }}
                            {{ $order->status === 'follow_up' ? 'bg-follow_up' : '' }}
                            {{ $order->status === 'processing' ? 'bg-processing' : '' }}
                            {{ $order->status === 'quality_check' ? 'bg-quality_check' : '' }}
                            {{ $order->status === 'product_dispatched' ? 'bg-product_dispatched' : '' }}
                            ">
                                <th scope="row">{{ $loop->index++ + 1 }}</th>
                                <td>
                                    <span class="d-block">
                                        @translate(BK Code) - #{{ $order->booking_code }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Order Number) - #{{ $order->order_number }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Logistic) - {{ $order->order->logistic->name }}
                                    </span>

                                </td>
                                <td>
                                    <span class="d-block text-uppercase">
                                        {{ $order->payment_type }}
                                    </span>

                                    <span class="d-block">
                                        @translate(Coupon) - {{ $order->order->applied_coupon ?? 'N/A'}}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shipping) - {{ formatPrice($order->order->logistic_charge) }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Total) - {{ formatPrice($order->order->pay_amount) }}
                                    </span>
                                </td>
                                <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $order->user ?$order->user->name: 'Guest Order' }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Phone) - {{ $order->order->phone }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Address) - {{ $order->order->address }}, {{ $order->order->area->thana_name }}, {{ $order->order->division->district_name }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Note) - {{ $order->order->note ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block">
                                        @translate(Shop Name) - {{ $order->seller->shop_name }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Email) - {{ $order->seller->email }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Phone) - {{ $order->seller->phone }}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shop Address) - {{ $order->seller->adrress ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($order->product->product->image) }}" class="w-25" alt="#{{ $order->product->product->name }}">
                                    </span>
                                    <span class="d-block">
                                        @translate(Name) - {{ $order->product->product->name }} - {{ $order->vendor_product_stock->product_variants }}
                                    </span>
                                    <span class="d-block">
                                        @translate(SKU) - {{ $order->product->product->sku }}
                                    </span>

                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        @if (isset($order->comment) || isset($order->commentedBy))
                                            {{ $order->comment ?? 'N/A' }} By {{ $order->user->name ?? 'N/A' }}
                                        @else
                                            @translate(No Comment)
                                        @endif
                                    </span>
                                </td>

                                @canany('order-modify')

                            @if ($order->status != 'delivered')
                                <td>
                                    <a href="#!"
                                       onclick="forModal('{{route('order.followup', $order->id)}}','@translate(Follow up comment)')"
                                       class="btn-sm btn-info d-block m-2 text-center">@translate(Follow Up)</a>

                                       @if (Auth::user()->user_type == 'Vendor')
                                           @if ($order->status != 'processing'
                                    && $order->status != 'quality_check'
                                    && $order->status != 'product_dispatched'
                                    && $order->status != 'delivered'
                                    && $order->status != 'canceled'
                                    && $order->status != 'confirmed'
                                    )
                                        <a href="{{ route('order.confirm', $order->id) }}"
                                           class="btn-sm btn-success d-block m-2 text-center">@translate(Confirm)</a>
                                    @endif


                                    @if ($order->status != 'processing' && $order->status != 'quality_check' && $order->status != 'product_dispatched')
                                        <a href="{{ route('order.processing', $order->id) }}"
                                           class="btn-sm btn-processing d-block m-2 text-center">@translate(Processing)</a>
                                    @endif

                                    @if ($order->status != 'quality_check' && $order->status != 'product_dispatched')
                                        <a href="{{ route('order.quality_check', $order->id) }}"
                                           class="btn-sm btn-qc d-block m-2 text-center">@translate(QC)</a>
                                    @endif

                                    @if ($order->status != 'product_dispatched')
                                        <a href="{{ route('order.product_dispatched', $order->id) }}"
                                           class="btn-sm btn-dispatched d-block m-2 text-center">@translate(Dispatched)</a>
                                    @endif
                                       @endif

                                    

                                    @if (Auth::user()->user_type != 'Vendor')
                                    {{-- Delivered and cancel permission --}}
                                        
                                        @if ($order->status != 'delivered')
                                            <a href="{{ route('order.delivered', $order->id) }}"
                                            class="btn-sm btn-delivered d-block m-2 text-center">@translate(Delivered)</a>
                                        @endif
                                        @if ($order->status != 'canceled')
                                            <a href="{{ route('order.cancel', $order->id) }}"
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
            $('#datetimepicker113, #datetimepicker114').datetimepicker();
        });
    </script>
@endsection

