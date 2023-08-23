<form class="form-horizontal" enctype="multipart/form-data"
      action="{{ route('modules.update') }}"
      method="POST">
    @csrf
 <input type="hidden" name="id" value="{{$module->id}}">
    <div class="form-group">
        <div class="">
            <label class="control-label">@translate(Name) <span class="text-danger">*</span></label>
        </div>
        <div class="">
            <input type="text" class="form-control" name="name" required
                   value="{{$module->name}}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label">@translate(Select permissions) <span
                class="text-danger">*</span></label>
        <div class="">
            <select class="form-control select2" name="p_id[]" multiple required>
                <option value=""></option>
                @foreach($permissions as $permission)
                        <option value="{{$permission->id}}"
                        @foreach($module->permissions as $per)
                             {{$permission->id == $per->permission_id ? 'selected': null}}
                            @endforeach
                        > {{$permission->name}}</option>

                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-12 text-right">
            <button class="btn btn-primary btn-block" type="submit">@translate(Save)
            </button>
        </div>
    </div>
</form>
