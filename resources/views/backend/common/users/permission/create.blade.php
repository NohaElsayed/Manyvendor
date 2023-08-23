@extends('backend.layouts.master')
@section('title') @translate(Permission Create) @endsection
@section('content')

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">@translate(Create Permission)</h3>

                <div class="float-right">
                    <a class="btn btn-success" href="{{ route("permissions.index") }}">
                        @translate(Permissions List)
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-2">
                <form action="{{route('permissions.store')}}" method="post">
                    @csrf
                    <div class="">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@translate(Name)</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">@translate(Description)</label>
                            <div class="mb-3 col-md-6">
                                <textarea class=" sr-textarea" name="description" placeholder="@translate(Place some text here)" ></textarea>
                            </div>
                        </div>



                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>

        </div>

@endsection
