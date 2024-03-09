<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\attendanceSummaryExport;
use App\Models\AttendanceSummary;
use App\Models\UserLog;

// use ExportController;


class AttendanceController extends Controller
{
    public function index()
    {

        return view('my_attendance');
    }

    public function daysPresent(Request $request)
    {
        //Compute Number of Present
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $userId = $request->input('employeeId');

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
        return view('my_attendance', $data);
    }

    public function export(Request $request)
    {
        $employeeName = auth()->user()->employee_name;
        $count_present = $request->input('count_present');
        $number_absences = $request->input('number_absences');
        $data = [];
        $data['employee_name'] = $employeeName;
        $data['from_date'] = $request->input('from_date');
        $data['to_date'] = $request->input('to_date');
        $data['count_present'] = $count_present;
        $data['number_absences'] = $number_absences;

        return Excel::download(new attendanceSummaryExport($data), "$employeeName-attendance-summary.xlsx");
    }
}
