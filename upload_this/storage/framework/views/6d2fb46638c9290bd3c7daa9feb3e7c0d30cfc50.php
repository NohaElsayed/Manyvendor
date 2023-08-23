<?php $__currentLoopData = categories(10, 'is_popular'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $home_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(vendorActive()): ?>
        <?php if($home_category->is_popular == 1): ?>
            <div class="ps-product-box">
                <div class="container">
                    <div class="ps-block--product-box">
                        <div class="ps-block__header">
                            <h3>
                                <i class="<?php echo e($home_category->icon); ?>"></i> <?php echo e($home_category->name); ?>

                            </h3>
                            <ul>

                                <?php
                                    $category_child_limit = 0;
                                ?>

                                <?php $__currentLoopData = $home_category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent_Cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $parent_Cat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <input type="hidden" value="<?php echo e($category_child_limit++); ?>">
                                        <li>
                                            <a
                                                href="<?php echo e(route('category.shop',$sub_cat->slug)); ?>"><?php echo e($sub_cat->name); ?>

                                            </a>
                                        </li>

                                        <?php if($category_child_limit == 8): ?>
                                            <?php break; ?>
                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($category_child_limit == 8): ?>
                                            <?php break; ?>
                                        <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        <div class="ps-carousel--nav-inside owl-slider px-5 pt-5" data-owl-auto="true"
                                     data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0"
                                     data-owl-nav="true" data-owl-dots="true" data-owl-item="1"
                                     data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1"
                                     data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">

                                    <?php $__currentLoopData = $home_category->promotionBanner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e($banner->link); ?>">
                                            <img src="<?php echo e(filePath($banner->image)); ?>" alt="">
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>


                        <div class="ps-block__content">
                            <div class="ps-block__left">
                                <div class="ps-block__products ps-tab-root">
                                    <ul class="ps-tab-list">
                                        <li class="current"><a
                                                href="#product-box-<?php echo e($home_category->id); ?>">
                                                New Items
                                            </a></li>
                                        <li>
                                            <a
                                                href="#product-box-<?php echo e($home_category->id); ?>-sale">Discount</a>
                                        </li>
                                    </ul>
                                    <div class="ps-tabs">
                                                    <?php
                                                        $product_limit = 0;
                                                        $sale_product_limit = 0;
                                                        $related_product_limit = 0;
                                                    ?>
                                        <div class="ps-tab active"
                                             id="product-box-<?php echo e($home_category->id); ?>">
                                            <div class="row">
                                                <?php $__currentLoopData = $home_category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <?php $__currentLoopData = $subcategory->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <?php $__empty_1 = true; $__currentLoopData = $cat->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                                        <input type="hidden" value="<?php echo e($product_limit++); ?>">

                                                        <div class="col-md-3 col-xl-3 t-mb-30">
                                                            <a href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>" class="product-card">
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
                                                                <span class="product-card__img-wrapper">
                                                                    <img src="<?php echo e(filePath($product->image)); ?>" alt="manyvendor" class="img-fluid mx-auto">
                                                                </span>
                                                                <span class="product-card__body">
                                                                    <span class="product-card__title">
                                                                        <?php echo e($product->name); ?>

                                                                    </span>
                                                                    <span class="t-mt-10 d-block">
                                                                    <span class="product-card__discount-price t-mr-5">
                                                                        <?php echo e(formatPrice(brandProductPrice($product->sellers)->min())
                                                                           == formatPrice(brandProductPrice($product->sellers)->max())
                                                                           ? formatPrice(brandProductPrice($product->sellers)->min())
                                                                           : formatPrice(brandProductPrice($product->sellers)->min()).
                                                                           '-' .formatPrice(brandProductPrice($product->sellers)->max())); ?>

                                                                    </span>
                                                                    </span>

                                                                </span>
                                                            </a>
                                                        </div>


                                                        <?php if($product_limit == 8): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($product_limit == 8): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($product_limit == 8): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        </div>

                                        <div class="ps-tab" id="product-box-<?php echo e($home_category->id); ?>-sale">
                                            <div class="row">
                                                <?php $__currentLoopData = $home_category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $subcategory->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $__currentLoopData = $cat->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $__empty_2 = true; $__currentLoopData = $product->vendorProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                <?php if($sale_item->is_discount != null): ?>
                                                                    <input type="hidden" value="<?php echo e($sale_product_limit++); ?>">
                                                                    <?php if($sale_product_limit <= 8): ?>
                                                                        <div class="col-md-3 col-xl-3 t-mb-30">
                                                                            <a href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>" class="product-card">
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
                                                                                            <span class="product-card__img-wrapper">
                                                                                <img src="<?php echo e(filePath($product->image)); ?>" alt="manyvendor" class="img-fluid mx-auto">
                                                                            </span>
                                                                                            <span class="product-card__body">
                                                                                <span class="product-card__title">
                                                                                    <?php echo e($product->name); ?>

                                                                                </span>

                                                                                <span class="t-mt-10 d-block">

                                                                                <div class="ps-product__badge out-stock">
                                                                                    Discount <?php echo e(number_format(doubleval($sale_item->discount_percentage - 100), 2, '.', '')); ?>%
                                                                                </div>
                                                                                <span class="product-card__discount-price t-mr-5">
                                                                                    <?php echo e(formatPrice($sale_item->discount_price)); ?>

                                                                                </span>
                                                                                    <del>
                                                                                    <?php echo e(formatPrice($sale_item->product_price)); ?>

                                                                                    </del>
                                                                                </span>

                                                                            </span>
                                                                            </a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-block__right">
                                <figure>
                                    <figcaption>You may like
                                    </figcaption>
                                    <?php $__currentLoopData = $home_category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $subcategory->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $cat->recommended->shuffle(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <input type="hidden" value="<?php echo e($related_product_limit++); ?>">
                                                                    <?php if($related_product_limit <= 8): ?>
                                                <div class="ps-product--horizontal">
                                                    <div class="ps-product__thumbnail">
                                                        <a
                                                            href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>"><img
                                                                src="<?php echo e(filePath($product->image)); ?>" class="rounded"
                                                                alt="#<?php echo e($product->name); ?>"></a>
                                                    </div>
                                                    <div class="ps-product__content">
                                                        <a class="ps-product__title"
                                                           href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>"><?php echo e($product->name); ?></a>

                                                        <p class="ps-product__price may-like">

                                                            <span class="product-card__discount-price t-mr-5">
                                                                        <?php echo e(formatPrice(brandProductPrice($product->sellers)->min())
																   == formatPrice(brandProductPrice($product->sellers)->max())
																   ? formatPrice(brandProductPrice($product->sellers)->min())
																   : formatPrice(brandProductPrice($product->sellers)->min()).
																   '-' .formatPrice(brandProductPrice($product->sellers)->max())); ?>

                                                                    </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </figure>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <?php if($home_category->is_popular == 1): ?>
            <div class="ps-product-box">
                <div class="container">
                    <div class="ps-block--product-box">
                        <div class="ps-block__header">
                            <h3>
                                <i class="<?php echo e($home_category->icon); ?>"></i> <?php echo e($home_category->name); ?>

                            </h3>
                            <ul>

                                <?php
                                    $category_child_limit = 0;
                                ?>

                                <?php $__currentLoopData = $home_category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent_Cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $parent_Cat->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <input type="hidden" value="<?php echo e($category_child_limit++); ?>">

                                        <li>
                                            <a
                                                href="<?php echo e(route('category.shop',$sub_cat->slug)); ?>"><?php echo e($sub_cat->name); ?></a>
                                        </li>

                                        <?php if($category_child_limit == 8): ?>
                                            <?php break; ?>
                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($category_child_limit == 8): ?>
                                        <?php break; ?>
                                    <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        <div class="ps-carousel--nav-inside owl-slider" data-owl-auto="true"
                             data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0"
                             data-owl-nav="true" data-owl-dots="true" data-owl-item="1"
                             data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1"
                             data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">

                            <?php $__currentLoopData = $home_category->promotionBanner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e($banner->link); ?>">
                                    <img src="<?php echo e(filePath($banner->image)); ?>" alt="">
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                        <div class="ps-block__content">
                            <div class="ps-block__left">
                                <div class="ps-block__products ps-tab-root">
                                    <ul class="ps-tab-list">
                                        <li class="current"><a
                                                href="#product-box-<?php echo e($home_category->id); ?>">
                                                New Items</a></li>
                                        <li>
                                            <a
                                                href="#product-box-<?php echo e($home_category->id); ?>-sale">Discount</a>
                                        </li>
                                    </ul>
                                    <div class="ps-tabs">
                                         New arrival


                                        <?php
                                            $product_limit = 0;
                                            $sale_product_limit = 0;
                                            $related_product_limit = 0;
                                        ?>

                                        <div class="ps-tab active"
                                             id="product-box-<?php echo e($home_category->id); ?>">
                                            <div class="row">
                                                <?php $__currentLoopData = $home_category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $subcategory->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $__currentLoopData = $cat->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <input type="hidden" value="<?php echo e($product_limit++); ?>">

                                                            <div class="col-md-3 col-xl-3 t-mb-30">
                                                                <a href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>" class="product-card">
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
                                                                    <span class="product-card__img-wrapper">
                                                                    <img src="<?php echo e(filePath($product->image)); ?>" alt="manyvendor" class="img-fluid mx-auto">
                                                                </span>
                                                                    <span class="product-card__body">
                                                                    <span class="product-card__title">
                                                                        <?php echo e($product->name); ?>

                                                                    </span>

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

                                                                </span>
                                                                </a>
                                                            </div>

                                                                <?php if($product_limit == 8): ?>
                                                                    <?php break; ?>
                                                                <?php endif; ?>

                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($product_limit == 8): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if($product_limit == 8): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        </div>

                                         Sale
                                        <div class="ps-tab" id="product-box-<?php echo e($home_category->id); ?>-sale">
                                            <div class="row">
                                                <?php $__currentLoopData = $home_category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $subcategory->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $__currentLoopData = $cat->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($product->is_discount): ?>

                                                                <input type="hidden" value="<?php echo e($sale_product_limit++); ?>">

                                                                <div class="col-md-3 col-xl-3 t-mb-30">
                                                                    <a href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>" class="product-card">
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
                                                                        <span class="product-card__img-wrapper">
                                                                            <img src="<?php echo e(filePath($product->image)); ?>" alt="manyvendor" class="img-fluid mx-auto">
                                                                        </span>
                                                                        <span class="product-card__body">
                                                                        <span class="product-card__title">
                                                                            <?php echo e($product->name); ?>

                                                                        </span>

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
                                                                    </span>
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php if($sale_product_limit == 8): ?>
                                                                    <?php break; ?>
                                                                <?php endif; ?>

                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($sale_product_limit == 8): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if($sale_product_limit == 8): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-block__right">
                                <figure>
                                    <figcaption>You may like
                                    </figcaption>
                                    <?php $__currentLoopData = $home_category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $subcategory->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $cat->recommended->shuffle(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <input type="hidden" value="<?php echo e($related_product_limit++); ?>">

                                                <div class="ps-product--horizontal">
                                                    <div class="ps-product__thumbnail">
                                                        <a
                                                            href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>"><img
                                                                src="<?php echo e(filePath($product->image)); ?>" class="rounded"
                                                                alt="#<?php echo e($product->name); ?>"></a>
                                                    </div>
                                                    <div class="ps-product__content">
                                                        <a class="ps-product__title"
                                                           href="<?php echo e(route('single.product',[$product->sku,$product->slug])); ?>"><?php echo e($product->name); ?></a>

                                                        <p class="ps-product__price may-like">
                                                            <?php if($product->is_discount === 1): ?>
                                                                <span><?php echo e(formatPrice($product->discount_price)); ?></span>
                                                                <del><?php echo e(formatPrice($product->product_price)); ?></del>
                                                            <?php else: ?>
                                                                <?php echo e(formatPrice($product->product_price)); ?>

                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php if($related_product_limit == 6): ?>
                                                                    <?php break; ?>
                                                                <?php endif; ?>

                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($related_product_limit == 6): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if($related_product_limit == 6): ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </figure>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/widgets/section/category-promotional.blade.php ENDPATH**/ ?>