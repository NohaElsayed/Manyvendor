@extends('backend.layouts.master')
@section('title')
    @translate(Deliver User List)
@endsection
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(All Deliver)</h3>
            <div class="float-right">
                <div class="text-right">
                    <div class="">
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
                    <tr class="{{$item->banned == true ? 'table-danger' : 'table-success'}}">
                        <td>
                            {{$loop->index+1}}
                        </td>
                        <td>
                            <img src="{{filePath($item->avatar)}}" width="80" height="80" class="img-circle">
                        </td>
                        <td>@translate(Name) : {{$item->name}} <br>
                            <strong>{{$item->gendear}}</strong>
                        </td>
                        <td> @translate(Email) : <a href="Mail:{{$item->email}}"
                                                    class="text-info">{{$item->email}}</a><br>
                            @translate(Phone) : <a href="Tel:{{$item->tel_number}}"
                                                   class="text-info">{{$item->tel_number}}</a>
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
                                        <li><a class="nav-link text-black" href="{{ route('users.edit') }}">@translate(Profile)</a>
                                        </li>
                                    @endif


                                    <li> <a href="#!"
                                            onclick="forModal('{{route('deliver.about', $item->id)}}','@translate(Deliver User Details)')"
                                            class="btn-sm btn-info d-block m-2 text-center">@translate(About)</a></li>
                                    @if(Illuminate\Support\Facades\Auth::user()->groups[0]->pivot->group_id == 1 && Illuminate\Support\Facades\Auth::id() != $item->id)
                                        <li class="divider"></li>
                                        @if($item->banned)
                                            <li><a href="#!" class="nav-link text-success"
                                                   onclick="confirm_modal('{{ route('deliver.banned',$item->id) }}')">@translate(Unblock user)</a>
                                            </li>
                                        @else
                                            <li><a href="#!" class="nav-link text-danger"
                                                   onclick="confirm_modal('{{ route('deliver.banned',$item->id) }}')">@translate(Block user)</a>
                                            </li>
                                        @endif

                                    @endif
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
