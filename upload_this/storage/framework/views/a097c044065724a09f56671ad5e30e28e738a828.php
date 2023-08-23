
<?php if(vendorActive()): ?>
<input type="hidden" class="add-to-campaign-url" value="<?php echo e(route('seller.campaign.products.store')); ?>">
<input type="hidden" class="remove-from-campaign-url" value="<?php echo e(route('seller.campaign.products.destroy')); ?>">
    <?php else: ?>
    <input type="hidden" class="add-to-campaign-url" value="<?php echo e(route('admin.campaign.products.store')); ?>">
    <input type="hidden" class="remove-from-campaign-url" value="<?php echo e(route('admin.campaign.products.destroy')); ?>">
<?php endif; ?>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/layouts/includes/url.blade.php ENDPATH**/ ?>