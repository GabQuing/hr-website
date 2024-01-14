<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSummary extends Model
{
    use HasFactory;
    protected $table = 'attendance_summary';


    public function getByDate($date, $user_id)
    {
        return $this->where('user_id', $user_id)->where('log_date', $date)->first();
    }
}
