<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\AttendanceSummary;
use Illuminate\Support\Facades\DB as FacadesDB;

class attendanceSummaryExport implements FromCollection, WithHeadings
{
    public $schedule_query;
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
        $user_id = auth()->user()->id;
        $this->schedule_query = (new AttendanceSummary())
            ->getUserAttendanceSummary($user_id)
            ->get()
            ->toArray();
    }

    public function collection()
    {
        $collection = FacadesDB::table('attendance_summary')
            ->where('user_id', auth()->user()->id)
            ->join('users', 'attendance_summary.user_id', '=', 'users.id')
            ->selectRaw("
                users.name,
                log_date,
                clock_in,
                break_start,
                break_end,
                clock_out
            ")
            ->whereBetween('log_date', [$this->data['from_date'], $this->data['to_date']])
            ->get();

        $collection = $collection->map(function ($item) {
            $item->days_present = $this->hasTimeInAndTimeOut($item) ? 1 : 0;
            $item->numberOfAbsences = $this->NoTimeInAndTimeOut($item) ? 1 : 0;
            return $item;
        });


        return $collection;
    }

    private function hasTimeInAndTimeOut($item)
    {
        return !empty($item->clock_in) && !empty($item->clock_out);
    }

    private function NoTimeInAndTimeOut($item)
    {
        return empty($item->clock_in) || empty($item->clock_out);
    }

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
