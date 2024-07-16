<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AttendanceSummary;
use App\Models\LogType;
use App\Models\User;
use App\Models\UserLog;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $today = Carbon::today()->toDateString(); // Get today's date
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
            ->leftJoin(DB::raw('
                (SELECT user_logs.user_id, user_logs.log_type_id, user_logs.log_time 
                FROM user_logs 
                WHERE user_logs.log_date = "' . $today . '" 
                AND user_logs.created_at = (
                    SELECT MAX(created_at) 
                    FROM user_logs ul 
                    WHERE ul.user_id = user_logs.user_id 
                    AND DATE(ul.created_at) = "' . $today . '"
                )
            ) as latest_user_logs'), function($join) {
                $join->on('latest_user_logs.user_id', '=', 'users.id');
            })
            ->leftJoin('log_types', 'log_types.id', '=', 'latest_user_logs.log_type_id') // Join with log_types
            ->whereNull('users.deleted_at')
            ->where('users.approval_status', 'APPROVED')
            ->where('model_has_roles.role_id', 2)
            // ->where('users.id','!=',$user_id)
            ->select(
                'users.*',
                'latest_user_logs.log_type_id', // Selecting log_type_id
                'latest_user_logs.log_time',
                'log_types.description' // Selecting the description from log_types
            )
            ->orderBy('users.name', 'ASC')
            ->get();
    
        // dd($data['team_logs']);
    
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
}
