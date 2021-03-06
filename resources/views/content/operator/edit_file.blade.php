@extends('layout.layout_admin')

@section('title', 'Edit Content File')

@section('page')

@include('layout.flash_alert')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Overview content -->
    <section class="content mt-3">

        <!--Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Content File</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('content_update_file', $content->content_id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{$content->content_title}}">
                                @error('title')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            @if($content->content_is_present == false)
                            <div class="form-group">
                                <label for="date">Date</label>
                                <select class="form-control select2 @error('date') is-invalid @enderror" data-placeholder="Select Date" style="width: 100%;" name="date">
                                    <option value="">Select Date</option>
                                    @foreach($date_list as $row)
                                    <option value="{{$row->missed_upload_date}}" @if($content->content_date == $row->missed_upload_date) selected @endif>{{Carbon\Carbon::parse($row->missed_upload_date)->isoFormat('D MMMM Y')}}</option>
                                    @endforeach
                                </select>
                                @error('date')
                                <div class="invalid-feedback">
                                    Please select date
                                </div>
                                @enderror
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control select2 @error('category') is-invalid @enderror" data-placeholder="Select Category" style="width: 100%;" name="category">
                                    <option value="">Select Category</option>
                                    @foreach($category as $row)
                                    <option value="{{$row->category_name}}" @if($content->content_category == $row->category_name) selected @endif>{{$row->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div class="invalid-feedback">
                                    Please select category
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" placeholder="Note">{{$content->content_note}}</textarea>
                                @error('note')
                                <div class=" invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Attached File</label>
                                @php $isFile = NULL; @endphp
                                @foreach($content->content_file()->get() as $file)

                                @if($file->content_file_id)
                                @php $isFile = $file->content_file_id; @endphp
                                @endif

                                <div id="{{$file->content_file_hash_name}}">
                                    <i class="far fa-fw fa-file-word"></i> {{$file->content_file_original_name}}
                                    @if($file->content_file_extension == "docx" || $file->content_file_extension == "doc")
                                    <a href="https://view.officeapps.live.com/op/view.aspx?src={{URL::asset('assets/file/word/' . $file->content_file_hash_name)}}" class="ml-1 btn btn-xs btn-primary" target="_blank"><i class="fas fa-eye"></i></a>
                                    @else
                                    <a href="{{route('content_file_preview', [$content->content_id,$file->content_file_hash_name])}}" class="ml-1 btn btn-xs btn-primary" target="_blank"><i class="fas fa-eye"></i></a>
                                    @endif
                                    <button id="{{$file->content_file_id}}" class="ml-1 btn btn-xs btn-danger btn-remove"><i class="fas fa-times"></i></a>
                                </div>

                                @endforeach

                                @if($isFile == NULL)
                                <div>
                                    <p>No File Attached</p>
                                </div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="file">File Upload (Can Multiple)</label>
                                <div class="input-group  @error('file') is-invalid @enderror">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" name="file[]" multiple>
                                        <label class="custom-file-label" for="file">Choose file</label>
                                    </div>
                                </div>
                                @error('file')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <a href="{{route('content')}}" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </section>

    </section>

</div>
@endsection

@push('plugin')

<!-- Select2 -->
<script src="{{URL::asset('assets/js/select2/js/select2.full.min.js')}}"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>

<!-- bs-custom-file-input -->
<script src="{{URL::asset('assets/js/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script type="text/javascript">
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<script>
    // Ajax setup from csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // --------------
    // Delete Button
    // --------------
    $('.btn-remove').on('click', function(e) {
        var id = $(this).attr('id');
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
                $.ajax({
                    url: "{{route('content_update_file_remove', $content->content_id)}}",
                    method: "POST",
                    data: {
                        file_id: id
                    },
                    success: function(data) {
                        console.log(data);
                        $("div#" + data).remove();
                    }
                });

            }
        });
    });
</script>
@endpush