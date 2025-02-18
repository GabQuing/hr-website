@extends('layouts.side_top_content' , ['title' => 'Employee Attendance'])

@section('module_name', 'Employee Attendance')

@section('content')

<style>
    .text-sky-blue{
    color:#02718A;
}
.text-gray{
    color:#4D4B4B;
}
.text-cetner{
    text-align: center;
}
.pad-left{
    padding-left: 1rem !important;
}
.blue-border{
    object-fit: contain;
    width: 80%;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;
    margin-bottom: 20px;
}
.text-message{
    color: #333333;
    text-align: justify;
}
.text-message-container{
    margin-bottom: 20px;
}
/* Custom scrollbar styles */
.custom-grid-container::-webkit-scrollbar {
    width: 2px; /* Width of the scrollbar */
}

.custom-grid-container::-webkit-scrollbar-track {
    background: #f3eeee; /* Background of the scrollbar track */
}

.custom-grid-container::-webkit-scrollbar-thumb {
    background: #02718A; /* Color of the scrollbar thumb */
    border-radius: 3px; /* Rounded corners for the scrollbar thumb */
}

.custom-grid-container::-webkit-scrollbar-thumb:hover {
    background: #02718A; /* Color of the scrollbar thumb on hover */
}

.mh-500{
    height: 400px !important;
}
.mh-200{
    height: 110px !important;
}
/* Grid container */
.attendance-graph {
    display: grid;
    grid-template-columns: repeat(7, 15px); /* 7 columns for days */
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
    background-color: #ebedf0; /* Default color (no attendance) */
}

