@extends('backend.layouts.master')

@section('title')
    @translate(Seller Dashboard)
@endsection

<?php

$start_week = \Carbon\Carbon::today()->startOfYear()->toDateTimeString();

$end_week = \Carbon\Carbon::today()->endOfYear()->toDateTimeString();

$seller = \App\Vendor::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();

?>

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="row col-md-12 pr-0">
                    <div class="col-sm-12 col-md-4">
                        <div class="info-box py-0">
                            <span class="info-box-icon bg-success elevation-1 my-2">
                                <i class="fa fa-check-square text-white"></i>
                            </span>
                            <div class="info-box-content">
                                <img src="{{asset('images/verified_seller.png')}}" class="img-fluid w-50 m-auto">
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-credit-card"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">@translate(Balance)</span>
                                <span class="info-box-number">{{formatPrice($seller->balance)}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-dollar"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">@translate(Total Earning)</span>
                                <span
                                    class="info-box-number">{{formatPrice(\App\Models\SellerEarning::where('user_id',\Illuminate\Support\Facades\Auth::id())->get()->sum('get_amount'))}}
                                    </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    @if(\App\Models\Campaign::where('active_for_seller','1')->where('end_at','>=',Carbon\Carbon::now()->format('Y-m-d'))->get()->count()>0)
                        <div class="col-sm-12 col-md-4">
                            <a href="{{route('seller.campaign.index')}}">
                                <div class="info-box">
                                        <span class="info-box-icon bg-danger elevation-1">
                                    <img src="{{asset('images/campaign_seller.png')}}"></span>

                                    <div class="info-box-content badge badge-light ml-2 fs-16 text-danger">
                                        @translate(Live Campaign)
                                        - {{\App\Models\Campaign::where('active_for_seller','1')->where('end_at','>=',Carbon\Carbon::now()->format('Y-m-d'))->get()->count()}}
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    @else
                        <div class="col-sm-12 col-md-4">
                            <a href="{{route('seller.campaign.index')}}">
                                <div class="info-box">
                                        <span class="info-box-icon bg-danger elevation-1">
                                    <img src="{{asset('images/campaign_seller.png')}}"></span>

                                    <div class="info-box-content badge badge-light ml-2 fs-16 text-danger">
                                        @translate(No Campaign Live)
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </a>
                        </div>
                    @endif


                    <div class="col-sm-12 col-md-4">
                        <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i
                                        class="fa fa-product-hunt"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">@translate(Products)</span>
                                <span
                                    class="info-box-number">{{\App\VendorProduct::where('user_id',\Illuminate\Support\Facades\Auth::id())->count()}}
                                    </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-12 col-md-4">
                        <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i
                                        class="fa fa-first-order"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">@translate(Total Orders)</span>
                                <span
                                    class="info-box-number">{{\App\Models\OrderProduct::where('shop_id',$seller->id)->count()}}
                                    </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>

            </div>
            <!-- /.row -->


            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">@translate(Seller earning)</h5>
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
                <div class="col-md-12  col-sm-12">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card card-primary card-outline">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">@translate(Alert Quantity stock)</h3>

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
                                <table class="table m-0 table-bordered">
                                    <thead>
                                    <tr>
                                        <th>@translate(Status)</th>
                                        <th>@translate(Item)</th>
                                        <th>@translate(Quantity)</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vps as $q)
                                        <tr>
                                            <td><a target="_blank" href="{{$q->url}}">{{$q->stock}}</a></td>
                                            <td>{{$q->name ?? ''}}<br><small>{{$q->shop_name}}</small></td>
                                            <td><span class="badge badge-success">{{$q->quantity}}</span></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{route('seller.products')}}" class="btn btn-sm btn-primary float-right">@translate(View All Product)</a>
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
$this_year_sell_order_product = array();
foreach ($months as $month) {
    $start_month = \Carbon\Carbon::parse($month)->startOfMonth()->toDateTimeString();
    $end_month = \Carbon\Carbon::parse($month)->endOfMonth()->toDateTimeString();
    $sell = \App\Models\OrderProduct::where('shop_id', $seller->id)->where('status', 'delivered')->whereBetween('created_at', [$start_month, $end_month])->get()->sum('product_price');
    array_push($this_year_sell_order_product, $sell);
}

