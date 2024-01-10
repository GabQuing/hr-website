<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class employeeNameController extends Controller
{
    public function index()
    {
        $employeeNames = DB::table('users')
            ->where('approval_status', 'APPROVED')
            ->pluck('employee_name')
            ->all();

        return response()->json($employeeNames);
    }
}
