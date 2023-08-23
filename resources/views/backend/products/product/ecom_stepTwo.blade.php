@extends('backend.layouts.master')
@section('title') @translate(Product Step Two) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"> @translate(Product Step Two)</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2">


            <form method="post" action="{{route('product.step.tow.store')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" class="chooseProduct" value="{{$product->id}}">
                <input type="hidden" name="category_id" value="{{$product->category_id}}">
                <div class="row">
                    <div class="col-md-12 p-2">
                        <input class="productdetailsUrl" type="hidden"
                               value="{{route('admin.product.show')}}">
                        <div class="card" id="productDetails">

                        </div>
                    </div>
                </div>
                <div class="form-group m-3">
                    <button type="submit" class="btn btn-block btn-primary">@translate(Submit)</button>
                </div>
            </form>

            <!-- Content starts here:END -->
        </div>
    </div>


@endsection

@section('script')
    <script>
        "use strict"
        $(document).ready(function (){
            var url = $(".productdetailsUrl").val();
            var chooseProduct = $(".chooseProduct").val();
            /*ajax get value*/
            if (url == null) {
                location.reload();
            } else {
                $.ajax({
                    url: url,
                    method: "GET",
                    data: { id: chooseProduct },
                    success: function (result) {
                        $("#productDetails").html(result);
                    },
                });
            }
        });
    </script>
@endsection



