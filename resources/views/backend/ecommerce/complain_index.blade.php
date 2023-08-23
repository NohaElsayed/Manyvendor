@extends('backend.layouts.master')
@section('title') @translate(Complain Management) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="text-center">
                <a class="btn btn-primary" href="{{ route('complains.index') }}">@translate(Total Complain)({{ App\Models\Complain::count() }})</a>
                <a class="btn btn-success" href="{{ route("complains.filter", 'Untouched') }}">@translate(Untouched)({{ complainCount('Untouched') }})</a>
                <a class="btn btn-success" href="{{ route("complains.filter", 'Solved') }}">@translate(Solved)({{ complainCount('Solved') }})</a>
                <a class="btn btn-danger" href="{{ route("complains.filter", 'Not Solved') }}">@translate(Not Solved)({{ complainCount('Not Solved') }})</a>
            </div>
        </div>

        {{-- Find Complain --}}

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form class="m-3" action="{{ route('find.complain') }}" method="GET">
                        <input type="hidden" name="search" value="search">
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
                                <label for="booking_code">@translate(Booking Code)</label>
                                <input type="number" id="booking_code" name="booking_code" value="{{Request::get('booking_code') ?? null}}" class="form-control" placeholder="@translate(Booking Code)">
                            </div>


                        </div>

                        <div class="form-row mt-3">

                            <div class="col-md-6 offset-md-5">
                                <button class="btn btn-primary" type="submit">@translate(FIND COMPLAIN)</button>
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
                    <th scope="col">@translate(Customer Info)</th>
                    <th scope="col">@translate(Product)</th>
                    <th scope="col">@translate(Complain)</th>
                    <th scope="col">@translate(Status)</th>
                    <th scope="col">@translate(Comment By)</th>
                    <th scope="col">@translate(Action)</th>
                </tr>
                </thead>
                <tbody>

                @forelse ($complains as $complain)
                    <tr>
                        <th scope="row">{{ $loop->index++ + 1 }}</th>
                        <td>
                                    <span class="d-block">
                                        @translate(BK Code) - #{{ $complain->booking_code }}
                                    </span>
                            <span class="d-block">
                                        @translate(Order Number) - #{{ $complain->ecom_order_product->order_number }}
                                    </span>
                            <span class="d-block">
                                        @translate(Logistic) - {{ $complain->ecom_order_product->logistic->name }}
                                    </span>

                        </td>

                        <td class="w-20">
                                    <span class="d-block">
                                        @translate(Name) - {{ $complain->ecom_order_product->user->name }}
                                    </span>
                            <span class="d-block">
                                        @translate(Phone) - {{ $complain->ecom_order_product->order->phone }}
                                    </span>
                            <span class="d-block">
                                        @translate(Address) - {{ $complain->ecom_order_product->order->address }},
                                        {{ $complain->ecom_order_product->order->area->thana_name }},
                                        {{ $complain->ecom_order_product->order->division->district_name }}
                                    </span>
                        </td>
                        <td class="w-15">
                                    <span class="d-block">
                                        <img src="{{ filePath($complain->ecom_order_product->product->image) }}" class="w-25" alt="#{{ $complain->ecom_order_product->product->name }}">
                                    </span>
                            <span class="d-block">
                                        @translate(Name) - {{ $complain->ecom_order_product->product->name }} - {{ $complain->ecom_order_product->product_stock->product_variants }}
                                    </span>
                            <span class="d-block">
                                        @translate(SKU) - {{ $complain->ecom_order_product->product->sku }}
                                    </span>

                        </td>

                        <td class="w-15">
                                    <span class="d-block">
                                        {{ $complain->desc ?? null }}
                                    </span>
                        </td>

                        <td class="w-5">
                                    <span class="d-block">
                                        {{ $complain->status  ?? null}}
                                    </span>
                        </td>

                        <td class="w-5">
                                    <span class="d-block">
                                        {{ $complain->user->name ?? null }}
                                    </span>
                        </td>

                        @if ($complain->status != 'Solved')
                            <td>
                                <a href="{{ route('complains.solved', $complain->id) }}" class="btn-sm btn-success d-block m-2 text-center">@translate(Solved)</a>
                                <a href="{{ route('complains.notsolved', $complain->id) }}" class="btn-sm btn-danger d-block m-2 text-center">@translate(Not Solved)</a>
                        @else
                            <td class="w-5">
                                @translate(Solved)
                            </td>
                            @endif
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
