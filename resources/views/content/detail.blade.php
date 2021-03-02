@extends('layout.layout_admin')

@section('title', 'Detail Content')

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
                    <h1>Content Detail</h1>
                </div>
            </div>
        </div>

        <!--Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('content')}}" class="btn btn-danger float-left btn-sm"><i class="fas fa-arrow-left"></i> Back</a>

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
                                <strong><i class="fas fa-align-center mr-1"></i> Title</strong>

                                <p class="text-muted">
                                    {{$content->content_title}}
                                </p>

                                <hr>

                                <strong><i class="fas fa-folder mr-1"></i> Type</strong>

                                <p class="text-muted"> {{$content->content_type}}</p>

                                <hr>

                                <strong><i class="fas fa-info-circle mr-1"></i> Status</strong>

                                <p class="text-muted">
                                    @if($content->content_status == __('content_status.content_status_process'))
                                    <span class="badge badge-pill badge-primary">{{$content->content_status}}</span>
                                    @elseif($content->content_status == __('content_status.content_status_success'))
                                    <span class="badge badge-pill badge-success">{{$content->content_status}}</span>
                                    @elseif($content->content_status == __('content_status.content_status_failed'))
                                    <span class="badge badge-pill badge-danger">{{$content->content_status}}</span>
                                    @endif
                                </p>

                                <hr>

                                <strong><i class="fas fa-user mr-1"></i> Owner</strong>

                                <p class="text-muted"> {{$content->user_name}}</p>

                                <hr>

                                <strong><i class="fas fa-calendar-alt mr-1"></i> Uploaded</strong>
                                <br>
                                <h4> <span class="badge badge-secondary">{{Carbon\Carbon::parse($content->created_at)->isoFormat('D MMMM Y, H:mm:ss')}}</span></h4>

                                <hr>

                                <strong><i class="fas fa-calendar-alt mr-1"></i> Last Update</strong>
                                <br>
                                <h4> <span class="badge badge-warning">{{Carbon\Carbon::parse($content->updated_at)->isoFormat('D MMMM Y, H:mm:ss')}}</span></h4>

                                <hr>

                                <strong><i class="fas fa-sticky-note mr-1"></i> Note</strong>

                                <p class="text-muted"> {{$content->content_note}}</p>

                                <hr>

                                @if($content->content_type=="link")
                                <strong><i class="fas fa-link mr-1 mb-1"></i> Link</strong>
                                @foreach($content->content_link()->get() as $link)
                                <br>
                                <a href="{{$link->content_link_url}}">{{$link->content_link_url}}</a>
                                @endforeach
                                @elseif($content->content_type=="file")
                                <strong><i class="fas fa-file-alt mr-1"></i> File</strong><br>
                                @foreach($content->content_file()->get() as $file)
                                @if($file->content_file_extension == "docx" || $file->content_file_extension == "doc")
                                <h6>
                                    <i class="far fa-fw fa-file-word"></i> {{$file->content_file_original_name}}
                                    <a href="https://view.officeapps.live.com/op/view.aspx?src={{URL::asset('assets/file/word/' . $file->content_file_hash_name)}}" class="ml-1 btn btn-xs btn-primary" target="_blank"><i class="fas fa-eye"></i></a>
                                    <a href="{{route('content_file_download', [$content->content_id,$file->content_file_hash_name])}}" class="ml-1 btn btn-xs btn-success"><i class="fas fa-cloud-download-alt"></i></a>
                                </h6>
                                @else
                                <h6>
                                    <i class="far fa-fw fa-file-image"></i> {{$file->content_file_original_name}}
                                    <a href="{{route('content_file_preview', [$content->content_id,$file->content_file_hash_name])}}" class="ml-1 btn btn-xs btn-primary" target="_blank"><i class="fas fa-eye"></i></a>
                                    <a href="{{route('content_file_download', [$content->content_id,$file->content_file_hash_name])}}" class="ml-1 btn btn-xs btn-success"><i class="fas fa-cloud-download-alt"></i></a>
                                </h6>
                                @endif
                                @endforeach
                                @endif
                                <hr>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- CONTENT HISTORY -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Content History</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Date, Time</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($content->content_history()->orderBy('created_at', 'desc')->get() as $content_history)
                                    @if($content_history)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{Carbon\Carbon::parse($content_history->created_at)->isoFormat('D MMMM Y, H:mm:ss')}}</td>
                                        <td>
                                            @if($content_history->content_history_status == __('content_status.content_status_process'))
                                            <span class="badge badge-pill badge-primary">{{$content_history->content_history_status}}</span>
                                            @elseif($content_history->content_history_status == __('content_status.content_status_success'))
                                            <span class="badge badge-pill badge-success">{{$content_history->content_history_status}}</span>
                                            @elseif($content_history->content_history_status == __('content_status.content_status_failed'))
                                            <span class="badge badge-pill badge-danger">{{$content_history->content_history_status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <p>{{$content_history->content_history_note}}</p>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td>No History</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </section>
    </section>

</div>

@endsection

<!-- Custom Javascript For This Page -->
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
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pagingType": "simple_numbers",
        });
    });
</script>

@endpush