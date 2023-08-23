@extends('backend.layouts.master')
@section('title')@translate(Request New Variation) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Request New Variation)</h3>

            <div class="float-right">
                <a class="btn btn-primary" href="{{route('seller.products')}}">
                    @translate(All Products)
                </a>
            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2">
            <form method="post" action="{{route('seller.variation.request.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@translate(Select parent category) <small class="text-danger">*</small></label>
                            <select class="form-control select2 parent-cat" name="parent_id" required>
                                <option value=""></option>
                                @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>@translate(Select child category) <small class="text-danger">*</small></label>
                            <input name="childUrl" class="childUrl" type="hidden"
                                   value="{{route('admin.child.index')}}" required>
                            <input name="productUrl" class="productUrl" type="hidden"
                                   value="{{route('admin.product.index')}}" required>
                            <select class="form-control select2 childCatShow" name="category_id" required></select>
                        </div>

                        <div class="form-group">
                            <label>@translate(Select Product) <small class="text-danger">*</small></label>
                            <input class="productdetailsUrl" type="hidden"
                                   value="{{route('admin.product.show')}}">
                            <select class="form-control select2 productShow" name="product_id" required></select>
                        </div>

                    </div>

                    <div class="col-md-12 px-2">
                        <div class="card card-primary" id="productDetails">
                        </div>
                    </div>



                    <div class="card-body p-2">
              
                        <div class="form-group">
                            <label class="col-form-label">@translate(Variant Unit)</label>
                            <select required class="form-control select2" name="unit" id="unit">
                                <option value="">@translate(Select unit)</option>
                                <option value="Size">@translate(Size)</option>
                                <option value="Color">@translate(Color)</option>
                                <option value="Fabric">@translate(Fabric)</option>
                                <option value="Wheel">@translate(Wheel)</option>
                                <option value="Weight">@translate(Weight)</option>
                                <option value="Capacity">@translate(Capacity)</option>
                                <option value="Sleeve">@translate(Sleeve)</option>
                                <option value="Lace">@translate(Lace)</option>
                                <option value="Bulbs">@translate(Bulbs)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">@translate(Variants)</label>
                            <input  type="text" name="variant" value="" class="form-control w-100">
                        </div>

                        <div class="form-group d-none code">
                            <label class="col-form-label">@translate(Color Code)</label>
                            <div class="input-group my-colorpicker2">
                                <input type="text" class="form-control" name="code">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                </div>
                            </div>
                        </div>


                </div>



                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">@translate(Submit)</button>
                </div>
            </form>

            <!-- Content starts here:END -->
        </div>
    </div>


@endsection
@section('script')
    <script>
        "use strict"
        $("#unit").change(function(){
            var unit = $(this). children("option:selected"). val();
            if(unit==='Color'){
                $('.code').removeClass('d-none')
            }else{
                $('.code').addClass('d-none')
            }

        });
    </script>
@endsection