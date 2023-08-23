@extends('backend.layouts.master')
@section('title') @translate(Permissions List) @endsection
@section('content')

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 class="card-title">@translate(Module Permission List)</h2>
                </div>
                <div class="card-body">
                    <!--begin: Datatable -->
                    <table class="table data-table">
                        <thead>
                        <tr>
                            <th>@translate(S/L)</th>
                            <th>@translate(Name)</th>
                            <th>@translate(Permissions)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($modules as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    @forelse($item->permissions as $permission)
                                        <snap class="badge badge-info">{{$permission->permission->name}}</snap>
                                    @empty
                                        <span class="badge badge-danger">@translate(No permission)</span>
                                    @endforelse
                                </td>
                                <td>
                                    <div class="btn-group">

                                        <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                            <li><a href="#!" class="nav-link text-black"
                                                   onclick="forModal('{{route('modules.edit',$item->id)}}','Module permission edit')">@translate(Edit)</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li class="d-none"><a href="#!" class="nav-link text-black"
                                                   onclick="confirm_modal('{{route('modules.destroy',$item->id)}}')">@translate(Delete)</a>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Module Setup)</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" enctype="multipart/form-data"
                          action="{{ route('modules.store') }}"
                          method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="">
                                <label class="control-label">@translate(Name) <span class="text-danger">*</span></label>
                            </div>
                            <div class="">
                                <input type="text" class="form-control" name="name" required
                                       placeholder="@translate(Ex: For category)">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label">@translate(Select permissions) <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <select class="form-control select2" name="p_id[]" multiple required>
                                    <option value=""></option>
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}"> {{$permission->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-primary btn-block" type="submit">@translate(Save)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--there are the main content-->

@endsection


