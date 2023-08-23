@extends('backend.layouts.master')
@section('title') @translate(Slider Widget Promotions) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Add New Slider Widget Promotions)</h3>
        </div>
            <div class="card-body">
                <form action="{{ route('header.promotion.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>@translate(Category Select) <small>(@translate(Optional))</small></label>
                        <select class="form-control select2" name="category_id">
                            <option value=""></option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <small class="text-warning">*@translate(if you choose a category, this will be displayed as slider in category wise products section).</small>
                    </div>

                    <div class="form-group">
                        <label>@translate(Link) <span class="text-danger">*</span></label>
                        <input class="form-control" name="link" placeholder="@translate(Link)">
                    </div>

                    <div class="form-group">
                        <label id="customFile" class="col-form-label text-md-right">@translate(Image)</label>
                        <div class="">
                            <input id="customFile" class="form-control lh-1"
                                   placeholder="@translate(Choose Image  only)" name="image" type="file" required>
                            <small class="text-info">@translate(Upload file Recommended png, jpg, svg format)</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label> @translate(Publish?)
                            <input class="add-variant" type="checkbox" name="is_published">
                        </label>
                    </div>

                    <div class="float-right">
                        <button class="btn btn-primary float-right" type="submit">@translate(Save)</button>
                    </div>

                </form>
            </div>
    </div>




    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Slider Widgets Lists)</h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-2">
            <div class="row">
                @forelse (promotionBannersForBackend('header') as $slider)
                    <div class="col-md-6 col-xl-4 mb-3">
                        <div class="card card-primary  p-3">
                            <div class="col">
                                <div class="">
                                    <img class="card-img-top" src="{{ filePath($slider->image) }}" alt="Card image cap">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input data-id="{{$slider->id}}"
                                               {{ $slider->is_published == true ? 'checked' : null }}  data-url="{{ route('promotion.activation') }}"
                                               type="checkbox" class="custom-control-input is_published"
                                               id="is_published_{{$slider->id}}">
                                        <label class="custom-control-label" for="is_published_{{$slider->id}}"></label>
                                    </div>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                        <li>
                                            <a href="#!" class="nav-link text-black"
                                               onclick="forModal('{{ route('header.promotion.edit', $slider->id) }}', '@translate(Edit)')">@translate(Edit)</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#!" class="nav-link text-black"
                                               onclick="confirm_modal('{{ route('promotions.destroy', $slider->id) }}')">@translate(Delete)</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ml-3 text-danger">
                        @translate(No Widget Found)
                    </div>
                @endforelse
            </div>
            
            {{ promotionBannersForBackend('header')->links() }}

        </div>
    </div>


@endsection
