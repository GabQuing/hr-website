@extends('layouts.side_top_content', ['title' => 'Dashboard'])

@section('module_name', 'Dashboard')

@section('content')
<style>
.dashboard_table{
    /* border:5px solid #02718A; */
    border-radius: 10px;
}
.dashboard_table th{
    text-align: center;
    vertical-align: middle !important;
    background: #02718A;
    padding: 10px; 
    color: white
}
.dashboard_table td{
    text-align: center;
    background-color: #e9eff5;
    padding: 10px;
}

.dashboard_table td:hover{
    background-color: #d4dbe2;
}
</style>
<div class="grid">
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">Today's Attendance</p>
        </div>
        <div class="today_attendance">
            <div class="today_attendance flex-column">
                <div class="today_attendance_p">
                    <h4 class="f-weight-5 attendance_action">{{ ($today_log && $today_log->log_date ? 'CLOCK IN: ' . $today_log->log_date : 'Press Clock In To Start') . ' (' . ($today_log->clock_in ?? '00:00:00') . ')' }}</h4>
                </div>
                <div class="today_attendance_message">
                    <h5 class="f-weight-4"><strong>Clock in</strong> once per day and then <strong>clock out</strong>.</h5>
                </div>
                <div class="today_attendance_btns">
                    <button type="button" data-action="CLOCK IN" data-column="clock_in" id="clock-in" class="action-button-log clock_in_btn" {{ $today_log?->clock_in || $today_log?->clock_out ? 'disabled' : '' }}>
                        <div class="today_clock_in">
                            <span class="material-symbols-outlined" style="font-size: 25px;">schedule</span>
                            <span>Clock In</span>
                        </div>
                    </button>
                    <button type="button" data-action="CLOCK OUT" data-column="clock_out" id="clock-out" class="action-button-log clock_out_btn" {{ $today_log?->clock_out || !$today_log?->clock_in ? 'disabled' : '' }}>
                        <div class="today_clock_out" >
                            <span class="material-symbols-outlined" style="font-size: 25px;">schedule</span>
                            <p>Clock Out</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container container_my_attendance">
        <div class="container_title">
            <p class="header_title_h2">My Break</p>
        </div>
        <div class="my_break">
            <div class="my_break flex-column">
                <div class="my_break_p">
                    <h4 class="f-weight-5 break_action">{{ ($today_log && $today_log->log_date ? 'BREAK START: ' . $today_log->log_date : 'Press Break Start') . ' (' . ($today_log->break_start ?? '00:00:00') . ')' }}</h4>
                </div>
                <div class="my_break_message">
                    <h5 class="f-weight-4"><strong>Break start</strong> once per day and then <strong>break end</strong>.</h5>
                </div>
                <div class="my_break_btns">
                    <button type="button" data-action="BREAK START" data-column="break_start" id="break-start" class="action-button-log clock_in_btn" {{ !$today_log?->clock_in || $today_log?->break_start || $today_log?->clock_out ? 'disabled' : '' }}>
                        <div class="break_start_btn">
                            <span class="material-symbols-outlined"style="font-size: 25px;">local_cafe</span>
                            <span>Break Start</span>
                        </div>
                    </button>
                    <button type="button" data-action="BREAK END" data-column="break_end" id="break-end" class="action-button-log clock_out_btn" {{ !$today_log?->break_start || $today_log?->break_end || $today_log?->clock_out ? 'disabled' : '' }}>
                        <div class="break_end_btn" >
                            <span class="material-symbols-outlined"style="font-size: 25px;">local_cafe</span>
                            <p>Break End</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container container_my_store_location">
        <div class="dashboard_table">
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date Access</th>
                        <th>Time Access</th>
                        <th>Log-Type</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $user_logs = $user_logs->sortByDesc('log_date')->take(4);
                    @endphp
                    @foreach ($user_logs as $user_log)
                        <tr>
                            <td>{{ date('M d Y', strtotime($user_log->log_date)) }}</td>
                            <td>{{ date('h:i a', strtotime($user_log->log_time)) }}</td>
                            <td>{{ $user_log->log_type_description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('script_content')
<script>
    $(document).ready(function(){
        function showLogDetails(logDetails) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
                customClass: {
                    popup: 'custom-swal'
                },
                iconColor: '#02718A'
            });
            Toast.fire({
                icon: "success",
                title: `Your log (${logDetails.log_type}) has been added to your today's log.`,
            });
        }

        function refreshButtons(logToday) {
            // console.log(logToday);
            const clockIn = $('#clock-in');
            const clockOut = $('#clock-out');
            const breakStart = $('#break-start');
            const breakEnd = $('#break-end');

            clockIn.attr('disabled', logToday.clock_in || logToday.clock_out);
            clockOut.attr('disabled', logToday.clock_out || !logToday.clock_in);
            breakStart.attr('disabled', !logToday.clock_in || logToday.break_start || logToday.clock_out);
            breakEnd.attr('disabled', !logToday.break_start || logToday.break_end || logToday.clock_out);
        }
        
        function displayAction(logToday) {
            console.log(logToday);
            let selector = '';
            if (logToday.log_type === "CLOCK IN" || logToday.log_type === "CLOCK OUT") {
                selector = '.attendance_action';
            }
            if (logToday.log_type === "BREAK START" || logToday.log_type === "BREAK END") {
                selector = '.break_action';
            }
            $(selector).text(`${logToday.log_type || 'No Action Available'}: ${logToday.log_date || 'No Date Available'} (${logToday.log_time || 'No Time Available'})`);
        }
        

        $( ".container" ).first().show( "slow", function showNext() {
            $( this ).next( ".container" ).show( "slow", showNext );
        });

        $('.action-button-log').on('click', function() {
            if ($(this).attr('disabled')) return;
            $(this).attr('disabled', true);
            const userId = "{{ auth()->user()->id }}";
            const userSchedID = "{{ auth()->user()->schedule_types_id }}";
            const action = $(this).attr('data-action');
            $.ajax({
                url: "{{ route('dashboard.log-action') }}",
                method: 'POST',
                type: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: userId,
                    user_sched_id:userSchedID,
                    action,
                },
                success: function(data) {
                    showLogDetails(data.log_details);
                    refreshButtons(data.log_today);
                    displayAction(data.log_details);
                },
                error: function(error) {
                    const errorMessage = error.responseJSON.message;
                    alert(errorMessage);
                }
            })
        });

                
    });
</script>
@endsection
@endsection