/*last year*/
$last_year_sell_order_product = array();
foreach ($months as $month) {
    $start_last_month = \Carbon\Carbon::parse($month)->subYear()->startOfMonth()->toDateTimeString();
    $end_last_month = \Carbon\Carbon::parse($month)->subYear()->endOfMonth()->toDateTimeString();
    $sell2 = \App\Models\OrderProduct::where('shop_id', $seller->id)->where('status', 'delivered')->whereBetween('created_at', [$start_last_month, $end_last_month])->get()->sum('product_price');
    array_push($last_year_sell_order_product, $sell2);
}

//complain_booking_cone
//where('shop_id',$seller->id)->where('status', 'delivered')->whereBetween('created_at', [$start_last_month, $end_last_month])
$solved = 0;
$s = \App\Models\OrderProduct::where('shop_id', $seller->id)->with('complain_booking_code_solved')->whereBetween('created_at', [$start_week, $end_week])->get();
foreach ($s as $k) {
    if ($k->complain_booking_code_solved != null) {
        $solved += 1;

    }
}

$not_solved = 0;
$n = \App\Models\OrderProduct::where('shop_id', $seller->id)->with('complain_booking_code_notsolved')->whereBetween('created_at', [$start_week, $end_week])->get();
foreach ($n as $k) {
    if ($k->complain_booking_code_notsolved != null) {
        $not_solved += 1;
    }
}

$untouched = 0;
$u = \App\Models\OrderProduct::where('shop_id', $seller->id)->with('complain_booking_code_untouched')->whereBetween('created_at', [$start_week, $end_week])->get();
foreach ($u as $k) {
    if ($k->complain_booking_code_untouched != null) {
        $untouched += 1;
    }
}

$this_year_earning = array();
foreach ($months as $month) {
    $start_month = \Carbon\Carbon::parse($month)->startOfMonth()->toDateTimeString();
    $end_month = \Carbon\Carbon::parse($month)->endOfMonth()->toDateTimeString();
    $earning = \App\Models\SellerEarning::where('user_id', \Illuminate\Support\Facades\Auth::id())->whereBetween('created_at', [$start_month, $end_month])->get()->sum('get_amount');
    array_push($this_year_earning, $earning);
}

$last_year_earning = array();
foreach ($months as $month) {
    $start_last_month = \Carbon\Carbon::parse($month)->subYear()->startOfMonth()->toDateTimeString();
    $end_last_month = \Carbon\Carbon::parse($month)->subYear()->endOfMonth()->toDateTimeString();
    $earning1 = \App\Models\SellerEarning::where('user_id', \Illuminate\Support\Facades\Auth::id())->whereBetween('created_at', [$start_last_month, $end_last_month])->get()->sum('get_amount');
    array_push($last_year_earning, $earning1);
}

?>

@section('script')
    <script>
        "use strict"
        $(document).ready(function () {
            {{--/*start year sells cart*/--}}
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
                        data: [@foreach($this_year_sell_order_product as $sale){{$sale}},@endforeach]
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
                        data: [@foreach($last_year_sell_order_product as $sale){{$sale}},@endforeach]
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


            /*seller earning compare*/
            var areaChartData = {
                labels: [@foreach($labels as $l)'{{$l}}',@endforeach],
                datasets: [
                    {
                        label: '@translate(This year  earning)',
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
                        label: '@translate(Last year  earning)',
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
            /* END seller single earning chart BAR CHART */


            //-------------
            //- DONUT CHART deliveryChart-
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('.deliveryChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Pending',
                    'Delivered'
                ],
                datasets: [
                    {
                        data: [{{\App\Models\OrderProduct::where('shop_id',$seller->id)->where('status','pending')->whereBetween('created_at',[$start_week,$end_week])->count()}},{{\App\Models\OrderProduct::where('shop_id',$seller->id)->where('status','delivered')->whereBetween('created_at',[$start_week,$end_week])->count()}}],
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
                        data: [{{$solved}},{{$not_solved}},{{$untouched}}],
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

