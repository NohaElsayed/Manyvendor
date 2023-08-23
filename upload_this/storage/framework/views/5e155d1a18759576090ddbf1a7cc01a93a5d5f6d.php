<div class="container-fluid">
    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger alert-dismissible fade show  m-3" role="alert">
            <ul class="nav">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="mx-2"><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>


            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/layouts/includes/error.blade.php ENDPATH**/ ?>