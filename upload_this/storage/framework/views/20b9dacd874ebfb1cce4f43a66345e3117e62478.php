

<?php $__env->startSection('title'); ?>

<?php $__env->startSection('content'); ?>
    <div id="homepage-5">

        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if($section->blade_name == "shop-store"): ?>
                <?php if(sellerStatus()): ?>
                    <?php echo $__env->renderWhen($section->active,'frontend.widgets.section.'.$section->blade_name, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
                <?php endif; ?>
            <?php else: ?>
                <?php echo $__env->renderWhen($section->active,'frontend.widgets.section.'.$section->blade_name, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if(getPromotions('popup')->count() > 0): ?>
    
   <?php echo $__env->make('frontend.widgets.popup.popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

    
    <?php echo $__env->make('frontend.widgets.popup.site-search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/homepage/index.blade.php ENDPATH**/ ?>