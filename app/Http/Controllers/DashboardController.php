<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AttendanceSummary;
use App\Models\LogType;
use App\Models\UserLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $user_id = auth()->user()->id;
        $date = date('Y-m-d');
        $data = [];
        $data['serverDateTime'] = now();
        $data['today_log'] = (new AttendanceSummary())->getByDate(date('Y-m-d'), auth()->user()->id);
        $data['user_logs'] = (new UserLog())
            ->getByUserId($user_id)
            ->get();

        $data['announcement'] = Announcement::whereNull('deleted_at')
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
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
        $user_id = auth()->user()->id;
        $date = date('Y-m-d H:i:s');
        Announcement::whereNotNull('id')->update(['deleted_at' => $date]);
        $announcement = Announcement::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_by' => $user_id,
            'created_at' => $date,
        ]);

        return redirect('/dashboard1')->with('success', 'Announcement created successfully.');
    }

    public function updateAnnouncement(Request $request)
    {
        $announcement = self::createAnnouncement($request);
        return redirect('/dashboard1')->with('success', 'Announcement updated successfully.');
    }
}
