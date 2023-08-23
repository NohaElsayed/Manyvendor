<form action="{{ route('admin.product.bycategory.download') }}" method="GET" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
                        <label>@translate(Select category)</label>
                        <select class="form-control select2 parent-cat" name="category_id" required>
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option
                                        value="{{$cat->id}}">{{$cat->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

    <button class="btn btn-primary" type="submit">@translate(Export)</button>
</form>
