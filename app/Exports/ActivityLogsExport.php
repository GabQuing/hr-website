<?php

namespace App\Exports;

use App\Models\ActivityLogs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\loginAttendance;
use App\Models\User;
use App\Models\UserLog;
use DB;

class ActivityLogsExport implements FromCollection, WithHeadings
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $collection = UserLog::join('users', 'users.id', '=', 'user_logs.user_id')
            ->where('users.id',auth()->user()->id)
            ->whereBetween('date', [$this->data['from_date'], $this->data['to_date']])
            ->select(
                'users.name',
                'user_logs.log_type_id',
                'user_logs.log_date',
                'user_logs.log_time',
            )
            ->get();

        // $collection = loginAttendance::join('users', 'users.employee_name', '=', 'login_attendances.employee_name')
        //     ->where('users.employee_name', auth()->user()->employee_name)
        //     ->whereBetween('date', [$this->data['from_date'], $this->data['to_date']])
        //     ->select(
        //         'users.mobile_number',
        //         'login_attendances.employee_name',
        //         'login_attendances.date',
        //         'login_attendances.time',
        //         'login_attendances.log_type',
        //         'login_attendances.store_address',
        //     )
        //     ->get();
        
        return $collection;
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Log-Type',
            'Date',
            'Time',
            // Add more column headings as needed
        ];
    }
}
