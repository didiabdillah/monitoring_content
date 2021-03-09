@extends('layout.layout_admin')

@section('title', 'Detail Operator')

@section('page')

@include('layout.flash_alert')

<!-- Custom Css For This Page -->
@push('style')
<style>
    .clickTableData:hover {
        cursor: pointer;
    }
</style>
@endpush

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Overview content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row content-header">
                <div class="col-sm-12">
                    <h1>Operator Detail</h1>
                </div>
            </div>
        </div>

        <!--Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('operator')}}" class="btn btn-danger float-left btn-sm"><i class="fas fa-arrow-left"></i> Back</a>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- About Me Box -->
                        <div class="card card-primary">

                            <div class="card-body">
                                <strong><i class="fas fa-user mr-1"></i> Name</strong>

                                <p class="text-muted">
                                    {{$user->user_name}}
                                </p>

                                <hr>

                                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                                <p class="text-muted">
                                    {{$user->user_email}}
                                </p>

                                <hr>

                                <strong><i class="fas fa-phone mr-1"></i> Phone Number</strong>

                                <p class="text-muted">
                                    {{$user->user_phone}}
                                </p>

                                <hr>

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

                                <hr>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
        </section>
    </section>

</div>

@endsection

<!-- Custom Javascript For This Page -->
@push('plugin')


@endpush