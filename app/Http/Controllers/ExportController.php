<?php

namespace App\Http\Controllers;
use App\Exports\attendanceSummary;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new attendanceSummary(), 'table_data.xlsx');
    }
}
