<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\loginAttendance;
use App\Models\User;
use App\Models\AttendanceSummary;
use DB;
use Carbon\Carbon;

class attendanceSummaryExport implements FromCollection, WithHeadings
{
    public function __construct($data)
    {
        $this->data = $data;
        $user_id = auth()->user()->id;
        $this->schedule_query = (new AttendanceSummary())
            ->getUserAttendanceSummary($user_id)
            ->get()
            ->toArray();
        

        // $this->data = $data;
        // $this->schedule_query = DB::table('work_schedules')
        //     ->where('user_id', auth()->user()->id)
        //     ->whereRaw('(rest_day != 1 or rest_day is null)');

        // $this->schedule_day_name = $this->schedule_query->pluck('work_day')->toArray();
        // $this->work_from = $this->schedule_query->select('work_from', 'work_day')->get()->toArray();
        // $this->work_to = $this->schedule_query->select('work_to', 'work_day')->get()->toArray();
    }

    public function collection()
    {
        $collection = DB::table('attendance_summary')
            ->where('user_id' , auth()->user()->id)
            ->selectRaw("
                user_id,
                log_date,
                clock_in,
                break_start,
                break_end,
                clock_out
            ")
            ->whereBetween('log_date', [$this->data['from_date'], $this->data['to_date']])
            ->get();


        // $collection = DB::table('login_attendances')
        //     ->where('employee_name', auth()->user()->employee_name)
        //     ->selectRaw("
        //         employee_name,
        //         date,
        //         MIN(CASE WHEN log_type = 'Time-In' THEN time END) AS time_in,
        //         MIN(CASE WHEN log_type = 'Time-In' THEN store_address END) AS time_in_location,
        //         MAX(CASE WHEN log_type = 'Time-Out' THEN time END) AS time_out,
        //         MAX(CASE WHEN log_type = 'Time-Out' THEN store_address END) AS time_out_location
        //     ")
        //     ->whereRaw("log_type IN ('Time-In', 'Time-Out')")
        //     ->whereBetween('date', [$this->data['from_date'], $this->data['to_date']])
        //     ->whereIn(DB::raw('DATE_FORMAT(date, "%W")'), $this->schedule_day_name)
        //     ->groupBy('employee_name', 'date')
        //     ->get();

        // $collection = $collection->map(function ($item) {
        //     $item->days_present = $this->hasTimeInAndTimeOut($item) ? 1 : 0;
        //     $item->numberOfAbsences = $this->NoTimeInAndTimeOut($item) ? 1 : 0;
        //     $item->lateMinutes = $this->calculateLateMinutes($item);
        //     $item->underMinutes = $this->calculateUnderMinutes($item);
        //     $item->totalMinutesLates = $this->calculateTotalLates($item);
        //     $item->total_hours = $this->calculateTotalHours($item);
        //     return $item;
        // });


        return $collection;
    }

    // private function hasTimeInAndTimeOut($item) {
    //     return !empty($item->time_in) && !empty($item->time_out);
    // }

    // private function NoTimeInAndTimeOut($item) {
    //     return empty($item->time_in) || empty($item->time_out);
    // }
    
    // private function calculateLateMinutes($item) {
    //     $date = Carbon::parse($item->date);
    //     $formattedDate = $date->format('l');

    //     if(!empty($item->time_in) && !empty($item->time_out)) {
    //         foreach ($this->work_from as $sched) {
    //             if ($sched->work_day === $formattedDate) {
    //                 $seconds_late = strtotime($item->time_in) - strtotime($sched->work_from);
    //                 return number_format($seconds_late / 60, 2);
    //             }
    //         }
    //     }
    // }
    // private function calculateUnderMinutes($item) {
    //     $date = Carbon::parse($item->date);
    //     $formattedDate = $date->format('l');

    //     if(!empty($item->time_in) && !empty($item->time_out)) {
    //         foreach ($this->work_to as $sched) {
    //             if ($sched->work_day === $formattedDate) {
    //                 $seconds_under = strtotime($sched->work_to) - strtotime($item->time_out) ;
    //                 return number_format($seconds_under / 60, 2);
    //             }
    //         }
    //     }
    // }
    // private function calculateTotalLates($item) {
    //     return $item->lateMinutes + $item->underMinutes;
    // }
    // private function calculateTotalHours($item) {
    //     if (!empty($item->time_in) && !empty($item->time_out)) {
    //         $timeIn = strtotime($item->time_in);
    //         $timeOut = strtotime($item->time_out);

    //         $seconds = $timeOut - $timeIn;
    //         $hours = floor($seconds / 3600);
    //         $minutes = floor(($seconds % 3600) / 60);
    //         $totalHours = $hours + ($minutes / 60);

    //         return number_format($totalHours, 2);
    //     }

    //     return 0;
    // }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Date',
            'Clock In',
            'Break Start',
            'Break End',
            'Clock Out',
            'Days Present',
            'Days Absent',
            'Late Minutes',
            'Undertime Minutes',
            'Total Lates',
            'Total Hours',
            'Total Working Hours',
            // Add more column headings as needed
        ];
    }
}
