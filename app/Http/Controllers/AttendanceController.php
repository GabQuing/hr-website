<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\attendanceSummaryExport;
use App\Models\AttendanceSummary;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\DB;

// use ExportController;


class AttendanceController extends Controller
{
    public function index()
    {

        return view('my_attendance');
    }

    public function daysPresent(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $userId = $request->input('employeeId');
        $summary_data = self::getSummaryData($userId, $fromDate, $toDate);

        // Generate months dynamically
        $filteredMonths = [];
        $start = date_create($fromDate);
        $toDate = date_create($toDate);

        while ($start <= $toDate) {
            $month = date_format($start, 'm'); // Get month number
            $year = date_format($start, 'Y'); // Get year
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $firstDayOfMonth = date('w', strtotime("$year-$month-01")); // Get first day (0 = Sunday, 6 = Saturday)

            $filteredMonths[] = [
                'month' => date_format($start, 'M'),
                'monthNumber' => $month,
                'year' => $year,
                'daysInMonth' => $daysInMonth,
                'firstDayOfMonth' => $firstDayOfMonth,
            ];

            // Move to the next month
            date_add($start, date_interval_create_from_date_string("1 month"));
        }

        $data['daysOfWeek'] = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
        $data['year'] = date('Y');
        $data['params'] = $request->all();
        $data['summary_data'] = [$summary_data];
        $data['filtered_months'] = $filteredMonths;
        return view('my_attendance', $data);
    }

    public function export(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $userId = $request->input('employeeId') ?: $request->input('users_id');
        $log_data = self::getLogData($userId, $fromDate, $toDate);
        $overtime_data = self::getOvertimeData($userId, $fromDate, $toDate);
        $summary_data = [];
        if (!is_array($userId)) $userId = [$userId];
        foreach ($userId as $id) {
            $summary_data[] = self::getSummaryData($id, $fromDate, $toDate);
        }
        return Excel::download(new attendanceSummaryExport($log_data, $overtime_data, $summary_data), "Attendance-Summary " . date('Y-m-d H.i.s') . ".xlsx");
    }

    public function getSummaryData($userId, $fromDate, $toDate)
    {
        $data = [];
        $DaysPresent = (new UserLog())->countTotalPresent($userId, $fromDate, $toDate);
        $DaysAbsent = (new AttendanceSummary())->countTotalAbsent($userId, $fromDate, $toDate);
        $totalHours = (new AttendanceSummary())->countTotalHours($userId, $fromDate, $toDate);
        $totalHours = round($totalHours / 60 / 60, 2);
        $totalLates = (new UserLog())->countTotalLates($userId, $fromDate, $toDate)->pluck('late_time')->toArray();
        $totalLates = array_reduce($totalLates, function ($total, $late_time) {
            return $total + $late_time;
        });
        $totalLates = floor($totalLates / 60);
        $totalUndertimes = (new UserLog())->countTotalUnderTimes($userId, $fromDate, $toDate)->pluck('under_time')->toArray();
        $totalUndertimes = array_reduce($totalUndertimes, function ($total, $under_time) {
            return $total + $under_time;
        });
        $totalUndertimes = floor($totalUndertimes / 60);
        $totalLatesUndertimes = $totalLates + $totalUndertimes;
        $data['user'] = User::find($userId)?->name;
        $data['days_present'] = $DaysPresent;
        $data['numberOfAbsences'] = $DaysAbsent;
        $data['total_hours'] = $totalHours;
        $data['total_lates'] = $totalLates;
        $data['total_undertimes'] = $totalUndertimes;
        $data['total_lates_undertimes'] = $totalLatesUndertimes;
        $data['fromDate'] = $fromDate;
        $data['toDate'] = $toDate;
        $data['from'] = $fromDate;
        $data['to'] = $toDate;
        return $data;
    }

    public function getLogData($userId, $fromDate, $toDate)
    {
        $userId = is_array($userId) ? $userId : [$userId];
        return DB::table('attendance_summary')
            ->join('users', 'attendance_summary.user_id', '=', 'users.id')
            ->leftJoin('work_schedules', function ($join) {
                $join
                    ->on('work_schedules.schedule_types_id', '=', 'attendance_summary.schedule_types_id')
                    ->on('work_schedules.work_day', '=', DB::raw('dayname(attendance_summary.log_date)'));
            })
            ->select(
                'users.name',
                'attendance_summary.log_date',
                'attendance_summary.day_name',
                'attendance_summary.clock_in',
                'attendance_summary.break_start',
                'attendance_summary.break_end',
                'attendance_summary.clock_out',
                DB::raw('(TIME_TO_SEC(attendance_summary.clock_out) - TIME_TO_SEC(attendance_summary.clock_in)) / 60 / 60 as total_hours'),
                DB::raw('(TIME_TO_SEC(attendance_summary.break_end) - TIME_TO_SEC(attendance_summary.break_start)) / 60 as break_minutes'),
                'work_schedules.rest_day',
            )
            ->orderBy('users.name')
            ->orderBy('attendance_summary.log_date')
            ->whereBetween('log_date', [$fromDate, $toDate])
            ->whereIn('user_id', $userId);
    }

    public function getOvertimeData($userId, $fromDate, $toDate)
    {
        $userId = is_array($userId) ? $userId : [$userId];
        return DB::table('overtimes')
            ->join('users as requestor', 'overtimes.created_by', '=', 'requestor.id')
            ->leftJoin('users as approver', 'overtimes.approved_by', '=', 'approver.id')
            ->leftJoin('work_schedules', function ($join) {
                $join
                    ->on('work_schedules.schedule_types_id', '=', 'overtimes.schedule_types_id')
                    ->on('work_schedules.work_day', '=', DB::raw('dayname(overtimes.shift_date)'));
            })
            ->select(
                'requestor.name as requestor_name',
                'approver.name as approver_name',
                'overtimes.*',
                DB::raw('DAYNAME(overtimes.shift_date) as day_name'),
                DB::raw('(TIME_TO_SEC(overtimes.time_end) - TIME_TO_SEC(overtimes.time_start)) / 60 / 60 as total_hours'),
                'work_schedules.rest_day',
            )
            ->where('status', 'APPROVED')
            ->whereBetween('shift_date', [$fromDate, $toDate])
            ->whereIn('created_by', $userId);
    }
}
