<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav float-left">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-align-right fs-18"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
            <a href="<?php echo e(route('homepage')); ?>" target="_blank" class="nav-link" title="Browse frontend">
                <i class="fas fa-globe fs-18"></i>
            </a>
        </li>
    </ul>


    <ul class="navbar-nav ml-auto">

        
        <li class="dropdown mx-2">
            <div class="m-2">
                <a class="dropdown-toggle text-dark" href="#" role="button" id="languagelink"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"><span class="live-icon">
                                        <?php echo e(Str::ucfirst(defaultCurrency())); ?>

                                    </span><span class="feather icon-chevron-down live-icon"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="languagelink">
                    <?php $__currentLoopData = \App\Models\Currency::where('is_published',true)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item" href="<?php echo e(route('currencies.change')); ?>" onclick="event.preventDefault();
                            document.getElementById('<?php echo e($item->name); ?>').submit()">
                            <img width="25" height="auto" src="<?php echo e(asset("images/lang/". $item->image)); ?>" alt=""/>
                            <?php echo e($item->name); ?></a>
                        <form id="<?php echo e($item->name); ?>" class="d-none" action="<?php echo e(route('currencies.change')); ?>"
                              method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="code" value="<?php echo e($item->id); ?>">
                        </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

        </li>

        
        <li class="dropdown mx-2">
            <div class="m-2">
                <a class="dropdown-toggle text-dark" href="#" role="button" id="languagelink"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"><span class="live-icon">
                                        <?php echo e(Str::ucfirst(\Illuminate\Support\Facades\Session::get('locale') ?? env('DEFAULT_LANGUAGE'))); ?>

                                    </span><span class="feather icon-chevron-down live-icon"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="languagelink">
                    <?php $__currentLoopData = \App\Models\Language::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item" href="<?php echo e(route('language.change')); ?>" onclick="event.preventDefault();
                            document.getElementById('<?php echo e($language->name); ?>').submit()">
                            <img width="25" height="auto" src="<?php echo e(asset("images/lang/". $language->image)); ?>" alt=""/>
                            <?php echo e($language->name); ?></a>
                        <form id="<?php echo e($language->name); ?>" class="d-none" action="<?php echo e(route('language.change')); ?>"
                              method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="code" value="<?php echo e($language->code); ?>">
                        </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

        </li>

        
        <!-- Notofications Dropdown Menu -->
        <?php if(\Illuminate\Support\Facades\Auth::user()->user_type != "Deliver"): ?>
            <li class="dropdown mx-2">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-danger navbar-badge"><?php echo e(orderCount('pending')); ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="<?php echo e(route('orders.index')); ?>" class="dropdown-item">
                        <!-- Notofications Start -->
                        <div class="media">
                            <img src="<?php echo e(asset('shopping_success.png')); ?>"
                                 alt="<?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?>"
                                 class="img-size-50 mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    <?php echo e(orderCount('pending')); ?> new order placed
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                            </div>
                        </div>
                        <!-- Notofications End -->
                    </a>
                </div>
            </li>
        <?php endif; ?>


        <li class="dropdown user user-menu  mx-2">
            <a class="dropdown-toggle" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <img src="<?php echo e(filePath(\Illuminate\Support\Facades\Auth::user()->avatar)); ?>"
                     class="img-circle m-b-1" width="40px" height="40px"
                     alt="<?php echo e(filePath(\Illuminate\Support\Facades\Auth::user()->name)); ?>">
            </a>
            <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('seller')): ?>
                    <a class="dropdown-item" href="<?php echo e(route('vendor.profile',\Illuminate\Support\Facades\Auth::id())); ?>">Profile</a>
                <?php endif; ?>

                <?php if(\Illuminate\Support\Facades\Auth::user()->user_type == "Admin"): ?>
                    <a class="dropdown-item" href="<?php echo e(route('users.edit',\Illuminate\Support\Facades\Auth::id())); ?>">Profile</a>
                <?php endif; ?>

                <?php if(\Illuminate\Support\Facades\Auth::user()->user_type == "Deliver"): ?>
                    <a class="dropdown-item" href="<?php echo e(route('deliver.profile')); ?>">Profile</a>
                <?php endif; ?>

                <a class="dropdown-divider"></a>
                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" class="d-none" action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                </form>

            </div>

        </li>

        <!--Setting-->
        <li class="nav-item d-none">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

    </ul>
</nav>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/layouts/includes/navbar.blade.php ENDPATH**/ ?>