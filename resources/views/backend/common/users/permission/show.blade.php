@extends('backend.layouts.master')
@section('title')  @translate(Permission Details) @endsection
@section('content')


            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"> @translate(Permission)</h3>

                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route("permissions.index") }}">
                            @translate(Permissions List)
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                    <form>
                        <div class="">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@translate(Name)</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $permission->name }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">@translate(Slug)</label>
                                <div class="col-md-6">
                                    <input  type="text" class="form-control" value="{{ $permission->slug }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">@translate(Description)</label>
                                <div class="mb-3 col-md-6">
                                   {!! $permission->description !!}
                                </div>
                            </div>



                        </div>
                    </form>
                </div>

            </div>

@endsection
