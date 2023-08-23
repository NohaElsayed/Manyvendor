@extends('backend.layouts.master')
@section('title')
    @translate(Deliver User List)
@endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(All Deliver Request)</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-2">

            <!-- there are the main content-->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th>@translate(Avatar)</th>
                    <th>@translate(Name)</th>
                    <th>@translate(Contact)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $item)
                    <tr>
                        <td>
                            {{$loop->index+1}}
                        </td>
                        <td>
                            <img src="{{filePath($item->pic)}}" width="80" height="80" class="img-circle">
                        </td>
                        <td>
                            @translate(First Name) : {{$item->first_name}} <br>
                            <strong>{{$item->gendear}}</strong>
                        </td>
                        <td>
                            @translate(Phone) : <a href="Tel:{{$item->phone_num}}"
                                                   class="text-info">{{$item->phone_num}}</a>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                    <li><a href="#!" class="nav-link text-success"
                                           onclick="forModal('{{ route('deliver.details.show',$item->id) }}','Deliver User Details')">@translate(Deliver user details)</a>
                                    </li>
{{--                                    @if(\Illuminate\Support\Facades\Auth::id() == $item->id)--}}
{{--                                        <li><a class="nav-link text-black" href="{{ route('users.edit') }}">@translate(Profile)</a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                    --}}{{--here 1 is super admin--}}
{{--                                    @if(\Illuminate\Support\Facades\Auth::user()->groups[0]->pivot->group_id == 1)--}}
{{--                                        <li><a class="nav-link text-black" href="{{ route('users.modify',$item->id) }}">@translate(Modify)</a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}

{{--                                    <li><a class="nav-link text-black d-none"--}}
{{--                                           href="{{ route('users.show', $item->id) }}">@translate(Show)</a></li>--}}
{{--                                    @if(Illuminate\Support\Facades\Auth::user()->groups[0]->pivot->group_id == 1 && Illuminate\Support\Facades\Auth::id() != $item->id)--}}
{{--                                        <li class="divider"></li>--}}
{{--                                        @if($item->banned)--}}
{{--                                            <li><a href="#!" class="nav-link text-success"--}}
{{--                                                   onclick="confirm_modal('{{ route('deliver.banned',$item->id) }}')">@translate(Unblock user)</a>--}}
{{--                                            </li>--}}
{{--                                        @else--}}
{{--                                            <li><a href="#!" class="nav-link text-danger"--}}
{{--                                                   onclick="confirm_modal('{{ route('deliver.banned',$item->id) }}')">@translate(Block user)</a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}

{{--                                    @endif--}}
                                </ul>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="float-left">
                {{$users->links()}}
            </div>
        </div>
    </div>


@endsection
