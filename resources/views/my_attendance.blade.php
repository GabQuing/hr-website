@extends('layouts.side_top_content' , ['title' => 'My Attendance'])

@section('module_name', 'My Attendance')

@section('content')

<div class="u-box u-box-shadow-medium">
    <form method="POST" action="{{route('generateTable')}}">
        @csrf
        <input type="text" name="employeeId" value="{{ auth()->user()->id }}" style="display: none;"> 
        <div class="u-bg-primary u-p-15" >
            <h4 class="u-t-center u-t-white u-fw-b">My Attendance Summary Report</h4>
        </div>
        <div class="u-p-15">
            <table class="custom_normal_table">
                <tbody>
                    <tr>
                        <td>
                            <p>From:</p>
                            <input class="u-input" type="date" name="from_date" id="from_date" value="{{ $from ?? '' }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>To:</p>
                            <input class="u-input" type="date" name="to_date" id="to_date" value="{{ $to ?? '' }}" required>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="u-flex-end u-mt-10 u-mb-10 u-mr-10">
                <button class="u-btn u-t-white u-bg-primary" type="submit" class="">Generate</button>
            </div>
        </div>   
    </form>
    @if ($has_generated ?? false)
        <div class="u-mt-10" style="overflow-x: auto;">
            <table class="u-responsive-table">
                <thead>
                    <tr class="u-fw-b u-t-gray" id="table_header">
                        <td scope="col" id="col_name">Name</td>
                        <td scope="col">Days Present</td>
                        <td scope="col">Days Absent</td>
                        <td scope="col">Late Minutes</td>
                        <td scope="col">Undertime Minutes</td>
                        <td scope="col">Total Lates Min</td>
                        <td scope="col">Total Hours</td>
                    </tr>
                </thead>
                <tbody>
                        <tr id="table_content">
                            <td>{{ auth()->user()->name }}</td>
                            <td> {{ $days_present ?? 0}}</td>
                            <td>{{ $numberOfAbsences ?? 0}}</td>
                            <td>{{ $total_lates }}</td>
                            <td>{{ $total_undertimes }}</td>
                            <td>{{ $total_lates_undertimes }}</td>
                            <td>{{ $total_hours }}</td>
                        </tr>                        
                </tbody>
            </table>
        </div>
        <div class="u-flex-end u-mt-10 u-mr-10">
            <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default">
                <a class="u-t-dark" style="text-decoration: none;" href="{{ route('export') }}?count_present={{ $days_present }}&number_absences={{ $numberOfAbsences}}&from_date={{ $fromDate }}&to_date={{ $toDate }}">Export</a>
            </button>
        </div>
    @endif
</div>

{{-- <div class="attendance_summary_content" style="display: none;">
    <div class="attendance_summary_report">
        <form method="POST" action="{{route('generateTable')}}">
        @csrf

            <input type="text" name="employeeId" value="{{ auth()->user()->id }}" style="display: none;">    

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
                                <td>{{ $total_lates }}</td>
                                <td>{{ $total_undertimes }}</td>
                                <td>{{ $total_lates_undertimes }}</td>
                                <td>{{ $total_hours }}</td>
                            </tr>                        
                    </tbody>
                </table>
                <br>
                <div class="datebtn">
                    <a href="{{ route('export') }}?count_present={{ $days_present }}&number_absences={{ $numberOfAbsences}}&from_date={{ $fromDate }}&to_date={{ $toDate }}" id="export_excel">Export</a>
                </div>
            </div>
            @endif
        </form>
    </div>


</div> --}}






@section('script_content')
    <script>
        $('.attendance_summary_content').fadeIn('slow');




        // function showTable(){
        //     $('#table_generate').attr('hidden',false);
        // }


    </script>
@endsection
@endsection

