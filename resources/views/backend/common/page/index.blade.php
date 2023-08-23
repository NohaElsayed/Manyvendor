@extends('backend.layouts.master')
@section('title') @translate(pages list) @endsection
@section('content')
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="float-left">
                        <h2 class="card-title">@translate(Page List)</h2>
                    </div>
                    <div class="float-right">
                        <div class="row">
                            <div class="col">
                                <a href="#!"
                                   onclick="forModal('{{ route("pages.create") }}', '@translate(Page Create)')"
                                   class="btn btn-primary">
                                    <i class="la la-plus"></i>
                                    @translate(Create New Page)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped- table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>@translate(S/L)</th>
                            <th>@translate(Title)</th>
                            <th>@translate(Total Content)</th>
                            <th>@translate(Active)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pages as  $item)
                            <tr>
                                <td>{{ ($loop->index+1) }}</td>
                                <td>{{$item->title}}</td>
                                <td>
                                    {{$item->content->count() ?? 'N/A'}}
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input data-id="{{$item->id}}"
                                                   {{$item->active == true ? 'checked' : null}}  data-url="{{route('pages.active')}}"
                                                   type="checkbox" class="custom-control-input"
                                                   id="customSwitch{{$item->id}}">
                                            <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">@translate(Toggle Dropdown)</span>
                                        </button>
                                        <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                            <li><a href="{{route('pages.content.index',$item->id)}}" class="nav-link text-black" >@translate(Page Content)</a></li>
                                            <li><a href="#!" class="nav-link text-black" onclick="forModal('{{ route('pages.edit', $item->id) }}','@translate(Page Edit)')">@translate(Edit)</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="nav-link text-black"
                                                   onclick="confirm_modal('{{ route('pages.destroy', $item->id) }}')">@translate(Delete)</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="5"><h3 class="text-center">@translate(No Data Found)</h3></td>
                            </tr>


                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
@endsection

