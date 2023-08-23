<form action="{{ route('admin.product.bydate.download') }}" method="GET" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>@translate(Product From)</label>
                <div class="input-group date" id="bydateFrom" data-target-input="nearest">
                    <input type="text" name="export_from" value="" class="form-control datetimepicker-input" data-target="#bydateFrom"  placeholder="@translate(Starting From)" required/>
                        <div class="input-group-append form-group" data-target="#bydateFrom" data-toggle="datetimepicker">
                            <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i></div>
                        </div>
                </div>
    </div>

    <div class="form-group">
        <label>@translate(Product To)</label>
                <div class="input-group date" id="bydateTo" data-target-input="nearest">
                    <input type="text" name="export_to" value="" class="form-control datetimepicker-input" data-target="#bydateTo"  placeholder="@translate(Starting To)" required/>
                        <div class="input-group-append form-group" data-target="#bydateTo" data-toggle="datetimepicker">
                            <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i></div>
                        </div>
                </div>
    </div>

    <button class="btn btn-primary" type="submit">@translate(Export)</button>

</form>

@section('script')
    <script type="text/javascript" src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <link type="text/javascript" src="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}"/>
    <script type="text/javascript">
        "use strict"
        $(function () {
            $('#bydateFrom, #bydateTo').datetimepicker();
        });
    </script>
@endsection
