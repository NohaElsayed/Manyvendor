<div class="card-body">
    <form action="{{route('seller.categories.store')}}" method="post" enctype="multipart/form-data">

        @csrf
        <div class="form-group">
            <label>@translate(Parent category)</label>
            <select class="form-control select2 w-100" name="category_id" required>
                <option value="">@translate(Select a parent category)</option>
                @foreach($parentCategories as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>@translate(Name)</label>
            <input class="form-control" name="name" type="text" placeholder="@translate(Category name)" required>

        </div>


        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
        </div>

    </form>
</div>



