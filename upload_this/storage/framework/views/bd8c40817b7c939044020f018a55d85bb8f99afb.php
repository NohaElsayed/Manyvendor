<article class="ps-product--detail ps-product--fullwidth ps-product--quickview">
    <div class="ps-product__header">
        <div class="ps-product__thumbnail" data-vertical="false">
            <div class="ps-product__images d-none" data-arrow="true">
                <?php $__currentLoopData = $quick_product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item">
                        <img src="<?php echo e(filePath($quick_product->image)); ?>" alt="#<?php echo e($quick_product->name); ?>">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="ps-product__images" data-arrow="true">
                <div class="item">
                    <img src="<?php echo e(filePath($quick_product->image)); ?>" alt="#<?php echo e($quick_product->name); ?>">
                </div>
            </div>

        </div>
        <div class="ps-product__info">
            <h1><?php echo e($quick_product->name); ?></h1>
                <div class="ps-product__meta border-0 mb-1">
                    <p>Brand: <a
                                href="<?php echo e(route('single.product',[$quick_product->sku,$quick_product->slug])); ?>"><?php echo e($quick_product->brand->name); ?></a>
                    </p>
                </div>
                <?php if(vendorActive()): ?>
                <h4 class="ps-product__price d-none">
                    <span class="t-mt-10 d-block">
                        <span class="product-card__discount-price t-mr-5">
                            <?php echo e(formatPrice(brandProductPrice($quick_product->sellers)->min())
                               == formatPrice(brandProductPrice($quick_product->sellers)->max())
                               ? formatPrice(brandProductPrice($quick_product->sellers)->min())
                               : formatPrice(brandProductPrice($quick_product->sellers)->min()).
                               '-' .formatPrice(brandProductPrice($quick_product->sellers)->max())); ?>

                        </span>
                    </span>
                </h4>
                <?php else: ?>
                <h4 class="ps-product__price">
                    <?php if($quick_product->is_discount): ?>
                        <p class="ps-product__price sale"><?php echo e(formatPrice($quick_product->discount_price)); ?>

                            <del>
                                <?php echo e(formatPrice($quick_product->product_price)); ?></del>
                        </p>
                    <?php else: ?>
                        <p class="ps-product__price"><?php echo e(formatPrice($quick_product->product_price)); ?></p>
                    <?php endif; ?>
                </h4>
                <?php endif; ?>
            <div class="ps-product__desc">
                <?php echo $quick_product->short_desc; ?>

            </div>
        </div>
    </div>
</article>
 <?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/include/product/quickview.blade.php ENDPATH**/ ?>