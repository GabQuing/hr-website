@extends('layouts.side_top_content')

@section('module_name', 'Dashboard')

@section('content')
<div class="grid">
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">Today's Attendance</p>
        </div>
        <div class="today_attendance">
            <div class="today_attendance flex-column">
                <div class="today_attendance_p">
                    <h4 class="f-weight-5"> Time In : 2023-09-11 (17:36:00)</h4>
                </div>
                <div class="today_attendance_message">
                    <h5 class="f-weight-4"><strong>Clock in</strong> once per day and then <strong>clock out</strong>.</h5>
                </div>
                <div class="today_attendance_btns">
                    <a href="#" class="clock_in_btn">
                        <div class="today_clock_in">
                            <span class="material-symbols-outlined" style="font-size: 25px;">schedule</span>
                            <span>Clock In</span>
                        </div>
                    </a>
                    <a href="#" class="clock_out_btn" >
                        <div class="today_clock_out" >
                            <span class="material-symbols-outlined" style="font-size: 25px;">schedule</span>
                            <p>Clock Out</p>
                        </div>
                    </a>
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
                    <h4 class="f-weight-5"> Break Start : 2023-09-11 (17:36:00)</h4>
                </div>
                <div class="my_break_message">
                    <h5 class="f-weight-4"><strong>Break start</strong> once per day and then <strong>break end</strong>.</h5>
                </div>
                <div class="my_break_btns">
                    <a href="#" class="clock_in_btn">
                        <div class="break_start_btn">
                            <span class="material-symbols-outlined"style="font-size: 25px;">local_cafe</span>
                            <span>Break Start</span>
                        </div>
                    </a>
                    <a href="#" class="clock_out_btn" >
                        <div class="break_end_btn" >
                            <span class="material-symbols-outlined"style="font-size: 25px;">local_cafe</span>
                            <p>Break End</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <div class="container container_my_attendance">
        <div class="container_title">
            <p class="header_title_h2">My Task</p>
        </div>
        <div class="container_attendance">

        </div>
    </div>
    <div class="container container_my_store_location">
        <canvas id="myLineChart" ></canvas>
    </div>
</div>

@section('script_content')
<script>
    $(document).ready(function(){
        $( ".container" ).first().show( "slow", function showNext() {
            $( this ).next( ".container" ).show( "slow", showNext );
        });
    })
</script>
@endsection
@endsection