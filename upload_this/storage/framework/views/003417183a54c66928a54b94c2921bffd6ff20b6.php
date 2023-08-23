<?php if(subCategory()->count() >0): ?>
    <div class="ps-search-trending">
        <div class="container">
            <div class="ps-section__header">
                <h3>Trending<span></span></h3>
            </div>
            <div class="ps-section__content">
                <div class="ps-block--categories-tabs ps-tab-root">
                    <div class="ps-block__header">
                        <div class="ps-carousel--nav ps-tab-list owl-slider" data-owl-auto="false"
                             data-owl-speed="1000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true"
                             data-owl-item="8" data-owl-item-xs="3" data-owl-item-sm="4"
                             data-owl-item-md="6" data-owl-item-lg="6" data-owl-duration="500"
                             data-owl-mousedrag="on">
                            <?php $__currentLoopData = subCategory(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#tab-<?php echo e($subCat->id); ?>">
                                    <i class="<?php echo e($subCat->icon); ?>"></i>
                                    <span class="<?php echo e($loop->index == 0 ? 'text-danger':''); ?>"><?php echo e($subCat->name); ?></span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="ps-tabs">
                        <div class="ps-tabs">
                            <?php $__currentLoopData = subCategory(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="ps-tab <?php echo e($loop->index == 0 ? 'active':""); ?>" id="tab-<?php echo e($subCat->id); ?>">
                                    <div class="row">

                                        <?php
                                            $trending_products = 0;
                                        ?>

                                    <?php $__currentLoopData = $subCat->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <input type="hidden" value="<?php echo e($trending_products++); ?>">

                                        <div class="col-md-3 col-xl-2 t-mb-30">
                                            <a href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>" class="trending-product-card product-card">
                                                <span class="product-card__action d-flex flex-column align-items-center ">
                                                    <span class="product-card__action-is product-card__action-view"
                                                    onclick="forModal('<?php echo e(route('quick.view',$product->slug)); ?>', 'Product quick view')">
                                                    <i class="fa fa-eye"></i>
                                                    </span>
                                                    <span class="product-card__action-is product-card__action-compare"
                                                    onclick="addToCompare(<?php echo e($product->id); ?>)">
                                                    <i class="fa fa-random"></i>
                                                    </span>


                                                    <?php if(auth()->guard()->check()): ?>
                                                                    <span class="product-card__action-is product-card__action-wishlist"
                                                                    onclick="addToWishlist(<?php echo e($product->id); ?>)">
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                                                <?php endif; ?>

                                                                <?php if(auth()->guard()->guest()): ?>
                                                                    <span 
                                                                class="product-card__action-is product-card__action-wishlist wishlist"
                                                                data-placement="top" 
                                                                data-title="Add to wishlist"
                                                                data-toggle="tooltip" 
                                                                data-product_name='<?php echo e($product->name); ?>' 
                                                                data-product_id='<?php echo e($product->id); ?>' 
                                                                data-product_sku='<?php echo e($product->sku); ?>' 
                                                                data-product_slug='<?php echo e($product->slug); ?>' 
                                                                data-product_image='<?php echo e(filePath($product->image)); ?>' 
                                                                data-app_url='<?php echo e(env('APP_URL')); ?>' 
                                                                data-product_price='<?php echo e(formatPrice(brandProductPrice($product->sellers)->min())
                                                                                                == formatPrice(brandProductPrice($product->sellers)->max())
                                                                                                ? formatPrice(brandProductPrice($product->sellers)->min())
                                                                                                : formatPrice(brandProductPrice($product->sellers)->min()).
                                                                                                '-' .formatPrice(brandProductPrice($product->sellers)->max())); ?>'    
                                                                >
                                                                    <i class="fa fa-heart-o"></i>
                                                                    </span>
                                                                <?php endif; ?>

                                                                
                                                    

                                                                    
                                                </span>
                                                <span class="product-card__img-wrapper trending-product-card__img-wrapper">
                                                    <img src="<?php echo e(filePath($product->image)); ?>" alt="<?php echo e(\Illuminate\Support\Str::limit($product->name,14)); ?>" class="img-fluid mx-auto">
                                                </span>
                                                <span class="product-card__body">
                                                    <span class="product-card__title">
                                                        <?php echo e(\Illuminate\Support\Str::limit($product->name,14)); ?>

                                                    </span>

                                                    <?php if(vendorActive()): ?>

                                                        <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                        <?php echo e(formatPrice(brandProductPrice($product->sellers)->min())
                                                                           == formatPrice(brandProductPrice($product->sellers)->max())
                                                                           ? formatPrice(brandProductPrice($product->sellers)->min())
                                                                           : formatPrice(brandProductPrice($product->sellers)->min()).
                                                                           '-' .formatPrice(brandProductPrice($product->sellers)->max())); ?>

                                                                    </span>
                                                        </span>

                                                    <?php else: ?>

                                                    <span class="t-mt-10 d-block">
                                                                        <?php if($product->is_discount): ?>
                                                                            <span class="product-card__discount-price t-mr-5">
                                                                            <?php echo e(formatPrice($product->discount_price)); ?>

                                                                        </span>
                                                                            <del class="product-card__price">
                                                                            <?php echo e(formatPrice($product->product_price)); ?>

                                                                        </del>
                                                                        <?php else: ?>
                                                                            <span class="product-card__discount-price t-mr-5">
                                                                            <?php echo e(formatPrice($product->product_price)); ?>

                                                                            </span>
                                                                        <?php endif; ?>

                                                                    </span>
                                                        
                                                    <?php endif; ?>
                                                    




                                            </a>

                                        </div>

                                        <?php if($trending_products == 18): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/widgets/section/search-trending.blade.php ENDPATH**/ ?>