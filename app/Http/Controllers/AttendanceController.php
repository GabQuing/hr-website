<?php

namespace App\Http\Controllers;
use App\Models\loginAttendance;
use Illuminate\Http\Request;
use DB;
use DateTime;
use DateInterval;
use DateTimeZone;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\attendanceSummary;
use App\Models\AttendanceSummary;
use Carbon\Carbon;

// use ExportController;


class AttendanceController extends Controller
{
    public function index(){

        return view('my_attendance');
    }

    public function daysPresent(Request $request) {
        //Compute Number of Present
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $userId = $request->input('employeeId');

        $DaysPresent = (new AttendanceSummary())->countPresentDays($userId, $fromDate, $toDate);
        $DaysAbsent = (new AttendanceSummary())->countAbsentDays($userId, $fromDate, $toDate);
        $data['has_generated'] = true;
        $data['days_present'] = $DaysPresent;
        $data['numberOfAbsences'] = $DaysAbsent;
        return view('my_attendance', $data);

        // $DaysIn = DB::table ('user_logs')
        //     ->where('user_logs', $userId)
        //     ->where('log_type_id', 1)
        //     ->whereBetween('date', [$fromDate,$toDate])
        //     ->distinct('log_date')
        //     ->pluck('log_date')
        //     ->toArray();
        // $DaysOut = DB::table('login_attendances')
        //     ->where('employee_name', $empName)
        //     ->where('log_type', 'Time-Out')
        //     ->whereBetween('date', [$fromDate,$toDate])
        //     // ->selectRaw('date_format(date,"%W") as day_name, date')
        //     ->distinct('date')
        //     ->pluck('date')
        //     ->toArray();

        // $days_present = 0;

        // $present_dates = [];
        // foreach ($DaysIn as $in) {
        //     $day = Carbon::createFromFormat('Y-m-d', $in);
        //     $day = $day->format('l');
        //     $is_valid = in_array($day, $schedule_day_name);
        //     if (in_array($in, $DaysOut) && $is_valid) {
        //         $days_present++;
        //         $present_dates[] = $in;
        //     }
        // }
        // // dd($present_dates);

        // //Compute Number of Absences
        // $startDate = new DateTime($fromDate);
        // $endDate = new DateTime($toDate);
        // $numDays=[];
        // $absent_dates = [];
        
        // while ($startDate <= $endDate){
        //     $current_date = $startDate;
        //     $formatted = $current_date->format('l');
        //     if (in_array($formatted, $schedule_day_name) && !in_array($current_date->format('Y-m-d'), $present_dates)) {
        //         $absent_dates[] = $current_date->format('Y-m-d');
        //     }
        //     $startDate->modify('+1 day');
        // }
        // $numberOfAbsences = count($absent_dates);
        
        // //Compute Total Hours
        // $earliestIn = [];
        // $latestOut = [];
        // $secondsTotal = 0;
        // $lateSeconds = 0;
        // $underSeconds = 0;
        // foreach ($present_dates as $specificDates) {
            
        //     $specificDay =  (new DateTime($specificDates))->format('l');
        //     $schedule_work_in = array_filter($work_from, function($obj) use ($specificDay) {
        //         return $obj->work_day === $specificDay;
        //     });
        //     $schedule_work_out = array_filter($work_to, function($obj) use($specificDay){
        //         return $obj->work_day === $specificDay;
        //     });
        //     $schedule_time_in = $schedule_work_in[array_key_first($schedule_work_in)]->work_from;
        //     $schedule_time_out = $schedule_work_out[array_key_first($schedule_work_out)]->work_to;
            
        //     $in_time = DB::table('login_attendances')
        //         ->where('employee_name', $empName)
        //         ->where('date', $specificDates)
        //         ->where('log_type', 'Time-In')
        //         ->min('time');
        //         $earliestIn[] = $in_time;
            
        //     $lateTime = strtotime($in_time) - strtotime($schedule_time_in);
        //         if ($lateTime < 0){
        //             $lateTime = 0;
        //         }
        //     $lateSeconds += $lateTime; //Total Seconds Late

        //     $out_time = DB::table('login_attendances')
        //         ->where('employee_name', $empName)
        //         ->where('date', $specificDates)
        //         ->where('log_type', 'Time-Out')
        //         ->max('time');
        //         $latestOut[] = $out_time;
            
        //     $underTime = strtotime($schedule_time_out) - strtotime($out_time);
        //         if($underTime < 0){
        //             $underTime = 0;
        //         }
        //     $underSeconds += $underTime; //Total Seconds Under-Time

        //     $cvt_str_to_time = strtotime($out_time) - strtotime($in_time);
        //         if($cvt_str_to_time < 0){
        //             $cvt_str_to_time = 0;
        //         }
        //     $secondsTotal += $cvt_str_to_time; //Total Seconds

        // }


        // $lateMinutes = number_format($lateSeconds / 60 , 2);
        // $underMinutes = number_format($underSeconds / 60 , 2);
        // $totalMinutesLates = $lateMinutes + $underMinutes;
        // $hoursTotal = number_format($secondsTotal / 60 / 60, 2);
        // // dd($underMinutes);
        // // dd($lateMinutes);
        // // dd($latestOut);


        // $data = [];
        // $data['days_present'] = $days_present;
        // $data['numberOfAbsences'] = $numberOfAbsences;
        // $data['lateMinutes'] = $lateMinutes;
        // $data['underMinutes'] = $underMinutes;
        // $data['totalMinutesLates'] = $totalMinutesLates;
        // $data['hoursTotal'] = $hoursTotal;
        // $data['fromDate'] = $fromDate;
        // $data['toDate'] = $toDate;
        // $data['from'] = $fromDate;
        // $data['to'] = $toDate;
        // $data['has_generated'] = true;
        
    
        // return view('my_attendance', $data);
        // return view('my_attendance', compact('countPresent', 'totalHours', 'fromDate', 'toDate'));
    }
    
    public function export(Request $request)  {
        $count_present = $request->input('count_present');
        $number_absences = $request->input('number_absences');
        $late_minutes = $request->input('late_minutes');
        $under_minutes = $request->input('under_minutes');
        $total_minutes_late = $request->input('total_minutes_late');
        $total_hours = $request->input('total_hours');
        $employeeName = auth()->user()->employee_name;
        $data = [];
        $data['count_present'] = $count_present;
        $data['number_absences'] = $number_absences;
        $data['late_minutes'] = $late_minutes;
        $data['under_minutes'] = $under_minutes;
        $data['total_minutes_late'] = $total_minutes_late;
        $data['total_hours'] = $total_hours;
        $data['employee_name'] = $employeeName;
        $data['from_date'] = $request->input('from_date');
        $data['to_date'] = $request->input('to_date');

        return Excel::download(new attendanceSummary($data), "$employeeName-attendance-summary.xlsx");
    }

}
