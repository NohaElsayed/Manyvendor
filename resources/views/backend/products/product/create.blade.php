@extends('backend.layouts.master')
@section('title') @translate(Product create)
@endsection
@section('parentPageTitle', '@translate(Product create)')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <h2 class="card-title">@translate(Add new product)</h2>
        </div>

        <div class="card-body">
            <form method="post" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="form-group">
                        <label>@translate(name)</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                               placeholder="@translate(Enter product name)" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>@translate(brand)</label>
                        <select class="form-control select2" name="brand_id">
                            <option value=""></option>
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>@translate(Select parent category)</label>
                        <select class="form-control select2 parent-cat" name="parent_id" required>
                            <option value=""></option>
                            @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Select child category)</label>
                        <input  class="childUrl" type="hidden" value="{{route('admin.child.index')}}"
                               required>
                        <select class="form-control select2 childCatShow" name="category_id">

                        </select>
                    </div>

                    <div class="form-group">
                        <label>@translate(Short Description)</label>
                        <textarea class="textarea" placeholder="@translate(short description)"
                                  name="short_desc"></textarea>
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Big Description)</label>
                        <textarea class="textarea" placeholder="@translate(short description)"
                                  name="big_desc"></textarea>
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Mobile View Description)</label>
                        <textarea class="form-control" cols="5" rows="10" placeholder="@translate(Mobile View Description)"
                                  name="mobile_desc"></textarea>
                    </div>

                    <div class="form-group">
                        <label>@translate(Featured image)</label>
                        <input name="image" class="form-control-file" type="file" required>
                    </div>

                    <div class="form-group">
                        <label>@translate(Video Provider)</label>
                        <select class="form-control select2" name="provider">
                            <option value=""></option>
                            <option value="youtube">@translate(Youtube)</option>
                            <option value="vimeo">@translate(vimeo)</option>
                        </select>
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Promotion Video Url)</label>
                        <input class="form-control" type="url" name="video_url"
                               placeholder="@translate(Enter promotion video url)">
                    </div>

                    <div class="form-group">
                        <label>@translate(Meta title)</label>
                        <input class="form-control" type="text" name="meta_title"
                               placeholder="@translate(Enter product meta title)">
                    </div>

                    <div class="form-group">
                        <label>@translate(Meta Description)</label>
                        <input class="form-control w-100" type="text" name="meta_desc"
                               placeholder="@translate(Enter product meta description)">
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Meta Image)</label>
                        <input class="form-control-file" type="file" name="meta_image">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">@translate(Tags)</label>
                        <input id="tags-input" type="text" name="tags" value="" class="form-control w-100"
                               data-role="tagsinput">
                    </div>

                    <div class="form-group">
                        <label> @translate(Add Tax)
                            <input class="add-tax" name="tax" type="checkbox" >
                        </label>
                    </div>

                    <div class="tax-input d-none">
                        <div class="form-group">
                            <input class="form-control tax-input-val" type="number" name="tax" min="0" step="0.01"
                                   placeholder="@translate(Enter tax %)">
                        </div>
                    </div>

                    {{--here the ecommerce check--}}
                    @if(!vendorActive())
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
                                @translate(has discount)?
                            </label>
                        </div>


                        <div class="form-group d-none" id="discount_price">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>@translate(Discounted Price)</label>
                                    <input name="discount_price" class="form-control" type="number"
                                           placeholder="@translate(Discounted price)">
                                </div>
                                <input type="hidden" name="discount_type" value="flat">
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>@translate(Add multiple product image)</label>
                        <input name="images[]" class="form-control-file" type="file" multiple>

                    </div>

                    <div class="form-group">
                        <label> @translate(Add Variant)
                            <input type="hidden" name="add_variant" value="off">
                            <input class="add-variant" name="add_variant" type="checkbox" value="on">
                        </label>
                    </div>




                    <div class="row d-none sr-variant">
                        {{--unit dropdown--}}
                        <strong class="text-info">@translate(If you select any variant you can't edit it, you can only add new variant)</strong>
                        <div class="form-group col-12">
                            <label>@translate(Select variant)</label>
                            <select class="form-control select2" name="units[]" multiple id="units">
                                <option value=""></option>
                                @foreach($variants as $variant)
                                <option value="{{ $variant->first()->unit }}">{{ $variant->first()->unit }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        {{--all varient--}}
                        @foreach($variants as $variant)
                            <div class="form-group col-12 {{ $variant->first()->unit }} d-none">
                                <label>{{ $variant->first()->unit }}</label>
                                <select class="form-control colorVariant" name="variant_id[]" multiple>
                                    <option value=""></option>
                                    @foreach($variant as $var)
                                        <option value="{{$var->id}}" data-color="{{$var->code}}"
                                                data-name="{{$var->variant}}">{{$var->variant}}</option>
                                        {{$var->unit}}
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">@translate(Save)</button>
                </div>

            </form>
        </div>
    </div>



@endsection
