<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;

class AttendanceSummary extends Model
{
    use HasFactory;
    protected $table = 'attendance_summary';


    public function getByDate($date, $user_id)
    {
        return $this->where('user_id', $user_id)->where('log_date', $date)->first();
    }

    public function countPresentDays($user_id, $fromDate, $toDate)
    {
        return $this->where('user_id', $user_id)
            ->whereBetween('log_date', [$fromDate, $toDate])
            ->whereNotNull('clock_in')
            ->whereNotNull('clock_out')
            ->count();
    }
    public function countAbsentDays($user_id, $fromDate, $toDate)
    {
        $present_dates = $this->where('user_id', $user_id)
            ->whereBetween('log_date', [$fromDate, $toDate])
            ->whereNotNull('clock_in')
            ->whereNotNull('clock_out')
            ->pluck('log_date')
            ->toArray();

        $dates = [];
        $absent_count = 0;
        if ($fromDate <= $toDate) {
            $dates[] = $fromDate;
            while ($fromDate < $toDate) {
                $newDateString = date('Y-m-d', strtotime($fromDate . ' +1 day'));

                $dates[] = $newDateString;
                $fromDate = $newDateString;
            }
        }

        foreach ($dates as $date) {
            if (!in_array($date, $present_dates)) {
                $absent_count++;
            }
        }

        return $absent_count;
    }

    public function getUserAttendanceSummary($user_id)
    {
        return $this->leftJoin('users', 'users.id', 'attendance_summary.user_id')
            ->select(
                'attendance_summary.*',
                'users.name as user_name',
            )
            ->where('users.id', $user_id);
    }

    public function countTotalHours($user_id, $from_date, $to_date)
    {
        return $this
            ->select(
                DB::raw("
                    TIME_TO_SEC(TIME_FORMAT(break_start, '%H:%i')) - TIME_TO_SEC(TIME_FORMAT(clock_in, '%H:%i')) + 
                    TIME_TO_SEC(TIME_FORMAT(clock_out, '%H:%i')) - TIME_TO_SEC(TIME_FORMAT(break_end, '%H:%i')) as total_hours
                "),
            )
            ->where('user_id', $user_id)
            ->whereBetween('log_date', [$from_date, $to_date])
            ->pluck('total_hours')
            ->first();
    }
}
