@extends('backend.layouts.master')
@section('title') @translate(Complain Management) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="text-center">
                <a class="btn btn-primary" href="{{ route('complains.index') }}">@translate(Total
                    Complain)({{ App\Models\Complain::count() }})</a>
                <a class="btn btn-success"
                   href="{{ route("complains.filter", 'Untouched') }}">@translate(Untouched)({{ complainCount('Untouched') }}
                    )</a>
                <a class="btn btn-success"
                   href="{{ route("complains.filter", 'Solved') }}">@translate(Solved)({{ complainCount('Solved') }}
                    )</a>
                <a class="btn btn-danger" href="{{ route("complains.filter", 'Not Solved') }}">@translate(Not
                    Solved)({{ complainCount('Not Solved') }})</a>
            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">@translate(SL).</th>
                    <th scope="col">@translate(Booking Code)</th>
                    <th scope="col">@translate(Customer Info)</th>

                    <th scope="col">@translate(Product)</th>
                    <th scope="col">@translate(Complain)</th>
                    <th scope="col">@translate(Status)</th>
                    <th scope="col">@translate(Comment By)</th>
                    <th scope="col">@translate(Action)</th>
                </tr>
                </thead>
                <tbody>

                @forelse ($getComplains as $getComplain)
                    <tr>
                        <th scope="row">{{ $loop->index++ + 1 }}</th>
                        <td>
                                    <span class="d-block">
                                        @translate(BK Code) - #{{ $getComplain->booking_code }}
                                    </span>
                            <span class="d-block">
                                        @translate(Order Number) - #{{ $getComplain->ecom_order_product->order_number }}
                                    </span>
                            <span class="d-block">
                                        @translate(Logistic) - {{ $getComplain->ecom_order_product->logistic->name }}
                                    </span>

                        </td>

                        <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $getComplain->ecom_order_product->user->name }}
                                    </span>
                            <span class="d-block">
                                        @translate(Phone) - {{ $getComplain->ecom_order_product->order->phone }}
                                    </span>
                            <span class="d-block">
                                        @translate(Address) - {{ $getComplain->ecom_order_product->order->address }},
                                        {{ $getComplain->ecom_order_product->order->area->thana_name }},
                                        {{ $getComplain->ecom_order_product->order->division->district_name }}
                                    </span>
                        </td>
                        <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($getComplain->ecom_order_product->product->image) }}"
                                             class="w-25"
                                             alt="#{{ $getComplain->ecom_order_product->product->name }}">
                                    </span>
                            <span class="d-block">
                                        @translate(Name) - {{ $getComplain->ecom_order_product->product->name }} - {{ $getComplain->ecom_order_product->product_stock->product_variants }}
                                    </span>
                            <span class="d-block">
                                        @translate(SKU) - {{ $getComplain->ecom_order_product->product->sku }}
                                    </span>

                        </td>

                        <td class="w-15">
                                    <span class="d-block">
                                        {{ $getComplain->desc }}
                                    </span>
                        </td>

                        <td class="w-5">
                                    <span class="d-block">
                                        {{ $getComplain->status }}
                                    </span>
                        </td>

                        <td class="w-5">
                                    <span class="d-block">
                                        {{ $getComplain->user->name }}
                                    </span>
                        </td>

                        <td>
                            <a href="{{ route('complains.solved', $getComplain->id) }}"
                               class="btn-sm btn-success d-block m-2 text-center">@translate(Solved)</a>
                            <a href="{{ route('complains.notsolved', $getComplain->id) }}"
                               class="btn-sm btn-danger d-block m-2 text-center">@translate(Not Solved)</a>
                        </td>
                    </tr>

                @empty

                    <tr class="text-center">
                        <td colspan="8">
                            @translate(No Complain Found)
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>

        </div>

    </div>


@endsection
