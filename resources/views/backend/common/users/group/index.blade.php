@extends('backend.layouts.master')
@section('title') @translate(Group List) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Group List)</h3>

            <div class="float-right">
                <a class="btn btn-primary" href="{{ route("groups.create") }}">
                    @translate(Add Group)
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-2">

            <!-- there are the main content-->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th>@translate(Name)</th>
                    <th>@translate(Permissions)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>

                @foreach($groups as $item)
                    <tr>
                        <td> {{$loop->index+1}}</td>
                        <td>@translate(Name) : {{$item->name}} <br> @translate(Slug) : {{$item->slug}}</td>
                        <td>
                            @foreach($item->permissions as $items)
                                <span class="badge badge-info">{{$items->name}}</span>
                            @endforeach
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                    <li><a href="{{ route('groups.edit', $item->id) }}" class="nav-link text-black">@translate(Edit)</a></li>
                                    <li><a href="{{ route('groups.show', $item->id) }}" class="nav-link text-black">@translate(Show)</a></li>
                                    <li class="divider"></li>
                                    <li class="d-none"><a href="#!"  class="nav-link text-black"
                                                          onclick="confirm_modal('{{route('modules.destroy',$item->id)}}')">@translate(Delete)</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>

@endsection
