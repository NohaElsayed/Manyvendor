<form action="{{ route('admin.product.import.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label class="col-form-label">@translate(Import)</label>
        <input required type="file"class="form-control" placeholder="@translate(Import product)" name="product_import">
    </div>

    <button class="btn btn-primary" type="submit">@translate(Save)</button>
</form>
