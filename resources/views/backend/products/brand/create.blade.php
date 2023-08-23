<div class="card-body">
    <form action="{{route('brands.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>@translate(Name) <span class="text-danger">*</span></label>
            <input class="form-control" name="name" placeholder="@translate(Name)" required>
        </div>

        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Logo)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image  only)"  name="logo" type="file">
                <small class="text-info">@translate(Recommended format: png, jpg, svg)</small>
            </div>
        </div>

        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Banner)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image only)"  name="banner" type="file">
                <small class="text-info">@translate(Recommended format: png, jpg, svg)</small>
            </div>
        </div>

        <div class="form-group">
            <label>@translate(Meta Title)</label>
            <input class="form-control" name="meta_title" type="text" max="100" placeholder="@translate(Meta Title)">
            <small class="text-info">@translate(Google standard: 100 characters)</small>
        </div>

        <div class="form-group">
            <label>@translate(Meta Description)</label>
            <input class="form-control form-control-lg" name="meta_desc" max="200" placeholder="@translate(Meta Description)">
            <small class="text-info">@translate(Google standard: 200 characters)</small>
        </div>

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>
