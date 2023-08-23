@extends('backend.layouts.master')
@section('title')
	@translate(Profile Update)
@endsection
@section('content')

	<div class="card card-primary card-outline">
		<div class="card-header">
			<h3 class="card-title">@translate(Update Profile)</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body p-2">
			<form action="{{route('deliver.update')}}" method="post" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="id" value="{{$user->id}}"/>
				<div class="avatar-upload">
					<div class="avatar-edit">
						<input type='file' name="avatar" id="imageUpload" accept=".png, .jpg, .jpeg"/>
						<label for="imageUpload"></label>
					</div>
					<div class="avatar-preview">
						<div id="imagePreview"
						     style="background-image: url({{filePath($user->avatar)}});">
						</div>
					</div>
				</div>

				<div class="">
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">@translate(Name)</label>

						<div class="col-md-6">
							<input id="name" type="text"
							       class="form-control @error('name') is-invalid @enderror" name="name"
							       value="{{ $user->name}}" required autocomplete="name" autofocus>

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
							<input id="email" type="email" name="email"
							       class="form-control @error('email') is-invalid @enderror"
							       value="{{ $user->email}}" readonly required autocomplete="email">

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
							<input id="" type="tel"
							       class="form-control @error('tel_number') is-invalid @enderror"  name="tel_number"
							       value="{{ $user->tel_number}}"  autocomplete="name" autofocus>

							@error('tel_number')
							<span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
							@enderror
						</div>
					</div>


					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">@translate(Select Gender)</label>
						<div class="col-md-6">
							<select class="form-control select2 w-100 @error('genders') is-invalid @enderror" required name="genders">
								<option value=""></option>
								<option value="Male" {{$user->genders == "Male" ? 'selected': null}}>
									@translate(Male)
								</option>
								<option value="Female" {{$user->genders == "Female" ? 'selected': null}}>
									@translate(Female)
								</option>
								<option value="Other" {{$user->genders == "Other" ? 'selected': null}}>
									@translate(Other)
								</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">@translate(Password)</label>
						<div class="col-md-6">
							<input id="password" type="password"
							       class="form-control @error('password') is-invalid @enderror"  name="password"
							       autofocus>
						</div>
					</div>

					<div class="form-group row">
						<label for="password-confirm" class="col-md-4 col-form-label text-md-right">@translate(Confirm Password)</label>
						<div class="col-md-6">
							<input id="password-confirm" type="password"
							       class="form-control"  name="password_confirmation"
							       autofocus>
						</div>
					</div>

				</div>
				<div class="text-center"><button class="btn btn-primary px-5" type="submit">@translate(Update)</button></div>
			</form>
		</div>

	</div>

@endsection
