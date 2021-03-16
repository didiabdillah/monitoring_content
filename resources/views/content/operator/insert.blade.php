@extends('layout.layout_admin')

@section('title', 'Insert Content')

@section('page')

@include('layout.flash_alert')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Overview content -->
    <section class="content">

        <!--Content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        Insert Content
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            @if(strtotime(date('Y-m-d H:i:s')) > strtotime(date('Y-m-d') . ' 08:00:00') && strtotime(date('Y-m-d H:i:s')) < strtotime(date('Y-m-d') . ' 17:00:00' )) <!-- -->
                                <li class="nav-item"><a class="nav-link active" href="#present" data-toggle="tab">Present</a></li>
                                <li class="nav-item"><a class="nav-link" href="#past" data-toggle="tab">Past</a></li>
                                @else
                                <li class="nav-item"><a class="nav-link active" href="#past" data-toggle="tab">Past</a></li>
                                @endif
                        </ul>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="tab-content">

                            <!-- PRESENT-->
                            @if(strtotime(date('Y-m-d H:i:s')) > strtotime(date('Y-m-d') . ' 08:00:00') && strtotime(date('Y-m-d H:i:s')) < strtotime(date('Y-m-d') . ' 17:00:00' )) <!-- -->
                                <div class="active tab-pane" id="present">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#filePresent" data-toggle="tab">File</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#linkPresent" data-toggle="tab">Link</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->

                                    <div class="card-body">
                                        <div class="tab-content">

                                            <!-- INSERT FILE -->
                                            <div class="active tab-pane" id="filePresent">
                                                <!-- form start -->
                                                <form action="{{route('content_store_file')}}" method="POST" enctype="multipart/form-data">
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
                                                            <label for="category">Category</label>
                                                            <select class="form-control select2 @error('category') is-invalid @enderror" data-placeholder="Select Category" style="width: 100%;" name="category">
                                                                <option value="">Select Category</option>

                                                                @foreach($category as $row)
                                                                <option value="{{$row->category_name}}" @if(old('category')==$row->category_name)selected@endif>{{$row->category_name}}</option>
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
                                                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" placeholder="Note">{{old('note')}}</textarea>
                                                            @error('note')
                                                            <div class=" invalid-feedback">
                                                                {{$message}}
                                                            </div>
                                                            @enderror
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
                                                        <button type="submit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Insert</button>
                                                    </div>
                                                </form>

                                            </div>
                                            <!-- /.tab-pane -->

                                            <!-- INSERT LINK -->
                                            <div class="tab-pane" id="linkPresent">
                                                <form action="{{route('content_store_link')}}" method="POST" enctype="multipart/form-data">
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
                                                            <label for="category">Category</label>
                                                            <select class="form-control select2 @error('category') is-invalid @enderror" data-placeholder="Select Category" style="width: 100%;" name="category">
                                                                <option value="">Select Category</option>
                                                                @foreach($category as $row)
                                                                <option value="{{$row->category_name}}" @if(old('category')==$row->category_name) selected @endif>{{$row->category_name}}</option>
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
                                                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" placeholder="Note">{{old('note')}}</textarea>
                                                            @error('note')
                                                            <div class=" invalid-feedback">
                                                                {{$message}}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="link">Link</label>
                                                            <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" placeholder="Link" value="{{old('link')}}">
                                                            @error('link')
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
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->

                                </div>
                                @endif
                                <!-- /.tab-pane -->

                                <!-- PAST -->
                                @if(strtotime(date('Y-m-d H:i:s')) > strtotime(date('Y-m-d') . ' 08:00:00') && strtotime(date('Y-m-d H:i:s')) < strtotime(date('Y-m-d') . ' 17:00:00' )) <!-- -->
                                    <div class="tab-pane" id="past">
                                        @else
                                        <div class="tab-pane active" id="past">
                                            @endif
                                            <div class="card-header p-2">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item"><a class="nav-link active" href="#filePast" data-toggle="tab">File</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#linkPast" data-toggle="tab">Link</a></li>
                                                </ul>
                                            </div><!-- /.card-header -->

                                            <div class="card-body">
                                                <div class="tab-content">

                                                    <!-- INSERT FILE -->
                                                    <div class="active tab-pane" id="filePast">
                                                        <!-- form start -->
                                                        <form action="{{route('content_store_file')}}" method="POST" enctype="multipart/form-data">
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
                                                                    <label for="category">Category</label>
                                                                    <select class="form-control select2 @error('category') is-invalid @enderror" data-placeholder="Select Category" style="width: 100%;" name="category">
                                                                        <option value="">Select Category</option>
                                                                        @foreach($category as $row)
                                                                        <option value="{{$row->category_name}}" @if(old('category')==$row->category_name)selected@endif>{{$row->category_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('category')
                                                                    <div class="invalid-feedback">
                                                                        Please select category
                                                                    </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="date">Date (If This Empty, It's mean You Don't Have Missed Upload)</label>
                                                                    <select class="form-control select2 @error('date') is-invalid @enderror" data-placeholder="Select Date (If This Empty, It's mean You Don't Have Missed Upload)" style="width: 100%;" name="date">
                                                                        <option value="">Select Date</option>
                                                                        @foreach($date as $row)
                                                                        <option value="{{$row->missed_upload_date}}">{{Carbon\Carbon::parse($row->missed_upload_date)->isoFormat('D MMMM Y')}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('date')
                                                                    <div class="invalid-feedback">
                                                                        Please select date
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
                                                                <button type="submit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Insert</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                    <!-- /.tab-pane -->

                                                    <!-- INSERT LINK -->
                                                    <div class="tab-pane" id="linkPast">
                                                        <form action="{{route('content_store_link')}}" method="POST" enctype="multipart/form-data">
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
                                                                    <label for="category">Category</label>
                                                                    <select class="form-control select2 @error('category') is-invalid @enderror" data-placeholder="Select Category" style="width: 100%;" name="category">
                                                                        <option value="">Select Category</option>
                                                                        @foreach($category as $row)
                                                                        <option value="{{$row->category_name}}" @if(old('category')==$row->category_name)selected@endif>{{$row->category_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('category')
                                                                    <div class="invalid-feedback">
                                                                        Please select category
                                                                    </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="date">Date (If This Empty, It's mean You Don't Have Missed Upload)</label>
                                                                    <select class="form-control select2 @error('date') is-invalid @enderror" data-placeholder="Select Date (If This Empty, It's mean You Don't Have Missed Upload)" style="width: 100%;" name="date">
                                                                        <option value="">Select Date</option>
                                                                        @foreach($date as $row)
                                                                        <option value="{{$row->missed_upload_date}}">{{Carbon\Carbon::parse($row->missed_upload_date)->isoFormat('D MMMM Y')}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('date')
                                                                    <div class="invalid-feedback">
                                                                        Please select date
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
                                                                    <label for="link">Link</label>
                                                                    <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" placeholder="Link" value="{{old('link')}}">
                                                                    @error('link')
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
                                                    <!-- /.tab-pane -->
                                                </div>
                                                <!-- /.tab-content -->
                                            </div><!-- /.card-body -->
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                        </div><!-- /.card-body -->
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


<!-- <script>
    //WHEN PROVIDER SELECTED
    $('select.type-option').change(function() {

        $('#lineChart').remove();
        $('.chart').append(' <canvas id="lineChart" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>');
        const provider_id = $(this).children("option:selected").val();
        const provider = $('select.provider-option').find(":selected").text();



        return false;
    });
</script> -->
@endpush