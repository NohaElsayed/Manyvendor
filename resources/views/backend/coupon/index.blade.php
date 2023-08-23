@extends('backend.layouts.master')
@section('title') @translate(Coupons) @endsection
@section('css')
    <script type="text/javascript" src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <link type="text/javascript" src="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}"/>
@endsection
@section('content')
    <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body p-2">
            <!-- Content starts here -->
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card-body">
                        <form method="post" action="{{route('coupon.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>@translate(Coupon Code)</label>
                                <input type="text" name="code" value="{{ old('code') }}" class="form-control"
                                    placeholder="@translate(Coupon Code)" required>
                            </div>

                            <div class="form-group">
                                <label>@translate(Discount Amount)</label>
                                <input type="number" name="rate" value="{{ old('rate') }}" min="0" step="0.01"
                                       class="form-control" placeholder="@translate(Insert Discount Amount)" required>
                            </div>

                            <div class="form-group">
                                <label>@translate(Starting Date)</label>
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" name="start_day" value="{{ old('start_day') }}"
                                           class="form-control datetimepicker-input" data-target="#datetimepicker1"
                                           placeholder="@translate(Starting Date)" required/>
                                    <div class="input-group-append form-group" data-target="#datetimepicker1"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>@translate(Ending Date)</label>
                                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                    <input type="text" name="end_day" value="{{ old('end_day') }}"
                                           class="form-control datetimepicker-input" data-target="#datetimepicker2"
                                           placeholder="@translate(Ending Date)" required/>
                                    <div class="input-group-append form-group" data-target="#datetimepicker2"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>@translate(Minimum Shopping Amount)</label>
                                <input type="number" name="min_value" value="{{ old('min_value') }}"
                                       class="form-control" min="0" placeholder="@translate(Minimum Shopping Amount)"
                                       required>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="is_published" id="published">
                                <label for="published">@translate(Is published?)</label>
                            </div>

                            <button type="submit" class="btn btn-primary">@translate(Submit)</button>

                        </form>
                    </div>
                </div>

            </div>

            <!-- Content starts here:END -->


        </div>

    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Coupon Informations)</h3>
        </div>
        <div class="card-body p-2">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th>@translate(Code)</th>
                    <th>@translate(Discount)</th>
                    <th>@translate(Minimum Shopping)</th>
                    <th>@translate(Start Date)</th>
                    <th>@translate(End Date)</th>
                    <th>@translate(Status)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>

                @forelse ($coupons as $coupon)
                    <tr>
                        <td>{{ $loop->index++ + 1 }}</td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ formatPrice($coupon->rate) }}</td>
                        <td>{{ formatPrice($coupon->min_value) }}</td>
                        <td>{{ $coupon->start_day }}</td>
                        <td>{{ $coupon->end_day }}</td>
                        <td>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$coupon->id}}"
                                           {{$coupon->is_published == true ? 'checked' : null}}  data-url="{{route('coupon.activation')}}"
                                           type="checkbox" class="custom-control-input coupon_activation"
                                           id="is_published_{{$coupon->id}}">
                                    <label class="custom-control-label" for="is_published_{{$coupon->id}}"></label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="#!" class="btn btn-primary"
                               onclick="forModal('{{ route('coupon.edit', $coupon->id) }}', '@translate(Edit)')">@translate(Edit)
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <h4>@translate(NO COUPON FOUND)</h4>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        "use strict"
        $(function () {
            $('#datetimepicker1, #datetimepicker2').datetimepicker();
        });
    </script>
@endsection
