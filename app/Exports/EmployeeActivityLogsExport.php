<?php

namespace App\Exports;

use App\Models\EmployeeActivityLogs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\loginAttendance;
use App\Models\User;
use DB;

class EmployeeActivityLogsExport implements FromCollection, WithHeadings
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
    
        $collection = loginAttendance::join('users', 'users.employee_name', '=', 'login_attendances.employee_name')
            ->whereBetween('date', [$this->data['from_date'], $this->data['to_date']])
            ->select(
                'users.mobile_number',
                'login_attendances.employee_name',
                'login_attendances.date',
                'login_attendances.time',
                'login_attendances.log_type',
                'login_attendances.store_address',
            )
            ->get();
        
        return $collection;
    }

    public function headings(): array
    {
        return [
            'Mobile Number',
            'Employee Name',
            'Date',
            'Time',
            'Log-Type',
            'Store Address',
            // Add more column headings as needed
        ];
    }
}

