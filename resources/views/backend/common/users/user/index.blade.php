@extends('backend.layouts.master')
@section('title')
    @translate(User List)
@endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(All Users)</h3>
            <div class="float-right">
                <div class="row text-right">
                    <div class="col-7">
                        <form action="" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12"
                                       placeholder="@translate(User Email)" value="{{Request::get('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">@translate(Search)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-5">
                            <a class="btn btn-primary" href="{{ route("users.create") }}">
                                @translate(Add User)
                            </a>
                    </div>
                </div>
            </div>

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
                    <th>@translate(Groups)</th>
                    <th>@translate(Last Login)</th>
                    <th>@translate(Action)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $item)
                    <tr class="{{$item->banned == true ? 'bg-canceled' : ''}}">
                        <td>
                            {{$loop->index+1}}
                        </td>
                        <td>
                            <img src="{{filePath($item->avatar)}}" width="80" height="80" class="img-circle">
                        </td>
                        <td>@translate(Name) : {{$item->name}} <br>
                        <strong>{{$item->gendear}}</strong>
                        </td>
                        <td> @translate(Email) : <a href="Mail:{{$item->email}}" class="text-info">{{$item->email}}</a><br>
                            @translate(Phone) : <a href="Tel:{{$item->tel_number}}" class="text-info">{{$item->tel_number}}</a>
                        <td>
                            @foreach($item->groups as $items)
                                <span class="badge badge-success">{{$items->name}}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($item->login_time != null)
                                <span class="badge badge-info">{{\Carbon\Carbon::parse($item->login_time)->diffForHumans() ?? ''}}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">

                                <button type="button" class="btn btn-info btn-flat dropdown-toggle btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-right p-2" role="menu">
                                    @if(\Illuminate\Support\Facades\Auth::id() == $item->id)
                                        <li><a class="nav-link text-black" href="{{ route('users.edit') }}">@translate(Profile)</a></li>
                                    @endif
                                    {{--here 1 is super admin--}}
                                    @if(\Illuminate\Support\Facades\Auth::user()->groups[0]->pivot->group_id == 1)
                                            <li><a class="nav-link text-black" href="{{ route('users.modify',$item->id) }}">@translate(Modify)</a></li>
                                        @endif

                                    <li><a class="nav-link text-black d-none" href="{{ route('users.show', $item->id) }}">@translate(Show)</a></li>
                                    @if(Illuminate\Support\Facades\Auth::user()->groups[0]->pivot->group_id == 1 && Illuminate\Support\Facades\Auth::id() != $item->id)
                                        <li class="divider"></li>
                                        <li><a href="#!" class="nav-link text-black"
                                               onclick="confirm_modal('{{ route('users.banned',$item->id) }}')">{{$item->banned == 1 ?'UnBlock user' :'Block user'}}</a>
                                        </li>
                                    @endif
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
