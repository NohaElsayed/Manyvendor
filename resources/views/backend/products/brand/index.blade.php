@extends('backend.layouts.master')
@section('title') @translate(Brands)
@endsection
@section('parentPageTitle', 'All Brands')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Brands List)</h2>
            </div>
            <div class="float-right">
                <div class="row text-right">
                    <div class="col-7">
                        <form action="{{route('brands.search.published')}}" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="searchPublished" class="form-control col-12"
                                       placeholder="@translate(Brand Name)" value="{{Request::get('searchPublished')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">@translate(Search)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-5">
                        <a href="#!"
                           onclick="forModal('{{ route("brands.create") }}', '@translate(Create Brand)')"
                           class="btn btn-primary">
                            <i class="la la-plus"></i>
                            @translate(Add New Brand)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center table-sm">
                    <thead>
                    <tr>
                        <th>@translate(S/L)</th>
                        <th class="text-left">@translate(Brand)</th>
                        <th>@translate(Logo)</th>
                        <th>@translate(Banner)</th>
                        <th>@translate(Publish)</th>
                        <th>@translate(Action)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($brands as $item)
                        <tr>
                            <td>{{ ($loop->index+1) + ($brands->currentPage() - 1)*$brands->perPage() }}</td>

                            <td>
                                {{ $item->name }}
                            </td>

                            <td>
                                @if($item->logo != null)
                                    <img src="{{filePath($item->logo)}}"
                                         class="img-thumbnail table-avatar " alt="{{$item->name}}">
                                @endif
                            </td>

                            <td>
                                @if($item->banner != null)
                                    <img src="{{filePath($item->banner)}}"
                                         class="img-thumbnail table-avatar" alt="{{$item->name}}">
                                @endif
                            </td>

                            <td>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input data-id="{{$item->id}}"
                                               {{$item->is_published == true ? 'checked' : null}}  data-url="{{route('brands.published')}}"
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
                                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                                        <li>
                                            <a  href="#!" class="nav-link text-black"
                                                onclick="forModal('{{ route('brands.edit', $item->id) }}', '@translate(Edit Brand)')">@translate(Edit)
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#!" class="nav-link text-black"
                                               onclick="confirm_modal('{{ route('brands.destroy', $item->id) }}')">@translate(Delete)
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
                        {{ $brands->links() }}
                    </div>
                </table>
            </div>
        </div>
    </div>

    @if(vendorActive())
    <div class="card m-2 mt-5 bg-gray-light">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Requested Brands)</h2>
            </div>
            <div class="float-right">
                <div class="row">
                        <div class="col-12">
                            <form action="{{route('brands.search.unpublished')}}" method="get">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="searchUnpublished" class="form-control col-12"
                                           placeholder="@translate(Brand Name)" value="{{Request::get('searchUnpublished')}}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">@translate(Search)</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center table-sm">
                    <thead>
                    <tr>
                        <th>@translate(S/L)</th>
                        <th class="text-left">@translate(Brand)</th>
                        <th>@translate(Logo)</th>
                        <th>@translate(Banner)</th>
                        <th>@translate(Approve)</th>
                        <th>@translate(Action)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($requested_brands as $requested_item)
                        <tr>
                            <td>{{ ($loop->index+1) + ($requested_brands->currentPage() - 1)*$requested_brands->perPage() }}</td>
                            <td class="text-left">{{$requested_item->name}}</td>
                            <td>
                                @if($requested_item->logo != null)
                                    <img src="{{filePath($requested_item->logo)}}"
                                         class="img-thumbnail table-avatar " alt="{{$requested_item->name}}">
                                @endif
                            </td>

                            <td>
                                @if($requested_item->banner != null)
                                    <img src="{{filePath($requested_item->banner)}}"
                                         class="img-thumbnail table-avatar" alt="{{$requested_item->name}}">
                                @endif
                            </td>

                            <td>
                                <button class="btn btn-outline-success btn-sm py-0 px-2">
                                    <a href="{{ route('brands.approve', $requested_item->id) }}" class="nav-item text-black"><i class="fa fa-check"></i> </a>
                                </button>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">@translate(Toggle Dropdown)</span>
                                    </button>
                                    <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                        <li>
                                            <a  href="#!" class="nav-link text-black"
                                                onclick="forModal('{{ route('brands.edit', $requested_item->id) }}', '@translate(Edit Brand)')">@translate(Edit)
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#!" class="nav-link text-black"
                                               onclick="confirm_modal('{{ route('brands.destroy', $requested_item->id) }}')">@translate(Delete)
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
                </table>
            </div>
        </div>
    </div>
    @endif
@endsection
