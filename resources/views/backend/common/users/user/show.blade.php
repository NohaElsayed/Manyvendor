@extends('backend.layouts.master')
@section('title')
   @translate(User Details)
@endsection
@section('content')

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">@translate(User)</h3>

                    <!-- there are the main content-->
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route("users.index") }}">
                            @translate(User List)
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                    <form>
                        <input type="hidden" name="id" value="{{$user->id}}" />
                        <div class="">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@translate(Name)</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name}}" readonly autocomplete="name" autofocus>

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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email}}" readonly autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">@translate(User Type)</label>

                                <div class="col-md-6">
                                    <input  type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->user_type}}" readonly >

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">@translate(Groups List)</label>
                                <div class="mb-3 col-md-6">
                                    @foreach($user->groups as $item)
                                        <span class="badge badge-success">{{$item->name}}</span>,
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

@endsection
