<?php if(vendorActive()): ?>
<div class="p-30">
    <div class="container">
      <div class="row">
          <div class="col-8">
              <div class="ps-section__header">
          <h3 class="text-capitalize">Shop by Brand</h3>
      </div>
          </div>
          <div class="col-4 text-right">
              <a href="<?php echo e(route('brands')); ?>" class="h3">
                      View All
              </a>
          </div>
      </div>
        <div class="ps-section__content">
            <div class="ps-block--categories-tabs ps-tab-root">
                <div class="ps-tabs">
                    <div class="ps-tabs">
                        <div class="ps-tab active">

                        <div class="row">
                                    <?php $__empty_1 = true; $__currentLoopData = brands(16); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="col-md-3 col-xl-2 t-mb-30">
                                        <a href="<?php echo e(route('brand.shop', $brand->slug)); ?>" class="brand-product-card">

                                            <?php if(empty($brand->logo)): ?>
                                            <span class="product-card__img-wrapper brand-product-card__img-wrapper">
                                                <img src="<?php echo e(asset('vendor-store.jpg')); ?>" alt="<?php echo e($brand->name); ?>" width="133" height="133" class="img-fluid mx-auto">
                                            </span>
                                             <?php else: ?>

                                                <span class="product-card__img-wrapper brand-product-card__img-wrapper">
                                                <img src="<?php echo e(filePath($brand->logo)); ?>" alt="<?php echo e($brand->name); ?>" class="img-fluid mx-auto">
                                            </span>

                                             <?php endif; ?>



                                            <span class="product-card__body">
                                                <span class="product-card__title text-center">
                                                    <?php echo e(\Illuminate\Support\Str::limit($brand->name,14)); ?>

                                                </span>

                                            </span>
                                        </a>
                                    </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <img src="<?php echo e(asset('No-Brand-Found.jpg')); ?>" class="img-fluid" alt="#no-brand-found">
                              <?php endif; ?>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/widgets/section/shop-brand.blade.php ENDPATH**/ ?>