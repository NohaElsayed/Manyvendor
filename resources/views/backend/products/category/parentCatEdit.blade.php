<div class="card-body">
    <form action="{{route('parent.categories.update')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{$category->id}}">
        <input type="hidden" name="slug" value="{{$category->slug}}">
        @csrf
        <div class="form-group">
            <label>@translate(Name) <span class="text-danger">*</span></label>
            <input class="form-control" name="name" value="{{$category->name}}" required>
        </div>

        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Icon Class)</label>
            <div class="custom-file">
                <input class="form-control" value="{{$category->icon}}" name="icon" type="text">
                <small>@translate(Want more icon) ? <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">Font Awesome</a></small>
            </div>
        </div>
        <div class="form-group">
            <input name="image" type="hidden" value="{{$category->image}}">
            <img src="{{filePath($category->image)}}" width="80" height="80" class="img-bordered">
        </div>
        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Image)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image  only)" name="newImage"
                       type="file">
                <small class="text-info">@translate(Upload file Recommended png, jpg, svg format)</small>
            </div>
        </div>

        <div class="form-group">
            <label>@translate(Meta Title)</label>
            <input class="form-control" name="meta_title" type="text" max="100" value="{{$category->meta_title}}">
            <small class="text-info">@translate(Google standard 100 characters)</small>
        </div>

        <div class="form-group">
            <label>@translate(Meta Description)</label>
            <input class="form-control form-control-lg" name="meta_desc" max="200" value="{{$category->meta_desc}}">
            <small class="text-info">@translate(Google standard 200 characters)</small>
        </div>
        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>
    </form>
</div>




