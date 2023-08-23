<div class="card-body pt-0">
    <form action="{{route('admin.campaign.reCampaignStore')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$campaign->id}}">
        <span class="text-warning">*@translate(All existing products will be removed from this campaign).</span>

        <div class="form-group">
            <label>@translate(Starting From)</label>
                <div class="input-group date" id="datetimepicker13" data-target-input="nearest">
                    <input type="text" name="start_from" value="{{$campaign->start_from}}" class="form-control datetimepicker-input" data-target="#datetimepicker13"  placeholder="@translate(Starting From)" required/>
                        <div class="input-group-append form-group" data-target="#datetimepicker13" data-toggle="datetimepicker">
                            <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i></div>
                        </div>
                </div>
        </div>
        
        
                <div class="form-group">
                    <label>@translate(End at)</label>
                        <div class="input-group date" id="datetimepicker14" data-target-input="nearest">
                            <input type="text" name="end_at" value="{{$campaign->end_at}}" class="form-control datetimepicker-input" data-target="#datetimepicker6"  placeholder="@translate(End at)" required/>
                                <div class="input-group-append form-group" data-target="#datetimepicker14" data-toggle="datetimepicker">
                                    <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i></div>
                                </div>
                        </div>
                </div>

        <div class="float-right">
            <button class="btn btn-primary float-right" type="submit">@translate(Re-campaign)</button>
        </div>
    </form>
</div>

@section('script')
    <script type="text/javascript" src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <link type="text/javascript" src="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}"/>
    <script type="text/javascript">
        "use strict"
        $(function () {
            $('#datetimepicker13, #datetimepicker14').datetimepicker();
        });
    </script>
@endsection
