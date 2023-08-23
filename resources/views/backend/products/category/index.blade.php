@extends('backend.layouts.master')
@section('title') @translate(Category Group)
@endsection
@section('parentPageTitle', 'All Category')
@section('content')
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Category group list)</h2>
            </div>
            <div class="float-right">
                <div class="row justify-content-end">
                    <div class="col">
                        <form method="get" action="">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12"
                                       placeholder="@translate(Search group)" value="{{Request::get('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">@translate(Search)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <a href="#!"
                           onclick="forModal('{{ route('group.categories.create') }}', '@translate(Add Category Group)');"
                           class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                            @translate(Add new group)
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
                    <th class="text-left">@translate(Group name)</th>
                    <th class="text-left">@translate(Parent Category List)</th>
                    <th>@translate(Icon class)</th>
                    <th>@translate(Image)</th>
                    <th>@translate(Popular)</th>
                    <th>@translate(Top)</th>
                    <th>@translate(Publish)</th>
                    <th>@translate(View)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as  $item)
                    <tr>
                        <td>{{ ($loop->index+1) + ($categories->currentPage() - 1)*$categories->perPage() }}</td>
                        <td class="text-left">{{$item->name}}</td>
                        <td class="text-left">
                            @forelse($item->childrenCategories as $cat)
                               <span class="badge badge-dark"><a class="text-white" href="{{route('child.categories.index',[$cat->id,$cat->slug])}}">{{$cat->name }}</a></span><br>
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
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$item->id}}"
                                           {{$item->is_popular == true ? 'checked' : null}}  data-url="{{route('categories.popular')}}"
                                           type="checkbox" class="custom-control-input"
                                           id="is_popular_{{$item->id}}">
                                    <label class="custom-control-label" for="is_popular_{{$item->id}}"></label>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$item->id}}"
                                           {{$item->top == true ? 'checked' : null}}  data-url="{{route('categories.top')}}"
                                           type="checkbox" class="custom-control-input"
                                           id="top_{{$item->id}}">
                                    <label class="custom-control-label" for="top_{{$item->id}}"></label>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input data-id="{{$item->id}}"
                                           {{$item->is_published == true ? 'checked' : null}}  data-url="{{route('categories.published')}}"
                                           type="checkbox" class="custom-control-input"
                                           id="is_published_{{$item->id}}">
                                    <label class="custom-control-label" for="is_published_{{$item->id}}"></label>
                                </div>
                            </div>
                        </td>

                        <td class="text-center">
                            <a href="{{route('parent.categories.index',[$item->id,$item->slug]) }}" class="btn btn-sm btn-warning w-75">@translate(Parent categories)</a>
                        </td>

                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right" role="menu">
                                    <li><a href="#!" class="nav-link text-black"
                                           onclick="forModal('{{ route('group.categories.edit', $item->id) }}', '@translate(Edit category group)');">@translate(Edit)</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="#!"
                                           onclick="confirm_modal('{{ route('categories.destroy', $item->id) }}')" class="nav-link text-black">@translate(Delete)</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10"><h3 class="text-center">@translate(No Data Found)</h3></td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $categories->links() }}
    </div>

    @if($sellerRequest != null && vendorActive())
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Requested sub-category list)</h2>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover text-left">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th>@translate(Requested sub-category name)</th>
                    <th>@translate(Category Group)</th>
                    <th>@translate(Parent category)</th>
                    <th>@translate(Requested by)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sellerRequest as  $item)
                    <tr>
                        <td>{{$loop->index+1 }}</td>
                        <td>{{$item->name}}</td>
                        <td>
                           {{\App\Models\Category::where('id',$item->parent->parent_category_id)->first()->name}}
                        </td>
                        <td>
                           {{$item->parent->name}}
                         </td>
                        <td>
                            {{$item->creator->name}}
                        </td>

                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right"  role="menu">
                                    <li><a href="#!" class="nav-link text-success"
                                           onclick="forModal('{{ route('categories.edit', [$item->id,$item->slug]) }}', '{{$item->name}}');">@translate(Approve)</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="#!"
                                           onclick="confirm_modal('{{ route('categories.destroy', $item->id) }}')" class="nav-link text-danger">@translate(Decline)</a>
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
    @endif

@endsection
