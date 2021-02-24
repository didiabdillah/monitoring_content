@extends('layout.layout_admin')

@section('title', 'Insert Content')

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
                        <h3 class="card-title">Insert Content</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('content_store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{old('title')}}">
                                @error('title')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" placeholder="Note">{{old('note')}}</textarea>
                                @error('note')
                                <div class=" invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control select2 type-option @error('type') is-invalid @enderror" data-placeholder="Select Type" style="width: 100%;" name="type">
                                    <option value="file" selected>File</option>
                                    <option value="link">Link</option>
                                </select>
                                @error('type')
                                <div class="invalid-feedback">
                                    Please select type
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="file">File Upload</label>
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
                            <button type="submit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Insert</button>
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
    //WHEN PROVIDER SELECTED
    $('select.type-option').change(function() {

        $('#lineChart').remove();
        $('.chart').append(' <canvas id="lineChart" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');
        const provider_id = $(this).children("option:selected").val();
        const provider = $('select.provider-option').find(":selected").text();



        return false;
    });
</script>
@endpush