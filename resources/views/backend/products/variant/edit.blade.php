<form action="{{route('variants.update')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$variant->id}}">
    <div class="form-group">
        <label class="col-form-label">@translate(Variant Unit)</label>
        <input required value="{{ old('unit') }}" type="text"
               class="form-control @error('unit') is-invalid @enderror"
               value="{{$variant->unit}}" name="unit">
        @error('unit')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>

    <div class="form-group">
        <label class="col-form-label">@translate(Variants)</label>
        <input id="tags-input" type="text" name="variant" value="
          @foreach($variant->variant as $data){{$data}},@endforeach" class="form-control w-100"
               data-role="tagsinput">
    </div>

    <button class="btn btn-primary" type="submit">@translate(Save)</button>
</form>
