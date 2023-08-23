<div class="card-body">
    <form action="{{route('admin.campaign.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$campaign->id}}">
        <input type="hidden" name="logo" value="{{$campaign->banner}}">
        <input type="hidden" name="banner" value="{{$campaign->meta_image}}">
        @csrf
        <div class="form-group">
            <label>@translate(Title) <span class="text-danger">*</span></label>
            <input class="form-control" name="title" placeholder="@translate(Title)" value="{{$campaign->title}}" required>
        </div>

        @if($campaign->banner != null)
            <img src="{{filePath($campaign->banner)}}" class="img-thumbnail table-avatar">
        @endif
        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Banner)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image  only)"  name="new_banner" type="file">
                <small class="text-info">@translate(Recommended format: png, jpg, svg)</small>
            </div>
        </div>

        <div class="form-group">
            <label>@translate(Sale Off %)</label>
            <input class="form-control" name="offer" type="number" max="100" placeholder="@translate(Offer %)" value="{{$campaign->offer}}" required>
        </div>

        <div class="form-group">
            <label>@translate(Starting From)</label>
                <div class="input-group date" id="datetimepicker5" data-target-input="nearest">
                    <input type="text" name="start_from" value="{{$campaign->start_from}}" class="form-control datetimepicker-input" data-target="#datetimepicker5"  placeholder="@translate(Starting From)" required/>
                        <div class="input-group-append form-group" data-target="#datetimepicker5" data-toggle="datetimepicker">
                            <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i></div>
                        </div>
                </div>
        </div>
    
                <div class="form-group">
                    <label>@translate(End at)</label>
                        <div class="input-group date" id="datetimepicker6" data-target-input="nearest">
                            <input type="text" name="end_at" value="{{$campaign->end_at}}" class="form-control datetimepicker-input" data-target="#datetimepicker6"  placeholder="@translate(End at)" required/>
                                <div class="input-group-append form-group" data-target="#datetimepicker6" data-toggle="datetimepicker">
                                    <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i></div>
                                </div>
                        </div>
                </div>

        <div class="form-group">
            <label>@translate(Meta Title)</label>
            <input class="form-control" name="meta_title" type="text" max="100" placeholder="@translate(Meta Title)" value="{{$campaign->meta_title}}">
            <small class="text-info">@translate(Google standard: 100 characters)</small>
        </div>

        <div class="form-group">
            <label>@translate(Meta Description)</label>
            <input class="form-control form-control-lg" name="meta_desc" max="200" placeholder="@translate(Meta Description)" value="{{$campaign->meta_desc}}">
            <small class="text-info">@translate(Google standard: 200 characters)</small>
        </div>

        @if($campaign->meta_image != null)
            <img src="{{filePath($campaign->meta_image)}}" class="img-thumbnail table-avatar">
        @endif
        <div class="form-group">
            <label class="col-form-label text-md-right">@translate(Meta Image)</label>
            <div class="">
                <input class="form-control-file sr-file" placeholder="@translate(Choose Image  only)"  name="new_meta_image" type="file">
                <small class="text-info">@translate(Recommended format: png, jpg, svg)</small>
            </div>
        </div>

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Update)</button>
        </div>
    </form>
</div>


