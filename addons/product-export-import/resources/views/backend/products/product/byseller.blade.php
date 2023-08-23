<form action="{{ route('admin.product.byseller.download') }}" method="GET" enctype="multipart/form-data">
    @csrf

    
    <div class="form-group">
                        <label>@translate(Select seller)</label>
                        <select class="form-control select2 parent-cat" name="seller_id" required>
                            <option value="">Select seller</option>
                            @foreach($sellers as $seller)
                                <option
                                        value="{{$seller->user_id}}">{{$seller->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

    <button class="btn btn-primary" type="submit">@translate(Export)</button>
</form>
