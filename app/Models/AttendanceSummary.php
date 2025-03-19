<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class AttendanceSummary extends Model
{
    use HasFactory;
    protected $table = 'attendance_summary';
    protected $fillable = [
        'user_id',
        'schedule_types_id',
        'log_date',
        'day_name',
    ];

    public function getByDate($date, $user_id)
    {
        return $this->where('user_id', $user_id)->where('log_date', $date)->first();
    }

    public function countTotalAbsent($user_id, $fromDate, $toDate)
    {
        $schedule_types_id = User::find($user_id)->schedule_types_id;
        $work_day_names = WorkSchedule::where('schedule_types_id', $schedule_types_id)
            ->where('rest_day', 0)
            ->pluck('work_day')->toArray();

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
            $day_name = date('l', strtotime($date));
            if (!in_array($date, $present_dates) && in_array($day_name, $work_day_names)) {
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
                DB::raw("SUM(TIME_TO_SEC(clock_out) - TIME_TO_SEC(clock_in)) as total_hours"),
            )
            ->where('user_id', $user_id)
            ->whereBetween('log_date', [$from_date, $to_date])
            ->groupBy('user_id')
            ->pluck('total_hours')
            ->first();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scheduleType(): BelongsTo
    {
        return $this->belongsTo(schedule_type::class, 'schedule_types_id', 'id');
    }

    public function workSchedule(): HasMany
    {
        return $this
            ->hasMany(WorkSchedule::class, 'schedule_types_id', 'schedule_types_id');
    }
}
