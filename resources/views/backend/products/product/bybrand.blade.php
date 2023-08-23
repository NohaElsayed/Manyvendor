<form action="{{ route('admin.product.bybrand.download') }}" method="GET" enctype="multipart/form-data">
    @csrf

    
    <div class="form-group">
                        <label>@translate(Select brand)</label>
                        <select class="form-control select2 parent-cat" name="brand_id" required>
                            <option value="">Select brand</option>
                            @foreach($brands as $brand)
                                <option
                                        value="{{$brand->id}}">{{$brand->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

    <button class="btn btn-primary" type="submit">@translate(Export)</button>
</form>
