

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="text-center mt-5">
                    <img src="<?php echo e(asset('shopping_success.png')); ?>" class="w-50" alt="">
                </div>


                <p class="m-5 h2 text-center">
                    <?php if(auth()->guard()->check()): ?>
                    Dear <?php echo e(Auth::user()->name); ?>,
                    <br/>
                    <?php endif; ?>
                    Thank you for your purchase.
                    <br>
                    Your order has been successfully placed.<br/>
                    Your Booking code -

                        <?php if(session()->has('booking')): ?>
                            <?php $__currentLoopData = $booking_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <strong>#<?php echo e($booking_code); ?>,</strong>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <?php else: ?>
                            
                            <?php $__currentLoopData = $order_booking_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order_booking_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <strong>#<?php echo e($order_booking_code->booking_code); ?>,</strong>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endif; ?>

                    
                    <br>
                    Please check your email for more details.
                    <br>
                </p>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        "use strict"
        $(document).ready(function () {
            localStorage.removeItem('guest_cart_items');
            guestCartList();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/checkout/success.blade.php ENDPATH**/ ?>