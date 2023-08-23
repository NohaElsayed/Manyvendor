@extends('backend.layouts.master')
@section('title')
    @translate(User Update)
@endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">@translate(Update User)</h3>

            <div class="float-right">
                <div class="">
                    <a class="btn btn-primary" href="{{ route("users.index") }}">
                        @translate(User List)
                    </a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-2">
            <form action="{{route('users.update.modify')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}"/>
                <div class="align-content-center text-center mb-3">
                    <img src="{{filePath($user->avatar)}}" class="img-rounded" height="100" width="100">
                </div>

                <div class="">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">@translate(Name)</label>

                        <div class="col-md-6">
                            <input id="name" type="text"
                                   class="form-control"
                                   value="{{ $user->name}}" readonly autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">@translate(E-Mail Address)</label>

                        <div class="col-md-6">
                            <input id="email" type="email"
                                   class="form-control"
                                   value="{{ $user->email}}" readonly autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">@translate(Phone number)</label>

                        <div class="col-md-6">
                            <input id="name" type="tel"
                                   class="form-control @error('tel_number') is-invalid @enderror"
                                   value="{{ $user->tel_number}}" readonly  autocomplete="name" autofocus>

                            @error('tel_number')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">@translate(User Status)</label>
                        <div class="col-md-6">
                            <select class="form-control select2 w-100" required name="banned">
                                <option value="0" {{$user->banned == 0 ? 'selected': null}}>
                                    @translate(Active)
                                </option>
                                <option value="1" {{$user->banned == 1 ? 'selected': null}}>
                                    @translate(Deactive)
                                </option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="user_type" value="Admin">

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">@translate(Select Groups)</label>
                        <div class="col-md-6">
                            <select class="form-control select2 w-100" name="group_id[]" multiple required>
                                @foreach($groups as $item)
                                    <option value="{{$item->id}}"
                                    @foreach($user->groups as $item1)
                                        {{$item1->id == $item->id ? 'selected' : null}}
                                        @endforeach
                                    >{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary  px-5" type="submit">@translate(Update)</button>
                </div>

            </form>
        </div>

    </div>

@endsection
