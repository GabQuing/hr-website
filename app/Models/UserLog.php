<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getAllLogs()
    {
        return $this->leftJoin('users', 'users.id', 'user_logs.user_id')
            ->leftJoin('log_types', 'log_types.id', 'user_logs.log_type_id')
            ->select(
                'user_logs.*',
                'users.name as user_name',
                'log_types.description as log_type_description',
            )
            ->orderBy('id', 'desc');
    }

    public function getByUserId($user_id)
    {
        return $this->leftJoin('users', 'users.id', 'user_logs.user_id')
            ->leftJoin('log_types', 'log_types.id', 'user_logs.log_type_id')
            ->select(
                'user_logs.*',
                'users.name as user_name',
                'log_types.description as log_type_description',
            )
            ->where('users.id', $user_id)
            ->orderBy('id', 'desc');
    }

    public function getDetails()
    {
        return $this->where('user_logs.id', $this->id)
            ->leftJoin('log_types', 'log_types.id', 'user_logs.log_type_id')
            ->select(
                'user_logs.*',
                'users.name',
                'log_types.description as log_type',
            )
            ->leftJoin('users', 'users.id', 'user_logs.user_id')
            ->first();
    }

    public function countTotalPresent($user_id, $from_date, $to_date)
    {
        $query = self::select('user_logs.log_date')
            ->leftJoin('work_schedules', function ($join) {
                $join
                    ->on('work_schedules.schedule_types_id', '=', 'user_logs.schedule_types_id')
                    ->on('work_schedules.work_day', '=', DB::raw('dayname(user_logs.log_date)'));
            })
            ->whereIn('user_logs.log_type_id', [1, 2])
            ->where('work_schedules.rest_day', 0)
            ->where('user_logs.user_id', $user_id)
            ->whereBetween('log_date', [$from_date, $to_date]);
        $dates = (clone $query)->distinct('log_date')->pluck('log_date')->toArray();

        $count = 0;

        foreach ($dates as $date) {
            $has_clock_in = (clone $query)
                ->where('user_logs.log_date', $date)
                ->where('user_logs.log_type_id', 1)
                ->exists();
            $has_clock_out = (clone $query)
                ->where('user_logs.log_date', $date)
                ->where('user_logs.log_type_id', 2)
                ->exists();
            $count += (int) $has_clock_in && $has_clock_out;
        }

        return $count;
    }

    public function countTotalLates($user_id, $from_date, $to_date)
    {
        return $this
            ->selectRaw("
                CASE 
                    WHEN 
                        work_schedules.work_from < user_logs.log_time 
                    THEN TIME_TO_SEC(user_logs.log_time) - TIME_TO_SEC(work_schedules.work_from)
                    ELSE 0
                END AS late_time
            ")
            ->leftJoin('work_schedules', function ($join) {
                $join
                    ->on('work_schedules.schedule_types_id', '=', 'user_logs.schedule_types_id')
                    ->on('work_schedules.work_day', '=', DB::raw('dayname(user_logs.log_date)'));
            })
            ->where('user_logs.user_id', $user_id)
            ->whereBetween('log_date', [$from_date, $to_date])
            ->where('user_logs.log_type_id', 1)
            ->where('work_schedules.rest_day', 0);
    }
    public function countTotalUnderTimes($user_id, $from_date, $to_date)
    {
        return $this
            ->selectRaw("
                CASE 
                    WHEN 
                        work_schedules.work_to > user_logs.log_time 
                    THEN  TIME_TO_SEC(work_schedules.work_to) - TIME_TO_SEC(user_logs.log_time)
                    ELSE 0
                END AS under_time
            ")
            ->leftJoin('work_schedules', function ($join) {
                $join
                    ->on('work_schedules.schedule_types_id', '=', 'user_logs.schedule_types_id')
                    ->on('work_schedules.work_day', '=', DB::raw('dayname(user_logs.log_date)'));
            })
            ->where('user_logs.user_id', $user_id)
            ->whereBetween('log_date', [$from_date, $to_date])
            ->where('user_logs.log_type_id', 2)
            ->where('work_schedules.rest_day', 0);
    }
}
