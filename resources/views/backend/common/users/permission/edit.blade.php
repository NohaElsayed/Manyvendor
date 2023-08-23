@extends('backend.layouts.master')
@section('title')
    @translate(Permission Update)
@endsection

@section('content')


            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(Update Permission)</h3>

                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route("permissions.index") }}">
                            @translate(Permissions List)
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                    <form action="{{route('permissions.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$permission->id}}"/>
                        <div class="">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@translate(Name)</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ $permission->name }}" required autocomplete="name" autofocus>

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
                                    <input type="text" class="form-control" value="{{ $permission->slug }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">@translate(Description)</label>
                                <div class="mb-3 col-md-6">
                                    <textarea class=" sr-textarea" name="description"
                                              placeholder="@translate(Place some text here)">{{ $permission->description }}</textarea>
                                </div>
                            </div>


                        </div>
                        <button class="btn btn-primary m-2" type="submit">@translate(Update)</button>
                    </form>
                </div>

            </div>
@endsection
