@extends('backend.layouts.master')
@section('title') @translate(Page Group) @endsection
@section('content')

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Page Group list)</h3>
                </div>
                <div class="card-body p-2">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>@translate(S/L)</th>
                            <th>@translate(Name)</th>
                            <th>@translate(Published)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pageGroups as $pageGroup)
                            <tr>
                                <td> {{$loop->index+1}}</td>
                                <td>{{$pageGroup->name}} <br>
                                    @translate(Total Page) {{$pageGroup->pages->count()}}</td>
                                <td>
                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input data-id="{{$pageGroup->id}}"
                                                   {{$pageGroup->is_published == true ? 'checked' : null}}  data-url="{{route('pages.group.publish')}}"
                                                   type="checkbox" class="custom-control-input"
                                                   id="customSwitch{{$pageGroup->id}}">
                                            <label class="custom-control-label"
                                                   for="customSwitch{{$pageGroup->id}}"></label>
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
                                            <li><a class="nav-link text-black" onclick="forModal('{{route('pages.group.edit', $pageGroup->id)}}')"
                                                   href="#!">@translate(Edit)</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="nav-link text-black"
                                                   onclick="confirm_modal('{{ route('pages.group.destroy', $pageGroup->id) }}')">@translate(Delete)</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <h5 class="text-center">@translate(No data found)</h5>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Page Group create)</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                    <form action="{{route('pages.group.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label">@translate(Name)</label>
                            <input type="text" name="name" required class="form-control w-100">
                        </div>


                        <button class="btn btn-primary" type="submit">@translate(Save)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection




