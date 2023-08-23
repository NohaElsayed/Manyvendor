@extends('backend.layouts.master')
@section('title') @translate(Product list)
@endsection
@section('parentPageTitle', 'All Products')
@section('content')
    @if(!request()->is('dashboard/request/product/index'))
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Products List)</h2>
            </div>
            <div class="float-right">
                @if (ProductExportImportActive() == 'YES')
                    <div class="row text-right">
                        <a href="#!" onclick="forModal('{{ route('admin.product.bydate') }}', 'Export By Date')" class="btn btn-export mr-3">Export By Date</a>
                        <a href="#!" onclick="forModal('{{ route('admin.product.bycategory', 'Export By Category') }}')" class="btn btn-export mr-3">Export By Category</a>
                        <a href="#!" onclick="forModal('{{ route('admin.product.bybrand', 'Export By Brand') }}')" class="btn btn-export mr-3">Export By Brand</a>
                        @if (vendorActive())
                            <a href="#!" onclick="forModal('{{ route('admin.product.byseller', 'Export By Seller') }}')" class="btn btn-export mr-3">Export By Seller</a>
                        @endif
                        <a href="{{ route('admin.product.export') }}" class="btn btn-export mr-3">Export CSV</a>
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
                        <tr>
                            <td>{{ ($loop->index+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                            <td class="text-left">
                             <p class="text-bold">{{$item->name}}</p>
                                <img src="{{filePath($item->image)}}" height="80" width="100">
                            </td>

                            <td class="">
                                <p>@translate(Brand :)<span class="text-bold">{{$item->brand->name}}</span></p>
                                <p> @translate(Parent Category :) <span class="text-bold">{{$item->category->name}}</span>
                                <p> @translate(Sub Category :) <span class="text-bold">{{$item->childcategory->name}}</span>
                                    @if(vendorActive())
                                        @if($item->childcategory->commission != null)
                                            <span class="badge badge-info">{{$item->childcategory->commission->amount}} %</span>
                                        @else
                                            <span class="badge badge-info"> @translate(Commission is not selected)</span>
                                        @endif

                                    @endif
                                </p>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input data-id="{{$item->id}}"
                                               {{$item->is_published == true ? 'checked' : null}}  data-url="{{route('admin.product.published')}}"
                                               type="checkbox" class="custom-control-input"
                                               id="is_published_{{$item->id}}">
                                        <label class="custom-control-label" for="is_published_{{$item->id}}"></label>
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
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a  href="{{ route('admin.products.edit', [$item->id,$item->slug]) }}" class="nav-link text-black">@translate(Edit)</a>
                                        </li>
                                        @if(!vendorActive())
                                            <li>
                                                <a  href="{{ route('product.step.tow.edit', [$item->id,$item->slug]) }}" class="nav-link text-black">@translate(Stock Add)</a>
                                            </li>
                                        @endif
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
                    @empty
                        <tr>
                            <td colspan="6"><h3 class="text-center" >@translate(No Data Found)</h3></td>
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
    @endif
    @if(request()->is('dashboard/request/product/index'))
    @if(vendorActive())
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Request products List)</h2>
            </div>
            <div class="float-right">
                <div class="row text-right">
                </div>
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
                        <th>@translate(Action)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($requestProducts as $item)
                        <tr>
                            <td>{{ ($loop->index+1) + ($requestProducts->currentPage() - 1)*$requestProducts->perPage() }}</td>
                            <td class="text-left">
                                <p class="text-bold">{{$item->name}}</p>
                                <img src="{{filePath($item->image)}}" height="80" width="100">
                            </td>

                            <td class="">
                                <p>@translate(Brand :)<span class="text-bold">{{$item->brand->name}}</span></p>
                                <p> @translate(Parent Category :) <span class="text-bold">{{$item->category->name}}</span>
                                    @if($item->category->start_percentage != null)
                                        <span class="badge badge-info">({{$item->category->start_percentage}}% - {{$item->category->end_percentage}}%)</span></p>
                                @endif
                                <p> @translate(Sub Category :) <span class="text-bold">{{$item->childcategory->name}}</span>
                                    @if(vendorActive())
                                    <span class="badge badge-info">{{$item->childcategory->commission ? $item->childcategory->commission->amount." %": translate("Commission is not selected")}}</span>
                                    @endif
                                </p>
                            </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a  href="{{ route('admin.products.edit', [$item->id,$item->slug]) }}" class="nav-link text-black">@translate(Edit)</a>
                                        </li>
                                        <li>
                                            <a  href="{{ route('admin.products.active', [$item->id,$item->slug]) }}" class="nav-link text-black">@translate(active)</a>
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
                    @empty
                        <tr>
                            <td colspan="6"><h3 class="text-center" >@translate(No Data Found)</h3></td>
                        </tr>
                    @endforelse
                    </tbody>
                    <div class="float-left">
                        {{ $requestProducts->links() }}
                    </div>
                </table>
            </div>
        </div>
    </div>
    @endif
    @endif
@endsection
