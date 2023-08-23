@extends('backend.layouts.master')
@section('title') @translate(Seller Products)
@endsection
@section('parentPageTitle', 'Seller Products')
@section('content')
    <div class="card m-2">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">@translate(Product Lists)</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>@translate(SKU)</th>
                        <th>@translate(Product Image)</th>
                        <th>@translate(Product Name)</th>
                        <th>@translate(Category)</th>
                        <th>@translate(Brand)</th>
                        <th>@translate(Price)</th>
                        <th>@translate(Quantity)</th>
                        <th>@translate(Action)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($seller_products as $item)
                        <tr>
                            <td>{{ $item->product->sku }}</td>
                            <td>
                                <img src="{{ filePath($item->product->image) }}" class="rounded w-50" alt="">
                            </td>
                            <td>{{ $item->product->name }}</td>
                            <td>
                                @foreach ( $item->parent_category as $p_category)
                                    {{ $p_category->name }}
                                @endforeach
                            </td>
                            <td>{{ $item->product->brand->name }}</td>
                            <td>

                                @if($item->is_discount === 1)
                                    <span>{{ formatPrice($item->discount_price) }}</span>
                                    <del>{{ formatPrice($item->product_price) }}</del>
                                @else
                                    {{ formatPrice($item->product_price) }}
                                @endif

                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                                        <li>
                                            <a href="{{ route('seller.product.edit',$item->id) }}"
                                               class="nav-link text-black">@translate(Edit)</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#!" class="nav-link text-black"
                                               onclick="confirm_modal('{{ route('admin.products.destroy', $item->id) }}')">@translate(Delete)
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
@endsection
