@extends('layout.layout_admin')

@section('title', 'Insert Category')

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
                        Insert Category
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- form start -->
                        <form action="{{route('category_store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" placeholder="Category Name" value="{{old('category')}}">
                                    @error('category')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="{{route('category')}}" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Insert</button>
                            </div>
                        </form>
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