<div class="card-body">
    <form action="{{route('categories.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$category->id}}">
        <input type="hidden" name="parent_id" value="{{$category->parent_category_id}}">
        <input type="hidden" name="image" value="{{$category->image}}">
        <input type="hidden" name="slug" value="{{$category->slug}}">
        <div class="form-group">
            <label>@translate(Name) <span class="text-danger">*</span></label>
            <input class="form-control" name="name" placeholder="@translate(Name)" required value="{{$category->name}}">
        </div>


        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Icon Class)</label>
            <div class="custom-file">
                <input class="form-control" value="{{$category->icon}}" name="icon" type="text">
                <small>@translate(Want more icon) ? <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">Font
                        Awesome</a></small>
            </div>
        </div>

        @if($category->image != null)
            <img src="{{filePath($category->image)}}" width="80" height="80" class="img-thumbnail">
        @endif
        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Image)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image  only)" name="newImage"
                       type="file">
                <small class="text-info">@translate(Upload file Recommended png, jpg, svg format)</small>
            </div>
        </div>
        @if(vendorActive())
            <div class="form-group">
                <label>@translate(Select commission)</label>
                <select class="form-control select2 w-100" name="commission_id" required>
                    <option value="">@translate(Select commission)</option>
                    @foreach($commissions as $item)
                        <option
                            value="{{$item->id}}" {{$category->commission_id == $item->id ? 'selected':null}}>{{$item->amount}}
                            %
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="form-group">
            <label>@translate(Meta Title)</label>
            <input class="form-control" name="meta_title" value="{{$category->meta_title}}" type="text" max="100"
                   placeholder="@translate(Meta title)">
            <small class="text-info">@translate(Google standard 100 characters)</small>
        </div>

        <div class="form-group">
            <label>@translate(Meta Description)</label>
            <input class="form-control form-control-lg" name="meta_desc" max="200" value="{{$category->meta_desc}}">
            <small class="text-info">@translate(Google standard 200 characters)</small>
        </div>

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Update)</button>
        </div>

    </form>
</div>
