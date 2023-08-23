
<?php $__env->startSection('title'); ?> Assign Orders <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(vendorActive()): ?>
        <div class="card card-primary card-outline">
            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered border" id="example">
                    <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Booking Code</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Delivery Address</th>
                        <th scope="col">Seller Address</th>
                        <th scope="col">Product</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $assignOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php if($getOrder->orderDetails->status == 'confirmed'): ?>
                            <tr>
                                <td scope="row"><?php echo e($loop->index++ + 1); ?></td>
                                <td>
                                    <span class="d-block">
                                        BK Code - #<?php echo e($getOrder->orderDetails->booking_code); ?>

                                    </span>
                                    <span class="d-block">
                                        Order Number - #<?php echo e($getOrder->orderDetails->order_number); ?>

                                    </span>
                                    <span class="d-block">
                                        Logistic - <?php echo e($getOrder->orderDetails->order->logistic->name ?? null); ?>

                                    </span>

                                </td>
                                <td>
                                    <span class="d-block text-uppercase">
                                       Payment <?php echo e($getOrder->orderDetails->payment_type); ?>

                                    </span>

                                    <span class="d-block">
                                        Coupon - <?php echo e($getOrder->orderDetails->order->applied_coupon ?? 'N/A'); ?>

                                    </span>
                                    <span class="d-block">
                                        Shipping - <?php echo e(formatPrice($getOrder->orderDetails->order->logistic_charge)); ?>

                                    </span>
                                    <span class="d-block">
                                        Quantity - <?php echo e($getOrder->orderDetails->quantity); ?>

                                        Total - <?php echo e(formatPrice($getOrder->orderDetails->order->pay_amount)); ?>

                                    </span>
                                </td>
                                <td class="w-20">
                                    <span class="d-block">
                                        Name - <?php echo e($getOrder->orderDetails->user ? $getOrder->orderDetails->user->name: 'Guest Order'); ?>

                                    </span>
                                    <span class="d-block">
                                        Phone - <?php echo e($getOrder->orderDetails->order->phone); ?>

                                    </span>
                                    <span class="d-block">
                                Address - <?php echo e($getOrder->orderDetails->order->address); ?>,
                                <?php echo e($getOrder->orderDetails->order->area->thana_name); ?>,
                                <?php echo e($getOrder->orderDetails->order->division->district_name); ?>

                                    </span>
                                    <span class="d-block">
                                        Note - <?php echo e($getOrder->orderDetails->order->note ?? 'N/A'); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="d-block">
                                        Shop Name - <?php echo e($getOrder->orderDetails->seller->shop_name); ?>

                                    </span>
                                    <span class="d-block">
                                        Shop Email - <?php echo e($getOrder->orderDetails->seller->email); ?>

                                    </span>
                                    <span class="d-block">
                                        Shop Phone - <?php echo e($getOrder->orderDetails->seller->phone); ?>

                                    </span>
                                    <span class="d-block">
                                        Shop Address - <?php echo e($getOrder->orderDetails->seller->adrress ?? 'N/A'); ?>

                                    </span>
                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        <img src="<?php echo e(filePath($getOrder->orderDetails->product->product->image)); ?>"
                                             class="w-25"
                                             alt="#<?php echo e($getOrder->orderDetails->product->product->name); ?>">
                                    </span>
                                    <span class="d-block">
                                        Name - <?php echo e($getOrder->orderDetails->product->product->name); ?> -
                                <?php echo e($getOrder->orderDetails->vendor_product_stock->product_variants); ?>

                                    </span>
                                    <span class="d-block">
                                        SKU - <?php echo e($getOrder->orderDetails->product->product->sku); ?>

                                    </span>

                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        <?php if(isset($getOrder->orderDetails->comment) || isset($getOrder->orderDetails->commentedBy)): ?>
                                            <?php echo e($getOrder->orderDetails->comment ?? 'N/A'); ?>

                                            By <?php echo e($getOrder->orderDetails->commentedBy->name ?? 'N/A'); ?>

                                        <?php else: ?>
                                            No Comment
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($getOrder->orderDetails->status != 'delivered'): ?>
                                        <?php if($getOrder->pick): ?>

                                            <a onclick="forModal('<?php echo e(route('order.location.status', $getOrder->id)); ?>','Update location')"
                                               href="javascript:void(0)"
                                               class="btn-sm btn-dark d-block m-2 text-center">Update Location</a>

                                            <a href="javascript:void(0)"
                                               onclick="forModal('<?php echo e(route('deliver.order.followup', $getOrder->orderDetails->id)); ?>','Follow up comment')"
                                               class="btn-sm btn-info d-block m-2 text-center">Follow Up</a>
                                            <hr>
                                            <a href="<?php echo e(route('deliver.order.delivered', $getOrder->orderDetails->id)); ?>"
                                               class="btn-sm btn-delivered d-block m-2 text-center">Delivered</a>


                                        <?php else: ?>
                                            <a href="javascript:void(0)"
                                               onclick="forModal('<?php echo e(route('deliver.pick', $getOrder->id)); ?>','Pick The Order')"
                                               class="btn-sm btn-delivered d-block m-2 text-center">Pick The
                                                Order</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <h4>NO ORDER FOUND</h4>
                            </td>
                        </tr>
                    <?php endif; ?>


                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Booking Code</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Delivery Address</th>
                        <th scope="col">Seller Address</th>
                        <th scope="col">Product</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="card card-primary card-outline">
            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered border" id="example">
                    <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Booking Code</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Delivery Address</th>
                        <th scope="col">Product</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $assignOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php if($getOrder->orderDetails->status == 'confirmed'): ?>
                            <tr>
                                <td scope="row"><?php echo e($loop->index++ + 1); ?></td>
                                <td>
                                    <span class="d-block">
                                        BK Code - #<?php echo e($getOrder->orderDetails->booking_code); ?>

                                    </span>
                                    <span class="d-block">
                                        Order Number - #<?php echo e($getOrder->orderDetails->order_number); ?>

                                    </span>
                                    <span class="d-block">
                                        Logistic - <?php echo e($getOrder->orderDetails->order->logistic->name ?? null); ?>

                                    </span>

                                </td>
                                <td>
                                    <span class="d-block text-uppercase">
                                       Payment <?php echo e($getOrder->orderDetails->payment_type); ?>

                                    </span>

                                    <span class="d-block">
                                        Coupon - <?php echo e($getOrder->orderDetails->order->applied_coupon ?? 'N/A'); ?>

                                    </span>
                                    <span class="d-block">
                                        Shipping - <?php echo e(formatPrice($getOrder->orderDetails->order->logistic_charge)); ?>

                                    </span>
                                    <span class="d-block">
                                        Quantity - <?php echo e($getOrder->orderDetails->quantity); ?>

                                        Total - <?php echo e(formatPrice($getOrder->orderDetails->order->pay_amount)); ?>

                                    </span>
                                </td>
                                <td class="w-20">
                                    <span class="d-block">
                                        Name - <?php echo e($getOrder->orderDetails->user ? $getOrder->orderDetails->user->name: 'Guest Order'); ?>

                                    </span>
                                    <span class="d-block">
                                        Phone - <?php echo e($getOrder->orderDetails->order->phone); ?>

                                    </span>
                                    <span class="d-block">
                                Address - <?php echo e($getOrder->orderDetails->order->address); ?>,
                                <?php echo e($getOrder->orderDetails->order->area->thana_name); ?>,
                                <?php echo e($getOrder->orderDetails->order->division->district_name); ?>

                                    </span>
                                    <span class="d-block">
                                        Note - <?php echo e($getOrder->orderDetails->order->note ?? 'N/A'); ?>

                                    </span>
                                </td>

                                <td class="w-15">
                                    <span class="d-block">
                                        <img src="<?php echo e(filePath($getOrder->orderDetails->product->image)); ?>"
                                             class="w-25"
                                             alt="#<?php echo e($getOrder->orderDetails->product->name); ?>">
                                    </span>
                                    <span class="d-block">
                                        Name - <?php echo e($getOrder->orderDetails->product->name); ?> -
                                <?php echo e($getOrder->orderDetails->product_stock->product_variants ?? ''); ?>

                                    </span>
                                    <span class="d-block">
                                        SKU - <?php echo e($getOrder->orderDetails->product->sku); ?>

                                    </span>

                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        <?php if(isset($getOrder->orderDetails->comment) || isset($getOrder->orderDetails->commentedBy)): ?>
                                            <?php echo e($getOrder->orderDetails->comment ?? 'N/A'); ?>

                                            By <?php echo e($getOrder->orderDetails->commentedBy->name ?? 'N/A'); ?>

                                        <?php else: ?>
                                            No Comment
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($getOrder->orderDetails->status != 'delivered'): ?>
                                        <?php if($getOrder->pick): ?>

                                            <a onclick="forModal('<?php echo e(route('order.location.status', $getOrder->id)); ?>','Update location')"
                                               href="javascript:void(0)"
                                               class="btn-sm btn-dark d-block m-2 text-center">Update Location</a>

                                            <a href="javascript:void(0)"
                                               onclick="forModal('<?php echo e(route('order.followup', $getOrder->orderDetails->id)); ?>','Follow up comment')"
                                               class="btn-sm btn-info d-block m-2 text-center">Follow Up</a>
                                            <hr>
                                            <a href="<?php echo e(route('order.delivered', $getOrder->orderDetails->id)); ?>"
                                               class="btn-sm btn-delivered d-block m-2 text-center">Delivered</a>


                                        <?php else: ?>
                                            <a href="javascript:void(0)"
                                               onclick="forModal('<?php echo e(route('deliver.pick', $getOrder->id)); ?>','Pick The Order')"
                                               class="btn-sm btn-delivered d-block m-2 text-center">Pick The
                                                Order</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <h4>NO ORDER FOUND</h4>
                            </td>
                        </tr>
                    <?php endif; ?>


                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Booking Code</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Delivery Address</th>
                        <th scope="col">Product</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php endif; ?>




<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>


    <script type="text/javascript">
        "use strict"
        $(document).ready(function () {
            var table = $('#example').DataTable({
                lengthChange: false,
            });
            $('#datetimepicker9, #datetimepicker10').datetimepicker();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/deliver/dashboard.blade.php ENDPATH**/ ?>