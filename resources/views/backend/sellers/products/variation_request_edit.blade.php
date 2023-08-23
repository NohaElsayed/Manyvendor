<div class="card-body">
    <form action="{{ route('admin.variation.update', $variation_request_edit->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>@translate(Variantion Select)</label>
            
                            <select required class="form-control select2" name="unit" id="unit">
                                <option value="">@translate(Select unit)</option>
                                <option value="Size" {{ $variation_request_edit->unit == 'Size' ? 'selected' : '' }}>@translate(Size)</option>
                                <option value="Color" {{ $variation_request_edit->unit == 'Color' ? 'selected' : '' }}>@translate(Color)</option>
                                <option value="Fabric" {{ $variation_request_edit->unit == 'Fabric' ? 'selected' : '' }}>@translate(Fabric)</option>
                                <option value="Wheel" {{ $variation_request_edit->unit == 'Wheel' ? 'selected' : '' }}>@translate(Wheel)</option>
                                <option value="Weight" {{ $variation_request_edit->unit == 'Weight' ? 'selected' : '' }}>@translate(Weight)</option>
                                <option value="Capacity" {{ $variation_request_edit->unit == 'Capacity' ? 'selected' : '' }}>@translate(Capacity)</option>
                                <option value="Sleeve" {{ $variation_request_edit->unit == 'Sleeve' ? 'selected' : '' }}>@translate(Sleeve)</option>
                                <option value="Lace" {{ $variation_request_edit->unit == 'Lace' ? 'selected' : '' }}>@translate(Lace)</option>
                                <option value="Bulbs" {{ $variation_request_edit->unit == 'Bulbs' ? 'selected' : '' }}>@translate(Bulbs)</option>
                            </select>

        </div>

        <div class="form-group">
            <label>@translate(Variant) <span class="text-danger">*</span></label>
            <input class="form-control" name="variant" value="{{ $variation_request_edit->variant }}"
                   placeholder="@translate(Variant)">
        </div>


        @if (isset($variation_request_edit->code))
            <div class="form-group">
            <label>@translate(Code) <span class="text-danger">*</span></label>
            <input class="form-control my-colorpicker2" name="code" value="{{ $variation_request_edit->code }}"
                   placeholder="@translate(Code)">
            </div>
        @endif



        


      

       

        

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>
