<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">@translate(Page Group Update)</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-2">
        <form action="{{route('pages.group.update')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$page_group->id}}">
            <div class="form-group">
                <label class="col-form-label">@translate(Name)</label>
                <input type="text" name="name" value="{{$page_group->name}}" required class="form-control w-100">
            </div>


            <button class="btn btn-primary" type="submit">@translate(Save)</button>
        </form>
    </div>
</div>

