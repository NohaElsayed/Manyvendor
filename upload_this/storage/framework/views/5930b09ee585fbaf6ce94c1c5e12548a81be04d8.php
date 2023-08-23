
<?php $__env->startSection('title'); ?> Order Management <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/tempusdominus-bootstrap-4.min.js')); ?>"></script>
    <link type="text/javascript" src="<?php echo e(asset('css/tempusdominus-bootstrap-4.min.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="text-center">
                        <a class="btn btn-primary mt-2" href="<?php echo e(route('orders.index')); ?>">Total Order(<?php echo e(orderCount('count')); ?>)</a>
                        <a class="btn btn-yellow mt-2" href="<?php echo e(route("find.filter", 'pending')); ?>">Pending(<?php echo e(orderCount('pending')); ?>)</a>
                        <a class="btn btn-danger mt-2" href="<?php echo e(route("find.filter", 'canceled')); ?>">Canceled(<?php echo e(orderCount('canceled')); ?>)</a>
                        <a class="btn btn-delivered mt-2" href="<?php echo e(route("find.filter", 'confirmed')); ?>">Confirmed(<?php echo e(orderCount('confirmed')); ?>)</a>
                        <a class="btn btn-processing text-white mt-2" href="<?php echo e(route("find.filter", 'processing')); ?>">Processing(<?php echo e(orderCount('processing')); ?>)</a>
                        <a class="btn btn-qc mt-2" href="<?php echo e(route("find.filter", 'quality_check')); ?>">Quality Check(<?php echo e(orderCount('quality_check')); ?>)</a>
                        <a class="btn btn-dispatched mt-2" href="<?php echo e(route("find.filter", 'product_dispatched')); ?>">Dispatched(<?php echo e(orderCount('product_dispatched')); ?>)</a>
                        <a class="btn btn-info mt-2" href="<?php echo e(route("find.filter", 'follow_up')); ?>">Follow Up(<?php echo e(orderCount('follow_up')); ?>)</a>
                        <a class="btn btn-success mt-2" href="<?php echo e(route("find.filter", 'delivered')); ?>">Delivered(<?php echo e(orderCount('delivered')); ?>)</a>
                    </div>
                </div>

                

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="m-3" action="<?php echo e(route('find.order')); ?>" method="GET">
                                <div class="form-row mt-3">
                                    <div class="col">
                                        <label>Order From</label>
                                        <div class="input-group date" id="datetimepicker9" data-target-input="nearest">
                                            <input type="text" name="start_date" value="<?php echo e(Request::get('start_date')); ?>"
                                                class="form-control datetimepicker-input" data-target="#datetimepicker9"
                                                placeholder="Order From"/>
                                            <div class="input-group-append form-group" data-target="#datetimepicker9"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label>Order To</label>
                                        <div class="input-group date" id="datetimepicker10" data-target-input="nearest">
                                            <input type="text" name="end_date" value="<?php echo e(Request::get('end_date')); ?>"
                                                class="form-control datetimepicker-input" data-target="#datetimepicker10"
                                                placeholder="Order To"/>
                                            <div class="input-group-append form-group" data-target="#datetimepicker10"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text form-group p-10"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col">
                                        <label for="email">Customer Email</label>
                                        <input type="email" id="email" name="email" value="<?php echo e(Request::get('email')?? null); ?>" class="form-control" placeholder="Customer Email">
                                    </div>


                                </div>
                                <div class="form-row mt-3">

                                    <div class="col">
                                        <label for="order_number">Order Number</label>
                                        <input type="number" id="order_number" name="order_number" value="<?php echo e(Request::get('order_number') ?? null); ?>" class="form-control" placeholder="Order Number">
                                    </div>
                                    <div class="col">
                                        <label for="booking_code">Booking Code</label>
                                        <input type="number" id="booking_code" name="booking_code" value="<?php echo e(Request::get('booking_code') ?? null); ?>" class="form-control" placeholder="Booking Code">
                                    </div>
                                    <div class="col">
                                        <label for="phone">Customer Phone</label>
                                        <input type="number" id="phone" name="phone" value="<?php echo e(Request::get('phone') ?? null); ?>" class="form-control" placeholder="Customer Phone">
                                    </div>

                                </div>

                                <div class="form-row mt-3">

                                    <div class="col-md-6 offset-md-5">
                                        <button class="btn btn-primary" type="submit">FIND ORDER</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body p-2 table-responsive">

                    <table class="table table-bordered border">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Booking Code</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Seller Address</th>
                                <th scope="col">Product</th>
                                <th scope="col">Comment</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('order-modify')): ?>
                                <th scope="col">Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__empty_1 = true; $__currentLoopData = $getOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="
                            <?php echo e($getOrder->status === 'pending' ? 'bg-newOrder' : ''); ?>

                            <?php echo e($getOrder->status === 'confirmed' ? 'bg-confirmed' : ''); ?>

                            <?php echo e($getOrder->status === 'delivered' ? 'bg-delivered' : ''); ?>

                            <?php echo e($getOrder->status === 'canceled' ? 'bg-canceled' : ''); ?>

                            <?php echo e($getOrder->status === 'follow_up' ? 'bg-follow_up' : ''); ?>

                            <?php echo e($getOrder->status === 'processing' ? 'bg-processing' : ''); ?>

                            <?php echo e($getOrder->status === 'quality_check' ? 'bg-quality_check' : ''); ?>

                            <?php echo e($getOrder->status === 'product_dispatched' ? 'bg-product_dispatched' : ''); ?>

                            ">
                                <th scope="row"><?php echo e($loop->index++ + 1); ?></th>
                                <td>
                                    <span class="d-block">
                                        BK Code - #<?php echo e($getOrder->booking_code); ?>

                                    </span>
                                    <span class="d-block">
                                        Order Number - #<?php echo e($getOrder->order_number); ?>

                                    </span>
                                    <span class="d-block">
                                        Logistic - <?php echo e($getOrder->order->logistic->name ?? null); ?>

                                    </span>

                                </td>
                                <td>
                                    <span class="d-block text-uppercase">
                                       Payment <?php echo e($getOrder->payment_type); ?>

                                    </span>

                                    <span class="d-block">
                                        Coupon - <?php echo e($getOrder->order->applied_coupon ?? 'N/A'); ?>

                                    </span>
                                    <span class="d-block">
                                        Shipping - <?php echo e(formatPrice($getOrder->order->logistic_charge)); ?>

                                    </span>
                                    <span class="d-block">
                                        Quantity - <?php echo e($getOrder->quantity); ?>

                                        Total - <?php echo e(formatPrice($getOrder->order->pay_amount)); ?>

                                    </span>
                                </td>
                                <td class="w-20">
                                    <span class="d-block">
                                        Name - <?php echo e($getOrder->user ? $getOrder->user->name: 'Guest Order'); ?>

                                    </span>
                                    <span class="d-block">
                                        Phone - <?php echo e($getOrder->order->phone); ?>

                                    </span>
                                    <span class="d-block">
                                        Address - <?php echo e($getOrder->order->address); ?>, <?php echo e($getOrder->order->area->thana_name); ?>, <?php echo e($getOrder->order->division->district_name); ?>

                                    </span>
                                    <span class="d-block">
                                        Note - <?php echo e($getOrder->order->note ?? 'N/A'); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="d-block">
                                        Shop Name - <?php echo e($getOrder->seller->shop_name); ?>

                                    </span>
                                    <span class="d-block">
                                        Shop Email - <?php echo e($getOrder->seller->email); ?>

                                    </span>
                                    <span class="d-block">
                                        Shop Phone - <?php echo e($getOrder->seller->phone); ?>

                                    </span>
                                    <span class="d-block">
                                        Shop Address - <?php echo e($getOrder->seller->adrress ?? 'N/A'); ?>

                                    </span>
                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        <img src="<?php echo e(filePath($getOrder->product->product->image)); ?>" class="w-25" alt="#<?php echo e($getOrder->product->product->name); ?>">
                                    </span>
                                    <span class="d-block">
                                        Name - <?php echo e($getOrder->product->product->name); ?> - <?php echo e($getOrder->vendor_product_stock->product_variants); ?>

                                    </span>
                                    <span class="d-block">
                                        SKU - <?php echo e($getOrder->product->product->sku); ?>

                                    </span>

                                </td>
                                <td class="w-15">
                                    <span class="d-block">
                                        <?php if(isset($getOrder->comment) || isset($getOrder->commentedBy)): ?>
                                            <?php echo e($getOrder->comment ?? 'N/A'); ?> By <?php echo e($getOrder->user->name ?? 'N/A'); ?>

                                        <?php else: ?>
                                        No Comment
                                        <?php endif; ?>
                                    </span>
                                </td>

                               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('order-modify')): ?>

                            <?php if($getOrder->status != 'delivered'): ?>
                                <td>
                                    <a href="#!"
                                       onclick="forModal('<?php echo e(route('order.followup', $getOrder->id)); ?>','Follow up comment')"
                                       class="btn-sm btn-info d-block m-2 text-center">Follow Up</a>

                                       <?php if(Auth::user()->user_type == 'Vendor'): ?>
                                           <?php if($getOrder->status != 'processing'
                                    && $getOrder->status != 'quality_check'
                                    && $getOrder->status != 'product_dispatched'
                                    && $getOrder->status != 'delivered'
                                    && $getOrder->status != 'canceled'
                                    && $getOrder->status != 'confirmed'
                                    ): ?>
                                        <a href="<?php echo e(route('order.confirm', $getOrder->id)); ?>"
                                           class="btn-sm btn-success d-block m-2 text-center">Confirm</a>
                                    <?php endif; ?>


                                    <?php if($getOrder->status != 'processing' && $getOrder->status != 'quality_check' && $getOrder->status != 'product_dispatched'): ?>
                                        <a href="<?php echo e(route('order.processing', $getOrder->id)); ?>"
                                           class="btn-sm btn-processing d-block m-2 text-center">Processing</a>
                                    <?php endif; ?>

                                    <?php if($getOrder->status != 'quality_check' && $getOrder->status != 'product_dispatched'): ?>
                                        <a href="<?php echo e(route('order.quality_check', $getOrder->id)); ?>"
                                           class="btn-sm btn-qc d-block m-2 text-center">QC</a>
                                    <?php endif; ?>

                                    <?php if($getOrder->status != 'product_dispatched'): ?>
                                        <a href="<?php echo e(route('order.product_dispatched', $getOrder->id)); ?>"
                                           class="btn-sm btn-dispatched d-block m-2 text-center">Dispatched</a>
                                    <?php endif; ?>
                                       <?php endif; ?>

                                    

                                    <?php if(Auth::user()->user_type != 'Vendor'): ?>
                                    
                                        
                                        <?php if($getOrder->status != 'delivered'): ?>


                                            <a href="<?php echo e(route('order.confirm', $getOrder->id)); ?>"
                                               class="btn-sm btn-success d-block m-2 text-center">Confirm</a>
                                        <?php endif; ?>
                                        <?php if($getOrder->status != 'canceled'): ?>
                                            <a href="<?php echo e(route('order.cancel', $getOrder->id)); ?>"
                                            class="btn-sm btn-danger d-block m-2 text-center">Cancel</a>
                                        <?php endif; ?>

                                    <?php endif; ?>


                                </td>
                            <?php else: ?>
                                <td>
                                    Delivered
                                </td>
                            <?php endif; ?>
                        <?php endif; ?>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center">
                                   <h4>NO ORDER FOUND</h4>
                                </td>
                            </tr>
                            <?php endif; ?>


                        </tbody>
                        </table>

                </div>

            </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        "use strict"
        $(function () {
            $('#datetimepicker9, #datetimepicker10').datetimepicker();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/orders/filter.blade.php ENDPATH**/ ?>