<?php

namespace App\Exports;

use App\Models\ActivityLogs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\loginAttendance;
use App\Models\User;
use App\Models\UserLogView;
use DB;

class ActivityLogsExport implements FromCollection, WithHeadings
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $collection = UserLogView::join('users', 'users.id', '=', 'user_log_view.user_id')
            ->join('log_types', 'log_types.id', '=', 'user_log_view.log_type_id')            ->where('users.id',auth()->user()->id)
            ->whereBetween('log_date', [$this->data['from_date'], $this->data['to_date']])
            ->select(
                'users.name',
                'user_log_view.log_date',
                'user_log_view.latest',
                'log_types.description',
            )
            ->orderBy('user_log_view.log_date', 'DESC')
            ->orderBy('user_log_view.latest', 'DESC')
            ->get();

        
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
