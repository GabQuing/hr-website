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
        $data = self::getSummaryData($userId, $fromDate, $toDate);
        $data['params'] = $request->all();
        return view('my_attendance', $data);
    }

    public function export(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $userId = $request->input('employeeId');
        $summary_data = self::getSummaryData($userId, $fromDate, $toDate);
        $log_data = self::getLogData($userId, $fromDate, $toDate);

        return Excel::download(new attendanceSummaryExport($log_data, [$summary_data]), "Attendance-Summary " . date('Y-m-d H.i.s') . ".xlsx");
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
        $data['has_generated'] = true;
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
        return DB::table('attendance_summary')
            ->where('user_id', $userId)
            ->join('users', 'attendance_summary.user_id', '=', 'users.id')
            ->selectRaw("
                users.name,
                log_date,
                clock_in,
                break_start,
                break_end,
                clock_out
            ")
            ->whereBetween('log_date', [$fromDate, $toDate]);
    }
}
