

<?php $__env->startSection('title'); ?>
    Dashboard
<?php $__env->stopSection(); ?>

<?php

$start_week = \Carbon\Carbon::today()->startOfYear()->toDateTimeString();

$end_week = \Carbon\Carbon::today()->endOfYear()->toDateTimeString();
$sellers = \App\User::with('vendor')->where('user_type', 'Vendor')->whereBetween('created_at', [$start_week, $end_week])->get();
?>

<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <?php echo $__env->make('backend.layouts.includes.config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-credit-card"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Selling Amount</span>
                            <span
                                class="info-box-number"><?php echo e(formatPrice(\App\Models\OrderProduct::where('status','delivered')->get()->sum('product_price'))); ?>

                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Admin's Total Earning</span>
                            <span
                                class="info-box-number"><?php echo e(formatPrice(\App\Models\AdminCommission::all()->sum('commission'))); ?>

                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Sellers</span>
                            <span
                                class="info-box-number"><?php echo e(number_format(\App\User::where('user_type','Vendor')->where('banned',0)->count())); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">New Customers</span>
                            <span
                                class="info-box-number"><?php echo e(number_format(\App\User::where('user_type','Customer')->whereBetween('created_at',[$start_week,$end_week])->count())); ?>

                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Admin commission earning</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="chart">
                                        <canvas class="admin-single-earning-chart"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Sales Reports</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-center">
                                        <strong>This year or Last Year</strong>
                                    </p>

                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas class="salesChart" height="250"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- USERS LIST -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Latest Seller</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="users-list clearfix row mx-3 mt-2">
                                <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($seller->vendor != null): ?>
                                    <li class="col-4 card card-body">
                                        <?php if($seller->vendor->shop_logo != null): ?>
                                        <img src="<?php echo e(filePath($seller->vendor->shop_logo)); ?>"
                                             alt="<?php echo e($seller->vendor->shop_name); ?>" class="w-50 mx-auto overflow-hidden">
                                        <?php endif; ?>
                                        <a class="users-list-name"
                                           href="<?php echo e(route('vendor.requests.view',$seller->id)); ?>"><?php echo e(\Illuminate\Support\Str::limit($seller->vendor->shop_name,10)); ?>

                                            ..</a>
                                        <span class="users-list-date"><?php echo e($seller->created_at->diffForHumans()); ?></span>
                                    </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="<?php echo e(route('vendor.all')); ?>" class="btn btn-primary btn-sm">View All seller</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>


                </div>
                <!-- /.col -->
                <div class="col-md-4">
                    <!-- Info Boxes Style 2 -->
                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pending Orders</span>
                            <span
                                class="info-box-number"><?php echo e(number_format(\App\Models\OrderProduct::where('status','pending')->whereBetween('created_at',[$start_week,$end_week])->count())); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="far fa-heart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Confirmed Orders</span>
                            <span
                                class="info-box-number"><?php echo e(number_format(\App\Models\OrderProduct::where('status','confirmed')->whereBetween('created_at',[$start_week,$end_week])->count())); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-danger">
                        <span class="info-box-icon"><i class="fas fa-cloud-upload-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Delivered Orders</span>
                            <span
                                class="info-box-number"><?php echo e(number_format(\App\Models\OrderProduct::where('status','delivered')->whereBetween('created_at',[$start_week,$end_week])->count())); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-info">
                        <span class="info-box-icon"><i class="far fa-comment"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Complain</span>
                            <span
                                class="info-box-number"><?php echo e(number_format(\App\Models\Complain::where('status','Not Solved')->whereBetween('created_at',[$start_week,$end_week])->count())); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <!-- PRODUCT LIST -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <hr>

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <!-- DONUT CHART -->
                    <div class="card card-primary card-outline">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Delivery Chart</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas class="deliveryChart"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </div>

                <div class="col-md-6  col-sm-12">
                    <!-- PIE CHART -->
                    <div class="card card-primary card-outline">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Complain Chart</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas class="complainChart"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card card-primary card-outline">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Latest Orders</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered m-0">
                                    <thead>
                                    <tr>
                                        <th>Booking code</th>
                                        <th>Item</th>
                                        <th>Status</th>
                                        <th>Logistic</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $orderProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><a target="_blank"
                                                   href="<?php echo e(route('orders.index')); ?>?booking_code=<?php echo e($pro->booking_code); ?>">#<?php echo e($pro->booking_code); ?></a>
                                            </td>
                                            <td><?php echo e($pro->product->product->name ?? ''); ?></td>
                                            <td><span class="badge badge-success"><?php echo e($pro->status); ?></span></td>
                                            <td><?php echo e($pro->logistic->name ?? 'N/A'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-sm btn-primary float-right">View All Orders</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->


<?php $__env->stopSection(); ?>

<?php
$months = array();
$labels = array();
for ($i = 1; $i <= 12; $i++) {
    $m = date("M", mktime(0, 0, 0, $i, 1, date('Y')));
    array_push($months, $m);
    array_push($labels, date('F', mktime(0, 0, 0, $i, 1, date("Y"))));
}

/*this year*/
$this_year_sell = array();
foreach ($months as $month) {
    $start_month = \Carbon\Carbon::parse($month)->startOfMonth()->toDateTimeString();
    $end_month = \Carbon\Carbon::parse($month)->endOfMonth()->toDateTimeString();
    $sell = \App\Models\OrderProduct::where('status', 'delivered')->whereBetween('created_at', [$start_month, $end_month])->get()->sum('product_price');
    array_push($this_year_sell, $sell);
}

/*last year*/
$last_year_sell = array();
foreach ($months as $month) {
    $start_last_month = \Carbon\Carbon::parse($month)->subYear()->startOfMonth()->toDateTimeString();
    $end_last_month = \Carbon\Carbon::parse($month)->subYear()->endOfMonth()->toDateTimeString();
    $sell2 = \App\Models\OrderProduct::where('status', 'delivered')->whereBetween('created_at', [$start_last_month, $end_last_month])->get()->sum('product_price');
    array_push($last_year_sell, $sell2);
}

$this_year_earning = array();
foreach ($months as $month) {
    $start_month = \Carbon\Carbon::parse($month)->startOfMonth()->toDateTimeString();
    $end_month = \Carbon\Carbon::parse($month)->endOfMonth()->toDateTimeString();
    $earning = \App\Models\AdminCommission::whereBetween('created_at', [$start_month, $end_month])->get()->sum('commission');
    array_push($this_year_earning, $earning);
}

$last_year_earning = array();
foreach ($months as $month) {
    $start_last_month = \Carbon\Carbon::parse($month)->subYear()->startOfMonth()->toDateTimeString();
    $end_last_month = \Carbon\Carbon::parse($month)->subYear()->endOfMonth()->toDateTimeString();
    $earning1 = \App\Models\AdminCommission::whereBetween('created_at', [$start_last_month, $end_last_month])->get()->sum('commission');
    array_push($last_year_earning, $earning1);
}
?>

<?php $__env->startSection('script'); ?>
    <script>
        "use strict"
        $(document).ready(function () {
            /*start year sells cart*/
            var salesChartCanvas = $('.salesChart').get(0).getContext('2d')

            var salesChartData = {
                labels: [<?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>'<?php echo e($l); ?>',<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
                datasets: [
                    {
                        label: 'This Year',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [<?php $__currentLoopData = $this_year_sell; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($earning); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]
                    },
                    {
                        label: 'Last Year',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [<?php $__currentLoopData = $last_year_sell; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($earning); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]
                    },
                ]
            }

            var salesChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            }

            // This will get the first returned node in the jQuery collection.
            var salesChart = new Chart(salesChartCanvas, {
                    type: 'line',
                    data: salesChartData,
                    options: salesChartOptions
                }
            )
            /*end chart js*/


            /*admin earning compare*/
            var areaChartData = {
                labels: [<?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>'<?php echo e($l); ?>',<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
                datasets: [
                    {
                        label: 'This year admin earning',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [<?php $__currentLoopData = $this_year_earning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($earning); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]
                    },
                    {
                        label: 'Last year admin earning',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [<?php $__currentLoopData = $last_year_earning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($earning); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]
                    },
                ]
            }

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('.admin-single-earning-chart').get(0).getContext('2d')
            var barChartData = jQuery.extend(true, {}, areaChartData)
            var temp = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp
            barChartData.datasets[1] = temp1

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })
            /* END admin single earning chart BAR CHART */


            //-------------
            //- DONUT CHART deliveryChart-
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('.deliveryChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Confirm',
                    'Delivered'
                ],
                datasets: [
                    {
                        data: [<?php echo e(\App\Models\OrderProduct::where('status','delivered')->whereBetween('created_at',[$start_week,$end_week])->count()); ?>,<?php echo e(\App\Models\OrderProduct::where('status','confirmed')->whereBetween('created_at',[$start_week,$end_week])->count()); ?>],
                        backgroundColor: ['#f56954', '#00a65a'],
                    }
                ]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var donutChart = new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutData2 = {
                labels: [
                    'Solved',
                    'Not Solved',
                    'Untouched'
                ],
                datasets: [
                    {
                        data: [<?php echo e(\App\Models\Complain::where('status','solved')->whereBetween('created_at',[$start_week,$end_week])->count()); ?>,<?php echo e(\App\Models\Complain::where('status','Not Solved')->whereBetween('created_at',[$start_week,$end_week])->count()); ?>,<?php echo e(\App\Models\Complain::where('status','Untouched')->whereBetween('created_at',[$start_week,$end_week])->count()); ?>],
                        backgroundColor: ['#f56954', '#00a65a', '#7400a6'],
                    }
                ]
            }
            var pieChartCanvas = $('.complainChart').get(0).getContext('2d')
            var pieData = donutData2;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/dashboard/dashboard.blade.php ENDPATH**/ ?>