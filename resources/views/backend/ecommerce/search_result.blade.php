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
                                      @translate(payment)  {{ $getData->payment_type }}
                                    </span>

                                    <span class="d-block">
                                        @translate(Coupon) - {{ $getData->order->applied_coupon ?? 'N/A'}}
                                    </span>
                                    <span class="d-block">
                                        @translate(Shipping) - {{ formatPrice($getData->order->logistic_charge) }}
                                    </span>
                                    <span class="d-block">

                                         @translate(Quantity) - {{$getData->quantity}}<br>
                                        @translate(Total) - {{ formatPrice($getData->order->pay_amount) }}
                                    </span>
                                </td>
                                <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $getData->user->name ?? 'guest' }}
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
                                <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($getData->product->image) }}" class="w-25" alt="#{{ $getData->product->name }}">
                                    </span>
                                    <span class="d-block">
                                        @translate(Name) - {{ $getData->product->name }} - {{ $getData->product_stock->product_variants }}
                                    </span>
                                    <span class="d-block">
                                        @translate(SKU) - {{ $getData->product->sku }}
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
                                    @if ($getData->status != 'delivered' && $getData->status != 'canceled')

                                <td>
                                    <a href="#!" onclick="forModal('{{route('order.followup', $getData->id)}}','@translate(Follow up comment)')" class="btn-sm btn-info d-block m-2 text-center">Follow Up</a>

                                    @if ($getData->status != 'processing'
                                    && $getData->status != 'quality_check'
                                    && $getData->status != 'product_dispatched'
                                    && $getData->status != 'delivered'
                                    && $getData->status != 'canceled'
                                    && $getData->status != 'confirmed'
                                    )
                                    <a href="{{ route('order.confirm', $getData->id) }}" class="btn-sm btn-success d-block m-2 text-center">@translate(Confirm)</a>
                                    @endif


                                        @if ($getData->status != 'processing' && $getData->status != 'quality_check' && $getData->status != 'product_dispatched')
                                       <a href="{{ route('order.processing', $getData->id) }}" class="btn-sm btn-processing d-block m-2 text-center">@translate(Processing)</a>
                                        @endif

                                        @if ($getData->status != 'quality_check' && $getData->status != 'product_dispatched')
                                        <a href="{{ route('order.quality_check', $getData->id) }}" class="btn-sm btn-qc d-block m-2 text-center">@translate(QC)</a>
                                        @endif

                                        @if ($getData->status != 'product_dispatched')
                                        <a href="{{ route('order.product_dispatched', $getData->id) }}" class="btn-sm btn-dispatched d-block m-2 text-center">@translate(Dispatched)</a>
                                        @endif

                                        @if ($getData->status != 'delivered')
                                        <a href="{{ route('order.delivered', $getData->id) }}" class="btn-sm btn-delivered d-block m-2 text-center">@translate(Delivered)</a>
                                        @endif

                                        @if ($getData->status != 'canceled')
                                            <a href="{{ route('order.cancel', $getData->id) }}" class="btn-sm btn-danger d-block m-2 text-center">@translate(Cancel)</a>
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

