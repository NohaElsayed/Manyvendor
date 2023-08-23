
<?php $__env->startSection('title'); ?>
	Profile Update
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

	<div class="card card-primary card-outline">
		<div class="card-header">
			<h3 class="card-title">Update Profile</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body p-2">
			<form action="<?php echo e(route('deliver.update')); ?>" method="post" enctype="multipart/form-data">
				<?php echo csrf_field(); ?>
				<input type="hidden" name="id" value="<?php echo e($user->id); ?>"/>
				<div class="avatar-upload">
					<div class="avatar-edit">
						<input type='file' name="avatar" id="imageUpload" accept=".png, .jpg, .jpeg"/>
						<label for="imageUpload"></label>
					</div>
					<div class="avatar-preview">
						<div id="imagePreview"
						     style="background-image: url(<?php echo e(filePath($user->avatar)); ?>);">
						</div>
					</div>
				</div>

				<div class="">
					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

						<div class="col-md-6">
							<input id="name" type="text"
							       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
							       value="<?php echo e($user->name); ?>" required autocomplete="name" autofocus>

							<?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
							<span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						</div>
					</div>

					<div class="form-group row">
						<label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

						<div class="col-md-6">
							<input id="email" type="email" name="email"
							       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
							       value="<?php echo e($user->email); ?>" readonly required autocomplete="email">

							<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
							<span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-md-4 col-form-label text-md-right">Phone number</label>

						<div class="col-md-6">
							<input id="" type="tel"
							       class="form-control <?php $__errorArgs = ['tel_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  name="tel_number"
							       value="<?php echo e($user->tel_number); ?>"  autocomplete="name" autofocus>

							<?php $__errorArgs = ['tel_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
							<span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						</div>
					</div>


					<div class="form-group row">
						<label class="col-md-4 col-form-label text-md-right">Select Gender</label>
						<div class="col-md-6">
							<select class="form-control select2 w-100 <?php $__errorArgs = ['genders'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required name="genders">
								<option value=""></option>
								<option value="Male" <?php echo e($user->genders == "Male" ? 'selected': null); ?>>
									Male
								</option>
								<option value="Female" <?php echo e($user->genders == "Female" ? 'selected': null); ?>>
									Female
								</option>
								<option value="Other" <?php echo e($user->genders == "Other" ? 'selected': null); ?>>
									Other
								</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
						<div class="col-md-6">
							<input id="password" type="password"
							       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  name="password"
							       autofocus>
						</div>
					</div>

					<div class="form-group row">
						<label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
						<div class="col-md-6">
							<input id="password-confirm" type="password"
							       class="form-control"  name="password_confirmation"
							       autofocus>
						</div>
					</div>

				</div>
				<div class="text-center"><button class="btn btn-primary px-5" type="submit">Update</button></div>
			</form>
		</div>

	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/deliver/profile.blade.php ENDPATH**/ ?>