<header class="header header--mobile" data-sticky="true">
    <div class="header__top">
        <div class="header__left">
           
        </div>
        <div class="header__right">
            <ul class="navigation__extra">
                <?php if(vendorActive()): ?>
                    <li><a href="<?php echo e(route('vendor.signup')); ?>">Apply Seller</a></li>
                <?php endif; ?>
               
                <li>
                    <div class="ps-dropdown"><a href="#"><?php echo e(Str::ucfirst(defaultCurrency())); ?></a>
                        <ul class="ps-dropdown-menu  dropdown-menu-right">
                            <?php $__currentLoopData = \App\Models\Currency::where('is_published',true)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('frontend.currencies.change')); ?>"
                                       onclick="event.preventDefault();
                                           document.getElementById('<?php echo e($item->name); ?>').submit()">
                                        <img width="25" height="auto" src="<?php echo e(asset("images/lang/". $item->image)); ?>"
                                             alt=""/>
                                        <?php echo e($item->name); ?></a>
                                    <form id="<?php echo e($item->name); ?>" class="d-none"
                                          action="<?php echo e(route('frontend.currencies.change')); ?>"
                                          method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="code" value="<?php echo e($item->id); ?>">
                                    </form>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="ps-dropdown language"><a
                            href="#"><?php echo e(Str::ucfirst(\Illuminate\Support\Facades\Session::get('locale') ?? env('DEFAULT_LANGUAGE'))); ?></a>
                        <ul class="ps-dropdown-menu  dropdown-menu-right">
                            <?php $__currentLoopData = \App\Models\Language::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('frontend.language.change')); ?>"
                                       onclick="event.preventDefault();
                                           document.getElementById('<?php echo e($language->name); ?>').submit()">
                                        <img width="25" height="auto"
                                             src="<?php echo e(asset("images/lang/". $language->image)); ?>" alt=""/>
                                        <?php echo e($language->name); ?></a>
                                    <form id="<?php echo e($language->name); ?>" class="d-none"
                                          action="<?php echo e(route('frontend.language.change')); ?>"
                                          method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="code" value="<?php echo e($language->code); ?>">
                                    </form>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="navigation--mobile">
        <div class="navigation__left"><a class="ps-logo" href="<?php echo e(route('homepage')); ?>"><img
                    src="<?php echo e(filePath(getSystemSetting('type_logo'))); ?>" class="" alt=""></a></div>
        <div class="navigation__right">
            <div class="header__actions">
                
                <?php if(auth()->guard()->check()): ?>
                    <div class="ps-cart--mini">
                        <a class="header__extra" href="<?php echo e(route('customer.track.order')); ?>">
                            <i class="icon-truck"></i>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="ps-block--user-header">
                        <?php if(auth()->guard()->check()): ?>
                            <div class="ps-block__left">
                                <?php if(Auth::user()->user_type == 'Customer'): ?>
                                    <a href="<?php echo e(route('customer.index')); ?>">
                                        <i class="icon-user"></i>
                                    </a>
                                <?php else: ?>
                                    <i class="icon-user"></i>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(auth()->guard()->guest()): ?>
                            <div class="ps-block__left">
                                <a href="<?php echo e(route('login')); ?>">
                                    <i class="icon-user"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
   
</header>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/include/header/mobile-header.blade.php ENDPATH**/ ?>