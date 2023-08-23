<footer class="ps-footer ps-footer--3 t-pt-70 t-pb-70 p-xl-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div class="ps-block--site-features ps-block--site-features-2 bg-white d-flex justify-content-center mt-5">
            <?php $__currentLoopData = infopage('bottom',4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($p->page != null): ?>
                    <div class="ps-block__item">
                        <a href="<?php echo e(route('frontend.page',$p->page->slug)); ?>">
                            <div class="ps-block__left"><i class="<?php echo e($p->icon); ?>"></i></div>
                            <div class="ps-block__right">
                                <a href="<?php echo e(route('frontend.page',$p->page->slug)); ?>">
                                    <h4><?php echo e($p->header); ?></h4>
                                    <p><?php echo e($p->desc); ?></p>
                                </a>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6 col-xl-3 mb-5 mb-xl-0 mt-5">
            <h4 class="s-footer text-uppercase mt-0">
                Contact Us
            </h4>
            <p>
                Call us 24/7
            </p>
            <ul class="info-list">
                <li class="info-list__item">
                    <?php echo e(getSystemSetting('type_address')); ?>

                </li>
                <li class="info-list__item">
                <span class="info-list__icon">
                <i class="fa fa-phone-square"></i>
                </span>
                
                    Phone: <?php echo e(getSystemSetting('type_number')); ?>

                </li>
            </ul>
            <ul class="social-list mt-4">
                <?php if(getSystemSetting('type_fb')): ?>
                    <li class="social-list__item">
                        <a href="<?php echo e(getSystemSetting('type_fb')); ?>" target="_blank" class="social-list__icon social-list__icon-fb">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(getSystemSetting('type_tw')): ?>
                        <li class="social-list__item">
                            <a href="<?php echo e(getSystemSetting('type_tw')); ?>" target="_blank" class="social-list__icon social-list__icon-tw">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                <?php endif; ?>
                <?php if(getSystemSetting('type_google')): ?>
                        <li class="social-list__item">
                            <a href="<?php echo e(getSystemSetting('type_google')); ?>" target="_blank" class="social-list__icon social-list__icon-pin">
                                <i class="fa fa-google"></i>
                            </a>
                        </li>
                <?php endif; ?>
            </ul>
        </div>

        <?php $__currentLoopData = \App\Models\PageGroup::where('is_published',true)->with('pages')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageGroups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($pageGroups->pages->count() >0): ?>
                    <div class="col-md-4 col-xl-2 mb-5 mb-xl-0 mt-5">
                        <h4 class="s-footer text-uppercase mt-0">
                            <?php echo e($pageGroups->name); ?>

                        </h4>
                        <ul class="footer-list">

                            <?php $__currentLoopData = $pageGroups->pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="footer-list__item">
                                    <a href="<?php echo e(route('frontend.page',$page->slug)); ?>" class="footer-list__link">
                                        <?php echo e($page->title); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="ps-footer__copyright mt-5 mb-0 border-0">
            <?php if(getSystemSetting('payment_logo') != null): ?>
                <p><span>Your payments are secured</span>
                    <img src="<?php echo e(filePath(getSystemSetting('payment_logo'))); ?>" class="logo-payment-footer"></p>
            <?php endif; ?>
            <?php if(getSystemSetting('type_android')!== null || getSystemSetting('type_ios') !== null): ?>
                <p class="mx-2">
                    <?php if(getSystemSetting('type_android')!== null): ?>
                    <a href="<?php echo e(getSystemSetting('type_android')); ?>" target="_blank">
                        <img src="<?php echo e(filePath(getSystemSetting('type_playstore'))); ?>" class="mobile-application"/>
                    </a>
                    <?php endif; ?>
                    <?php if(getSystemSetting('type_ios')!== null): ?>
                    <a href="<?php echo e(getSystemSetting('type_ios')); ?>" target="_blank">
                        <img src="<?php echo e(filePath(getSystemSetting('type_appstore'))); ?>" class="mobile-application"/>
                    </a>
                    <?php endif; ?>
                </p>
                <?php endif; ?>

                <p>© <?php echo e(date('Y')); ?> <?php echo e(getSystemSetting('type_footer')); ?></p>

        </div>
    </div>
</footer>

<div id="back2top"><i class="pe-7s-angle-up"></i></div>


<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/include/footer/footer.blade.php ENDPATH**/ ?>