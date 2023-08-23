@extends('backend.layouts.master')
@section('title') @translate(Product list)
@endsection
@section('parentPageTitle', 'All Products')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Products List)</h2>
            </div>
            <div class="float-right">
                @if (ProductExportImportActive() == 'YES' && Auth::user()->user_type == 'Vendor')
                    <div class="row text-right">
                        <a href="#!" onclick="forModal('{{ route('admin.product.bydate') }}', 'Export By Date')" class="btn btn-export mr-3">Export By Date</a>
                        <a href="#!" onclick="forModal('{{ route('admin.product.bycategory') }}','Export By Category')" class="btn btn-export mr-3">Export By Category</a>
                        <a href="#!" onclick="forModal('{{ route('admin.product.byseller') }}','Export By Seller')" class="btn btn-export mr-3">Export By Seller</a>
                        <a href="{{ route('seller.product.export') }}" class="btn btn-export mr-3">Export CSV</a>
                        <a href="{{ route('admin.product.blank.csv') }}" class="btn btn-export mr-3">Sample CSV</a>
                        <a href="#!" onclick="forModal('{{ route('admin.product.import') }}', 'Import')" class="btn btn-export">Import CSV</a>
                    </div>
                @else

                    <div class="row text-right">
                    </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center table-sm">
                    <thead>
                    <tr>
                        <th>@translate(S/L)</th>
                        <th class="text-left">@translate(Title)</th>
                        <th>@translate(Details)</th>
                        <th>@translate(Published)</th>
                        <th>@translate(Action)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $item)
                        @if($item->product != null)
                            <tr>
                                <td>{{ ($loop->index+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                                <td class="text-left">
                                    <p class="text-bold">{{$item->product->name}}</p>
                                    <img src="{{filePath($item->product->image)}}" height="80" width="100">
                                </td>

                                <td class="">
                                    <p>@translate(Brand :)<span class="text-bold">{{$item->product->brand->name}}</span>
                                    </p>
                                    <p> @translate(Parent Category :) <span
                                            class="text-bold">{{$item->product->category->name}}</span>
                                        @if($item->product->category->start_percentage != null)
                                            <span class="badge badge-info">({{$item->product->category->start_percentage}}% - {{$item->category->end_percentage}}%)</span>
                                    </p>
                                    @endif
                                    <p> @translate(Sub Category :) <span
                                            class="text-bold">{{$item->product->childcategory->name ?? 'N/A'}}</span>
                                        <span class="badge badge-info">{{$item->product->childcategory->commission->amount ?? 'N/A'}} %</span>
                                    </p>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input data-id="{{$item->id}}"
                                                   {{$item->is_published == true ? 'checked' : null}}  data-url="{{route('seller.product.published')}}"
                                                   type="checkbox" class="custom-control-input"
                                                   id="is_published_{{$item->id}}">
                                            <label class="custom-control-label"
                                                   for="is_published_{{$item->id}}"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                                            <li>
                                                <a href="{{ route('seller.products.edit', $item->id) }}"
                                                   class="nav-link text-black">@translate(Edit)</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6"><h3 class="text-center">@translate(No Data Found)</h3></td>
                        </tr>
                    @endforelse
                    </tbody>
                    <div class="float-left">
                        {{ $products->links() }}
                    </div>
                </table>
            </div>
        </div>
    </div>


@endsection
