@extends('layout.layout_admin')

@section('title', 'Notification')

@section('page')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Overview content -->
    <section class="content">

        <!--In Progress content -->
        <section class="content">

            <div class="container-fluid">

                <!-- Timelime example  -->
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <!-- The time line -->
                        <div class="timeline">
                            <!-- timeline item -->

                            @foreach($notification as $notif)
                            <div>
                                <i class="fas fa-bell bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{Carbon\Carbon::parse($notif->notification_date)->isoFormat('dddd, D MMMM Y')}}</span>
                                    <h3 class="timeline-header"><b>Admin</b></h3>

                                    <div class="timeline-body">
                                        {!!$notif->notification_detail!!}
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- END timeline item -->
                        </div>
                        <div class="float-right">
                            {{ $notification->links() }}
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
        </section>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection