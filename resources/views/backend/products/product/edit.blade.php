@extends('backend.layouts.master')
@section('title') @translate(Edit Product)
@endsection
@section('parentPageTitle', '@translate(Product create)')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <h2 class="card-title">@translate(Edit Product)</h2>
        </div>

        <div class="card-body">
            <form method="post" action="{{route('admin.products.update')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}">
                <input type="hidden" name="slug" value="{{$product->slug}}">
                <input type="hidden" name="image" value="{{$product->image}}">
                <div>
                    <div class="form-group">
                        <label>@translate(name)</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                               value="{{$product->name}}" required>
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
                                <option
                                        value="{{$brand->id}}" {{$product->brand_id == $brand->id ? 'selected':null}}>{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>@translate(Select parent category)</label>
                        <select class="form-control select2 parent-cat" name="parent_id" required>
                            <option value=""></option>
                            @foreach($categories as $cat)
                                <option
                                        value="{{$cat->id}}" {{$product->parent_id == $cat->id ? 'selected':null}}>{{$cat->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Select child category)</label>
                        <input name="childUrl" class="childUrl" type="hidden" value="{{route('admin.child.index')}}"
                               required>
                        <select class="form-control select2 childCatShow" name="category_id">

                            @if(vendorActive())
                                @foreach(\App\Models\Category::where('parent_category_id',$product->parent_id)->Published()->get() as $item)
                                    @if($item->commission != null)
                                    <option
                                            value="{{$item->id}}" {{$item->id == $product->category_id ?'selected':null}}>{{$item->name}}
                                        ({{$item->commission->amount}}% @translate(Commission))
                                    </option>
                                    @endif

                                @endforeach
                            @else
                                @foreach(\App\Models\Category::where('parent_category_id',$product->parent_id)->Published()->get() as $item)
                                    <option
                                            value="{{$item->id}}" {{$item->id == $product->category_id ?'selected':null}}>{{$item->name}}
                                    </option>
                                @endforeach
                            @endif


                        </select>
                    </div>

                    <div class="form-group">
                        <label>@translate(Short Description)</label>
                        <textarea class="textarea" placeholder="@translate(short description)"
                                  name="short_desc">{{$product->short_desc}}</textarea>
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Big Description)</label>
                        <textarea class="textarea" placeholder="@translate(short description)"
                                  name="big_desc">{{$product->big_desc}}</textarea>
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Mobile View Description)</label>
                        <textarea class="form-control" cols="5" rows="10"  placeholder="@translate(Mobile View Description)"
                                  name="mobile_desc">{{$product->mobile_desc}}</textarea>
                    </div>

                    @if($product->image != null)
                        <img src="{{filePath($product->image)}}" width="80" height="80">
                    @endif

                    <div class="form-group">
                        <label>@translate(Product featured image)</label>
                        <input name="newImage" class="form-control-file" type="file">
                    </div>

                    <div class="form-group">
                        <label>@translate(Video Provider)</label>
                        <select class="form-control select2" name="provider">
                            <option value=""></option>
                            <option value="youtube" {{$product->provider == 'youtube' ? 'selected' : null}}>
                                @translate(Youtube)
                            </option>
                            <option value="vimeo" {{$product->provider == 'vimeo' ? 'selected' : null}}>
                                @translate(vimeo)
                            </option>
                        </select>
                    </div>

                    <div class="form-group mb-5">
                        <label>@translate(Promotion Video Url)</label>
                        <input class="form-control" type="url" name="video_url"
                               value="{{$product->video_url}}">
                    </div>

                    <div class="form-group">
                        <label>@translate(Meta title)</label>
                        <input class="form-control" type="text" name="meta_title"
                               value="{{$product->meta_title}}">
                    </div>

                    <div class="form-group">
                        <label>@translate(Meta Desc)</label>
                        <input class="form-control-lg w-100" type="text" name="meta_desc"
                               value="{{$product->meta_desc}}">
                    </div>
                    @if($product->meta_image != null)
                        <img src="{{filePath($product->meta_image)}}" width="80" height="80">
                    @endif

                    <div class="form-group mb5">
                        <label>@translate(Product featured image)</label>
                        <input type="hidden" name="meta_image" value="{{$product->meta_image}}">
                        <input name="newMetaImage" class="form-control-file" type="file">
                    </div>


                    <div class="form-group">
                        <label class="col-form-label">@translate(Tags)</label>
                        <input id="tags-input" type="text" name="tags[]"
                               value="@foreach(json_decode($product->tags) as $data){{$data}},@endforeach"
                               class="form-control w-100"
                               data-role="tagsinput">
                    </div>

                    {{--here the ecommerce check--}}
                    @if(!vendorActive())
                        <div class="form-group">
                            <label>@translate(Price) <small class="text-danger">*</small></label>

                            <input name="product_price" min="0" class="form-control" value="{{$product->product_price}}"
                                   type="number" step="0.01" required
                                   placeholder="@translate(Product price)">
                        </div>

                        <div class="form-group d-none">
                            <label>@translate(Purchase Price) <small class="text-danger">*</small></label>
                            <input name="purchase_price" value="{{$product->purchase_price}}" class="form-control"
                                   type="number"
                                   placeholder="@translate(purchase product price)">
                        </div>



                        <div class="form-group">
                            <label>
                                <input id="is_discount" name="is_discount"
                                       type="checkbox" {{$product->is_discount == 0 ? null: 'checked'}}>
                                @translate(has discount)?
                            </label>
                        </div>
                        <div class="form-group {{$product->is_discount == 0 ? 'd-none': null}}" id="discount_price">
                            <div class="row">
                                <div class="col">
                                    <label>@translate(Discounted Price)</label>
                                    <input name="discount_price" class="form-control" type="number"
                                           value="{{$product->discount_price}}"
                                           placeholder="@translate(Discounted price)">
                                </div>
                                <input type="hidden" name="discount_type" value="flat">
                            </div>
                        </div>

                    @endif


                    <div class="form-group">
                        <label> @translate(Add Tax)
                            <input class="add-tax" name="tax" type="checkbox" @if($product->tax != 0) checked @endif>
                        </label>
                    </div>


                    <div class="tax-input  @if($product->tax == 0) d-none @endif">
                        <div class="form-group">
                            <input type="hidden" class="tax-value-for-update" value="{{$product->tax}}">
                            <input class="form-control tax-input-val" type="number" name="tax" min="0"
                                   value="{{$product->tax}}" step="0.01"
                                   placeholder="@translate(Enter tax %)">
                        </div>
                    </div>


                    <div class="form-group">
                        <label>@translate(Select multiple images)</label>
                        <input name="images[]" class="form-control-file" type="file" multiple>
                    </div>
                    <div class="row">
                        @foreach($product->images as $item)
                            <div class="col-md-3 remove-{{$item->id}}">
                                <img src="{{filePath($item->image)}}" width="100" height="100">
                                <button type="button"
                                        onclick="removeImage('{{route('admin.products.image.remove',$item->id)}}')"
                                        class="btn btn-sm btn-danger">@translate(Remove)
                                </button>
                            </div>
                        @endforeach
                    </div>


                    <div class="form-group">
                        <label> @translate(Add Variant)
                            <input class="add-variant" type="checkbox" name="add_variant"
                                   @if($product->variants->count() >0 ) checked @endif>
                        </label>
                    </div>

                    <div class="row @if($product->variants->count() >0 ) rumon @else d-none @endif sr-variant">
                        {{--unit dropdown--}}
                        <strong class="text-info">@translate(If you select any variant you can't edit it, you can only
                            add new variant)</strong>
                        <div class="form-group col-12">
                            <label>@translate(Select variant)</label>
                            <select class="form-control select2" name="units[]" multiple id="units">
                                <option value=""></option>
                                @foreach($variants as $variant)
                                    <option value="{{ $variant->first()->unit }}" {{$product->variants->where('unit',$variant->first()->unit)->count() > 0 ? 'selected' : null}}>{{ $variant->first()->unit }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{--all varient--}}
                        @foreach($variants as $variant)
                            <div class="{{ $variant->first()->unit }} form-group col-12 {{$product->variants->where('unit',$variant->first()->unit)->count() > 0 ? null : 'd-none'}}">
                                <label>{{ $variant->first()->unit }}</label>
                                <select class="form-control colorVariant" name="variant_id[]" multiple>
                                    <option value=""></option>
                                    @foreach($variant as $var)
                                        <option value="{{$var->id}}" data-color="{{$var->code}}"
                                                {{$product->variants->where('variant_id',$var->id)->first() == null ? null:'selected'}}
                                                data-name="{{$var->variant}}">{{$var->variant}}</option>
                                        {{$var->unit}}
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">@translate(Save)</button>
            </form>
        </div>
    </div>



@endsection
