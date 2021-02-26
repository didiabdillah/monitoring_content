@extends('layout.layout_admin')

@section('title', 'Content')

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
                    <h1>Content</h1>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-3 col-md-3">
                    <a href="{{route('content_insert')}}" class="btn btn-primary btn-md mb-3 btn-block"><i class="fas fa-plus"></i> Insert a new Content</a>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

        <!--Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover table-striped projects">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date, Time</th>
                                    <th>Content</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($content as $data)
                                @php $link_detail = route('content_detail', $data->content_id); @endphp
                                <tr>
                                    <td>
                                        <h6> {{$loop->iteration}}</h6>
                                    </td>

                                    <td class="clickTableData" onClick="document.location.href='{{$link_detail}}';">
                                        <h6>{{$data->content_title}}</h6>
                                    </td>

                                    <td>
                                        <h6>{{$data->content_type}}</h6>
                                    </td>

                                    <td>
                                        <h6>
                                            @if($data->content_status == __('content_status.content_status_process'))
                                            <span class="badge badge-pill badge-primary">{{$data->content_status}}</span>

                                            @elseif($data->content_status == __('content_status.content_status_success'))

                                            <span class="badge badge-pill badge-success">{{$data->content_status}}</span>

                                            @elseif($data->content_status == __('content_status.content_status_failed'))

                                            <span class="badge badge-pill badge-danger">{{$data->content_status}}</span>
                                            @endif

                                            @if($data->content_comment != NULL)
                                            <!-- Example single danger button -->
                                            <div class=" ml-2 btn-group">
                                                <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Comment
                                                </button>
                                                <div class="dropdown-menu">
                                                    <p class="dropdown-header">Comment</p>
                                                    <div class="dropdown-divider"></div>
                                                    <p class="p-1 m-1">{{$data->content_comment}}</p>
                                                </div>
                                            </div>
                                            @endif
                                        </h6>
                                    </td>

                                    <td>
                                        <h6>{{Carbon\Carbon::parse($data->updated_at)->isoFormat('D MMMM Y, H:mm:ss')}}</h6>
                                    </td>

                                    <td>
                                        @if($data->content_type=="link")
                                        @foreach($data->content_link()->get() as $link)
                                        <a href="{{$link->content_link_url}}">{{$link->content_link_url}}</a>
                                        @endforeach
                                        @elseif($data->content_type=="file")
                                        @foreach($data->content_file()->get() as $file)
                                        <h6>
                                            <i class="far fa-fw fa-file-word"></i> {{$file->content_file_original_name}}
                                            <a href="{{route('content_file_preview', [$data->content_id,$file->content_file_hash_name])}}" class="ml-1 btn btn-xs btn-primary" target="_blank"><i class="fas fa-eye"></i></a>
                                            <a href="{{route('content_file_download', [$data->content_id,$file->content_file_hash_name])}}" class="ml-1 btn btn-xs btn-success"><i class="fas fa-cloud-download-alt"></i></a>
                                        </h6>
                                        @endforeach
                                        @endif
                                    </td>

                                    <td>
                                        <form action="{{route('content_destroy', $data->content_id)}}" method="POST" class="form-inline form-horizontal">
                                            @csrf
                                            @method('delete')
                                            <div class="card-body">
                                                <a class="btn btn-success btn-sm" href="{{$link_detail}}">
                                                    <i class="fas fa-folder">
                                                    </i>

                                                    Detail
                                                </a>
                                                <a class="btn btn-primary btn-sm" href="{{route('content_edit', $data->content_id)}}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>

                                                    Edit
                                                </a>
                                                <button class="btn btn-danger btn-sm btn-remove" type="submit">
                                                    <i class="fas fa-trash">
                                                    </i>

                                                    Remove
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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