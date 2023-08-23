@extends('backend.layouts.master')
<title>{{getSystemSetting('type_name')}} | @translate(Socialite Setup)</title>
@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">
            <form method="post" action="{{route('socialite.env.store')}}">
                @csrf
                <div class="card mt-2">
                    <div class="card-header">
                        <h2 class="card-title"> <i class="fa fa-google text-danger"></i> <i class="mx-2 fa fa-facebook-square text-primary"></i>@translate(Setup Social Media Login)</h2>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fa fa-facebook-square text-primary"></i> @translate(Facebook)</h2>
                    </div>
                    <div class="card-body">
                        <label class="label" for="fb_client">@translate(Facebook Api Client Id) <a href="https://developers.facebook.com/apps/" target="_blank" class="ml-2"><i class="fa fa-info text-warning"></i></a></label>
                        <input type="hidden" name="types[]" value="FACEBOOK_CLIENT_ID">
                        <input id="fb_client" type="text" placeholder="@translate(Enter the data)" value="{{env('FACEBOOK_CLIENT_ID')}}"
                               name="FACEBOOK_CLIENT_ID"
                               class="form-control mb-2">

                        <label class="label" for="fb_secret">@translate(Facebook App Secret)</label>
                        <input type="hidden" name="types[]" value="FACEBOOK_SECRET">
                        <input id="fb_secret" type="text" placeholder="@translate(Enter the data)" value="{{env('FACEBOOK_SECRET')}}"
                               name="FACEBOOK_SECRET"
                               class="form-control mb-2">

                        <input type="hidden" name="types[]" value="FACEBOOK_CALLBACK">
                        <input type="hidden" placeholder="@translate(Enter the data)" value="{{env('APP_URL').'/callback/facebook'}}" name="FACEBOOK_CALLBACK">
                        <p>@translate(Redirect Url) : {{env('FACEBOOK_CALLBACK')}}</p>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h2 class="card-title"> <i class="fa fa-google text-danger"></i> @translate(Google)</h2>
                    </div>
                    <div class="card-body">
                        <label class="label" for="ggl_client">@translate(Google Api Client Id) <a href="https://developers.google.com/identity/one-tap/web/guides/get-google-api-clientid" target="_blank" class="ml-2"><i class="fa fa-info text-warning"></i></a></label>
                        <input type="hidden" name="types[]" value="GOOGLE_CLIENT_ID">
                        <input id="ggl_client" type="text" placeholder="@translate(Enter the data)" value="{{env('GOOGLE_CLIENT_ID')}}"
                               name="GOOGLE_CLIENT_ID"
                               class="form-control mb-2">

                        <label class="label" for="ggl_secret">@translate(Google App Secret)</label>
                        <input type="hidden" name="types[]" value="GOOGLE_SECRET">
                        <input id="ggl_secret" type="text" placeholder="@translate(Enter the data)" value="{{env('GOOGLE_SECRET')}}"
                               name="GOOGLE_SECRET"
                               class="form-control mb-2">

                        <input type="hidden" name="types[]" value="GOOGLE_CALLBACK">
                        <input type="hidden" value="{{env('APP_URL').'/callback/google'}}"  name="GOOGLE_CALLBACK">
                        <p>@translate(Redirect Url) : {{env('GOOGLE_CALLBACK')}}</p>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary px-5 mb-3" type="submit">@translate(Save)</button>
                </div>

            </form>
        </div>
    </div>


@endsection



@section('js-link')

@stop

@section('page-script')
@stop
