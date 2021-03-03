@extends('layout.layout_admin')

@section('title', 'Confirm Content')

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
                        <div class="card card-primary">

                            <form action="{{route('content_confirm_update', $content->content_id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="confirm">Status</label>
                                        <select class="form-control select2 @error('confirm') is-invalid @enderror" data-placeholder="Select Confirm Status" style="width: 100%;" name="confirm">
                                            <option value="">Select Status...</option>
                                            {{-- <option value="{{__('content_status.content_status_process')}}" @if($content->content_status == __('content_status.content_status_process')){{"selected"}}@endif>Process</option> --}}
                                            <option value="{{__('content_status.content_status_success')}}" @if($content->content_status == __('content_status.content_status_success')){{"selected"}}@endif>Accept</option>
                                            <option value="{{__('content_status.content_status_failed')}}" @if($content->content_status == __('content_status.content_status_failed')){{"selected"}}@endif>Reject</option>
                                        </select>
                                        @error('confirm')
                                        <div class="invalid-feedback">
                                            Please select status
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        @php // @endphp
                                        <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" placeholder="Note">{{$content->content_comment}}</textarea>
                                        @error('note')
                                        <div class=" invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <a href="{{route('content')}}" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Confirm</button>
                                </div>
                            </form>

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
                                @if($content->updated_at != $content->created_at)
                                <strong><i class="fas fa-calendar-alt mr-1"></i> Last Update</strong>
                                <br>
                                <h4> <span class="badge badge-warning">{{Carbon\Carbon::parse($content->updated_at)->isoFormat('D MMMM Y, H:mm:ss')}}</span></h4>

                                <hr>
                                @endif

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
            </div>
        </section>
    </section>

</div>

@endsection

<!-- Custom Javascript For This Page -->
@push('plugin')


@endpush