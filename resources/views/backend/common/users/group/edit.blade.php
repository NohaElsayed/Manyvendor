@extends('backend.layouts.master')
@section('title') @translate(Group Update) @endsection
@section('content')


    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Update Group)</h3>

            <div class="float-right">
                <a class="btn btn-primary" href="{{ route("groups.index") }}">
                    @translate(Group List)
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-2">
            <form action="{{route('groups.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$group->id}}"/>
                <div class="">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">@translate(Name)</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ $group->name }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">@translate(Slug)</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $group->slug }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">@translate(Description)</label>
                        <div class="mb-3 col-md-6">
                            <textarea class="w-100 sr-textarea" name="description" cols="50" rows="5"
                                      placeholder="@translate(Place some text here)">{{ $group->description }}</textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-form-label text-md-right font-weight-bold">@translate(Select
                            Permission)</label>
                        <div class="col-md-12">
                            <div class="row">
                                @forelse($modules as $m)
                                    <div class="col-md-4 card p-5">
                                        <h2 class="card-title py-2">@translate(Module): {{$m->name}}</h2>
                                        @foreach($m->permissions as $item)
                                            <div class="form-group">
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox"
                                                           @foreach($group->permissions as $item1)
                                                           {{$item1->id == $item->permission_id ? 'checked' : null}}
                                                           @endforeach
                                                           value="{{$item->permission->id}}" name="permission_id[]"
                                                           class="custom-control-input"
                                                           id="customSwitch{{$item->id}}">
                                                            <label class="custom-control-label"
                                                           for="customSwitch{{$item->id}}">{{$item->permission->name}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @empty
                                    <span class="badge badge-danger">@translate(No permission)</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary m-2" type="submit">@translate(Update)</button>
            </form>
        </div>

    </div>

@endsection
