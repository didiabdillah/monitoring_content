@extends('layout.layout_admin')

@section('title', 'Setting')

@section('page')

@include('layout.flash_alert')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Overview content -->
    <section class="content">

        <!--In Progress content -->
        <section class="content">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-5 mt-4">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <strong><i class="fab fa-whatsapp mr-1"></i>API Whatsapp</strong>
                                <p class="text-muted">
                                    @if($setting)
                                    {{$setting->setting_api_whatsapp}}
                                    @endif
                                </p>

                                <hr>

                                <strong><i class="fab fa-telegram mr-1"></i>API Telegram</strong>

                                <form action="{{route('telegram_setwebhook')}}" method="POST">
                                    @csrf
                                    @method('patch')
                                    <p class="text-muted">
                                        @if($setting)
                                        {{$setting->setting_api_telegram}}
                                        @endif

                                        <button type="submit" class="ml-3 btn btn-primary btn-sm"><i class="fas fa-sync"></i> Refresh Set Webhook</button>

                                    </p>
                                </form>

                                <hr>

                                <strong><i class="fas fa-server mr-1"></i>SMTP Host</strong>
                                <p class="text-muted">
                                    @if($setting)
                                    {{$setting->setting_smtp_host}}
                                    @endif
                                </p>

                                <hr>

                                <strong><i class="fas fa-network-wired mr-1"></i>SMTP Port</strong>
                                <p class="text-muted">
                                    @if($setting)
                                    {{$setting->setting_smtp_port}}
                                    @endif
                                </p>

                                <hr>

                                <strong><i class="fas fa-envelope mr-1"></i>SMTP User</strong>
                                <p class="text-muted">
                                    @if($setting)
                                    {{$setting->setting_smtp_user}}
                                    @endif
                                </p>

                                <hr>

                                <strong><i class="fas fa-lock mr-1"></i>SMTP Password</strong>
                                <p class="text-muted">
                                    @if($setting)
                                    {{$setting->setting_smtp_password}}
                                    @endif
                                </p>

                                <hr>

                                @php
                                $logo = ($setting) ? $setting->setting_logo : 'default-logo.png';
                                $favicon = ($setting) ? $setting->setting_favicon : 'default-favicon.ico';
                                @endphp

                                <strong><i class="fas fa-image mr-1"></i>Logo</strong>
                                <p class="text-muted">
                                    <img src="{{URL::asset('assets/img/logo/' . $logo)}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: 1; max-width: 250px;">
                                    <button type="button" data-toggle="modal" data-target="#modal-logo" class="ml-3 mt-3 btn btn-primary btn-sm">Change</button>
                                </p>

                                <hr>

                                <strong><i class="fas fa-image mr-1"></i>Favicon</strong>
                                <p class="text-muted">
                                    <img src="{{URL::asset('assets/img/favicon/' . $favicon)}}" alt="AdminLTE Favicon" class="brand-image elevation-3" style="opacity: 1; max-width: 100px;">
                                    <button type="button" data-toggle="modal" data-target="#modal-favicon" class="ml-3 mt-3 btn btn-primary btn-sm">Change</button>
                                </p>

                                <hr>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-7 mt-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane" id="profile">

                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane  active" id="settings">
                                        <!-- general form elements -->
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-wrench"></i> Setting</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form action="{{route('setting_update')}}" method="POST">
                                                @csrf
                                                @method('patch')
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="api_wa">API Whatsapp</label>
                                                        <input name="api_wa" type="text" class="form-control @error('api_wa') is-invalid @enderror" id="api_wa" placeholder="Enter API Whatsapp" value="@if($setting){{$setting->setting_api_whatsapp}}@endif">
                                                        @error('api_wa')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="api_tg">API Telegram</label>
                                                        <input name="api_tg" type="text" class="form-control @error('api_tg') is-invalid @enderror" id="api_tg" placeholder="Enter API Telegram" value="@if($setting){{$setting->setting_api_telegram}}@endif">
                                                        @error('api_tg')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="host">SMTP Host</label>
                                                        <input name="host" type="text" class="form-control @error('host') is-invalid @enderror" id="host" placeholder="Enter SMTP Host" value="@if($setting){{$setting->setting_smtp_host}}@endif">
                                                        @error('host')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="port">SMTP Port</label>
                                                        <input name="port" type="text" class="form-control @error('port') is-invalid @enderror" id="port" placeholder="Enter SMTP Port" value="@if($setting){{$setting->setting_smtp_port}}@endif">
                                                        @error('port')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="user">SMTP User</label>
                                                        <input name="user" type="email" class="form-control @error('user') is-invalid @enderror" id="user" placeholder="Enter SMTP User" value="@if($setting){{$setting->setting_smtp_user}}@endif">
                                                        @error('user')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">SMTP Password</label>
                                                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter SMTP Password" value="@if($setting){{$setting->setting_smtp_password}}@endif">
                                                        @error('password')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <!-- /.card-body -->

                                                <div class="card-footer">
                                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                                    <button type="submit" class="btn btn-primary btn-setting-save">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.card -->

                                    </div>
                                    <!-- /.tab-pane -->

                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

        </section>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Upload Logo Modal Form -->
<div class="modal fade" id="modal-logo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Logo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('setting_logo')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="logo">Logo Upload (.jpg/.jpeg/.png/.gif)</label>
                            <div class="input-group @error('logo') is-invalid @enderror">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" id="logo" name="logo">
                                    <label class="custom-file-label" for="logo">Choose file</label>
                                </div>
                            </div>
                            @error('logo')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Upload Favicon Modal Form -->
<div class="modal fade" id="modal-favicon">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Favicon</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('setting_favicon')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="favicon">Favicon Upload (.ico)</label>
                            <div class="input-group @error('favicon') is-invalid @enderror">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('favicon') is-invalid @enderror" id="favicon" name="favicon">
                                    <label class="custom-file-label" for="favicon">Choose file</label>
                                </div>
                            </div>
                            @error('favicon')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@push('plugin')

@error('logo')
<script type="text/javascript">
    $(document).ready(function() {
        $('#modal-logo').modal('show');
    });
</script>
@enderror

@error('favicon')
<script type="text/javascript">
    $(document).ready(function() {
        $('#modal-favicon').modal('show');
    });
</script>
@enderror

<script>
    // --------------
    // Delete Button
    // --------------
    $('.btn-setting-save').on('click', function(e) {
        e.preventDefault();
        var form = $(this).parents('form');
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

<!-- bs-custom-file-input -->
<script src="{{URL::asset('assets/js/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script type="text/javascript">
    $(function() {
        bsCustomFileInput.init();
    });
</script>
@endpush