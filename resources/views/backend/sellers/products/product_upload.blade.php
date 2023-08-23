@extends('backend.layouts.master')
@section('title')@translate(Upload Product) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Upload Product)</h3>

            <div class="float-right">
                <a class="btn btn-primary" href="{{route('seller.products')}}">
                    @translate(All Products)
                </a>
            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2">
            <form method="post" action="{{route('seller.product.store')}}" enctype="multipart/form-data">
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

                        <div class="form-group">
                            <label>@translate(Price) <small class="text-danger">*</small></label>

                            <input name="product_price" min="0" class="form-control" type="number" step="0.01" required
                                   placeholder="@translate(Product price)">
                        </div>

                        <div class="form-group d-none">
                            <label>@translate(Purchase Price) <small class="text-danger">*</small></label>
                            <input name="purchase_price" class="form-control" type="number"
                                   placeholder="@translate(purchase product price)">
                        </div>

                        <div class="form-group">
                            <label>
                                <input id="is_discount" name="is_discount" type="checkbox">
                                @translate(is discount)?
                            </label>
                        </div>


                        <div class="form-group d-none" id="discount_price">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>@translate(Discounted Price)</label>
                                    <input name="discount_price" class="form-control" type="number"
                                           placeholder="@translate(Discounted price)">
                                </div>
                                <input type="hidden" name="discount_type" value="flat">

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 px-2">
                        <div class="card card-primary" id="productDetails">
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
