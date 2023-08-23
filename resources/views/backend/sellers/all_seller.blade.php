@extends('backend.layouts.master')
@section('title')
    @translate(Seller Lists)
@endsection
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Seller Lists)</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" id="searchStore" class="form-control float-right"
                           placeholder="Search">

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
                    <th>@translate(S/L)</th>
                    <th>@translate(Logo)</th>
                    <th>@translate(Shop name)</th>
                    <th>@translate(Name)</th>
                    <th>@translate(Email)</th>
                    <th>@translate(Phone)</th>
                    <th>@translate(Trade Licence)</th>
                    <th>@translate(Join date)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($sellers as $seller)
                    {{--@if ($seller->vendor != null)--}}
                        <tr class="{{$seller->banned == true ? 'bg-canceled' : ''}}">
                            <td>{{ $loop->index+1 }}</td>
                            @if (empty($seller->vendor->shop_logo))
                                <td>
                                    <img src="{{ asset('vendor-store.jpg') }}" class="w-50" alt="">
                                </td>
                            @else
                                <td>
                                    <img src="{{ filePath($seller->vendor->shop_logo) }}" class="w-50" alt="">
                                </td>
                            @endif

                            <td>{{ $seller->vendor->shop_name ?? '' }}</td>
                            <td>{{ $seller->vendor->name ?? ''}}</td>
                            <td>{{ $seller->vendor->email ?? ''}}</td>
                            <td>{{ $seller->vendor->phone ?? '' }}</td>
                            <td>{{ $seller->vendor->trade_licence ?? '' }}</td>
                            <td>{{ $seller->created_at->diffForHumans() ?? '' }}</td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                                        <li>
                                            <a href="{{ route('vendor.requests.view2',$seller->id) }}"
                                               class="nav-link text-black">@translate(View)</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#!"
                                               class="nav-link {{$seller->banned == 1 ?'text-danger' :'text-black'}}"
                                               onclick="confirm_modal('{{ route('users.banned',$seller->id) }}')">{{$seller->banned == 1 ?'UnBlock user' :'Block user'}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        {{--@endif--}}
                @empty
                    <tr>
                        <td colspan="9" class="text-center">@translate(No Request Found)</td>
                    </tr>
                @endforelse


                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>


@endsection
