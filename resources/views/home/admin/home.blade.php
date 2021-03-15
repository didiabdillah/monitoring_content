@extends('layout.layout_admin')

@section('title', 'Home')

@section('page')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Overview content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row mb-2 content-header">
                <div class="col-sm-12">
                    <h1>Home</h1>
                </div>
            </div>

        </div>

        <!--In Progress content -->
        <section class="content">

            <div class="container-fluid">

                <!-- ADMIN -->
                <div class="row">
                    <div class="col-md-6">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$total_target}}</h3>

                                <p>All User Target</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-md-6">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$total_user}}</h3>

                                <p>Operator</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <!-- <h4 class="card-title mb-3"><strong>Submited Content Chart</strong></h4> -->

                            <div class="card-body">

                                <div class="chart content">
                                    <!-- CHART Will Render Here -->
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title"><strong>User Missed Upload</strong></h3>

                            </div>
                            <div class="card-body p-0">

                                <table class="table table-bordered table-hover table-striped projects" id="listMissed">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Total Missed Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($missed_upload as $data)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{$data->user_name}}
                                            </td>
                                            <td>
                                                {{$data->total}}
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
</div>
<!-- /.content -->


@endsection

@push('plugin')

<!-- DataTables  & Plugins -->
<script src="{{URL::asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
    $(function() {
        $('#listMissed').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pagingType": "simple_numbers",
            "lengthMenu": [10]
        });

    });
</script>

<!-- Select2 -->
<script src="{{URL::asset('assets/js/select2/js/select2.full.min.js')}}"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>

<!-- ChartJS -->
<script src="{{ asset('assets/js/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/chart.js/utils.js') }}"></script>

<script>
    // Ajax setup from csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // LOAD DATA TOTAL SUBMITTED CONTENT
    $(function() {
        var lineChart;

        var content_id = 0;

        //generate Content Chart
        $.ajax({
            url: "{{route('home_content_chart')}}",
            method: "POST",
            data: {
                id: content_id
            },

            dataType: 'json',
            success: function(data) {
                $('#lineChartContent').remove();
                $('.content').append(' <canvas id="lineChartContent" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');

                var lineChartCanvas = document.getElementById('lineChartContent').getContext('2d')

                var lineChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        fontSize: 18,
                        text: "Total Submited Content In Last 1 Week"
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
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
                            },
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    }
                }

                var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                var today = new Date();
                var d;
                var day = [];

                for (var i = 6; i >= 0; i--) {
                    d = new Date(today.getFullYear(), today.getMonth(), today.getDate() - i);
                    day[6 - i] = dayNames[d.getDay()];
                }
                var chart_result = data.chartData;
                // console.log(chart_result);
                var lineChartData = {
                    labels: day,
                    datasets: []
                }

                var newDataset = {

                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: chart_result,
                    fill: false
                };

                lineChartData.datasets.push(newDataset);

                lineChartOptions.datasetFill = false

                lineChart = new Chart(lineChartCanvas, {
                    type: 'line',
                    data: lineChartData,
                    options: lineChartOptions
                })

                lineChart.update();

            }
        });

        return false;
    });
</script>
@endpush