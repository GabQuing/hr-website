<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserLog;
use Throwable;
use Carbon\Carbon;


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
            $data['year'] = date('Y');
            $data['daysOfWeek'] = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
            $data['usernames'] = (new User())
                ->getAllActiveUsers()
                ->select('users.id', 'users.name')
                ->orderBy('users.name', 'asc')
                ->get();
            $fromDate = date_create($request->input('from_date'));
            $toDate = date_create($request->input('to_date'));
            $userIds = $request->input('users_id');
            $workSchedules = User::whereIn('id', $userIds)->with('workSchedule')->get()->toArray();
            foreach ($workSchedules as $schedule) {
                $data['workSchedules'][$schedule['id']] = $schedule['work_schedule'];
            }
            $controller = new AttendanceController();
            $summary_data = [];
            foreach ($userIds as $userId) {
                $summary_data[] = array_merge(
                    ['user_id' => $userId],
                    $controller->getSummaryData($userId, date_format($fromDate, 'Y-m-d'), date_format($toDate, 'Y-m-d'))
                );
            }

            // Generate months dynamically
            $filteredMonths = [];
            $start = clone $fromDate;

            while ($start <= $toDate) {
                $month = date_format($start, 'm'); // Get month number
                $year = date_format($start, 'Y'); // Get year
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $firstDayOfMonth = date('w', strtotime("$year-$month-01")); // Get first day (0 = Sunday, 6 = Saturday)

                $filteredMonths[] = [
                    'month' => date_format($start, 'M'),
                    'monthNumber' => $month,
                    'year' => $year,
                    'daysInMonth' => $daysInMonth,
                    'firstDayOfMonth' => $firstDayOfMonth,
                ];

                // Move to the next month
                date_add($start, date_interval_create_from_date_string("1 month"));
            }

            $data['params'] = $request->all();
            $data['summary_data'] = $summary_data;
            $data['filtered_months'] = $filteredMonths; // Pass dynamically generated months

            return view('employee_attendance', $data);
        } catch (Throwable $e) {
            return 'Something went wrong. Please check if the users have a schedule.';
        }
    }
}
