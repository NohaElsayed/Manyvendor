<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">@translate(Add Info page)</h3>
    </div>
    <div class="card-body">
        <form class="form-horizontal" enctype="multipart/form-data"
              action="{{ route('info.page.update') }}"
              method="POST">
            <input type="hidden" name="id" value="{{$infopage->id}}">
            @csrf
            <div class="form-group">
                <div class="">
                    <label class="control-label">@translate(Header) <span class="text-danger">*</span></label>
                </div>
                <div class="">
                    <input type="text" class="form-control" name="header" required value="{{$infopage->header}}"
                           placeholder="@translate(Ex: Header)">
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <label class="control-label">@translate(Icon)</label>
                </div>
                <div class="">
                    <input type="text" class="form-control" name="icon" required value="{{$infopage->icon}}"
                           placeholder="@translate(Ex: Icon class only)">
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <label class="control-label">@translate(Small text)</label>
                </div>
                <div class="">
                    <input type="text" class="form-control" name="desc" required value="{{$infopage->desc}}"
                           placeholder="@translate(Ex: small description)">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">@translate(Select Section)</label>
                <div class="">
                    <select class="form-control select2" name="section" required>
                        <option value="top" {{$infopage->section == "top" ? 'selected' : null}}>@translate(Top Section)</option>
                        <option value="bottom" {{$infopage->section == "bottom" ? 'selected' : null}}>@translate(Bottom Section)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">@translate(Select page)</label>
                <div class="">
                    <select class="form-control select2" name="page_id" required>
                        <option value=""></option>
                        @foreach($pages as $page)
                            <option
                                value="{{$page->id}}" {{$page->id == $infopage->page_id ? 'selected' :null}}> {{$page->title}}</option>
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
    </div>
</div>
