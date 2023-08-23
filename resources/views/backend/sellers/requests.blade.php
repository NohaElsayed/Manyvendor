@extends('backend.layouts.master')
@section('title')
    @translate(Seller Requests)
@endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Seller Requests)</h3>

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
                    <th>@translate(S/L)</th>
                    <th>@translate(Logo)</th>
                    <th>@translate(Shop name)</th>
                    <th>@translate(Name)</th>
                    <th>@translate(Email)</th>
                    <th>@translate(Phone)</th>
                    <th>@translate(Trade Licence)</th>
                    <th>@translate(Request date)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($vendor_requests as $vendor_request)
                    <tr>

                        <td>{{ $loop->index+1 }}</td>
                        @if (empty($vendor_request->shop_logo))
                            <td>
                                <img src="{{ asset('vendor-store.jpg') }}" class="w-50" alt="">
                            </td>
                        @else
                            <td>
                                <img src="{{ filePath($vendor_request->shop_logo) }}" class="w-50" alt="">
                            </td>
                        @endif

                        <td>{{ $vendor_request->shop_name }}</td>
                        <td>{{ $vendor_request->name }}</td>
                        <td>{{ $vendor_request->email }}</td>
                        <td>{{ $vendor_request->phone }}</td>
                        <td>{{ $vendor_request->trade_licence }}</td>
                        <td>{{ $vendor_request->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('vendor.requests.view',$vendor_request->id) }}"
                               class="btn-sm btn-primary">@translate(View)</a>
                        </td>
                    </tr>
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
