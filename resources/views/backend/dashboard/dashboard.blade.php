@extends('backend.layouts.master')

@section('title')
    @translate(Dashboard)
@endsection

<?php

$start_week = \Carbon\Carbon::today()->startOfYear()->toDateTimeString();

$end_week = \Carbon\Carbon::today()->endOfYear()->toDateTimeString();
$sellers = \App\User::with('vendor')->where('user_type', 'Vendor')->whereBetween('created_at', [$start_week, $end_week])->get();
?>

@section('content')
    <!-- Main content -->
    @include('backend.layouts.includes.config')
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-credit-card"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@translate(Selling Amount)</span>
                            <span
                                class="info-box-number">{{formatPrice(\App\Models\OrderProduct::where('status','delivered')->get()->sum('product_price'))}}
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
                            <span class="info-box-text">@translate(Admin's Total Earning)</span>
                            <span
                                class="info-box-number">{{formatPrice(\App\Models\AdminCommission::all()->sum('commission'))}}
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
                            <span class="info-box-text">@translate(Total Sellers)</span>
                            <span
                                class="info-box-number">{{number_format(\App\User::where('user_type','Vendor')->where('banned',0)->count())}}</span>
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
                            <span class="info-box-text">@translate(New Customers)</span>
                            <span
                                class="info-box-number">{{number_format(\App\User::where('user_type','Customer')->whereBetween('created_at',[$start_week,$end_week])->count())}}
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
                            <h5 class="card-title">@translate(Admin commission earning)</h5>
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
                            <h5 class="card-title">@translate(Sales Reports)</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-center">
                                        <strong>@translate(This year or Last Year)</strong>
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
                            <h3 class="card-title">@translate(Latest Seller)</h3>
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
                                @foreach($sellers as $seller)
                                    @if($seller->vendor != null)
                                    <li class="col-4 card card-body">
                                        @if($seller->vendor->shop_logo != null)
                                        <img src="{{filePath($seller->vendor->shop_logo)}}"
                                             alt="{{$seller->vendor->shop_name}}" class="w-50 mx-auto overflow-hidden">
                                        @endif
                                        <a class="users-list-name"
                                           href="{{route('vendor.requests.view',$seller->id)}}">{{\Illuminate\Support\Str::limit($seller->vendor->shop_name,10)}}
                                            ..</a>
                                        <span class="users-list-date">{{$seller->created_at->diffForHumans()}}</span>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="{{route('vendor.all')}}" class="btn btn-primary btn-sm">@translate(View All seller)</a>
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
                            <span class="info-box-text">@translate(Pending Orders)</span>
                            <span
                                class="info-box-number">{{number_format(\App\Models\OrderProduct::where('status','pending')->whereBetween('created_at',[$start_week,$end_week])->count())}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="far fa-heart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@translate(Confirmed Orders)</span>
                            <span
                                class="info-box-number">{{number_format(\App\Models\OrderProduct::where('status','confirmed')->whereBetween('created_at',[$start_week,$end_week])->count())}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-danger">
                        <span class="info-box-icon"><i class="fas fa-cloud-upload-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@translate(Delivered Orders)</span>
                            <span
                                class="info-box-number">{{number_format(\App\Models\OrderProduct::where('status','delivered')->whereBetween('created_at',[$start_week,$end_week])->count())}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-info">
                        <span class="info-box-icon"><i class="far fa-comment"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@translate(Complain)</span>
                            <span
                                class="info-box-number">{{number_format(\App\Models\Complain::where('status','Not Solved')->whereBetween('created_at',[$start_week,$end_week])->count())}}</span>
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
                            <h3 class="card-title">@translate(Delivery Chart)</h3>

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
                            <h3 class="card-title">@translate(Complain Chart)</h3>

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
                            <h3 class="card-title">@translate(Latest Orders)</h3>

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
                                        <th>@translate(Booking code)</th>
                                        <th>@translate(Item)</th>
                                        <th>@translate(Status)</th>
                                        <th>@translate(Logistic)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderProducts as $pro)
                                        <tr>
                                            <td><a target="_blank"
                                                   href="{{route('orders.index')}}?booking_code={{$pro->booking_code}}">#{{$pro->booking_code}}</a>
                                            </td>
                                            <td>{{$pro->product->product->name ?? ''}}</td>
                                            <td><span class="badge badge-success">{{$pro->status}}</span></td>
                                            <td>{{$pro->logistic->name ?? 'N/A'}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{route('orders.index')}}" class="btn btn-sm btn-primary float-right">@translate(View All Orders)</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->


@endsection

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

@section('script')
    <script>
        "use strict"
        $(document).ready(function () {
            /*start year sells cart*/
            var salesChartCanvas = $('.salesChart').get(0).getContext('2d')

            var salesChartData = {
                labels: [@foreach($labels as $l)'{{$l}}',@endforeach],
                datasets: [
                    {
                        label: '@translate(This Year)',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [@foreach($this_year_sell as $earning){{$earning}},@endforeach]
                    },
                    {
                        label: '@translate(Last Year)',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [@foreach($last_year_sell as $earning){{$earning}},@endforeach]
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
                labels: [@foreach($labels as $l)'{{$l}}',@endforeach],
                datasets: [
                    {
                        label: '@translate(This year admin earning)',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [@foreach($this_year_earning as $earning){{$earning}},@endforeach]
                    },
                    {
                        label: '@translate(Last year admin earning)',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [@foreach($last_year_earning as $earning){{$earning}},@endforeach]
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
                        data: [{{\App\Models\OrderProduct::where('status','delivered')->whereBetween('created_at',[$start_week,$end_week])->count()}},{{\App\Models\OrderProduct::where('status','confirmed')->whereBetween('created_at',[$start_week,$end_week])->count()}}],
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
                        data: [{{\App\Models\Complain::where('status','solved')->whereBetween('created_at',[$start_week,$end_week])->count()}},{{\App\Models\Complain::where('status','Not Solved')->whereBetween('created_at',[$start_week,$end_week])->count()}},{{\App\Models\Complain::where('status','Untouched')->whereBetween('created_at',[$start_week,$end_week])->count()}}],
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
@endsection
