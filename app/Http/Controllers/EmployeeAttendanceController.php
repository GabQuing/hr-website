<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserLog;
use Throwable;

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
            ->orderBy('users.name', 'asc')
            ->get();

        return view('employee_attendance', $data);
    }

    public function employeeDaysPresent(Request $request)
    {
        try {
            $data['year'] = now()->year;
            $data['all_months'] = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];
            $data['daysOfWeek'] = ['Sa', 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr'];
            $data['usernames'] = (new User())
            ->getAllActiveUsers()
            ->select(
                'users.id',
                'users.name',
            )
            ->orderBy('users.name', 'asc')
            ->get();
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $userIds = $request->input('users_id');
            $controller = new AttendanceController();
            $summary_data = [];
            foreach ($userIds as $userId) {
                $summary_data[] = $controller->getSummaryData($userId, $fromDate, $toDate);
            }
            $data['params'] = $request->all();
            $data['summary_data'] = $summary_data;
            return view('employee_attendance', $data);
        } catch (Throwable $e) {
            return 'Something went wrong. Please check if the users have schedule.';
        }
    }
}
