<div class="ps-section__left">
    <ul class="menu--dropdown category-scroll hide-scrollbar">

      <?php $__currentLoopData = categories(100,null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($gCat->childrenCategories->count() > 0): ?>
        <li class="current-menu-item menu-item-has-children has-mega-menu">
          <a href="<?php echo e(route('category.shop',$gCat->slug)); ?>"><i class="<?php echo e($gCat->icon); ?>"></i> <?php echo e($gCat->name); ?></a>
            <div class="mega-menu">
                <div class="mega-menu__column">
                    <div class="row">
                        <?php $__currentLoopData = $gCat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($pCat->childrenCategories->count() > 0): ?>
                                <div class="col-4 mb-5">
                                    <h4><?php echo e($pCat->name); ?></h4>
                                    <hr>

                                    <ul class="mega-menu__list">
                                        <?php $__currentLoopData = $pCat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="current-menu-item "><a
                                                    href="<?php echo e(route('category.shop',$sCat->slug)); ?>"><?php echo e($sCat->name); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>
                                </div>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                </div>

                <div class="card w-30 brand-overflow">
                    <?php $__currentLoopData = brandsShuffle(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brandShuffle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img class="card-img-top mb-2" src="<?php echo e(filePath($brandShuffle->logo)); ?>" alt="#<?php echo e($brandShuffle->name); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>

        </li>

            <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </ul>
</div>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/include/sidebar/desktop/category-sidebar.blade.php ENDPATH**/ ?>