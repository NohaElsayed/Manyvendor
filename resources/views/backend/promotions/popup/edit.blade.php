<div class="card-body">
    <form action="{{ route('popup.promotion.update',$popup_edit->id) }}" method="post"
          enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>@translate(Category Select)</label>
            <select class="form-control select2" name="category_id">
                <option value=""></option>
                @foreach($categories as $category)
                    <option
                        value="{{$category->id}}" {{ $popup_edit->category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                @endforeach
            </select>
            <small>@translate(if you choose a category, this will display at category slider).</small>
        </div>

        <div class="form-group">
            <label>@translate(Link) <span class="text-danger">*</span></label>
            <input class="form-control" name="link" value="{{ $popup_edit->link }}"
                   placeholder="@translate(Link)">
        </div>
S

        <div class="form-group">
            <label id="customFile" class="col-form-label text-md-right">@translate(Current Image)</label>
            <div class="">
                <input name="oldImage" type="hidden" value="{{ $popup_edit->image }}">
                <img src="{{ filePath($popup_edit->image) }}" alt="#Main Slider" class="img-fluid">
            </div>
        </div>

        <div class="form-group">
            <label id="customFile" class="col-form-label text-md-right">@translate(Image)</label>
            <div class="">
                <input id="customFile" class="form-control lh-1" placeholder="@translate(Choose Image  only)"
                       name="image" type="file">
                <small class="text-info">@translate(Upload file Recommended png, jpg, svg format)</small>
            </div>
        </div>

        <div class="form-group">
            <label> @translate(Publish?)
                <input class="add-variant" type="checkbox"
                       name="is_published" {{ $popup_edit->is_published == 1 ? 'checked' : ''}}>
            </label>
        </div>

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>
