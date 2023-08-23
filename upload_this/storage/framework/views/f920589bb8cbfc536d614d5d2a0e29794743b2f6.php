



<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?> Register <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php echo e(route('homepage')); ?>">Home</a></li>
                <li>My account</li>
            </ul>
        </div>
    </div>
<?php if(env('APP_ENV') == 'local'): ?>
    <div class="ps-my-account">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="ps-form--account ps-tab-root mx-1 py-0">
                    <div class="ps-tab-list">
                        <span class="p-2 fs-28  font-weight-bold"></span>
                        <span class="p-2 fs-28 font-weight-bold"></span>
                    </div>
                    <div class="card card-primary card-outline pb-5" style="margin-top:35px;">

                        <div class="text-center">
                            <img src="<?php echo e(filepath('logo.png')); ?>" class="bg-primary w-100 py-3 px-5"/>
                        </div>
                        <div class="card-body" id="sign-in">
                            <div class="ps-form__content pt-0">
                                <div class="text-center mb-2"><small>Click For Demo Login Credentials</small>
                                </div>

                                <div class="btn btn-warning btn-block fs-16 admin">Copy admin credentials</div>
                                <?php if(vendorActive()): ?>
                                <div class="btn btn-danger btn-block fs-16 seller">Copy seller credentials</div>
                                <?php endif; ?>
                                <div class="btn btn-success btn-block fs-16 mt-2 customer">Copy customer credentials</div>
                                <div class="btn btn-secondary btn-block fs-16 mt-2 deliver">Copy Deliveryman  credentials</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-form--account ps-tab-root pt-2 mx-1">
                    <div class="ps-tab-list">
                    <span class="p-2 fs-28  font-weight-bold"><a href="<?php echo e(route('login')); ?>"
                                                                 class="<?php echo e(request()->is('login') ? 'color-active' : null); ?>" style="color: #ff5a5f">Login</a></span>
                        / <span class="p-2 fs-28 font-weight-bold"><a href="<?php echo e(route('register')); ?>"
                                                                    class="<?php echo e(request()->is('register') ? 'color-active' : null); ?>">Register</a></span>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-body" id="sign-in">
                            <div class="ps-form__content">
                                <form method="POST" action="<?php echo e(route('login')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <h5>Log In Your Account</h5>
                                    <div class="form-group">
                                        <input class="form-control insertEmail <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="email" value="admin@mail.com"
                                               name="email" placeholder="Email address" required>
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
                                    <div class="form-group form-forgot">
                                        <input class="form-control insertPw <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="password"  value="12345678"
                                               name="password" placeholder="Password" required>
                                        <?php $__errorArgs = ['password'];
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
                                        <a href="<?php echo e(route('password.request')); ?>">Forgot?</a>
                                    </div>
                                    <div class="form-group">
                                        <div class="ps-checkbox">
                                            <input class="form-control" type="checkbox" id="remember-me" name="remember">
                                            <label for="remember-me">Rememeber me</label>
                                        </div>
                                    </div>
                                    <div class="form-group submtit">
                                        <button class="ps-btn ps-btn--fullwidth" id="loginBtn" type="submit">Login</button>
                                    </div>
                                </form>
                            </div>


                            <div class="ps-form__footer">
                                <?php if(env('FACEBOOK_CLIENT_ID') != "" || env('GOOGLE_CLIENT_ID') != ""): ?>
                                    <p>Connect with:</p>
                                <?php endif; ?>
                                <ul class="ps-list--social">
                                    <?php if(!env('FACEBOOK_CLIENT_ID') == "" && !env('FACEBOOK_SECRET') == "" && !env('FACEBOOK_CALLBACK') == ""): ?>
                                        <li><a class="google" href="<?php echo e(url('/auth/redirect/google')); ?>"><i class="fa fa-google-plus"></i></a></li>
                                    <?php endif; ?>

                                    <?php if(!env('GOOGLE_CLIENT_ID') == "" && !env('GOOGLE_CALLBACK') == "" && !env('GOOGLE_SECRET') == ""): ?>
                                        <li><a class="facebook" href="<?php echo e(url('/auth/redirect/facebook')); ?>"><i
                                                        class="fa fa-facebook"></i></a></li>
                                    <?php endif; ?>

                                </ul>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="ps-my-account">
        <div class="container">
            <div class="ps-form--account ps-tab-root">
                <div class="ps-tab-list">
                    <span class="p-2 fs-28  font-weight-bold"><a href="<?php echo e(route('login')); ?>"
                                                                 class="<?php echo e(request()->is('login') ? 'color-active' : null); ?>"  style="color: #ff5a5f">Login</a></span>
                    / <span class="p-2 fs-28 font-weight-bold"><a href="<?php echo e(route('register')); ?>"
                                                                class="<?php echo e(request()->is('register') ? 'color-active' : null); ?>">Register</a></span>
                </div>
                <div class="card card-primary card-outline">

                    <div class="m-4">
                        <?php if(Session::has('status')): ?>
                            <div class="alert alert-info text-center"><?php echo e(Session::get('status')); ?></div>
                        <?php endif; ?>
                        <?php if(Session::has('warning')): ?>
                            <div class="alert alert-info text-center"><?php echo e(Session::get('warning')); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body" id="sign-in">
                        <div class="ps-form__content">
                            <form method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>
                                <h5>Log In Your Account</h5>
                                <div class="form-group">
                                    <input class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="email"
                                           name="email" placeholder="Email address" required>
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
                                <div class="form-group form-forgot">
                                    <input class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="password"
                                           name="password" placeholder="Password" required>
                                    <?php $__errorArgs = ['password'];
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
                                    <a href="<?php echo e(route('password.request')); ?>">Forgot?</a>
                                </div>
                                <div class="form-group">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox" id="remember-me" name="remember">
                                        <label for="remember-me">Rememeber me</label>
                                    </div>
                                </div>
                                <div class="form-group submtit">
                                    <button class="ps-btn ps-btn--fullwidth" type="submit">Login</button>
                                </div>
                            </form>
                        </div>


                        <div class="ps-form__footer">
                            <?php if(env('FACEBOOK_CLIENT_ID') != "" || env('GOOGLE_CLIENT_ID') != ""): ?>
                                <p>Connect with:</p>
                            <?php endif; ?>
                            <ul class="ps-list--social">
                                <?php if(!env('FACEBOOK_CLIENT_ID') == "" && !env('FACEBOOK_SECRET') == "" && !env('FACEBOOK_CALLBACK') == ""): ?>

                                    <li><a class="facebook" href="<?php echo e(url('/auth/redirect/facebook')); ?>"><i
                                                    class="fa fa-facebook"></i></a></li>
                                <?php endif; ?>

                                <?php if(!env('GOOGLE_CLIENT_ID') == "" && !env('GOOGLE_CALLBACK') == "" && !env('GOOGLE_SECRET') == ""): ?>
                                    <li><a class="google" href="<?php echo e(url('/auth/redirect/google')); ?>"><i class="fa fa-google-plus"></i></a></li>
                                <?php endif; ?>

                            </ul>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    
    <script>
        $('.seller').click(function () {
            $('.insertEmail').val("seller@mail.com");
            $('.insertPw').val("12345678");
            $('.insertEmail').focus();
        })

        $('.customer').click(function () {
            $('.insertEmail').val("customer@mail.com");
            $('.insertPw').val("12345678");
            $('.insertEmail').focus();
        })

        $('.admin').click(function () {
            $('.insertEmail').val("admin@mail.com");
            $('.insertPw').val("12345678");
            $('.insertEmail').focus();
        })

        $('.deliver').click(function () {
            $('.insertEmail').val("m@m.com");
            $('.insertPw').val("12345678");
            $('.insertEmail').focus();
        })
    </script>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/auth/login.blade.php ENDPATH**/ ?>