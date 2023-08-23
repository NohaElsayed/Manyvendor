@extends('backend.layouts.master')
@section('title')@endsection
<title>{{getSystemSetting('type_name')}} | General settings</title>
@section('content')
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="card m-2">
                <div class="card-header">
                    <h2 class="card-title">@translate(general Settings)</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('site.update')}}" enctype="multipart/form-data">
                    @csrf

                    <!--logo-->
                        <label class="label">@translate(Logo)</label>
                        <input type="hidden" value="type_logo" name="type_logo">

                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="logo" id="imageUpload" accept=".png, .jpg, .jpeg"/>
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview"
                                     style="background-image: url({{filePath(getSystemSetting('type_logo'))}});">
                                </div>
                            </div>
                        </div>
                        <!--logo end-->



                        <!--favicon icon-->
                        <label class="label">@translate(Favicon)</label>
                        <input type="hidden" value="favicon_icon" name="favicon_icon">


                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="f_icon" id="imageUpload_f_icon" accept=".png, .jpg, .jpeg"/>
                                <label for="imageUpload_f_icon"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview_f_icon"
                                     style="background-image: url({{filePath(getSystemSetting('favicon_icon'))}}">
                                </div>
                            </div>
                        </div>
                        <!--favicon end-->

                        <!--name-->
                        <label class="label my-2">@translate(Organization Name)</label>
                        <input type="hidden" value="type_name" name="type_name">
                        <input type="text" value="{{getSystemSetting('type_name')}}" name="name"
                               class="form-control" placeholder="Name">

                        <!--footer-->
                        <label class="label my-2">@translate(Organization Footer)</label>
                        <input type="hidden" value="type_footer" name="type_footer">
                        <input type="text" value="{{getSystemSetting('type_footer')}}" name="footer"
                               class="form-control" placeholder="Footer text">

                        <!--address-->
                        <label class="label my-2">@translate(Address)</label>
                        <input type="hidden" value="type_address" name="type_address">
                        <textarea name="address"
                                  class="form-control" rows="3" placeholder="Address">{{getSystemSetting('type_address')}}</textarea>
                        <!--mail-->
                        <label class="label mt-4">@translate(Organization Mail)</label>
                        <input type="hidden" value="type_mail" name="type_mail">
                        <input type="text" value="{{getSystemSetting('type_mail')}}" name="mail"
                               class="form-control" placeholder="Email">

                        <!--fb-->
                        <label class="label my-2">@translate(Organization Facebook Link)</label>
                        <input type="hidden" value="type_fb" name="type_fb">
                        <input type="text" value="{{getSystemSetting('type_fb')}}" name="fb"
                               class="form-control" placeholder="https://www.facebook.com/example">

                        <!--tw-->
                        <label class="label my-2">@translate(Organization Twitter Link)</label>
                        <input type="hidden" value="type_tw" name="type_tw">
                        <input type="text" value="{{getSystemSetting('type_tw')}}" name="tw"
                               class="form-control"  placeholder="https://www.twitter.com/example">

                        <!--google-->
                        <label class="label my-2">@translate(Organization Google Link)</label>
                        <input type="hidden" value="type_google" name="type_google">
                        <input type="text" value="{{getSystemSetting('type_google')}}" name="google"
                               class="form-control" placeholder="https://www.google.com/example">

                        <!--Number-->
                        <label class="label my-2">@translate(Organization Number )</label>
                        <input type="hidden" value="type_number" name="type_number">
                        <input type="text" value="{{getSystemSetting('type_number')}}" name="number"
                               class="form-control"  placeholder="Number">

                        <!--android app image-->
                        <label class="label mt-3">@translate(Playstore Image)</label>
                        <input type="hidden" value="type_playstore" name="type_playstore">

                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="playstoreImg" id="imageUpload_Playstore" accept=".png, .jpg, .jpeg"/>
                                <label for="imageUpload_Playstore"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview_Playstore"
                                     style="background-image: url({{filePath(getSystemSetting('type_playstore'))}});">
                                </div>
                            </div>
                        </div>
                        <!--android app image end-->
                        <!--android app-->
                        <label class="label my-2">@translate(Android App Link)</label>
                        <input type="hidden" value="type_android" name="type_android">
                        <input type="text" value="{{getSystemSetting('type_android')}}" name="android"
                               class="form-control" placeholder="https://www.example.com/example">


                        <!--android app image-->
                        <label class="label mt-3">@translate(Appstore Image)</label>
                        <input type="hidden" value="type_appstore" name="type_appstore">

                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="appstoreImg" id="imageUpload_Appstore" accept=".png, .jpg, .jpeg"/>
                                <label for="imageUpload_Appstore"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview_Appstore"
                                     style="background-image: url({{filePath(getSystemSetting('type_appstore'))}});">
                                </div>
                            </div>
                        </div>
                        <!--ios app image end-->
                        <!--ios app-->
                        <label class="label my-2">@translate(IOS App Link)</label>
                        <input type="hidden" value="type_ios" name="type_ios">
                        <input type="text" value="{{getSystemSetting('type_ios')}}" name="ios"
                               class="form-control" placeholder="https://www.example.com/example">

                        <div class="m-2 float-right">
                            <button class="btn btn-block btn-primary" type="submit">@translate(Save)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection



