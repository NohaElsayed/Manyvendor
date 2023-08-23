@extends('backend.layouts.master')
@section('title') @translate(Parent Categories)
@endsection
@section('parentPageTitle', 'All Category')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title"><span><a class="btn btn-sm btn-secondary" href="{{route('categories.index')}}"><i class="fa fa-reply"></i> </a></span> @translate(Category Group): <span class=" font-weight-bold">{{$cat->name}}</span></h2>
            </div>
            <div class="float-right">
                <div class="row text-right">
                    <div class="col">
                        <a href="#!"
                           onclick="forModal('{{ route("parent.categories.create",[$cat->id,$cat->slug]) }}', '@translate(Add parent category)');"
                           class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            @translate(Add parent category)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th class="text-left">@translate(Category)</th>
                    <th class="text-left">@translate(Sub category)</th>
                    <th>@translate(Icon class)</th>
                    <th>@translate(Image)</th>
                    <th>@translate(Publish)</th>
                    <th>@translate(View)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as  $item)
                    <tr>
                        <td>{{$loop->index+1 }}</td>
                        <td class="text-left">{{$item->name}}</td>
                        <td  class="text-left">
                            @forelse($item->childrenCategories as $cat)
                                <span class="badge badge-primary"><a class="text-white" href="{{route('child.categories.index',[$item->id,$item->slug])}}">{{$cat->name }}</a></span><br>
                            @empty
                                N/A
                            @endforelse
                        </td>
                        <td class="text-center">
                            @if($item->icon != null)
                                <i class="{{$item->icon}}"></i>
                            @endif
                        </td>

                        <td>
                            @if($item->image != null)
                                <img src="{{filePath($item->image)}}" width="80" height="80"
                                     class="img-thumbnail" alt="{{$item->name}}">
                            @endif
                        </td>

                        <td>
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$item->id}}"
                                           {{$item->is_published == true ? 'checked' : null}}  data-url="{{route('categories.published')}}"
                                           type="checkbox" class="custom-control-input"
                                           id="is_published_{{$item->id}}">
                                    <label class="custom-control-label" for="is_published_{{$item->id}}"></label>
                                </div>
                            </div>
                        </td>


                        <td class="text-center">
                            <a class="btn btn-sm btn-warning w-75"  href="{{route('child.categories.index',[$item->id,$item->slug])}}">@translate(Sub-categories)</a>
                        </td>

                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                                    <li><a  href="#!" class="nav-link text-black" onclick="forModal('{{ route('parent.categories.edit', [$item->id,$item->parent_category_id]) }}', '{{$item->name}}');">@translate(Edit)</a></li>

                                    <li class="divider"></li>
                                    <li><a class="nav-link text-black" href="#!"
                                           onclick="confirm_modal('{{ route('categories.destroy', $item->id) }}')">@translate(Delete)</a>
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