.on-time-sq{
    width: 15px;
    height: 15px;
    border-radius: 3px;
    transition: transform 0.2s ease, opacity 0.2s ease;
    background-color: green;
}
.late-sq{
    width: 15px;
    height: 15px;
    border-radius: 3px;
    transition: transform 0.2s ease, opacity 0.2s ease;
    background-color: red;
}
.vacation-sq{
    width: 15px;
    height: 15px;
    border-radius: 3px;
    transition: transform 0.2s ease, opacity 0.2s ease;
    background-color: yellow;
}
.absent-sq{
    width: 15px;
    height: 15px;
    border-radius: 3px;
    transition: transform 0.2s ease, opacity 0.2s ease;
    background-color: black;
}
.no-sched-sq{
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
    /* background: linear-gradient(to bottom right, #00FFFF 50%, #ebedf0 50%); */
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
.details-container{
    display:none;
    gap: 20px !important;
}

/* Attendance levels (shades of green) */
.level-1 { background-color: #c6e48b; }
.level-2 { background-color: #7bc96f; }
.level-3 { background-color: #239a3b; }
.level-4 { background-color: #196127; }

/* Hover effect */
.day:hover, .on-time-sq:hover, .late-sq:hover, .vacation-sq:hover,
.absent-sq:hover,.no-sched-sq:hover,.no-work-sq:hover,.over-time-sq:hover,.over-break-sq:hover
{
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

.custom-detail-btn{
    background: none;
    border: none;
    cursor: pointer;
    font-size: small;
    font-weight: bold;
    color: #02718A;
    padding: 5px;
    text-decoration: underline;
}
.custom-detail-btn:hover{
    opacity: 75%;
}

.notes-container{
    border: 1px solid #02718A;
    padding: 15px 30px;
    border-radius: 15px;
}

.legend-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(2, auto); /* Ensures 2 rows */
    gap: 20px;
    padding: 10px;
}

.notes-title
{
    font-size: 17px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #02718A;
}
.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltiptext {
    visibility: hidden;
    background-color: black;
    color: #fff;
    text-align: left;
    border-radius: 5px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s;
    white-space: nowrap;
    font-size: 8px;
    min-width: 70px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}


@media (max-width: 1492px) {
    .blue-border {
        width: 100%;
    }
    ..message_container{
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
    .notes-container{
    padding: 10px 20px;
}
}
</style>

<div class="u-box u-box-shadow-medium">
    <form method="POST" action="{{route('employeeGenerateTable')}}">
        @csrf
        <div class="u-bg-primary u-p-15" >
            <h4 class="u-t-center u-t-white u-fw-b">Employee Attendance Summary Report</h4>
        </div>
        <div class="u-p-15">
            <table class="custom_normal_table">
                <tbody>
                    <tr>
                        <td>
                            <p>From:</p>
                            <input class="u-input" type="date" name="from_date" id="from_date" value="{{ $params['from_date'] ?? '' }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>To:</p>
                            <input class="u-input" type="date" name="to_date" id="to_date" value="{{ $params['to_date'] ?? '' }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Select Users:</p> 
                            <select class="js-example-basic-single s-single multiple-select" name="users_id[]" id="users_id" multiple="multiple" required>
                                @foreach ( $usernames as $username )
                                    <option value="{{ $username->id }}" {{ in_array($username->id, $params['users_id'] ?? []) ? "selected" : '' }}>{{ $username->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <span style="color:#02718A">Note: More users or larger date range, more waiting time.</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="u-flex-end u-mt-10 u-mb-10 u-mr-10">
                <button class="u-btn u-t-white u-bg-primary" type="submit" class="">Generate</button>
            </div>
        </div>   
    </form>
    @if ($summary_data ?? false)
        <div class="u-mt-10" style="overflow-x: auto;">
            <table class="u-responsive-table">
                <thead>
                    <tr class="u-fw-b u-t-gray" id="table_header">
                        <td scope="col" id="col_name">Name</td>
                        <td scope="col">Days Present</td>
                        <td scope="col">Days Absent</td>
                        <td scope="col">Late Minutes</td>
                        <td scope="col">Undertime Minutes</td>
                        <td scope="col">Total Late/Undertime Mins</td>
                        <td scope="col">Total Hours</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summary_data as $summary)
                        <tr id="table_content">
                            <td>{{ $summary['user'] }}</td>
                            <td> {{ $summary['days_present'] ?? 0}}</td>
                            <td>{{ $summary['numberOfAbsences'] ?? 0}}</td>
                            <td>{{ $summary['total_lates'] }}</td>
                            <td>{{ $summary['total_undertimes'] }}</td>
                            <td>{{ $summary['total_lates_undertimes'] }}</td>
                            <td>{{ $summary['total_hours'] }}</td>
                        </tr>  
                    @endforeach                      
                </tbody>
            </table>
        </div>
        <div class="u-mt-32 u-p-10 ">
            <div>
                <span class="text-sky-blue u-fw-b u-fs-small">FILL GUNIO:</span>
            </div>
            <div class="dashboard_table mh-500 u-flex u-p-10 custom-grid-container u-mt-5">
                @foreach($all_months as $index => $month)
                    @php
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $index + 1, $year);
                        $firstDayOfMonth = \Carbon\Carbon::create($year, $index + 1, 1)->dayOfWeek; // Get first day (0 = Sunday, 6 = Saturday)
                    @endphp
                    <div class="u-flex u-align-items-center u-flex-direction-column ">
                        <span class="u-fs-small u-fw-b text-sky-blue">{{ $month }} ({{ $year }})</span>
                        <div class="attendance-graph mh-200">
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
                                @for($day = 1; $day <= $daysInMonth; $day++)
                                <div class="day tooltip" data-date="{{ $month }}-{{ $day }}-{{ $year }}">
                                    <span class="tooltiptext">
                                        <strong>{{ $month }}-{{ $day }}-{{ $year }}</strong><br>
                                        Clock In: <span class="">08:00</span><br>
                                        Clock Out: <span class="">08:00</span><br>
                                    </span>
                                </div>
                            @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="u-flex-end u-mt-10 u-mr-10">
        <a class="u-t-dark" style="text-decoration: none;" href="{{ route('export') . '?' . http_build_query($params) }}" target="_blank">
            <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default">
                Export
            </button>
        </a>
        </div>
    @endif
</div>

@section('script_content')
    <script>

    $('.s-single').select2({
            width: '100%',
        });

        $('.attendance_summary_content').fadeIn('slow');
    </script>
@endsection
@endsection

