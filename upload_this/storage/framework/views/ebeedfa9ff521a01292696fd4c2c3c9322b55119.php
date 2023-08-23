<?php if(vendorActive()): ?>
<div class="p-30">
    <div class="container">
      <div class="row">
          <div class="col-8">
              <div class="ps-section__header">
          <h3 class="text-capitalize">Shop by Store</h3>
      </div>
          </div>
          <div class="col-4 text-right">
              <a href="<?php echo e(route('vendor.shops')); ?>" class="h3">
                      View All
              </a>
          </div>
      </div>
        <div class="ps-section__content">
            <div class="ps-block--categories-tabs ps-tab-root store_section">
                <div class="ps-tabs">
                    <div class="ps-tabs">
                        <div class="ps-tab active p-0">

                        <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $shop_by_store = App\User::where('user_type','Vendor')->latest()->paginate(paginate()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                       <?php if($store->vendor != null): ?>
                        <div class="col-md-3 col-xl-2 t-mb-30">
                            <a href="<?php echo e(route('vendor.shop',$store->vendor->slug)); ?>" class="product-card store-product-card">

                                <?php if(empty($store->vendor->shop_logo)): ?>
                                <span class="product-card__img-wrapper store-product-card__img-wrapper">
                                    <img src="<?php echo e(asset('vendor-store.jpg')); ?>" alt="<?php echo e($store->vendor->shop_name); ?>" class="img-fluid mx-auto">
                                </span>
                                 <?php else: ?>

                                 <span class="product-card__img-wrapper store-product-card__img-wrapper">
                                    <img src="<?php echo e(asset($store->vendor->shop_logo)); ?>" alt="<?php echo e($store->vendor->shop_name); ?>" class="img-fluid mx-auto">
                                </span>

                                 <?php endif; ?>


                                <span class="product-card__body">
                                    <span class="product-card__title text-center">
                                        <?php echo e($store->vendor->shop_name); ?>

                                    </span>

                                </span>
                            </a>
                        </div>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                              <div class="col-md-12 col-sm-12">
                                <img src="<?php echo e(asset('shop-not-found.png')); ?>" alt="">
                            </div>
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
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/widgets/section/shop-store.blade.php ENDPATH**/ ?>