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
                                        <div class="row">
                                            <div class="col-sm-6">
                                                {!!$notif->notification_detail!!}
                                            </div>
                                            <div class="col-sm-6">
                                                <form action="{{route('notification_destroy', $notif->notification_id)}}" method="POST" class="form-inline form-horizontal float-right">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-xs btn-remove" type="submit">
                                                        <i class="fas fa-times">
                                                        </i>

                                                        Remove
                                                    </button>
                                                </form>

                                            </div>
                                        </div>

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

@push('plugin')
<script>
    // --------------
    // Delete Button
    // --------------
    $('.btn-remove').on('click', function(e) {
        e.preventDefault();
        var form = $(this).parents('form');
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

@endpush