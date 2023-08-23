<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap4/css/bootstrap.css') }}">

    <title>{{ $name }}</title>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            @translate(Invoice) #{{ $invoice_number }}
            <strong>{{ $order->created_at->format('M d, Y') }}</strong>

        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="mb-3">@translate(From):</h6>
                    <div>
                        <strong>{{getSystemSetting('type_name')}}</strong>
                    </div>

                    <div>{{getSystemSetting('type_address')}}</div>
                    <div>@translate(Email): {{getSystemSetting('type_mail')}}</div>
                    <div>@translate(Phone): {{getSystemSetting('type_number')}}</div>
                </div>

                <div class="col-sm-6">
                    <h6 class="mb-3">@translate(To):</h6>
                    <div>
                        <strong>{{ $name }}</strong>
                    </div>
                    <div>@translate(Address): {{ $order->address }}</div>
                    <div>{{ $order->division->district_name }}, {{ $order->area->thana_name }}</div>
                    <div>@translate(Email): {{ $email }}</div>
                    <div>@translate(Phone): {{ $order->phone }}</div>
                </div>

            </div>

            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="center">@translate(Booking Code)</th>
                        <th>@translate(Image)</th>
                        <th>@translate(Item)</th>
                        <th class="center">@translate(Price)</th>
                        <th class="center">@translate(Quantity)</th>
                        <th class="right">@translate(Total)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->order_product as $product)
                        <tr>
                            <td class="center">{{ $product->booking_code }}</td>
                            <td class="left">
                                <img src="{{ filePath( $product->product->image ) }}" sizes="4vw" width="800" class="w-20">
                            </td>
                            <td class="left strong">{{ $product->name }}</td>

                            <td class="center">{{ $product->quantity }}</td>
                            <td class="right">{{ formatPrice($product->product_price) }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5"></div>

                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>

                        <tr>
                            <td class="left">
                                <strong>@translate(Logistic)</strong>
                            </td>
                            <td class="right">{{ $order->logistic->name }}({{ formatPrice($order->logistic_charge) }})</td>
                        </tr>

                        <tr>
                            <td class="left">
                                <strong>@translate(Payment Type)</strong>
                            </td>
                            <td class="right">{{ $order->payment_type }}</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong>@translate(Coupon)</strong>
                            </td>
                            <td class="right">{{ $order->applied_coupon ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong>@translate(Total)</strong>
                            </td>
                            <td class="right">
                                <strong>{{ formatPrice($order->pay_amount) }}</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
</div>



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('frontend/plugins/jquery.js') }}"></script>
<script src="{{ asset('frontend/plugins/popper.js') }}"></script>
<script src="{{ asset('frontend/plugins/bootstrap4/js/bootstrap.js') }}"></script>
</body>
</html>
