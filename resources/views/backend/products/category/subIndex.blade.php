@extends('backend.layouts.master')
@section('title') @translate(Sub Categories)
@endsection
@section('parentPageTitle', 'All category')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title font-weight-bold"></h2>
                <h2 class="card-title"><span><a class="btn btn-sm btn-secondary" href="{{route('parent.categories.index',[$category->parent->id,$category->parent->slug])}}"><i class="fa fa-reply"></i> </a></span> @translate(Parent category) : <span class="font-weight-bold">{{$category->name}}</span></h2>
            </div>
            <div class="float-right">
                <a href="#!"
                   onclick="forModal('{{ route('categories.create',[$category->id,$category->slug]) }}', '@translate(Add category)');"
                   class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    @translate(Add sub-category)
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover text-center datatable">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th class="text-left">@translate(Sub-category)</th>
                    @if(vendorActive())
                    <th class="text-left">@translate(Commission)</th>
                    @endif
                    <th>@translate(Icon class)</th>
                    <th>@translate(Image)</th>
                    <th>@translate(Trending)</th>
                    <th>@translate(Publish)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sub_categories as  $sub)
                    <tr>
                        <td>{{ ($loop->index+1)}}</td>
                        <td class="text-left">{{$sub->name}}</td>
                        @if(vendorActive())
                        <td  class="text-left">
                            @if($sub->commission != null)
                            {{$sub->commission->amount ?? ''}} {{$sub->commission->type == "percentage" ? '%':''}}
                            @else
                                @translate(Commission is not selected)
                            @endif

                        </td>
                        @endif
                        <td class="text-center">
                            @if($sub->icon != null)
                                <i class="{{$sub->icon}}"></i>
                            @endif
                        </td>

                        <td>
                            @if($sub->image != null)
                                <img src="{{filePath($sub->image)}}" width="80" height="80"
                                     class="img-thumbnail" alt="{{$sub->name}}">
                            @endif
                        </td>
                        <td>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$sub->id}}"
                                           {{$sub->is_popular == true ? 'checked' : null}}  data-url="{{route('categories.popular')}}"
                                           type="checkbox" class="custom-control-input"
                                           id="is_popular_{{$sub->id}}">
                                    <label class="custom-control-label" for="is_popular_{{$sub->id}}"></label>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$sub->id}}"
                                           {{$sub->is_published == true ? 'checked' : null}}  data-url="{{route('categories.published')}}"
                                           type="checkbox" class="custom-control-input"
                                           id="is_published_{{$sub->id}}">
                                    <label class="custom-control-label" for="is_published_{{$sub->id}}"></label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                                    <li><a class="nav-link text-black"  href="#!" onclick="forModal('{{ route('categories.edit', [$sub->id,$sub->slug]) }}', '{{$sub->name}}');">@translate(Edit)</a></li>
                                    <li class="divider"></li>
                                    <li><a class="nav-link text-black" href="#!"
                                           onclick="confirm_modal('{{ route('categories.destroy', $sub->id) }}')">@translate(Delete)</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9"><h3 class="text-center">@translate(No Data Found)</h3></td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

@endsection
