@extends('layout.layout_admin')

@section('title', 'Calendar')

@section('page')

@push('style')
<link rel="stylesheet" href="{{URL::asset('assets/css/fullcalendar/main.css')}}">
@endpush

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Overview content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row mb-2 content-header">
                <div class="col-sm-12">
                    <h1>Calendar</h1>
                </div>
            </div>

        </div>

        <!--In Progress content -->
        <section class="content">

            <div class="container-fluid">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-body p-0">
                                        <!-- THE CALENDAR -->
                                        <div id="calendar"></div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>

            </div>
        </section>
</div>
<!-- /.content -->


@endsection

@push('plugin')

<script src="{{URL::asset('assets/js/moment/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/fullcalendar/main.js')}}"></script>

<script>
    // Ajax setup from csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //
    $(function() {
        // Generate Hosting Chart
        $.ajax({
            url: "{{route('calendar_get_data')}}",
            method: "POST",
            data: {
                id: 0
            },
            dataType: 'json',
            success: function(data) {
                /* initialize the calendar
                      -----------------------------------------------------------------*/
                //Date for the calendar events (dummy data)
                var date = new Date()
                var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear()

                var Calendar = FullCalendar.Calendar;
                var Draggable = FullCalendar.Draggable;

                var calendarEl = document.getElementById('calendar');

                var calendar = new Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth'
                    },
                    themeSystem: 'bootstrap',
                    //Random default events
                    events: data,
                    editable: false,
                    droppable: false, // this allows things to be dropped onto the calendar !!!
                    drop: function(info) {
                        // is the "remove after drop" checkbox checked?
                        console.log(checkbox.checked);
                        if (checkbox.checked) {
                            // if so, remove the element from the "Draggable Events" list
                            info.draggedEl.parentNode.removeChild(info.draggedEl);

                        }
                    }
                });

                calendar.render();
                // $('#calendar').fullCalendar()

            }
        });

    });
</script>

@endpush