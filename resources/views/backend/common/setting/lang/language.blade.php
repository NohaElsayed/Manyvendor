@extends('backend.layouts.master')
@section('title') @translate(Language List) @endsection
@section('content')

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 class="card-title">@translate(Language List)</h2>
                </div>
                <div class="card-body">
                    <!--begin: Datatable -->
                    <table class="table data-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@translate(Code)</th>
                            <th>@translate(Name)</th>
                            <th>@translate(Flag)</th>
                            <th>@translate(Action)</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($languages as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item->code}}</td>
                                <td>
                                    {{$item->name ?? 'N/A'}}
                                </td>
                                <td>
                                    <img
                                        src="{{asset('images/lang/'.$item->image)}}" class="" height="30px"
                                        alt=""/>
                                </td>
                                <td>
                                    <div class="btn-group-vertical">
                                        <a class="btn btn-primary"
                                           href="{{route('language.translate',$item->id)}}">@translate(Translate)</a>
                                        <a class="btn btn-default"
                                           href="{{route('language.default',$item->id)}}">@translate(Set Default)</a>
                                        @if($item->id != 1)
                                        <a class="btn btn-warning" href="#!"
                                           onclick="confirm_modal('{{ route('language.destroy', $item->id) }}')">@translate(Delete)</a>
                                        @endif

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
                    <h3 class="card-title">@translate(Language Setup)</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" enctype="multipart/form-data"
                          action="{{ route('language.store') }}"
                          method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="">
                                <label class="control-label">@translate(Name) <span class="text-danger">*</span></label>
                            </div>
                            <div class="">
                                <input type="text" class="form-control" name="name" required
                                       placeholder="@translate(Ex: English)">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <label class="control-label">@translate(Code) <span class="text-danger">*</span></label>
                            </div>
                            <div class="">
                                <input type="text" class="form-control" name="code" required
                                       placeholder="@translate(Ex: en for english)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">@translate(Select country flag) <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <select class="form-control lang col" name="image" required>
                                    <option value=""></option>
                                    @foreach(readFlag() as $item)
                                        @if ($loop->index >1)
                                            <option value="{{$item}}"
                                                    data-image="{{asset('images/lang/'.$item)}}"> {{flagRenameAuto($item)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12 text-right px-0">
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


