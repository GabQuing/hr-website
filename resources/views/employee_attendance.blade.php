@extends('layouts.side_top_content' , ['title' => 'Employee Attendance'])

@section('module_name', 'Employee Attendance')

@section('css')
<link rel="stylesheet" type='text/css' property='stylesheet' href="{{ asset('css/dashboard.css') }}" />
<link rel="stylesheet" type='text/css' property='stylesheet' href="{{ asset('css/attendance-tracker.css') }}" />
@endsection

@section('content')

<div class="u-box u-box-shadow-medium">
    <form method="POST" action="{{route('employeeGenerateTable')}}">
        @csrf
        <div class="u-bg-primary u-p-15">
            <h4 class="u-t-center u-t-white u-fw-b">Employee Attendance Summary Report</h4>
        </div>
        <div class="u-p-15">
            <table class="custom_normal_table">
                <tbody>
                    <tr>
                        <td>
                            <p>From:</p>
                            <input class="u-input" type="date" name="from_date" id="from_date"
                                value="{{ $params['from_date'] ?? '' }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>To:</p>
                            <input class="u-input" type="date" name="to_date" id="to_date"
                                value="{{ $params['to_date'] ?? '' }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Select Users:</p>
                            <select class="js-example-basic-single s-single multiple-select" name="users_id[]"
                                id="users_id" multiple="multiple" required>
                                @foreach ( $usernames as $username )
                                <option value="{{ $username->id }}" {{ in_array($username->id, $params['users_id'] ??
                                    []) ? "selected" : '' }}>{{ $username->name }}</option>
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
    <div class="u-mt-32 u-p-10">
        @foreach($summary_data as $summary)
        <div>
            <span class="text-sky-blue u-fw-b u-fs-small">{{ $summary['user'] }}</span>
        </div>
        <div class="dashboard_table mh-500 u-flex u-p-10 custom-grid-container u-mt-5">
            @foreach($filtered_months as $monthData)
            @php
            $month = $monthData['month'];
            $year = $monthData['year'];
            $daysInMonth = $monthData['daysInMonth'];
            $firstDayOfMonth = $monthData['firstDayOfMonth'];
            @endphp
            <div class="u-flex u-align-items-center u-flex-direction-column">
                <span class="u-fs-small u-fw-b text-sky-blue">{{ $month }} ({{ $year }})</span>
                <div class="attendance-graph mh-200">
                    <!-- Weekday headers -->
                    @foreach($daysOfWeek as $day)
                    <div class="day-label text-sky-blue">{{ $day }}</div>
                    @endforeach
                    <!-- Days grid -->
                    <div class="days-grid">
                        <!-- Empty spaces for proper alignment -->
                        @if ($firstDayOfMonth != 0)
                        <div class="day empty"
                            style="grid-column-start: {{ ($firstDayOfMonth == 0) ? 1 : $firstDayOfMonth }};"></div>
                        @endif
                        <!-- Days of the month -->
                        @for($day = 1; $day <= $daysInMonth; $day++) <div class="day tooltip"
                            data-date="{{ $month }}-{{ $day }}-{{ $year }}">
                    </div>
                    @endfor
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>



<div class="u-flex-end u-mt-10 u-mr-10">
    <a class="u-t-dark" style="text-decoration: none;" href="{{ route('export') . '?' . http_build_query($params) }}"
        target="_blank">
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