@extends('install.app')
@section('content')

    <div class="card-body">
        <h2 class="text-lg-center p-3">@translate(App Setup)</h2>
        <form action="{{route('app.active,store')}}" method="post">
            @csrf
            <div class="form-group">
                <input type="hidden" name="types[]" value="APP_ACTIVE">
                <div class="">
                    <label class="control-label">Select Application  Mode<span
                            class="text-danger">*</span></label>
                </div>
                <div class="">
                    <select class="form-control" name="APP_ACTIVE">
                        <option value="ecommerce"@if (env('APP_ACTIVE') == "ecommerce") selected @endif>
                           Single Vendor eCommerce
                        </option>
                        <option value="vendor" @if (env('APP_ACTIVE') == "vendor") selected @endif>
                            Multi Vendor eCommerce
                        </option>
                    </select>
                </div>
            </div>


            <button type="submit" class="btn btn-primary btn-block">@translate(Activate )</button>
        </form>
    </div>
@endsection
