<div class="ps-home-banner pb-5">
    <div class="container">

        <?php echo $__env->make('frontend.include.sidebar.desktop.category-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="ps-section__center">
            <?php if(getPromotions('mainSlider')->count() != 1): ?>

                <div class="ps-carousel--dots owl-slider" data-owl-auto="true" data-owl-loop="true"
                     data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1"
                     data-owl-item-xs="1" data-owl-item-sm="1"
                     data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
                    <?php $__currentLoopData = getPromotions('mainSlider'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($main_slider->link); ?>">
                            <img src="<?php echo e(filePath($main_slider->image)); ?>" alt="">
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <?php $__currentLoopData = getPromotions('mainSlider'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($main_slider->link); ?>">
                        <img src="<?php echo e(filePath($main_slider->image)); ?>" alt="">
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endif; ?>

        </div>

        <div class="ps-section__right">
            <?php $__currentLoopData = promotionBanners('header'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat_header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($cat_header->link); ?>">
                    <img src="<?php echo e(filePath($cat_header->image)); ?>" alt="#Header Category">
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>


    </div>
</div>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/widgets/section/main-banner.blade.php ENDPATH**/ ?>