
<form class="border border-light p-5" action="<?php echo e(route('deliver.pick.store')); ?>" method="POST"
      enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <input name="id" value="<?php echo e($deliver->id); ?>" type="hidden">

    <label for="textarea">Deliver within date.</label>
    <input name="duration" class="form-control" type="date" placeholder="Deliver within date" required>
    <button class="btn btn-info btn-block my-4" type="submit">Submit</button>

</form>


<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/deliver/durationToDeliver.blade.php ENDPATH**/ ?>