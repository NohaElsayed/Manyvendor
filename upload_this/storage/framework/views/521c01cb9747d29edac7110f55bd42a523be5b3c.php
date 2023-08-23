<div class="ps-panel--sidebar" id="navigation-mobile">
    <div class="ps-panel__header">
        <h3>Categories</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
          <?php $__currentLoopData = categories(9,null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($gCat->childrenCategories->count() > 0): ?>
            <li class="current-menu-item menu-item-has-children has-mega-menu">
              <a href="<?php echo e(route('category.shop',$gCat->slug)); ?>"><?php echo e($gCat->name); ?></a>
              <span class="sub-toggle"></span>
                <div class="mega-menu">
                    <div class="mega-menu__column">
                      <?php $__currentLoopData = $gCat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <h4><?php echo e($pCat->name); ?><span class="sub-toggle"></span></h4>
                        <ul class="mega-menu__list">
                          <?php $__currentLoopData = $pCat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="current-menu-item ">
                              <a href="<?php echo e(route('category.shop',$sCat->slug)); ?>"><?php echo e($sCat->name); ?></a>
                            </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </li>
                <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/include/sidebar/mobile/category-sidebar.blade.php ENDPATH**/ ?>