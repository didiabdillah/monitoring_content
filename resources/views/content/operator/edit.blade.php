@extends('layout.layout_admin')

@section('title', 'Edit Provider')

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
                        <h3 class="card-title">Edit Provider</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('provider_update', $provider->provider_id)}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="provider">Provider</label>
                                <input type="text" class="form-control @error('provider') is-invalid @enderror" id="provider" name="provider" placeholder="Provider" value="{{$provider->provider_name}}">
                                @error('provider')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <a href="{{route('provider')}}" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
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