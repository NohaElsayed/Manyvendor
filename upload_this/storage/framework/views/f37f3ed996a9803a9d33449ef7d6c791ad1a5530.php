
<?php if(\Illuminate\Support\Facades\Auth::user()->user_type == 'Deliver'): ?>
    <form class="border border-light p-5" action="<?php echo e(route('deliver.order.followup_comment', $followup)); ?>" method="POST"
          enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
<?php else: ?>
            <form class="border border-light p-5" action="<?php echo e(route('order.followup_comment', $followup)); ?>" method="POST"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
<?php endif; ?>



    <label for="textarea">Write a reason for follow up.</label>
    <textarea id="textarea" name="comment" class="form-control mb-4" placeholder="Customer did not pick up the call"
              required></textarea>

    <button class="btn btn-info btn-block my-4" type="submit">Submit</button>

</form>


<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/orders/followup_modal.blade.php ENDPATH**/ ?>