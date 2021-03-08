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

                <!-- OPERATOR -->
                <div class="row">
                    <div class="col-md-3">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$daily_target}}</h3>

                                <p>Daily Target</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-md-3">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$total_upload_missed->total_missed}}</h3>

                                <p>Total Upload Missed</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-upload"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-md-3">
                        <!-- small card -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{$today_upload_remaining}}</h3>

                                <p>Today Upload Remaining</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-md-3">
                        <!-- small card -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$total_missed_day}}</h3>

                                <p>Total Missed Day</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

            </div>
        </section>
</div>
<!-- /.content -->


@endsection

@push('plugin')
{{--
<!-- Select2 -->
<script src="{{URL::asset('assets/js/select2/js/select2.full.min.js')}}"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>

<script>
    // Ajax setup from csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // First Load Domain Price Rank
    $(function() {
        const domain_id = $('select.domain-rank-option').children("option:selected").val();

        // generate provider option select
        $.ajax({
            url: "{{route('home_get_domain_rank')}}",
            method: "POST",
            data: {
                id: domain_id
            },
            cache: false,
            success: function(data) {
                $('table#rankDomain > tbody').empty();
                $('table#rankDomain > tbody').html(data);

                $('#domainCheapButton').removeClass('btn-outline-primary');
                $('#domainCheapButton').addClass('btn-primary');
                $('#domainExpensiveButton').removeClass('btn-primary');
                $('#domainExpensiveButton').addClass('btn-outline-primary');
            }
        });

        return false;
    });

    $('#domainExpensiveButton').click(function() {
        const domain_id = $('select.domain-rank-option').children("option:selected").val();

        $.ajax({
            url: "{{route('home_get_expensive_domain_rank')}}",
            method: "POST",
            data: {
                id: domain_id
            },
            cache: false,
            success: function(data) {
                $('table#rankDomain > tbody').empty();
                $('table#rankDomain > tbody').html(data);

                $('#domainCheapButton').removeClass('btn-primary');
                $('#domainCheapButton').addClass('btn-outline-primary');
                $('#domainExpensiveButton').removeClass('btn-outline-primary');
                $('#domainExpensiveButton').addClass('btn-primary');
            }
        });
    });

    $('#domainCheapButton').click(function() {
        const domain_id = $('select.domain-rank-option').children("option:selected").val();

        $.ajax({
            url: "{{route('home_get_cheap_domain_rank')}}",
            method: "POST",
            data: {
                id: domain_id
            },
            cache: false,
            success: function(data) {
                $('table#rankDomain > tbody').empty();
                $('table#rankDomain > tbody').html(data);

                $('#domainCheapButton').removeClass('btn-outline-primary');
                $('#domainCheapButton').addClass('btn-primary');
                $('#domainExpensiveButton').removeClass('btn-primary');
                $('#domainExpensiveButton').addClass('btn-outline-primary');
            }
        });


    });

    $('select.domain-rank-option').change(function() {
        const domain_id = $(this).children("option:selected").val();

        // generate provider option select
        $.ajax({
            url: "{{route('home_get_domain_rank')}}",
            method: "POST",
            data: {
                id: domain_id
            },
            cache: false,
            success: function(data) {
                $('table#rankDomain > tbody').empty();
                $('table#rankDomain > tbody').html(data);

                $('#domainCheapButton').removeClass('btn-outline-primary');
                $('#domainCheapButton').addClass('btn-primary');
                $('#domainExpensiveButton').removeClass('btn-primary');
                $('#domainExpensiveButton').addClass('btn-outline-primary');
            }
        });

        return false;
    });


    // HOSTING RANK
    $('#hostingExpensiveButton').click(function() {
        $('#hostingExpensiveButton').removeClass('btn-outline-primary');
        $('#hostingExpensiveButton').addClass('btn-primary');
        $('#hostingCheapButton').removeClass('btn-primary');
        $('#hostingCheapButton').addClass('btn-outline-primary');

        //
        $.ajax({
            url: "{{route('home_get_expensive_hosting_rank')}}",
            method: "POST",
            data: {
                id: 0
            },
            cache: false,
            success: function(data) {
                $('table#rankHosting > tbody').empty();
                $('table#rankHosting > tbody').html(data);
            }

        });
    });

    $('#hostingCheapButton').click(function() {
        $('#hostingCheapButton').removeClass('btn-outline-primary');
        $('#hostingCheapButton').addClass('btn-primary');
        $('#hostingExpensiveButton').removeClass('btn-primary');
        $('#hostingExpensiveButton').addClass('btn-outline-primary');

        //
        $.ajax({
            url: "{{route('home_get_cheap_hosting_rank')}}",
            method: "POST",
            data: {
                id: 0
            },
            cache: false,
            success: function(data) {
                $('table#rankHosting > tbody').empty();
                $('table#rankHosting > tbody').html(data);
            }

        });
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

    // ------------
    // DEFAULT LOAD DOMAIN CHART
    // ------------
    $(function() {
        var lineChart;

        var domain_id = 0;

        //generate Domain Chart
        $.ajax({
            url: "{{route('domain_chart')}}",
            method: "POST",
            data: {
                id: domain_id
            },

            dataType: 'json',
            success: function(data) {
                $('#lineChartDomain').remove();
                $('.domain').append(' <canvas id="lineChartDomain" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');

                var lineChartCanvas = document.getElementById('lineChartDomain').getContext('2d')

                var lineChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        fontSize: 18,
                        text: data[1]
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

                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                var today = new Date();
                var d;
                var month = [];

                for (var i = 11; i >= 0; i--) {
                    d = new Date(today.getFullYear(), today.getMonth() - i, 1);
                    month[11 - i] = monthNames[d.getMonth()] + ' ' + d.getFullYear();
                }
                var chart_result = data[0];
                // console.log(chart_result);
                var lineChartData = {
                    labels: month,
                    datasets: []
                }

                if (chart_result === undefined || chart_result.length == 0 || chart_result.length == null) {
                    var newDataset = {
                        label: "EMPTY",
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        fill: false
                    };

                    lineChartData.datasets.push(newDataset);
                } else {
                    var colorNames = Object.keys(window.chartColors);
                    for (i = 0; i < chart_result.length; i++) {
                        var colorName = colorNames[lineChartData.datasets.length % colorNames.length];
                        var newColor = window.chartColors[colorName];
                        var newDataset = {
                            label: chart_result[i][1],
                            backgroundColor: newColor,
                            borderColor: newColor,
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: newColor,
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: newColor,
                            data: chart_result[i][0],
                            fill: false
                        };

                        lineChartData.datasets.push(newDataset);
                    }
                }

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

    // ------------
    // DEFAULT LOAD HOSTING CHART
    // ------------
    $(function() {
        var lineChart;

        var hosting_id = 0;

        // Generate Hosting Chart
        $.ajax({
            url: "{{route('hosting_chart')}}",
            method: "POST",
            data: {
                id: hosting_id
            },

            dataType: 'json',
            success: function(data) {
                $('#lineChartHosting').remove();
                $('.hosting').append(' <canvas id="lineChartHosting" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');

                var lineChartCanvas = document.getElementById('lineChartHosting').getContext('2d')

                var lineChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        fontSize: 18,
                        text: data[1]
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

                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                var today = new Date();
                var d;
                var month = [];

                for (var i = 11; i >= 0; i--) {
                    d = new Date(today.getFullYear(), today.getMonth() - i, 1);
                    month[11 - i] = monthNames[d.getMonth()] + ' ' + d.getFullYear();
                }
                var chart_result = data[0];
                // console.log(chart_result);
                var lineChartData = {
                    labels: month,
                    datasets: []
                }

                if (chart_result === undefined || chart_result.length == 0 || chart_result.length == null) {
                    var newDataset = {
                        label: "EMPTY",
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        fill: false
                    };

                    lineChartData.datasets.push(newDataset);
                } else {
                    var colorNames = Object.keys(window.chartColors);
                    for (i = 0; i < chart_result.length; i++) {
                        var colorName = colorNames[lineChartData.datasets.length % colorNames.length];
                        var newColor = window.chartColors[colorName];
                        var newDataset = {
                            label: chart_result[i][1],
                            backgroundColor: newColor,
                            borderColor: newColor,
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: newColor,
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: newColor,
                            data: chart_result[i][0],
                            fill: false
                        };

                        lineChartData.datasets.push(newDataset);
                    }
                }

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

    //-------------
    //- DOMAIN LINE CHART -
    //-------------- 
    $('select.domain-option').change(function() {
        var lineChart;
        $('#lineChartDomain').remove();
        $('.domain').append(' <canvas id="lineChartDomain" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');
        const domain_id = $(this).children("option:selected").val();
        const domain = $('select.domain-option').find(":selected").text();

        // generate provider option select
        $.ajax({
            url: "{{route('home_get_domain_provider')}}",
            method: "POST",
            data: {
                id: domain_id
            },
            cache: false,
            success: function(data) {
                $('.select2-domain-provider').remove();
                $('.domain-provider').html(data);
                $('.select2-domain-provider').select2()
            }
        });

        //generate Domain Chart
        $.ajax({
            url: "{{route('domain_chart')}}",
            method: "POST",
            data: {
                id: domain_id
            },

            dataType: 'json',
            success: function(data) {

                var lineChartCanvas = document.getElementById('lineChartDomain').getContext('2d')

                var lineChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        fontSize: 18,
                        text: data[1]
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

                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                var today = new Date();
                var d;
                var month = [];

                for (var i = 11; i >= 0; i--) {
                    d = new Date(today.getFullYear(), today.getMonth() - i, 1);
                    month[11 - i] = monthNames[d.getMonth()] + ' ' + d.getFullYear();
                }
                var chart_result = data[0];
                // console.log(chart_result);
                var lineChartData = {
                    labels: month,
                    datasets: []
                }

                if (chart_result === undefined || chart_result.length == 0 || chart_result.length == null) {
                    var newDataset = {
                        label: "EMPTY",
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        fill: false
                    };

                    lineChartData.datasets.push(newDataset);
                } else {
                    var colorNames = Object.keys(window.chartColors);
                    for (i = 0; i < chart_result.length; i++) {
                        var colorName = colorNames[lineChartData.datasets.length % colorNames.length];
                        var newColor = window.chartColors[colorName];
                        var newDataset = {
                            label: chart_result[i][1],
                            backgroundColor: newColor,
                            borderColor: newColor,
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: newColor,
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: newColor,
                            data: chart_result[i][0],
                            fill: false
                        };

                        lineChartData.datasets.push(newDataset);
                    }
                }

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

    //When Domain Provider Option Clicked
    $(document).on('change', '.domain-provider-option', function() {
        const provider_id = $(this).children("option:selected").val();
        const domain_id = $('select.domain-option').children("option:selected").val();
        const provider = $('select.domain-provider-option').find(":selected").text();

        var lineChart;
        $('#lineChartDomain').remove();
        $('.domain').append(' <canvas id="lineChartDomain" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');

        //generate Domain Chart
        $.ajax({
            url: "{{route('home_get_domain_chart')}}",
            method: "POST",
            data: {
                domain_id: domain_id,
                provider_id: provider_id
            },
            dataType: 'json',
            success: function(data) {

                var lineChartCanvas = document.getElementById('lineChartDomain').getContext('2d')

                var lineChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        fontSize: 18,
                        text: data.domainName
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

                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                var today = new Date();
                var d;
                var month = [];

                for (var i = 11; i >= 0; i--) {
                    d = new Date(today.getFullYear(), today.getMonth() - i, 1);
                    month[11 - i] = monthNames[d.getMonth()] + ' ' + d.getFullYear();
                }
                var chart_result = data.chartData;
                // console.log(chart_result);
                var lineChartData = {
                    labels: month,
                    datasets: []
                }

                var colorNames = Object.keys(window.chartColors);

                var colorName = colorNames[lineChartData.datasets.length % colorNames.length];
                var newColor = window.chartColors[colorName];
                var newDataset = {
                    label: data.providerName,
                    backgroundColor: newColor,
                    borderColor: newColor,
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: newColor,
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: newColor,
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

    });


    //-------------
    //- HOSTING LINE CHART -
    //-------------- 
    $('select.hosting-option').change(function() {
        var lineChart;
        $('#lineChartHosting').remove();
        $('.hosting').append(' <canvas id="lineChartHosting" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');
        const hosting_id = $(this).children("option:selected").val();
        const hosting = $('select.hosting-option').find(":selected").text();

        // generate provider option select
        $.ajax({
            url: "{{route('home_get_hosting_provider')}}",
            method: "POST",
            data: {
                id: hosting_id
            },
            cache: false,
            success: function(data) {
                $('.select2-hosting-provider').remove();
                $('.hosting-provider').html(data);
                $('.select2-hosting-provider').select2()
            }
        });

        // Generate Hosting Chart
        $.ajax({
            url: "{{route('hosting_chart')}}",
            method: "POST",
            data: {
                id: hosting_id
            },

            dataType: 'json',
            success: function(data) {

                var lineChartCanvas = document.getElementById('lineChartHosting').getContext('2d')

                var lineChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        fontSize: 18,
                        text: data[1]
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

                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                var today = new Date();
                var d;
                var month = [];

                for (var i = 11; i >= 0; i--) {
                    d = new Date(today.getFullYear(), today.getMonth() - i, 1);
                    month[11 - i] = monthNames[d.getMonth()] + ' ' + d.getFullYear();
                }
                var chart_result = data[0];
                // console.log(chart_result);
                var lineChartData = {
                    labels: month,
                    datasets: []
                }

                if (chart_result === undefined || chart_result.length == 0 || chart_result.length == null) {
                    var newDataset = {
                        label: "EMPTY",
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        fill: false
                    };

                    lineChartData.datasets.push(newDataset);
                } else {
                    var colorNames = Object.keys(window.chartColors);
                    for (i = 0; i < chart_result.length; i++) {
                        var colorName = colorNames[lineChartData.datasets.length % colorNames.length];
                        var newColor = window.chartColors[colorName];
                        var newDataset = {
                            label: chart_result[i][1],
                            backgroundColor: newColor,
                            borderColor: newColor,
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: newColor,
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: newColor,
                            data: chart_result[i][0],
                            fill: false
                        };

                        lineChartData.datasets.push(newDataset);
                    }
                }

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

    //When Hosting Provider Option Clicked
    $(document).on('change', '.hosting-provider-option', function() {
        const provider_id = $(this).children("option:selected").val();
        const hosting_id = $('select.hosting-option').children("option:selected").val();
        const provider = $('select.hosting-provider-option').find(":selected").text();

        var lineChart;
        $('#lineChartHosting').remove();
        $('.hosting').append(' <canvas id="lineChartHosting" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');

        //generate Hosting Chart
        $.ajax({
            url: "{{route('home_get_hosting_chart')}}",
            method: "POST",
            data: {
                hosting_id: hosting_id,
                provider_id: provider_id
            },
            dataType: 'json',
            success: function(data) {

                var lineChartCanvas = document.getElementById('lineChartHosting').getContext('2d')

                var lineChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        fontSize: 18,
                        text: data.hostingType
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

                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                var today = new Date();
                var d;
                var month = [];

                for (var i = 11; i >= 0; i--) {
                    d = new Date(today.getFullYear(), today.getMonth() - i, 1);
                    month[11 - i] = monthNames[d.getMonth()] + ' ' + d.getFullYear();
                }
                var chart_result = data.chartData;
                // console.log(chart_result);
                var lineChartData = {
                    labels: month,
                    datasets: []
                }

                var colorNames = Object.keys(window.chartColors);

                var colorName = colorNames[lineChartData.datasets.length % colorNames.length];
                var newColor = window.chartColors[colorName];
                var newDataset = {
                    label: data.providerName,
                    backgroundColor: newColor,
                    borderColor: newColor,
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: newColor,
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: newColor,
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

    });
</script>
--}}
@endpush