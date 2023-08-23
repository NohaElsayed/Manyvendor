<div class="card-body">
    <form action="{{route('group.categories.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>@translate(Name) <span class="text-danger">*</span></label>
            <input class="form-control" name="name" placeholder="@translate(Name)" required>
        </div>

        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Icon Class)</label>
            <div class="custom-file">
                <input class="form-control" placeholder="fa fa-address-book-o"  name="icon" type="text">
                <small>@translate(Want more icon) ? <a href="https://fontawesome.com/v4.7.0/icons/"  target="_blank">Font Awesome</a></small>
            </div>
        </div>

        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Image)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image  only)"   name="image" type="file">
                <small class="text-info">@translate(Upload file Recommended png, jpg, svg format)</small>
            </div>
        </div>

        <div class="form-group">
            <label>@translate(Meta Title)</label>
            <input class="form-control" name="meta_title" type="text" max="100" placeholder="@translate(Meta title)">
            <small class="text-info">@translate(Google standard 100 characters)</small>
        </div>

        <div class="form-group">
            <label>@translate(Meta Description)</label>
            <input class="form-control form-control-lg" name="meta_desc" max="200" placeholder="@translate(Meta description)">
            <small class="text-info">@translate(Google standard 200 characters)</small>
        </div>

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>



