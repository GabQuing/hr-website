@extends('layouts.side_top_content', ['title' => 'Dashboard'])

@section('module_name', 'Dashboard')

@section('content')
<style>
    textarea {
        resize: none;
    }

    .modal-box {
        max-width: 75rem !important;
    }

    .message_container {
        margin-top: 30px;
        padding: 0px 50px;
    }


    .text-red {
        color: red;
        font-weight: bold
    }

    .text-green {
        color: green;
        font-weight: bold
    }

    .text-sky-blue {
        color: #02718A;
    }

    .text-gray {
        color: #4D4B4B;
    }

    .text-cetner {
        text-align: center;
    }

    .pad-left {
        padding-left: 1rem !important;
    }

    .blue-border {
        object-fit: contain;
        width: 80%;
        box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;
        margin-bottom: 20px;
    }

    .text-message {
        color: #333333;
        text-align: justify;
    }

    #ann_subject {
        margin-bottom: 10px;
        color: black;
    }

    .text-message-container {
        margin-bottom: 20px;
    }


    .scrollable-container {
        max-height: 250px;
        /* Set your desired height */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    /* Custom scrollbar styles */
    .scrollable-container::-webkit-scrollbar {
        width: 12px;
        /* Width of the scrollbar */
    }

    .scrollable-container::-webkit-scrollbar-track {
        background: #f3eeee;
        /* Background of the scrollbar track */
    }

    .scrollable-container::-webkit-scrollbar-thumb {
        background: #02718A;
        /* Color of the scrollbar thumb */
        border-radius: 10px;
        /* Rounded corners for the scrollbar thumb */
    }

    .scrollable-container::-webkit-scrollbar-thumb:hover {
        background: #02718A;
        /* Color of the scrollbar thumb on hover */
    }

    /* Custom scrollbar styles */
    .custom-grid-container::-webkit-scrollbar {
        width: 2px;
        /* Width of the scrollbar */
    }

    .custom-grid-container::-webkit-scrollbar-track {
        background: #f3eeee;
        /* Background of the scrollbar track */
    }

    .custom-grid-container::-webkit-scrollbar-thumb {
        background: #02718A;
        /* Color of the scrollbar thumb */
        border-radius: 3px;
        /* Rounded corners for the scrollbar thumb */
    }

    .custom-grid-container::-webkit-scrollbar-thumb:hover {
        background: #02718A;
        /* Color of the scrollbar thumb on hover */
    }

    .mh-500 {
        height: 400px !important;
    }

    .mh-200 {
        height: 110px !important;
    }

    /* Grid container */
    .attendance-graph {
        display: grid;
        grid-template-columns: repeat(7, 15px);
        /* 7 columns for days */
        gap: 4px;
        padding: 10px;
        max-width: fit-content;
    }

    /* Header row for days */
    .day-label {
        font-size: 10px;
        font-weight: bold;
        text-align: center;
    }

    /* Days container */
    .days-grid {
        display: grid;
        grid-template-columns: repeat(7, 15px);
        gap: 4px;
    }

    /* Each day box */
    .day {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        text-align: center;
        font-size: 10px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: #0000009d;
    }

    /* Empty placeholders for alignment */
    .day.empty {
        background-color: transparent;
    }


    /* Each square (day) */
    .day {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: #ebedf0;
        /* Default color (no attendance) */
    }

    .on-time-sq {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: green;
    }

    .late-sq {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: red;
    }

    .vacation-sq {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: yellow;
    }

    .absent-sq {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: black;
    }

    .no-sched-sq {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: #ebedf0;
    }

    .no-work-sq {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: #00FFFF;
        background: linear-gradient(to bottom right, #00FFFF 50%, #ebedf0 50%);
    }

    .over-time-sq {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background: linear-gradient(to bottom right, #FF00FF 50%, #ebedf0 50%);
    }

    .over-break-sq {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background: linear-gradient(to bottom right, blue 50%, #ebedf0 50%);
    }

    .on-time-ot {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background: linear-gradient(to bottom right, #FF00FF 50%, green 50%);
    }

    .on-time-ob {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background: linear-gradient(to bottom right, blue 50%, green 50%);
    }

    .on-time-no-work {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: #00FFFF;
        background: linear-gradient(to bottom right, #00FFFF 50%, green 50%);
    }

    .on-time-ot-ob {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background: conic-gradient(blue 0deg 120deg, green 120deg 240deg, #FF00FF 240deg 360deg);
    }

    .on-late-ot {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background: linear-gradient(to bottom right, #FF00FF 50%, red 50%);
    }

    .on-late-ob {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background: linear-gradient(to bottom right, blue 50%, red 50%);
    }

    .on-late-ot-ob {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        transition: transform 0.2s ease, opacity 0.2s ease;
        background: conic-gradient(blue 0deg 120deg, red 120deg 240deg, #FF00FF 240deg 360deg);
    }

    .details-container {
        display: none;
        gap: 20px !important;
    }

    /* Attendance levels (shades of green) */
    .level-1 {
        background-color: #c6e48b;
    }

    .level-2 {
        background-color: #7bc96f;
    }

    .level-3 {
        background-color: #239a3b;
    }

    .level-4 {
        background-color: #196127;
    }

    /* Hover effect */
    .day:hover,
    .on-time-sq:hover,
    .late-sq:hover,
    .vacation-sq:hover,
    .absent-sq:hover,
    .no-sched-sq:hover,
    .no-work-sq:hover,
    .over-time-sq:hover,
    .over-break-sq:hover {
        transform: scale(1.2);
        opacity: 0.8;
    }

    .custom-grid-container {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        grid-template-rows: repeat(2, auto);
        gap: 10px;
        overflow-y: auto;
    }

    .custom-detail-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: small;
        font-weight: bold;
        color: #02718A;
        padding: 5px;
        text-decoration: underline;
    }

    .custom-detail-btn:hover {
        opacity: 75%;
    }

    .notes-container {
        border: 1px solid #02718A;
        padding: 15px 30px;
        border-radius: 15px;
    }

    .legend-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(2, auto);
        /* Ensures 2 rows */
        gap: 20px;
        padding: 10px;
    }

    .notes-title {
        font-size: 17px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #02718A;
    }

    .tooltip {
        position: relative;
        display: inline-block;
    }


    @media (max-width: 1492px) {
        .blue-border {
            width: 100%;
        }

        ..message_container {
            padding: 0px 30px;
        }
    }


    /* Adjust to 2 columns on tablets */
    @media (max-width: 768px) {
        .legend-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;

        }
    }

    /* Stack into 1 column on smaller screens */
    @media (max-width: 480px) {
        .legend-container {
            /* grid-template-columns: repeat(1, 1fr); */
            font-size: 14px;
            gap: 17px;
            padding: 2px;
        }

        .notes-container {
            padding: 10px 20px;
        }
    }

    .loader {
        width: 50px;
        height: 50px;
        border: 5px solid #ccc;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="modal-center create-holiday-form" style="display: none">
    <div class="modal-box ">
        <div class="modal-content">
            <form method="POST" action="{{ route('holiday.create') }}" enctype="multipart/form-data">
                @csrf
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <h3 class="f-weight-bold">Add Holiday</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Select Date:</p>
                                <input class="u-input" name="holiday_date" type="date" required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p>Holiday Name:</p>
                                <input type="text" class="u-input" name="holiday_name" required></input>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="u-flex-space-between u-flex-wrap">
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close"
                        id="holiday-btn-close" type="button">Close</button>
                    <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default btn-close"
                        id="holiday-btn-submit" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-center edit-holiday-form" style="display: none">
    <div class="modal-box ">
        <div class="modal-content">
            <form method="POST" action="{{ route('holiday.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="text" name="holiday_id" value="0" hidden>
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <h3 class="f-weight-bold">Add Holiday</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Select Date:</p>
                                <input class="u-input" name="holiday_date" type="date" required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p>Holiday Name:</p>
                                <input type="text" class="u-input" name="holiday_name" required></input>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="u-flex-space-between u-flex-wrap">
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close"
                        id="edit-holiday-btn-close" type="button">Close</button>
                    <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default btn-close"
                        type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal-center create-ann-form" style="display:none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" action="{{ route('announcement.create') }}" autocomplete="off"
                enctype="multipart/form-data" id="announcementCreateForm">
                @csrf
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <h3 class="f-weight-bold">Make Announcement</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Start Date:</p>
                                <input class="u-input" name="start_date" type="date" required>
                            </td>
                            <td>
                                <p>End Date:</p>
                                <input class="u-input" name="end_date" type="date" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Subject: <span
                                        style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span>
                                </p>
                                <input class="u-input" name="subject" placeholder="Enter the subject of your message"
                                    type="text">
                            </td>
                            <td>
                                <p>Insert Image: <span
                                        style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span>
                                </p>
                                <input class="u-input" id="imageInput" name="imageInput" type="file"
                                    accept=".png, .jpg, .jpeg">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p>Message: <span
                                        style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span>
                                </p>
                                <div id="create-editor" class="u-input" name="message"></div>
        </div>
        <input type="hidden" name="message" id="messageInputCreate">
        </td>
        </tr>
        </tbody>
        </table>
        <div class="u-flex-space-between u-flex-wrap">
            <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default" id="modal-btn-close"
                type="button">Close</button>
            <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default" id="modal-btn-submit"
                type="submit">Submit</button>
        </div>
        </form>
    </div>
</div>
</div>

<div class="modal-center edit-ann-form" style="display:none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" action="{{ route('announcement.update') }}" autocomplete="off"
                enctype="multipart/form-data" id="announcementEditForm">
                @csrf
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <h3 class="f-weight-bold">Edit Announcement</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Start Date:</p>
                                <input class="u-input" name="start_date" type="date"
                                    value="{{ $announcement?->start_date }}" required>
                            </td>
                            <td>
                                <p>End Date:</p>
                                <input class="u-input" name="end_date" type="date"
                                    value="{{ $announcement?->end_date }}" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Subject: <span
                                        style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span>
                                </p>
                                <input class="u-input" name="subject" placeholder="Reminder:" type="text"
                                    value="{{ $announcement?->subject }}">
                            </td>
                            <td>
                                <p>Insert Image: <span
                                        style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span>
                                </p>
                                <input class="u-input" name="imageInput" type="file" accept=".png, .jpg, .jpeg">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p>Message: <span
                                        style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span>
                                </p>
                                <div id="edit-editor" class="u-input" name="message"></div>
        </div>
        <input type="hidden" name="message" id="messageInputEdit">
        </td>
        </tr>
        </tbody>
        </table>
        <div class="u-flex-space-between u-flex-wrap">
            <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close"
                id="btn-close-edit" type="button">Close</button>
            <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default btn-close" id="btn-edit-submit"
                type="submit">Submit</button>
        </div>
        </form>
    </div>
</div>
</div>

<div class="grid">
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">Today's Attendance</p>
        </div>
        <div class="today_attendance">
            <div class="today_attendance flex-column">
                <div class="today_attendance_p">
                    <h4 class="f-weight-5 attendance_action">
                        @php
                        if ($today_log) {
                        if ($today_log->clock_out) {
                        $label = 'CLOCK OUT';
                        $log_time = $today_log->clock_out;
                        } else if ($today_log->clock_in) {
                        $label = 'CLOCK IN';
                        $log_time = $today_log->clock_in;
                        }
                        $text = "$label: $today_log->log_date ($log_time)";
                        }
                        @endphp
                        {{ $text ?? "Press Clock In To Start (00:00:00)" }}
                    </h4>
                </div>
                <div class="today_attendance_message">
                    <h5 class="f-weight-4"><strong>Clock in</strong> once per day and then <strong>clock out</strong>.
                    </h5>
                </div>
                <div class="today_attendance_btns">
                    <button type="button" data-action="CLOCK IN" data-column="clock_in" id="clock-in"
                        class="action-button-log clock_in_btn" {{ $today_log?->clock_in || $today_log?->clock_out ||
                        $is_rest_day ? 'disabled' : '' }}>
                        <div class="today_clock_in">
                            <span class="material-symbols-outlined" style="font-size: 25px;">schedule</span>
                            <span>Clock In</span>
                        </div>
                    </button>
                    <button type="button" data-action="CLOCK OUT" data-column="clock_out" id="clock-out"
                        class="action-button-log clock_out_btn" {{ $today_log?->clock_out || !$today_log?->clock_in ?
                        'disabled' : '' }}>
                        <div class="today_clock_out">
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
                    <h4 class="f-weight-5 break_action">
                        @php
                        $breakLabel = "";
                        if ($today_log && ($today_log->break_end || $today_log->break_start)){
                        if ($today_log->break_end){
                        $breakLabel = "BREAK END";
                        $breakLogTime = "$today_log->break_end";
                        } elseif ($today_log->break_start) {
                        $breakLabel = "BREAK START";
                        $breakLogTime = "$today_log->break_start";
                        }
                        $break = "$breakLabel: $today_log->log_date ($breakLogTime)";
                        }
                        @endphp
                        {{ $break ?? "Press Break Start (00:00:00)" }}
                    </h4>
                </div>
                <div class="my_break_message">
                    <h5 class="f-weight-4"><strong>Break start</strong> once per day and then <strong>break
                            end</strong>.</h5>
                </div>
                <div class="my_break_btns">
                    <button type="button" data-action="BREAK START" data-column="break_start" id="break-start"
                        class="action-button-log clock_in_btn" {{ !$today_log?->clock_in || $today_log?->break_start ||
                        $today_log?->clock_out ? 'disabled' : '' }}>
                        <div class="break_start_btn">
                            <span class="material-symbols-outlined" style="font-size: 25px;">local_cafe</span>
                            <span>Break Start</span>
                        </div>
                    </button>
                    <button type="button" data-action="BREAK END" data-column="break_end" id="break-end"
                        class="action-button-log clock_out_btn" {{ !$today_log?->break_start || $today_log?->break_end
                        || $today_log?->clock_out ? 'disabled' : '' }}>
                        <div class="break_end_btn">
                            <span class="material-symbols-outlined" style="font-size: 25px;">local_cafe</span>
                            <p>Break End</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">My Activity</p>
        </div>
        <div class="dashboard_table scrollable-container ">
            <table class="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date Access</th>
                        <th>Time Access</th>
                        <th>Log-Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_logs as $user_log)
                    <tr>
                        <td>{{ date('M d Y', strtotime($user_log->log_date)) }}</td>
                        <td class="pad-left">{{ date('h:ia', strtotime($user_log->log_time)) }}</td>
                        <td>{{ $user_log->log_type_description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">Team Attendance (Today)</p>
        </div>
        <div class="dashboard_table scrollable-container ">
            <table class="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Time-Access</th>
                        <th>Log-Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($team_logs as $team_log)
                    <tr>
                        <td>{{ $team_log->name }}</td>
                        <td class="pad-left">
                            {{ $team_log->log_time ? date('h:ia', strtotime($team_log->log_time)) : 'Not Available' }}
                        </td>
                        <td class="
                                {{ 
                                    !$team_log->description ? 'text-red' : 
                                    ($team_log->description === 'CLOCK IN' ? 'text-green' : 
                                    ($team_log->description === 'CLOCK OUT' ? 'text-red' : 
                                    ($team_log->description === 'BREAK START' ? 'text-red' : 
                                    ($team_log->description === 'BREAK END' ? 'text-green' : '')))
                                    )
                                }}">
                            {{ $team_log->description ? $team_log->description : 'NO LOGS' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container container_my_store_location">
        <div class="container_title">
            <p class="header_title_h2">Attendance Tracker</p>
        </div>
        <div class="dashboard_table mh-500 u-flex u-p-10 custom-grid-container">
            @for ($i=1; $i<=12; $i++) @php $daysInMonth=cal_days_in_month(CAL_GREGORIAN, $i, $year); $monthIndex=$i;
                $firstDayOfMonth=(\Carbon\Carbon::create($year, $monthIndex, 1)->dayOfWeek + 6) % 7;
                $month = "$year-$monthIndex-01";
                $month = new DateTime($month);
                $month = $month->format('M');
                @endphp
                <div id="calendar-{{ $year }}-{{ $month }}"
                    class="u-flex u-align-items-center u-flex-direction-column ">
                    <span class="u-fs-small u-fw-b text-sky-blue">{{ $month }} ({{ $year }})</span>
                    <div class="attendance-graph mh-200" id="graph-{{ $month }}" style="display: none">
                        <!-- Weekday headers -->
                        @foreach($daysOfWeek as $day)
                        <div class="day-label text-sky-blue">{{ $day }}</div>
                        @endforeach
                        <!-- Days grid -->
                        <div class="days-grid">
                            <!-- Empty spaces for proper alignment -->
                            @if ($firstDayOfMonth != 6)
                            <div class="day empty" style="grid-column-start: {{ $firstDayOfMonth + 1 }};"></div>
                            @endif
                            <!-- Days of the month -->
                            @for($day = 1; $day <= $daysInMonth; $day++) <div
                                class="day tooltip day-{{ $year }}-{{ str_pad($monthIndex, 2, '0', STR_PAD_LEFT) }}-{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}"
                                data-date="{{ $month }}-{{ $day }}-{{ $year }}">
                        </div>
                        @endfor
                    </div>
                </div>
                <div style="margin-top: 2rem" id="loader-{{ $month }}">
                    <div class="loader"></div>
                </div>
        </div>
        @endfor
    </div>
    <div class="u-flex-center-row u-m-10 u-gap-2">
        <button class="custom-detail-btn view-detail-btn">View Details</button>
    </div>
    <div class="u-flex-center-column u-p-20 details-container">
        <div class="legend-container">
            <div class="u-flex u-gap-1 u-align-items-center">
                <div class="on-time-sq"></div>
                <span>On Time</span>
            </div>
            <div class="u-flex u-gap-1 u-align-items-center">
                <div class="late-sq"></div>
                <span>Late</span>
            </div>
            <div class="u-flex u-gap-1 u-align-items-center">
                <div class="vacation-sq"></div>
                <span>Vacation/Birthday Leave</span>
            </div>
            <div class="u-flex u-gap-1 u-align-items-center">
                <div class="absent-sq"></div>
                <span>Absent/No logs</span>
            </div>
            <div class="u-flex u-gap-1 u-align-items-center">
                <div class="no-work-sq"></div>
                <span>PH Holiday/No Work Day</span>
            </div>
            <div class="u-flex u-gap-1 u-align-items-center">
                <div class="over-time-sq"></div>
                <span>Paid Over Time</span>
            </div>
            <div class="u-flex u-gap-1 u-align-items-center">
                <div class="over-break-sq"></div>
                <span>Over Break</span>
            </div>
            <div class="u-flex u-gap-1 u-align-items-center">
                <div class="no-sched-sq"></div>
                <span>No Schedule</span>
            </div>
        </div>
        <div class="notes-container">
            <div class="notes-title"><span> NOTES:</span></div>
            <div class="u-fs-15">
                <div class="u-mb-5">
                    <span class="u-fw-600 text-gray u-fw-b">1. On-Time and Late Policy</span>
                    <div class="u-pl-16">
                        <p>
                            • An Employee is considered on time if they clock in before or exactly at 8:00am.
                        </p>
                        <p>
                            • A grace period of 5 minutes is allowed, meaning clocking in at 8:05 Am or earlier is still
                            considered on time.
                        </p>
                        <p>
                            • Clocking in at 8:06 AM or later is considered late.
                        </p>
                    </div>
                </div>
                <div class="u-mb-5 ">
                    <span class="u-fw-600 text-gray u-fw-b">2. Public Holidays and No Work Days</span>
                    <div class="u-pl-16">
                        <p>
                            • On PH holidays or company-declared no work days, if you are requred to work, you must file
                            an OB request to have your attendance marked as 'GREEN'.
                        </p>
                    </div>
                </div>
                <div class="u-mb-5">
                    <span class="u-fw-600 text-gray u-fw-b">3. Vacation and Birthday Leave Policy</span>
                    <div class="u-pl-16">
                        <p>
                            • Employees must file a Paid Time Off (PTO) request at least one week before the planned
                            leave date to allow for scheduling adjustments.
                        </p>
                        <p>
                            • PTO request can also be filed months in advance to secure approval ahead of time,
                            especially for extended leaves.
                        </p>
                    </div>
                </div>
                <div class="u-mb-5">
                    <span class="u-fw-600 text-gray u-fw-b">4. Over Break</span>
                    <div class="u-pl-16">
                        <p>
                            • Coverage Must be provided on the same day as the shift.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container container_today">
    <div class="container_title">
        <p class="header_title_h2">Announcement</p>
    </div>
    <div class="u-flex-center-column ">
        @if ($announcement)
        <div class=" message_container">
            @if ($announcement && $announcement->file_path)
            <div style="text-align: center;">
                <img class="blue-border" src="{{ $announcement->file_path }}" alt="" style=" ">
            </div>
            @endif
            <h4 id="ann_subject" class="u-fw-500  u-t-center "><strong>{{ $announcement?->subject }}</strong></h4>
            <div class="text-message-container">
                <span class=" text-message">{!!$announcement?->message !!}</span>
            </div>
        </div>
        @else
        <p class="text-center u-p-15 u-mt-25">No announcement for today.</p>
        @endif
        @role('admin||hr')
        <div>
            <div class="today_attendance_btns u-p-10" style="display: flex; justify-content: center;">
                @if ($announcement)
                <button type="button" class="ann_btn edit-ann">
                    <div class="edit_ann_btn">
                        <span class="material-symbols-outlined" style="font-size: 25px;">edit_square</span>
                        <span>Edit</span>
                    </div>
                </button>
                <button type="button" class="ann_btn remove-ann">
                    <div class="remove_ann_btn">
                        <span class="material-symbols-outlined">disabled_by_default</span>
                        <p>Remove</p>
                    </div>
                </button>
                @else
                <button type="button" class="ann_btn create-ann">
                    <div class="announcement_btn">
                        <span class="material-symbols-outlined">wysiwyg</span>
                        <p>Create</p>
                    </div>
                </button>
                @endif
            </div>
            @if (session('success'))
            <h5 class="u-fw-b" style="color: green; display:block; margin-top: 15px;">{{ session('success') }}</h5>
            @endif
        </div>
        @endrole
    </div>
</div>
<div class="container container_today">
    <div class="container_title">
        <p class="header_title_h2">Holidays ({{ $year }})</p>
    </div>
    <div class="dashboard_table scrollable-container ">
        <table class="myTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Holiday</th>
                    @role('admin||hr')
                    <th>Action</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach ($holidays as $holiday)
                <tr>
                    <td>{{ date('M d Y', strtotime($holiday->holiday_date)) }}</td>
                    <td class="pad-left">{{ $holiday->holiday_name }}</td>
                    @role('admin||hr')
                    <td style="display: flex; gap: 10px;">
                        <button type="button" class="edit-holiday-btn" data-holiday-id="{{ $holiday->id }}"
                            data-holiday-date="{{ $holiday->holiday_date }}"
                            data-holiday-name="{{ $holiday->holiday_name }}"
                            style="display: flex; color: white; border: none; cursor: pointer; background: #238c7c; padding: 5px; border-radius: 5px;">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                        <button type="button" class="delete-holiday-btn" data-holiday-id="{{ $holiday->id }}"
                            data-holiday-date="{{ $holiday->holiday_date }}"
                            data-holiday-name="{{ $holiday->holiday_name }}"
                            style="display: flex; color: white; border: none; cursor: pointer; background: #882c03; padding: 5px; border-radius: 5px;">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                        @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @role('admin||hr')
    <div>
        <div class="today_attendance_btns u-p-10" style="display: flex; justify-content: center;">
            <button type="button" class="add_holiday_btn" id="add-holiday-btn"
                style="display: flex; color: white; border: none; cursor: pointer">
                <span class="material-symbols-outlined">wysiwyg</span>
                <p>Add a holiday</p>
            </button>
        </div>
        <h5 class="u-fw-b" style="color: green; display:block; margin: 15px 0; text-align: center;">
            {{session('success-holiday')}}
        </h5>
    </div>
    @endrole
</div>

@section('script_content')
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
</script>
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
        const createAnnouncementEditor = new Quill('#create-editor', {theme: 'snow'});
        const editAnnouncementEditor = new Quill('#edit-editor', {theme: 'snow' });
        const htmlEditString = `{!! $announcement?->message !!}`;
        const delta = editAnnouncementEditor.clipboard.dangerouslyPasteHTML(htmlEditString);
        $('#announcementCreateForm').submit(function(e) {
            e.preventDefault();
            const quillContent = createAnnouncementEditor.getSemanticHTML();
            $('#messageInputCreate').val(quillContent);
            this.submit();
        });

        $('#announcementEditForm').submit(function(e) {
            e.preventDefault();
            const quillContent = editAnnouncementEditor.getSemanticHTML();
            $('#messageInputEdit').val(quillContent);
            this.submit();
        });
        $('#announcementCreateForm').submit(function(e) {
            e.preventDefault();
            const quillContent = createAnnouncementEditor.getSemanticHTML();
            $('#messageInputCreate').val(quillContent);
            this.submit();
        });
        
        $('.myTable').DataTable({
            responsive: true,
            paging:false,
            info:false,
            searching: false,
            ordering: false,
        });
        
        $('#modal-btn-close').on('click', function(){
            $('.create-ann-form').hide();
        });
        $('#holiday-btn-close').on('click', function(){
            $('.create-holiday-form').hide();
        });
        $('#btn-close-edit').on('click', function(){
            $('.edit-ann-form').hide();
        });
        $('.edit-ann').on('click', function(){
            $('.edit-ann-form').show();
        });
        $('.create-ann').on('click', function(){
            $('.create-ann-form').show();
        });
        $('#add-holiday-btn').on('click', function(){
            $('.create-holiday-form').show();
        });

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

        $('.remove_ann_btn').click(function(e){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove It!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.assign("{{ route('announcement.delete') }}");
                }
            });
        });

        $('.view-detail-btn').click(function(){
            $('.details-container').slideToggle('fast', function() {
                // Ensures display: flex is applied after slideToggle
                if ($(this).is(':visible')) {
                    $(this).css('display', 'flex');
                }
            });

            let buttonText = $(this).text() === "View Details" ? "Hide Details" : "View Details";
            $(this).text(buttonText);
        });             
    });


    // attendace tracker
    const WORK_SCHEDULE = {!! json_encode(auth()->user()->workSchedule) !!};
    const WORK_DAYS = WORK_SCHEDULE.filter(wokSchedule => !wokSchedule.rest_day);
    const GRACE_PERIOD_IN_MINS = 5;

    function formatTime(timeString) {
        if (!timeString) return;
        const [hours, minutes] = timeString.split(":"); // Extract hours and minutes
        const formattedTime = new Date(0, 0, 0, hours, minutes).toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
        return formattedTime;
    }

    function isValidDate(dateString) {
        const date = new Date(dateString);
        
        // Check if the date object is valid
        if (isNaN(date.getTime())) {
            return false;
        }

        // Extract the year, month, and day from the input
        const [year, month, day] = dateString.split('-').map(Number);

        // Check if the reconstructed date matches the input
        return (
            date.getFullYear() === year &&
            date.getMonth() + 1 === month && // Months are 0-based in JS
            date.getDate() === day
        ) ? date : false;
    }

    function populateCalendar(month, data, formattedDate) {
        console.log(month, data, formattedDate);
        const year = "{{ $year }}";
        const calendar = $(`#calendar-${year}-${month}`);

        for (let i=1; i<=31; i++) {
            const dateString = `${formattedDate}-${i.toString().padStart(2, '0')}`;
            const date = isValidDate(dateString);
            if (!date) continue;
            const dayName = date.toLocaleDateString('en-US', { weekday: 'long' });
            const daylog = data.logs.find(e => e.log_date === dateString);
            const workSchedule = daylog?.work_schedule.work_from ?? WORK_SCHEDULE.find(e => e.work_day === dayName);
            const overtime = data.overtimes.length ? data.overtimes.find(e => e.shift_date === dateString) : null;
            const leave = data.leaves.length ? data.leaves.find(e => e.leave_from === dateString) : null;
            const holiday = data.holidays.length ? data.holidays.find(e => e.holiday_date === dateString) : null;
            const tooltip = calendar.find(`.day-${dateString}`);

            let isOverBreak = false;
            let isOnTime = true;
            let isOverTime = overtime ? true : false;
            let isHoliday = holiday ? true : false;

            const dateFormat = { month: 'short', day: '2-digit', year: 'numeric' };
            let tooltipContent = `<p style="font-weight: bold; color: yellow;">${date.toLocaleDateString('en-US', dateFormat)}</p>`

            if (isHoliday) {
                tooltipContent += `<p style="color: #76fcfe">${holiday.holiday_name}</p>`;
            }

            if (isOverTime) {
                const timeFormat = {hour: '2-digit', minute: '2-digit', hour12: true}
                tooltipContent += `<p style="color: #f84bfd">Overtime: ${formatTime(overtime.time_start)} - ${formatTime(overtime.time_end)} (${overtime.reason})</p>`;
            }

            if (leave) {
                tooltipContent += `<p style="color: yellow">Leave: ${leave.leave_type} (${leave.reason})</p>`;
            }

            if (daylog) {
                if (daylog.clock_in) tooltipContent += `<p>Clock in: ${formatTime(daylog.clock_in)}</p>`;
                if (daylog.break_start) tooltipContent += `<p>Break start: ${formatTime(daylog.break_start)}</p>`;
                if (daylog.break_end) tooltipContent += `<p>Break end: ${formatTime(daylog.break_end)}</p>`;
                if (daylog.clock_out) tooltipContent += `<p>Clock out: ${formatTime(daylog.clock_out)}</p>`;
            }

            tippy(`#calendar-${year}-${month} .day-${dateString}`, {
                content: tooltipContent,
                allowHTML: true,
                trigger: 'mouseenter focus click',
            });


            // checking if absent
            if (!isHoliday && (!daylog || !daylog.clock_in || !daylog.clock_out)) {
                if (!workSchedule.rest_day) {
                    tooltip.addClass('absent-sq');
                    continue;
                }
                continue;
            } else if (isHoliday) {
                if (daylog?.clock_in && daylog?.clock_out) {
                    tooltip.addClass('on-time-no-work');
                } else {
                    tooltip.addClass('no-work-sq');
                }
                continue;
            }

            if (leave) {
                tooltip.addClass('vacation-sq');
                continue;
            }
        
            // checking if overbreak
            if (daylog?.break_start && daylog?.break_end) {
                const breakStart = new Date(`1970-01-01T${daylog.break_start}Z`);
                const breakEnd = new Date(`1970-01-01T${daylog.break_end}Z`);
                const totalBreakMinutes = (breakEnd - breakStart) / (1000 * 60);

                if (totalBreakMinutes > 60) {
                    isOverBreak = true;
                }
            }

            // checking if ontime or late
            const clockIn = new Date(`1970-01-01T${daylog.clock_in}Z`);
            const clockInSched = new Date(`1970-01-01T${daylog.work_schedule.work_from}Z`);
            if (daylog?.clock_in && daylog?.clock_out && (clockIn <= clockInSched || daylog.work_schedule.rest_day)) {
                isOnTime = true;
            } else {
                isOnTime = false;
            }

            if (isOnTime) {
                if (isOverTime && isOverBreak) {
                    tooltip.addClass('on-time-ot-ob');
                } else if (isOverTime) {
                    tooltip.addClass('on-time-ot');
                } else if (isOverBreak) {
                    tooltip.addClass('on-time-ob');
                } else {
                    tooltip.addClass('on-time-sq');
                }
            } else {
                if (isOverTime && isOverBreak) {
                    tooltip.addClass('late-ot-ob');
                } else if (isOverTime) {
                    tooltip.addClass('on-late-ot');
                } else if (isOverBreak) {
                    tooltip.addClass('late-ob');
                } else {
                    tooltip.addClass('late-sq');
                }
            }
        }
    }


    const allMonths = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    const year = "{{ $year }}";
    const userId = "{{ auth()->user()->id }}";
    allMonths.forEach(async month => {
        let yearMonth = `${year}-${month}`;
        const date = new Date(yearMonth);
        const formattedDate = new Intl.DateTimeFormat('en-CA', { year: 'numeric', month: '2-digit' }).format(date);
        const response = await fetch("{{ route('tracker.log', ['user_id' => auth()->user()->id,'month' => '__MONTH__']) }}".replace('__MONTH__', formattedDate));
        const data = await response.json();
        populateCalendar(month, data, formattedDate);
        $(`#loader-${month}`).hide();
        $(`#graph-${month}`).show();
    });


    // holidays
    $('.edit-holiday-btn').on('click', function() {
        const holidayId = $(this).data('holiday-id');
        const holidayDate = $(this).data('holiday-date');
        const holidayName = $(this).data('holiday-name');
        const form = $('.edit-holiday-form');
        form.find('input[name="holiday_id"]').val(holidayId);
        form.find('input[name="holiday_date"]').val(holidayDate);
        form.find('input[name="holiday_name"]').val(holidayName);
        form.show();
    });

    $('#edit-holiday-btn-close').on('click', function() {
        $('.edit-holiday-form').hide();
    });

    $('.delete-holiday-btn').on('click', function() {
        const holidayId = $(this).data('holiday-id');
        const holidayDate = $(this).data('holiday-date');
        const holidayName = $(this).data('holiday-name');
        // create a swal dialog
        Swal.fire({

            title: 'Are you sure?',
            html: `You are about to delete <strong>${holidayName}</strong> on <strong>${holidayDate}</strong>.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                location.assign("{{ route('holiday.delete') }}" + '?holiday_id=' + holidayId);
            }
        });
    });


</script>
@endsection
@endsection