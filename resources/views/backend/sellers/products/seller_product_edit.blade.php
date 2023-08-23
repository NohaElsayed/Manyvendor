@extends('backend.layouts.master')
@section('title') @translate(Edit Product) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"> @translate(Edit Product)</h3>

            <div class="float-right">
                <a class="btn btn-success" href="#">
                    @translate(All Products)
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-2">
            <!-- Content starts here -->
            <div class="card-body">
                <form method="post" action="{{route('seller.product.update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$product->id}}" name="vendor_product_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@translate(Select parent category)</label>
                                <select class="form-control select2 parent-cat" name="parent_id" disabled>
                                    <option value=""></option>
                                    @foreach($categories as $cat)
                                        <option
                                            value="{{$cat->id}}" {{$product->product->parent_id == $cat->id ? 'selected':null}}>{{$cat->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@translate(Select child category)</label>
                                <input name="childUrl" class="childUrl" type="hidden"
                                       value="{{route('admin.child.index')}}" required>
                                <input class="catId" type="hidden" value="{{$product->product->id}}" required>
                                <input name="productUrl" class="productUrl" type="hidden"
                                       value="{{route('admin.product.index')}}" required>
                                <select class="form-control select2 childCatShow" name="category_id" disabled>
                                    @foreach(\App\Models\Category::where('parent_category_id',$product->product->parent_id)->Published()->get() as $item)
                                        <option
                                            value="{{$item->id}}" {{$item->id == $product->product->category_id ?'selected':null}}>{{$item->name}}
                                            ({{$item->commission->amount}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@translate(Select Product)</label>
                                <input name="productdetailsUrl" class="productdetailsUrl" type="hidden"
                                       value="{{route('admin.product.show')}}" required>
                                <select class="form-control select2 productShow" name="product_id" disabled>
                                    @foreach(\App\Models\Product::where('category_id', $product->product->category_id)->where('is_published', true)->get() as $item)
                                        <option
                                            value="{{$item->id}}" {{$item->id == $product->product->id ?'selected':null}}>{{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@translate(Price) <small class="text-danger">*</small></label>
                                <input name="product_price" class="form-control" type="number" step="0.01"
                                       value="{{$product->product_price}}" required
                                       placeholder="@translate(Product price)">
                            </div>

                            <div class="form-group d-none">
                                <label>@translate(Purchase Price) <small class="text-danger">*</small></label>
                                <input name="purchase_price" class="form-control" type="number" step="0.01"
                                       placeholder="@translate(purchase product price)">
                            </div>

                            <div class="form-group">
                                <label>
                                    <input id="is_discount" name="is_discount"
                                           type="checkbox" {{$product->is_discount == 0 ? null: 'checked'}}>
                                    @translate(is discount)?
                                </label>
                            </div>
                            <div class="form-group {{$product->is_discount == 0 ? 'd-none': null}}" id="discount_price">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>@translate(Discounted Price)</label>
                                        <input name="discount_price" class="form-control" type="number"
                                               value="{{$product->discount_price}}"
                                               placeholder="@translate(Discounted price)">
                                    </div>
                                    <input type="hidden" name="discount_type" value="flat">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-2">
                            <div class='row m-2'>
                                @if($product->product->variants->count()==0)
                                    {{--if no variant--}}
                                    <input name="have_vpstock_id" type="hidden"
                                           value="{{$product->variantProductStock->first()->id}}">
                                    <div class='form-group col-6'>
                                        <label>@translate(Total Quantity)</label>
                                        <input name='t_quantity' type='number' min='0'
                                               placeholder="@translate(Total Quantity)"
                                               class='form-control'
                                               value="{{$product->variantProductStock->first()->quantity}}" required>
                                    </div>
                                    <div class='form-group col-6'>
                                        <label>@translate(Alert Quantity)</label>
                                        <input name='alert_quantity' min='0' name='a_quantity' type='number'
                                               placeholder="@translate(Alert Quantity)"
                                               class='form-control'
                                               value="{{$product->variantProductStock->first()->alert_quantity}}">
                                    </div>
                                    {{--if no variant--}}
                                @else

                                    <table class='table table-responsive-sm'>
                                        <tbody class=''>
                                        @foreach($product->variantProductStock as $productVariant)
                                            <tr>
                                                <input name="have_pv_id[]" type="hidden"
                                                       value="{{$productVariant->id}}">
                                                <td><label>@translate(Variants)</label>
                                                    <div class="form-control text-uppercase">
                                                        {{$productVariant->product_variants ?? '@translate(No variant)' }}
                                                    </div>
                                                </td>
                                                <td><label>@translate(Quantity)</label><input name='have_pv_q[]'
                                                                                              type='number'
                                                                                              placeholder="@translate(Quantity)"
                                                                                              min='0'
                                                                                              class='form-control'
                                                                                              value="{{$productVariant->quantity}}">
                                                </td>
                                                <td><label>@translate(Extra Price)</label><input name='have_pv_price[]'
                                                                                                 type='number'
                                                                                                 placeholder="@translate(Extra Price)"
                                                                                                 class='form-control'
                                                                                                 value="{{$productVariant->extra_price}}">
                                                </td>
                                                <td><label class="">@translate(Alert Quantity)</label>
                                                    <input name='have_pv_alert_quantity[]' type='number'
                                                           placeholder="@translate(Alert Quantity)" min='0'
                                                           class='form-control'
                                                           value="{{$productVariant->alert_quantity}}"></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <div class="card w-100" id="productDetails"></div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">@translate(Submit)</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- Content starts here:END -->
    </div>

    <input class="productdetailsUrl" type="hidden"
           value="{{route('admin.product.show')}}">
@endsection

@section('script')
    <script>
        "use strict"
        $(document).ready(function () {
            var url = $(".productdetailsUrl").val();
            var chooseProduct = $(".catId").val();
            /*ajax get value*/
            if (url == null) {
                location.reload();
            } else {
                $.ajax({
                    url: url,
                    method: "GET",
                    data: {id: chooseProduct},
                    success: function (result) {
                        $("#productDetails").html(result);

                    },
                });
            }
        })

    </script>
@endsection
