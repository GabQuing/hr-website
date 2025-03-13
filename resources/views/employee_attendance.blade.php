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
    <div class="u-flex-end u-mt-10 u-mr-10">
        <a class="u-t-dark" style="text-decoration: none;"
            href="{{ route('export') . '?' . http_build_query($params) }}" target="_blank">
            <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default">
                Export
            </button>
        </a>
    </div>
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
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        @foreach($summary_data as $summary)
        <hr>
        <div class="u-mt-32 u-p-10">
            <div>
                <span class="text-sky-blue u-fw-b u-fs-small">{{ $summary['user'] }}</span>
            </div>
            <div class="dashboard_table mh-500 u-flex u-p-10 custom-grid-container u-mt-5">
                @foreach($filtered_months as $monthData)
                @php
                $month = $monthData['month'];
                $monthNumber = $monthData['monthNumber'];
                $year = $monthData['year'];
                $daysInMonth = $monthData['daysInMonth'];
                $firstDayOfMonth = $monthData['firstDayOfMonth'];
                @endphp
                <div class="u-flex u-align-items-center u-flex-direction-column">
                    <span class="u-fs-small u-fw-b text-sky-blue">{{ $month }} ({{ $year }})</span>
                    <div class="attendance-graph mh-200" data-user="{{ $summary['user_id'] }}"
                        data-month-number="{{ $monthNumber }}" data-month="{{ $month }}" data-year="{{ $year }}"
                        style="display: none">
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
                            @for($day = 1; $day <= $daysInMonth; $day++) <div
                                class="day tooltip user-{{ $summary['user_id'] }} day-{{ $year }}-{{ str_pad($monthNumber, 2, '0', STR_PAD_LEFT) }}-{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}"
                                data-user="{{ $summary['user_id'] }}" data-date="{{ $month }}-{{ $day }}-{{ $year }}">
                        </div>
                        @endfor
                    </div>
                </div>
                <div style="margin-top: 2rem"
                    class="calendar-loader loader-{{ $month }} user-{{ $summary['user_id'] }} year-{{ $year }} month-{{ $month }}">
                    <div class="loader"></div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@endif
</div>

@section('script_content')
<script src="{{ asset('js/attendance-tracker.js') }}"></script>
<script>
    $('.s-single').select2({
        width: '100%',
    });

    $('.attendance_summary_content').fadeIn('slow');

    @if ($summary_data ?? false)
    // attendance graph
    const WORK_SCHEDULES = {!! json_encode($workSchedules) !!};

    function populateCalendar(month, data, formattedDate, attendanceGraph) {
        const year = "{{ $year }}";
        const calendar = $(attendanceGraph);
        const userId = attendanceGraph.dataset?.user;

        for (let i=1; i<=31; i++) {
            const dateString = `${formattedDate}-${i.toString().padStart(2, '0')}`;
            const date = isValidDate(dateString);
            if (!date) continue;
            const dayName = date.toLocaleDateString('en-US', { weekday: 'long' });
            const daylog = data.logs.find(e => e.log_date === dateString);
            const workSchedule = daylog?.work_schedule.work_from ?? WORK_SCHEDULES[userId].find(e => e.work_day === dayName);
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
                tooltipContent += `<p style="color: #f84bfd">${formatTime(overtime.time_start)} - ${formatTime(overtime.time_end)} (${overtime.reason})</p>`;
            }

            if (leave) {
                tooltipContent += `<p style="color: yellow">${leave.leave_type} (${leave.reason})</p>`;
            }

            if (daylog) {
                if (daylog.clock_in) tooltipContent += `<p>Clock in: ${formatTime(daylog.clock_in)}</p>`;
                if (daylog.break_start) tooltipContent += `<p>Break start: ${formatTime(daylog.break_start)}</p>`;
                if (daylog.break_end) tooltipContent += `<p>Break end: ${formatTime(daylog.break_end)}</p>`;
                if (daylog.clock_out) tooltipContent += `<p>Clock out: ${formatTime(daylog.clock_out)}</p>`;
            }

            tippy(`.user-${userId}.day-${dateString}`, {
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

    $('.attendance-graph').each(async function() {
        const year = this.dataset.year;
        const monthNumber = this.dataset.monthNumber;
        const month = this.dataset.month;
        const user = this.dataset.user;

        let yearMonth = `${year}-${month}`;
        const date = new Date(yearMonth);
        const formattedDate = new Intl.DateTimeFormat('en-CA', { year: 'numeric', month: '2-digit' }).format(date);
        const response = await fetch("{{ route('tracker.log', ['user_id' => '__USER_ID__','month' => '__MONTH__']) }}"
            .replace('__USER_ID__', user)
            .replace('__MONTH__', formattedDate)
        );
        const data = await response.json();
        populateCalendar(month, data, formattedDate, this);
        $(`.calendar-loader.user-${user}.month-${month}.year-${year}`).hide();
        $(this).show();
    })
    @endif
</script>
@endsection
@endsection