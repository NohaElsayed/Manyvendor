
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-5">
                <h1 class="m-0 text-dark"><?php echo $__env->yieldContent('title'); ?></h1>
            </div>
            <div class="col-md-4 d-none">
                <ol class="breadcrumb float-sm-right">
                    <?php $__currentLoopData = $segments = request()->segments(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(url(implode('/',array_slice($segments,0,($index+1))))); ?>">
                            <?php echo e(Str::title($segment)); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </div>
        </div>
    </div>


<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/layouts/includes/breadcrumb.blade.php ENDPATH**/ ?>