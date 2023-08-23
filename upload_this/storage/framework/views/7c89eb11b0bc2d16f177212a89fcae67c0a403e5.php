
<form class="border border-light p-5" action="<?php echo e(route('order.location.status.store')); ?>" method="POST"
      enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <input name="deliver_assign_id" value="<?php echo e($deliver->id); ?>" type="hidden">
    <input name="order_id" value="<?php echo e($deliver->order_id); ?>" type="hidden">
    <label for="textarea">Write present location.</label>
    <textarea id="textarea" name="location" class="form-control mb-4" placeholder="Add location"
              required></textarea>

    <button class="btn btn-info btn-block my-4" type="submit">Submit</button>

</form>


<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/deliver/location.blade.php ENDPATH**/ ?>