<div class="card-body">
    <form action="{{route('brands.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$brand->id}}">
        <input type="hidden" name="logo" value="{{$brand->logo}}">
        <input type="hidden" name="banner" value="{{$brand->banner}}">
        <div class="form-group">
            <label>@translate(Name) <span class="text-danger">*</span></label>
            <input class="form-control" name="name" placeholder="@translate(Name)" required value="{{$brand->name}}">
        </div>


        @if($brand->logo != null)
            <img src="{{filePath($brand->logo)}}" class="img-thumbnail table-avatar">
        @endif

        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Logo)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image  only)"  name="new_logo" type="file">
                <small class="text-info">@translate(Recommended format: png, jpg, svg)</small>
            </div>
        </div>

        @if($brand->banner != null)
            <img src="{{filePath($brand->banner)}}" class="img-thumbnail table-avatar">
        @endif
        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Banner)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image only)"  name="new_banner" type="file">
                <small class="text-info">@translate(Recommended format: png, jpg, svg)</small>
            </div>
        </div>

        <div class="form-group">
            <label>@translate(Meta Title)</label>
            <input class="form-control" name="meta_title" type="text" max="100" placeholder="@translate(Meta Title)" value="{{$brand->meta_title}}">
            <small class="text-info">@translate(Google standard: 100 characters)</small>
        </div>

        <div class="form-group">
            <label>@translate(Meta Description)</label>
            <textarea class="form-control" name="meta_desc" maxlength="200" placeholder="@translate(Meta description)">{{$brand->meta_desc}}</textarea>
            <small class="text-info">@translate(Google standard: 200 characters)</small>
        </div>

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Update)</button>
        </div>


    </form>
</div>
