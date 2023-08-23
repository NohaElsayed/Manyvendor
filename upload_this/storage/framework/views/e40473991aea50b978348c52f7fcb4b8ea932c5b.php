<div class="ps-panel--sidebar" id="menu-mobile">
    <div class="ps-panel__header">
        <h3>Menu</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            <?php if(vendorActive()): ?>
                <li><a href="<?php echo e(route('all.product')); ?>">All Products</a></li>
                <li><a href="<?php echo e(route('vendor.shops')); ?>">All Shops</a></li>
                <li><a href="<?php echo e(route('brands')); ?>">All Brands</a></li>
                <li><a href="<?php echo e(route('customer.campaigns.index')); ?>">Campaigns</a></li>
                <li><a href="<?php echo e(route('vendor.signup')); ?>">Be a seller</a></li>
                <?php if(affiliateRoute() && affiliateActive()): ?>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->user_type != "Admin" && Auth::user()->user_type != "Vendor"): ?>
                            <li><a href="<?php echo e(route('customers.affiliate.registration')); ?>">Affiliate Marketing</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(auth()->guard()->guest()): ?>
                        <li><a href="<?php echo e(route('customers.affiliate.registration')); ?>">Affiliate Marketing</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="<?php echo e(route('all.product')); ?>">All Products</a></li>
                <li><a href="<?php echo e(route('customer.campaigns.index')); ?>">Campaigns</a></li>
                <?php if(affiliateRoute() && affiliateActive()): ?>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->user_type != "Admin" && Auth::user()->user_type != "Vendor"): ?>
                            <li><a href="<?php echo e(route('customers.affiliate.registration')); ?>">Affiliate Marketing</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(auth()->guard()->guest()): ?>
                        <li><a href="<?php echo e(route('customers.affiliate.registration')); ?>">Affiliate Marketing</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/include/sidebar/mobile/mobile-menu.blade.php ENDPATH**/ ?>