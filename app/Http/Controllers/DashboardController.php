<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AttendanceSummary;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LogType;
use App\Models\Overtime;
use App\Models\User;
use App\Models\UserLog;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString(); // Get today's date
        $now = date('Y-m-d H:i:s');
        $user_id = auth()->user()->id;
        $sched_type = auth()->user()->schedule_types_id;
        $day_name = date('l');
        $is_rest_day = WorkSchedule::where('schedule_types_id', $sched_type)
            ->where('work_day', $day_name)
            ->first()
            ->rest_day;
        $date = date('Y-m-d');
        $data = [];
        $data['is_rest_day'] = $is_rest_day;
        $data['serverDateTime'] = now();
        $data['today_log'] = (new AttendanceSummary())->getByDate(date('Y-m-d'), auth()->user()->id);
        $data['team_logs'] = User::leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin(DB::raw("
                (SELECT user_logs.user_id, user_logs.log_type_id, user_logs.log_time 
                FROM user_logs 
                WHERE user_logs.log_date = '$today'  
                AND user_logs.log_at < '$now'  
                AND user_logs.log_at = (
                    SELECT MAX(log_at) 
                    FROM user_logs ul 
                    WHERE ul.user_id = user_logs.user_id
                    AND ul.log_at < '$now' 
                    AND ul.log_date = '$today'
                )
            ) as latest_user_logs"), function ($join) {
                $join->on('latest_user_logs.user_id', '=', 'users.id');
            })
            ->leftJoin('log_types', 'log_types.id', '=', 'latest_user_logs.log_type_id') // Join with log_types
            ->whereNull('users.deleted_at')
            ->where('users.approval_status', 'APPROVED')
            ->where('model_has_roles.role_id', 2)
            ->where('users.id', '!=', $user_id)
            ->where('users.email', '!=', 'dummyaccount@gmail.com')
            ->select(
                'users.*',
                'latest_user_logs.log_type_id', // Selecting log_type_id
                'latest_user_logs.log_time',
                'log_types.description' // Selecting the description from log_types
            )
            ->orderBy('users.name', 'ASC')
            ->get();

        $num_rows = $data['team_logs']->count();
        $data['user_logs'] = (new UserLog())
            ->getByUserId($user_id)
            ->orderByDesc('log_date')
            ->take($num_rows)
            ->get();

        $data['announcement'] = Announcement::whereNull('deleted_at')
            ->where('start_date', '<=', $date)
            ->where('end_date', '>', $date)
            ->first();

        $data['all_months'] = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];
        $data['year'] = 2024;
        $data['daysOfWeek'] = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

        $data['holidays'] = Holiday::where('holiday_date', 'like', $data['year'] . '%')
            ->orderBy('holiday_date', 'asc')->get();

        return view('dashboard', $data);
    }


    public function log_action(Request $request)
    {
        $user_id = $request->get('user_id');
        $user_sched_id = $request->get('user_sched_id');
        $timestamp = date('Y-m-d H:i');
        $action = $request->get('action');

        $log_type = (new LogType())->getByDescription($action);

        if (!$log_type) {
            abort(404, 'The request action type does not exist in the database.');
        }

        $is_existing = UserLog::where([
            'log_type_id' => $log_type->id,
            'user_id' => $user_id,
            'log_date' => date('Y-m-d')
        ])->exists();

        if ($is_existing) {
            abort(404, "Log of type $action already exists.");
        }

        $user_log = UserLog::create([
            'log_type_id' => $log_type->id,
            'log_at' => $timestamp,
            'user_id' => $user_id,
            'schedule_types_id' => $user_sched_id
        ]);

        $log_details = $user_log->getDetails();
        $response = [];
        $response['log_details'] = $log_details;
        $response['log_today'] = (new AttendanceSummary())->getByDate(date('Y-m-d'), $user_id);
        return $response;
    }

    public function createAnnouncement(Request $request)
    {
        $date = date('Y-m-d H:i:s');
        $user_id = auth()->user()->id;

        $file_path = null;

        if ($request->hasFile('imageInput')) {
            $image_file = $request->file('imageInput');
            $storage_path = 'img/announcements';
            $image_file_name = time() . '.' . $image_file->getClientOriginalExtension();
            $image_file->storeAs($storage_path, $image_file_name, 'public');
            $file_path = url('/img/announcements/' . $image_file_name);
        }

        Announcement::whereNull('deleted_at')->update(['deleted_at' => $date]);

        Announcement::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'subject' => $request->subject,
            'file_path' => $file_path, // Save the file path or null
            'message' => $request->message,
            'created_by' => $user_id,
            'created_at' => $date,
        ]);

        return redirect('/dashboard1')->with('success', 'Announcement created successfully.');
    }

    public function updateAnnouncement(Request $request)
    {
        self::createAnnouncement($request);
        return redirect('/dashboard1')->with('success', 'Announcement updated successfully.');
    }

    public function deleteAnnouncement(Request $request)
    {
        Announcement::whereNull('deleted_at')->update(['deleted_at' => date('Y-m-d H:i:s')]);
        return redirect('/dashboard1')->with('success', 'Announcement deleted successfully.');
    }

    public function fetchDailyLog(Request $request, $user_id, $month)
    {
        sleep(rand(0, 5));
        $logs = AttendanceSummary::where('user_id', $user_id)
            ->with('workSchedule')
            ->where('log_date', 'like', "$month%")
            ->get()
            ->each(function ($log) {
                $log->setRelation('workSchedule', $log->workSchedule->where('work_day', $log->day_name)->first());
            });

        $leaves = Leave::where([
            'created_by' => $user_id,
            'status' => 'APPROVED'
        ])->where('leave_from', 'like', "$month%")
            ->get();

        $overtimes = Overtime::where([
            'created_by' => $user_id,
            'status' => 'APPROVED'
        ])->where('shift_date', 'like', "$month%")
            ->get();

        return [
            'user' => $user_id,
            'month' => $month,
            'logs' => $logs,
            'leaves' => $leaves,
            'overtimes' => $overtimes,
        ];
    }

    public function createHoliday(Request $request)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'holiday_name' => 'required|string',
        ]);

        $holiday_date = $request->holiday_date;
        $holiday_name = $request->holiday_name;

        Holiday::create([
            'holiday_date' => $holiday_date,
            'holiday_name' => $holiday_name,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success-holiday', 'Holiday created successfully.');
    }
}
