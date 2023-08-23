@extends('backend.layouts.master')
@section('title')@endsection
<title> {{getSystemSetting('type_name')}} | @translate(Switch Application Mode) </title>
@section('content')

    <div class="col-md-6 offset-3 mt-5">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">@translate(Switch Application Mode)</h3>
            </div>

            <div class="card-body mt-3 ">
                <form action="{{route('smtp.store')}}" method="post">
                    @csrf
                    <div class="text-center">
                        <p class="text-white text-uppercase"><span class="bg-primary rounded-sm p-2">@translate(Activated Mode) : {{env('APP_ACTIVE')}}</span></p>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="types[]" value="APP_ACTIVE">
                        <div class="">
                            <label class="control-label">@translate(Active) <span
                                        class="text-danger">*</span></label>
                        </div>
                        <div class="">
                            <select class="form-control select2" name="APP_ACTIVE">
                                <option value="ecommerce" @if (env('APP_ACTIVE') == "ecommerce") selected @endif> Single Vendor eCommerce </option>
                                <option value="vendor" @if (env('APP_ACTIVE') == "vendor") selected @endif>Multi Vendor eCommerce </option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block btn-primary">@translate(Active)</button>
                </form>
            </div>

        </div>
    </div>


@endsection
