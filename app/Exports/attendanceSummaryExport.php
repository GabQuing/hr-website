<?php

namespace App\Exports;

use App\Exports\Sheets\AttendanceLogSheet;
use App\Exports\Sheets\AttendanceSummarySheet;
use App\Exports\Sheets\OvertimeSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class attendanceSummaryExport implements WithMultipleSheets
{
    public $log_data;
    public $summary_data;
    public $overtime_data;
    public function __construct($log_data, $overtime_data, array $summary_data)
    {
        $this->log_data = $log_data;
        $this->overtime_data = $overtime_data;
        $this->summary_data = $summary_data;
    }

    public function sheets(): array
    {
        $sheets = [
            new AttendanceLogSheet($this->log_data->orderBy(DB::raw(1))),
            new OvertimeSheet($this->overtime_data->orderBy(DB::raw(1))),
            new AttendanceSummarySheet($this->summary_data),
        ];

        return $sheets;
    }
}
