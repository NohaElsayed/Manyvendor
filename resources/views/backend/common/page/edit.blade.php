<div class="card-body">
    <form action="{{route('pages.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$page->id}}">
        <div class="form-group">
            <select class="form-control select2" name="page_group_id" required>
                <option>@translate(Select Group)</option>
                @foreach($pageGroups as $item)
                    <option value="{{$item->id}}" {{$page->page_group_id == $item->id ? 'selected':null}}>{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>@translate(Page Title) <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="title" value="{{$page->title}}" required>
        </div>
        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>

