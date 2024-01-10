@extends('layouts.side_top_content')

@section('module_name', 'My Attendance')

@section('content')
<div class="attendance_summary_content" style="display: none;">
    <div class="attendance_summary_report">
        <form method="POST" action="{{route('generateTable')}}">
        @csrf

            <input type="text" name="employeeName" value="{{ auth()->user()->employee_name }}" style="display: none;">    

            <div class="container_title">
                <p class="header_title_h2">My Attendance Summary Report</p>
            </div>
            <div class="summary_report">
                <div class="sr_from_date">
                    <label for="">From:</label>
                    <input type="date" name="from_date" id="from_date" value="{{ $from ?? '' }}" required>
                </div>
                <div class="sr_to_date">
                    <label for="">To:</label>
                    <input type="date" name="to_date" id="to_date" value="{{ $to ?? '' }}" required>
                </div>
            </div>
            <div class="datebtn">
                <button type="submit" class="date_generate">Generate</button>
            </div>
            @if ($has_generated ?? false)
            <div id="display_table">
                <table id="table_generate" name="attendanceTable" >
                    <thead>
                        <tr id="table_header">
                            <th scope="col" id="col_name">Name</th>
                            <th scope="col">Days Present</th>
                            <th scope="col">Days Absent</th>
                            <th scope="col">Late Minutes</th>
                            <th scope="col">Undertime Minutes</th>
                            <th scope="col">Total Lates Min</th>
                            <th scope="col">Total Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr id="table_content">
                                <td>{{ auth()->user()->name }}</td>
                                <td> {{ $days_present ?? 0}}</td>
                                <td>{{ $numberOfAbsences ?? 0}}</td>
                                <td>{{ $lateMinutes ?? 0 }}</td>
                                <td>{{ $underMinutes ?? 0 }}</td>
                                <td>{{ $totalMinutesLates ?? 0}}</td>
                                <td>{{ $hoursTotal ?? 0 }}</td>
                            </tr>                        
                    </tbody>
                </table>
                <br>
                <div class="datebtn">
                    {{-- <a href="{{ route('export') }}?count_present={{ $days_present }}&total_hours={{ $hoursTotal }}&from_date={{ $fromDate }}&to_date={{ $toDate }}" id="export_excel">Export</a> --}}
                    <a href="{{ route('export') }}?count_present={{ $days_present }}&number_absences={{ $numberOfAbsences}}&late_minutes={{ $lateMinutes}}&under_minutes={{ $underMinutes }}&total_minutes_late={{ $totalMinutesLates }}&total_hours={{ $hoursTotal }}&from_date={{ $fromDate }}&to_date={{ $toDate }}" id="export_excel">Export</a>
                </div>
                
            </div>
            @endif
        </form>
    </div>


</div>

    @section('script_content')
        <script>
            $('.attendance_summary_content').fadeIn('slow');




            // function showTable(){
            //     $('#table_generate').attr('hidden',false);
            // }


        </script>
    @endsection
@endsection

