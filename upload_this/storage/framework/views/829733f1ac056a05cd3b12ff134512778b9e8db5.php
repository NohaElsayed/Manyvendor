

<?php $__env->startSection('title'); ?>
    Customer Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="ps-page--single">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="<?php echo e(route('homepage')); ?>">Home</a></li>
                    <li><a href="javascript:void(0)">Profile</a></li>
                    <li><?php echo e(Auth::user()->name); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ps-vendor-dashboard pro">
        <div class="container">
            <div class="ps-section__header">
                <h3>Customer Dashboard</h3>
            </div>
            <div class="ps-section__content">
                <ul class="ps-section__links">
                    <li><a href="<?php echo e(route('customer.orders')); ?>">Your Order</a></li>
                    <li class="active"><a href="<?php echo e(route('customer.index')); ?>">Your Profile</a></li>

                    <?php if(affiliateRoute() && affiliateActive()): ?>
                    <li><a href="<?php echo e(route('customers.affiliate.registration')); ?>">Affiliate Marketing</a></li>
                    <?php endif; ?>
                    
                    <li><a href="<?php echo e(route('logout')); ?>"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            Sign Out
                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                </ul>
            </div>
            <form action="<?php echo e(route('customer.update')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                        <figure class="ps-block--vendor-status w-300 text-center">

                            <?php if(Str::substr(Auth::user()->avatar, 0, 7) == 'uploads'): ?>
                                <img src="<?php echo e(filePath($customer->avatar)); ?>" alt="<?php echo e(Auth::user()->name); ?>" class="w-70 rounded-circle">
                            <?php else: ?>
                                <img src="<?php echo e(asset(Auth::user()->avatar)); ?>" alt="<?php echo e(Auth::user()->name); ?>" class="w-70 rounded-circle">
                            <?php endif; ?>

                        </figure>

                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                        <figure class="ps-block--vendor-status">
                            <figcaption>Profile Information</figcaption>
                            <input type="hidden" name="slug" value="<?php echo e($customer->slug); ?>">

                            <?php if($errors->has('name')): ?>
                                <div class="error text-danger"><?php echo e($errors->first('name')); ?></div>
                            <?php endif; ?>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Name" name="name"
                                       value="<?php echo e($customer->name ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="email" placeholder="Email address"
                                       name="email" value="<?php echo e($customer->email ?? ''); ?>" disabled>
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="number" placeholder="Contact number"
                                       name="phn_no" value="<?php echo e($customer->phn_no ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Nationality"
                                       name="nationality" value="<?php echo e(Auth::user()->nationality ?? ''); ?>">
                            </div>


                            <div class="form-group">
                                <textarea class="form-control" placeholder="Your address"
                                          name="address"><?php echo e($customer->address ?? ''); ?></textarea>
                            </div>


                            <?php if($errors->has('avatar')): ?>
                                <div class="error text-danger"><?php echo e($errors->first('avatar')); ?></div>
                            <?php endif; ?>
                            <div class="form-group">
                                <input type="hidden" name="oldAvatar" value="<?php echo e($customer->avatar ?? ''); ?>">
                                <input class="form-control pt-3" type="file" name="avatar">
                            </div>


                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="Password"
                                       name="password">
                            </div>

                            <?php if($errors->has('password')): ?>
                                <div class="error text-danger"><?php echo e($errors->first('password')); ?></div>
                            <?php endif; ?>
                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="Confirm password"
                                       name="password_confirmation">
                            </div>

                            <button type="submit" class="ps-btn">Save</button>
                        </figure>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/customer/index.blade.php ENDPATH**/ ?>