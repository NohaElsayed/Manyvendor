
@if(vendorActive())
    <div class="card">
        <div class="card-body">
            <h3 class="text-center">@translate(Order details)</h3>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>
                <span class="d-block">
                     @translate(BK Code) - #{{ $deliver->orderDetails->booking_code }}
                </span>
                        <span class="d-block">
                                        @translate(Order Number) - #{{ $deliver->orderDetails->order_number }}
                                    </span>
                        <span class="d-block">
                                        @translate(Logistic) - {{ $deliver->orderDetails->order->logistic->name ?? null }}
                                    </span>

                    </td>

                    <td>
                                    <span class="d-block text-uppercase">
                                       @translate(Payment) {{ $deliver->orderDetails->payment_type }}
                                    </span>

                        <span class="d-block">
                                        @translate(Coupon) - {{ $deliver->orderDetails->order->applied_coupon ?? 'N/A'}}
                                    </span>
                        <span class="d-block">
                                        @translate(Shipping) - {{ formatPrice($deliver->orderDetails->order->logistic_charge) }}
                                    </span>
                        <span class="d-block">
                                        @translate(Quantity) - {{$deliver->orderDetails->quantity}}
                                        @translate(Total) - {{ formatPrice($deliver->orderDetails->order->pay_amount) }}
                                    </span>
                    </td>

                    <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $deliver->orderDetails->user ? $deliver->orderDetails->user->name: 'Guest Order' }}
                                    </span>
                        <span class="d-block">
                                        @translate(Phone) - {{ $deliver->orderDetails->order->phone }}
                                    </span>
                        <span class="d-block">
                                        @translate(Address) - {{ $deliver->orderDetails->order->address }}, {{ $deliver->orderDetails->order->area->thana_name }}, {{ $deliver->orderDetails->order->division->district_name }}
                                    </span>
                        <span class="d-block">
                                        @translate(Note) - {{ $deliver->orderDetails->order->note ?? 'N/A' }}
                                    </span>
                    </td>

                    <td>
                                    <span class="d-block">
                                        @translate(Shop Name) - {{ $deliver->orderDetails->seller->shop_name }}
                                    </span>
                        <span class="d-block">
                                        @translate(Shop Email) - {{ $deliver->orderDetails->seller->email }}
                                    </span>
                        <span class="d-block">
                                        @translate(Shop Phone) - {{ $deliver->orderDetails->seller->phone }}
                                    </span>
                        <span class="d-block">
                                        @translate(Shop Address) - {{ $deliver->orderDetails->seller->adrress ?? 'N/A' }}
                                    </span>
                    </td>

                    <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($deliver->orderDetails->product->product->image) }}"
                                             class="w-25"
                                             alt="#{{ $deliver->orderDetails->product->product->name }}">
                                    </span>
                        <span class="d-block">
                                        @translate(Name) - {{ $deliver->orderDetails->product->product->name }} - {{ $deliver->orderDetails->vendor_product_stock->product_variants }}
                                    </span>
                        <span class="d-block">
                                        @translate(SKU) - {{ $deliver->orderDetails->product->product->sku }}
                                    </span>

                    </td>

                </tr>
                </tbody>
            </table>
            <h3 class="text-center">@translate(Order Delivery Summery)</h3>
            @if($deliver->deliverSummery != null)
                <table class="table table-bordered">
                    <tbody>
                    @foreach($deliver->deliverSummery as $data)
                        <tr>
                            <td>
                                <p class="px-2"> @translate(Location): {{$data->location}}
                                    <span class="badge badge-info">
                            {{\Carbon\Carbon::parse($data->created_at)->diffForHumans()}}
                        </span></p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="badge badge-info">@translate(No Delivery Summery)</p>
            @endif
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>@translate(Deliver User Details)</h3>
                        </div>
                        @if($deliver->deliverUser->avatar != null)
                            <img class="card-img-top" src="{{filePath($deliver->deliverUser->avatar)}}" alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <p>{{$deliver->deliverUser->name}}</p>
                                <p>{{$deliver->deliverUser->email}}</p>
                                <p>{{$deliver->deliverUser->tel_number}}</p>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>@translate(Assign User Details)</h3>
                        </div>
                        @if($deliver->assignUser->avatar != null)
                            <img class="card-img-top" src="{{filePath($deliver->assignUser->avatar)}}" alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <p>{{$deliver->assignUser->name}}</p>
                                <p>{{$deliver->assignUser->email}}</p>
                                <p>{{$deliver->assignUser->tel_number}}</p>
                            </h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body">
            <h3 class="text-center">@translate(Order details)</h3>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>
                <span class="d-block">
                     @translate(BK Code) - #{{ $deliver->orderDetails->booking_code }}
                </span>
                        <span class="d-block">
                                        @translate(Order Number) - #{{ $deliver->orderDetails->order_number }}
                                    </span>
                        <span class="d-block">
                                        @translate(Logistic) - {{ $deliver->orderDetails->order->logistic->name ?? null }}
                                    </span>

                    </td>

                    <td>
                                    <span class="d-block text-uppercase">
                                       @translate(Payment) {{ $deliver->orderDetails->payment_type }}
                                    </span>

                        <span class="d-block">
                                        @translate(Coupon) - {{ $deliver->orderDetails->order->applied_coupon ?? 'N/A'}}
                                    </span>
                        <span class="d-block">
                                        @translate(Shipping) - {{ formatPrice($deliver->orderDetails->order->logistic_charge) }}
                                    </span>
                        <span class="d-block">
                                        @translate(Quantity) - {{$deliver->orderDetails->quantity}}
                                        @translate(Total) - {{ formatPrice($deliver->orderDetails->order->pay_amount) }}
                                    </span>
                    </td>

                    <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $deliver->orderDetails->user ? $deliver->orderDetails->user->name: 'Guest Order' }}
                                    </span>
                        <span class="d-block">
                                        @translate(Phone) - {{ $deliver->orderDetails->order->phone }}
                                    </span>
                        <span class="d-block">
                                        @translate(Address) - {{ $deliver->orderDetails->order->address }}, {{ $deliver->orderDetails->order->area->thana_name }}, {{ $deliver->orderDetails->order->division->district_name }}
                                    </span>
                        <span class="d-block">
                                        @translate(Note) - {{ $deliver->orderDetails->order->note ?? 'N/A' }}
                                    </span>
                    </td>


                    <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($deliver->orderDetails->product->image) }}"
                                             class="w-25"
                                             alt="#{{ $deliver->orderDetails->product->name }}">
                                    </span>

                        <span class="d-block">
                                        @translate(Name) - {{ $deliver->orderDetails->product->name }} - {{ $deliver->orderDetails->product_stock->product_variants ?? '' }}
                                    </span>
                        <span class="d-block">
                                        @translate(Product Price) - {{ $deliver->orderDetails->product->product_price }}
                                    </span>
                        <span class="d-block">
                                        @translate(SKU) - {{ $deliver->orderDetails->product->sku }}
                                    </span>

                    </td>

                </tr>
                </tbody>
            </table>
            <h3 class="text-center">@translate(Order Delivery Summery)</h3>
            @if($deliver->deliverSummery != null)
                <table class="table table-bordered">
                    <tbody>
                    @foreach($deliver->deliverSummery as $data)
                        <tr>
                            <td>
                                <p class="px-2"> @translate(Location): {{$data->location}}
                                    <span class="badge badge-info">
                            {{\Carbon\Carbon::parse($data->created_at)->diffForHumans()}}
                        </span></p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="badge badge-info">@translate(No Delivery Summery)</p>
            @endif
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>@translate(Deliver User Details)</h3>
                        </div>
                        @if($deliver->deliverUser->avatar != null)
                            <img class="card-img-top" src="{{filePath($deliver->deliverUser->avatar)}}" alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <p>{{$deliver->deliverUser->name}}</p>
                                <p>{{$deliver->deliverUser->email}}</p>
                                <p>{{$deliver->deliverUser->tel_number}}</p>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>@translate(Assign User Details)</h3>
                        </div>
                        @if($deliver->assignUser->avatar != null)
                            <img class="card-img-top" src="{{filePath($deliver->assignUser->avatar)}}" alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <p>{{$deliver->assignUser->name}}</p>
                                <p>{{$deliver->assignUser->email}}</p>
                                <p>{{$deliver->assignUser->tel_number}}</p>
                            </h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif







