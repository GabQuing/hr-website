<?php

namespace App\Exports;

use App\Exports\Sheets\AttendanceLogSheet;
use App\Exports\Sheets\AttendanceSummarySheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class attendanceSummaryExport implements WithMultipleSheets
{
    public $log_data;
    public $summary_data;
    public function __construct($log_data, $summary_data)
    {
        $this->log_data = $log_data;
        $this->summary_data = $summary_data;
    }

    public function sheets(): array
    {
        $sheets = [
            new AttendanceLogSheet($this->log_data->orderBy(DB::raw(1))),
            new AttendanceSummarySheet($this->summary_data),
        ];

        return $sheets;
    }
}
