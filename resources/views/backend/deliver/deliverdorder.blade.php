@extends('backend.layouts.master')
@section('title') Delivered Orders @endsection

@section('css')

@endsection

@section('content')

    @if(vendorActive())
        <div class="card card-primary card-outline">
            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered border" id="example">
                    <thead>
                    <tr>
                        <th scope="col">@translate(SL)</th>
                        <th scope="col">@translate(Booking Code)</th>
                        <th scope="col">@translate(Payment Status)</th>
                        <th scope="col">@translate(Delivery Address)</th>
                        <th scope="col">@translate(Seller Address)</th>
                        <th scope="col">@translate(Product)</th>
                        <th scope="col">@translate(Comment)</th>
                        <th scope="col">@translate(Status)</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($deliverOrder as $getOrder)


                        <tr>
                            <td scope="row">{{ $loop->index++ + 1 }}</td>
                            <td>
                                    <span class="d-block">
                                        @translate(BK Code) - #{{ $getOrder->orderDetails->booking_code }}
                                    </span>
                                <span class="d-block">
                                        @translate(Order Number) - #{{ $getOrder->orderDetails->order_number }}
                                    </span>
                                <span class="d-block">
                                        @translate(Logistic) - {{ $getOrder->orderDetails->order->logistic->name ?? null }}
                                    </span>

                            </td>
                            <td>
                                    <span class="d-block text-uppercase">
                                       @translate(Payment) {{ $getOrder->orderDetails->payment_type }}
                                    </span>

                                <span class="d-block">
                                        @translate(Coupon) - {{ $getOrder->orderDetails->order->applied_coupon ?? 'N/A'}}
                                    </span>
                                <span class="d-block">
                                        @translate(Shipping) - {{ formatPrice($getOrder->orderDetails->order->logistic_charge) }}
                                    </span>
                                <span class="d-block">
                                        @translate(Quantity) - {{$getOrder->orderDetails->quantity}}
                                        @translate(Total) - {{ formatPrice($getOrder->orderDetails->order->pay_amount) }}
                                    </span>
                            </td>
                            <td class="w-20">
                                    <span class="d-block">
                                        @if($getOrder->orderDetails->user)
                                        @translate(Name) - {{ $getOrder->orderDetails->commentedBy ? $getOrder->orderDetails->user->name: 'Guest Order' }}
                                            @endif
                                    </span>
                                <span class="d-block">
                                        @translate(Phone) - {{ $getOrder->orderDetails->order->phone }}
                                    </span>
                                <span class="d-block">
                                @translate(Address) - {{ $getOrder->orderDetails->order->address }},
                                {{ $getOrder->orderDetails->order->area->thana_name }},
                                {{ $getOrder->orderDetails->order->division->district_name }}
                                    </span>
                                <span class="d-block">
                                        @translate(Note) - {{ $getOrder->orderDetails->order->note ?? 'N/A' }}
                                    </span>
                            </td>
                            <td>
                                    <span class="d-block">
                                        @translate(Shop Name) - {{ $getOrder->orderDetails->seller->shop_name }}
                                    </span>
                                <span class="d-block">
                                        @translate(Shop Email) - {{ $getOrder->orderDetails->seller->email }}
                                    </span>
                                <span class="d-block">
                                        @translate(Shop Phone) - {{ $getOrder->orderDetails->seller->phone }}
                                    </span>
                                <span class="d-block">
                                        @translate(Shop Address) - {{ $getOrder->orderDetails->seller->adrress ?? 'N/A' }}
                                    </span>
                            </td>
                            <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($getOrder->orderDetails->product->product->image) }}"
                                             class="w-25"
                                             alt="#{{ $getOrder->orderDetails->product->product->name }}">
                                    </span>
                                <span class="d-block">
                                        @translate(Name) - {{ $getOrder->orderDetails->product->product->name }} -
                                {{ $getOrder->orderDetails->vendor_product_stock->product_variants }}
                                    </span>
                                <span class="d-block">
                                        @translate(SKU) - {{ $getOrder->orderDetails->product->product->sku }}
                                    </span>

                            </td>
                            <td class="w-15">
                                    <span class="d-block">
                                        @if (isset($getOrder->orderDetails->comment) || isset($getOrder->orderDetails->commentedBy))
                                            {{ $getOrder->orderDetails->comment ?? 'N/A' }}
                                            By {{ $getOrder->orderDetails->deliverdBy->name ?? 'N/A' }}
                                        @else
                                            @translate(No Comment)
                                        @endif
                                    </span>
                            </td>
                            <td>
                                {{$getOrder->orderDetails->status}}
                            </td>
                        </tr>


                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h4>@translate(NO ORDER FOUND)</h4>
                            </td>
                        </tr>
                    @endforelse


                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col">@translate(SL)</th>
                        <th scope="col">@translate(Booking Code)</th>
                        <th scope="col">@translate(Payment Status)</th>
                        <th scope="col">@translate(Delivery Address)</th>
                        <th scope="col">@translate(Seller Address)</th>
                        <th scope="col">@translate(Product)</th>
                        <th scope="col">@translate(Comment)</th>
                        <th scope="col">@translate(Actions)</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @else
        <div class="card card-primary card-outline">
            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered border" id="example">
                    <thead>
                    <tr>
                        <th scope="col">@translate(SL)</th>
                        <th scope="col">@translate(Booking Code)</th>
                        <th scope="col">@translate(Payment Status)</th>
                        <th scope="col">@translate(Delivery Address)</th>
                        <th scope="col">@translate(Product)</th>
                        <th scope="col">@translate(Comment)</th>
                        <th scope="col">@translate(Status)</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($deliverOrder as $getOrder)


                        <tr>
                            <td scope="row">{{ $loop->index++ + 1 }}</td>
                            <td>
                                    <span class="d-block">
                                        @translate(BK Code) - #{{ $getOrder->orderDetails->booking_code }}
                                    </span>
                                <span class="d-block">
                                        @translate(Order Number) - #{{ $getOrder->orderDetails->order_number }}
                                    </span>
                                <span class="d-block">
                                        @translate(Logistic) - {{ $getOrder->orderDetails->order->logistic->name ?? null }}
                                    </span>

                            </td>
                            <td>
                                    <span class="d-block text-uppercase">
                                       @translate(Payment) {{ $getOrder->orderDetails->payment_type }}
                                    </span>

                                <span class="d-block">
                                        @translate(Coupon) - {{ $getOrder->orderDetails->order->applied_coupon ?? 'N/A'}}
                                    </span>
                                <span class="d-block">
                                        @translate(Shipping) - {{ formatPrice($getOrder->orderDetails->order->logistic_charge) }}
                                    </span>
                                <span class="d-block">
                                        @translate(Quantity) - {{$getOrder->orderDetails->quantity}}
                                        @translate(Total) - {{ formatPrice($getOrder->orderDetails->order->pay_amount) }}
                                    </span>
                            </td>
                            <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $getOrder->orderDetails->commentedBy ? ($getOrder->orderDetails->user == null ? 'Guest Order' : $getOrder->orderDetails->user->name): 'Guest Order' }}
                                    </span>
                                <span class="d-block">
                                        @translate(Phone) - {{ $getOrder->orderDetails->order->phone }}
                                    </span>
                                <span class="d-block">
                                @translate(Address) - {{ $getOrder->orderDetails->order->address }},
                                {{ $getOrder->orderDetails->order->area->thana_name }},
                                {{ $getOrder->orderDetails->order->division->district_name }}
                                    </span>
                                <span class="d-block">
                                        @translate(Note) - {{ $getOrder->orderDetails->order->note ?? 'N/A' }}
                                    </span>
                            </td>
                            <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($getOrder->orderDetails->product->image) }}"
                                             class="w-25"
                                             alt="#{{ $getOrder->orderDetails->product->name }}">
                                    </span>
                                <span class="d-block">
                                        @translate(Name) - {{ $getOrder->orderDetails->product->name }} -
                                {{ $getOrder->orderDetails->product_stock->product_variants }}
                                    </span>
                                <span class="d-block">
                                        @translate(SKU) - {{ $getOrder->orderDetails->product->sku }}
                                    </span>

                            </td>
                            <td class="w-15">
                                    <span class="d-block">
                                        @if (isset($getOrder->orderDetails->comment) || isset($getOrder->orderDetails->commentedBy))
                                            {{ $getOrder->orderDetails->comment ?? 'N/A' }}
                                            By {{ $getOrder->orderDetails->deliverdBy->name ?? 'N/A' }}
                                        @else
                                            @translate(No Comment)
                                        @endif
                                    </span>
                            </td>
                            <td>
                                {{$getOrder->orderDetails->status}}
                            </td>
                        </tr>


                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h4>@translate(NO ORDER FOUND)</h4>
                            </td>
                        </tr>
                    @endforelse


                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col">@translate(SL)</th>
                        <th scope="col">@translate(Booking Code)</th>
                        <th scope="col">@translate(Payment Status)</th>
                        <th scope="col">@translate(Delivery Address)</th>
                        <th scope="col">@translate(Product)</th>
                        <th scope="col">@translate(Comment)</th>
                        <th scope="col">@translate(Actions)</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif




@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>


    <script type="text/javascript">
        "use strict"
        $(document).ready(function () {
            var table = $('#example').DataTable({
                lengthChange: false,
            });
            $('#datetimepicker9, #datetimepicker10').datetimepicker();
        });
    </script>
@endsection

