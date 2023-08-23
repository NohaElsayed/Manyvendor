@extends('install.app')
@section('content')

        <div class="card-body">
            <h2 class="text-lg-center p-3">@translate(Setup Site Setting)</h2>
            <form method="post" action="{{route('org.setup')}}" enctype="multipart/form-data">
            @csrf


                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <!--logo-->
                        <label class="label">@translate(Site logo)</label>
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
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--favicon icon-->
                        <label class="label">@translate(Favicon Icon)</label>
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
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--name-->
                        <label class="label">@translate(Site Name)</label>
                        <input type="hidden" required value="type_name" name="type_name">
                        <input type="text"  name="name"
                               class="form-control">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--footer-->
                        <label class="label">@translate(Site Footer)</label>
                        <input type="hidden" required value="type_footer" name="type_footer">
                        <input type="text"  name="footer"
                               class="form-control">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--address-->
                        <label class="label">@translate(Address)</label>
                        <input type="hidden" value="type_address" name="type_address">
                        <input type="text"  name="address"
                               class="form-control">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--mail-->
                        <label class="label">@translate(Mail)</label>
                        <input type="hidden" value="type_mail" name="type_mail">
                        <input type="text"  name="mail"
                               class="form-control">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--fb-->
                        <label class="label">@translate(Facebook Link)</label>
                        <input type="hidden" value="type_fb" name="type_fb">
                        <input type="text"  name="fb"
                               class="form-control">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--tw-->
                        <label class="label">@translate(Twitter Link)</label>
                        <input type="hidden" value="type_tw" name="type_tw">
                        <input type="text"  name="tw"
                               class="form-control">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--google-->
                        <label class="label">@translate(Instagram Link)</label>
                        <input type="hidden" value="type_google" name="type_google">
                        <input type="text"  name="google"
                               class="form-control">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--Number-->
                        <label class="label">@translate(Phone Number)</label>
                        <input type="hidden" value="type_number" name="type_number">
                        <input type="text"  name="number"
                               class="form-control">
                    </div>

                </div>























                <div class="m-2">
                    <button class="btn btn-block btn-primary" type="submit">@translate(Save)</button>
                </div>
            </form>

        </div>



@endsection
