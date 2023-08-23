<div class="card-body">
    <form action="{{ route('main.slider.update',$main_slider_edit->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>@translate(Category Select)</label>
            <select class="form-control select2" name="category_id">
                <option value=""></option>
                @foreach($categories as $category)
                    <option
                        value="{{$category->id}}" {{ $main_slider_edit->category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                @endforeach
                <small>@translate(if you choose a category, this will display at category slider).</small>
            </select>
        </div>

        <div class="form-group">
            <label>@translate(Link) <span class="text-danger">*</span></label>
            <input class="form-control" name="link" value="{{ $main_slider_edit->link }}"
                   placeholder="@translate(Link)">
        </div>


        <div class="form-group">
            <label id="customFile" class="col-form-label text-md-right">@translate(Current Image)</label>
            <div class="">
                <input name="oldImage" type="hidden" value="{{ $main_slider_edit->image }}">
                <img src="{{ filePath($main_slider_edit->image) }}" alt="#Main Slider">
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
                       name="is_published" {{ $main_slider_edit->is_published == 1 ? 'checked' : ''}}>
            </label>
        </div>

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>
