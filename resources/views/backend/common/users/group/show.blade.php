@extends('backend.layouts.master')
@section('title') @translate(Group Details) @endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Group)</h3>

            <div class="float-right">
                <a class="btn btn-primary" href="{{ route("groups.index") }}">
                    @translate(Group List)
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
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ $group->name }}" readonly>
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
                            {!! $group->description !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">@translate(Permission List)</label>
                        <div class="mb-3 col-md-6">
                            @foreach($group->permissions as $item)
                                <span class="badge badge-success">{{$item->name}}</span>
                            @endforeach
                        </div>
                    </div>


                </div>
            </form>
        </div>

    </div>

@endsection
