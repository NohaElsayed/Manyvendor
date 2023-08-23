@extends('backend.layouts.master')
@section('title') @translate(Seller Earning)
@endsection
@section('parentPageTitle', 'Admin Earning')
@section('content')

    <!-- BAR CHART -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                @translate(Seller Earning)</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas class="admin-single-earning-chart"></canvas>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <hr>
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">@translate(Seller Earning list)</h2>
            </div>
            <div class="float-right">
                <div class="row justify-content-end">
                    <div class="col">
                        <form method="get" action="">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-12"
                                       placeholder="@translate(Search by  booking code)"
                                       value="{{Request::get('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">@translate(Search)</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="btn btn-secondary px-5">
                        <div class="my-auto fs-16">{{formatPrice($total_earning)}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover text-left">
                <thead>
                <tr>
                    <th>@translate(S/L)</th>
                    <th>@translate(Booking Code)</th>
                    <th>@translate(Product Name)</th>
                    <th>@translate(Total amount)</th>
                    <th>@translate(Admin commission)</th>
                    <th>@translate(Earned)</th>
                    <th>@translate(Date)</th>
                </tr>
                </thead>
                <tbody>
                @forelse($earning as  $item)
                    <tr>
                        <td>{{ ($loop->index+1) + ($earning->currentPage() - 1)*$earning->perPage() }}</td>
                        <td>#{{$item->booking_code}}</td>
                        <td>{{$item->product->name}}</td>
                        <td>{{formatPrice($item->price)}}</td>
                        <td>{{formatPrice($item->commission_pay)}}</td>
                        <td>{{formatPrice($item->get_amount)}}</td>
                        <td>{{date('d-M-Y',strtotime($item->created_at))}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9"><h3 class="text-center">@translate(No Data Found)</h3></td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $earning->links() }}
    </div>



@endsection
<?php
/*get month*/
$months = array();
$labels = array();
for ($i = 1; $i <= 12; $i++) {
    $m = date("M", mktime(0, 0, 0, $i, 1, date('Y')));
    array_push($months, $m);
    array_push($labels, date('F', mktime(0, 0, 0, $i, 1, date("Y"))));
    if (date('M') == $m) {
        break;
    }
}

$earnings = array();
foreach ($months as $month) {
    $start_month = \Carbon\Carbon::parse($month)->startOfMonth()->toDateTimeString();
    $end_month = \Carbon\Carbon::parse($month)->endOfMonth()->toDateTimeString();
    $earning = \App\Models\SellerEarning::whereBetween('created_at', [$start_month, $end_month])->get()->sum('get_amount');
    array_push($earnings, $earning);
}
?>

@section('script')
    <script>
        "use strict"
        $(document).ready(function () {

            var areaChartData = {
                labels: [@foreach($labels as $l)'{{$l}}',@endforeach],
                datasets: [
                    {
                        label: '@translate(This year seller earning)',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [@foreach($earnings as $earning){{$earning}},@endforeach]
                    },
                ]
            }

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('.admin-single-earning-chart').get(0).getContext('2d')
            var barChartData = jQuery.extend(true, {}, areaChartData)
            var temp = areaChartData.datasets[0]
            barChartData.datasets[0] = temp


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
        })
    </script>
@endsection

