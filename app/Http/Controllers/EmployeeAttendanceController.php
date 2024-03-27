<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserLog;

class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        $data['usernames'] = (new User())
        ->getAllActiveUsers()
        ->select(
            'users.id',
            'users.name',
        )
        ->get();

        return view('employee_attendance', $data);
    }

    public function employeeDaysPresent(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $UserId = $request->input('users_id');
        $data = self::getSummaryData($userId, $fromDate, $toDate);
        $data['params'] = $request->all();
        return view('my_attendance', $data);
    }
}
