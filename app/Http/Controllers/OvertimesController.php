<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\schedule_type;
use App\Models\Overtime;
use App\Models\UserLog;
use App\Models\WorkSchedule;

class OvertimesController extends Controller
{

    public function index()
    {
        $data = [];
        $user_id = auth()->user()->id;
        $server_datetime_today = now();
        $server_day = $server_datetime_today->format('l');
        $server_date = date('Y-m-d');
        $user_sched_id = auth()->user()->schedule_types_id;
        $user_schedules = WorkSchedule::where('schedule_types_id', $user_sched_id)
            ->get()
            ->toArray();

        $data['user_schedules'] = $user_schedules;

        $user_sched = schedule_type::where('id', $user_sched_id)
            ->pluck('name')
            ->first();

        $user_shift_from = WorkSchedule::where('schedule_types_id', $user_sched_id)
            ->where('work_day', $server_day)
            ->pluck('work_from')
            ->first();

        $user_shift_to = WorkSchedule::where('schedule_types_id', $user_sched_id)
            ->where('work_day', $server_day)
            ->pluck('work_to')
            ->first();

        $data['pending_logs'] = Overtime::where('created_by', $user_id)
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'desc')
            ->get();
        $data['approved_logs'] = Overtime::where('created_by', $user_id)
            ->where('status', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->get();
        $data['rejected_canceled_logs'] = Overtime::where('created_by', $user_id)
            ->whereIn('status', ['REJECTED', 'CANCELED'])
            ->orderBy('created_at', 'desc')
            ->get();
        $data['has_clock_in_today'] = UserLog::where('log_date', $server_date)
            ->where('log_type_id', 1)
            ->where('user_id', $user_id)
            ->exists();

        $data['shift_from'] = $user_shift_from;
        $data['shift_to'] = $user_shift_to;
        $data['serverCurrentDay'] = $server_day;
        $data['serverDateTime'] = $server_datetime_today;
        $data['server_date'] = $server_date;
        $data['employee_schedule'] = $user_sched;

        return view('my_overtimes', $data);
    }

    public function createOT(Request $request)
    {
        $employee_id = auth()->user()->id;
        $user_sched_id = auth()->user()->schedule_types_id;

        Overtime::insert([
            'schedule_types_id' => $user_sched_id,
            'shift_date' => $request->input('shift_date'),
            'shift_from' => $request->input('shift_from'),
            'shift_to' => $request->input('shift_to'),
            'time_start' => $request->input('start_time'),
            'time_end' => $request->input('end_time'),
            'status' => 'PENDING',
            'ot_classification' => $request->input('ot_classification'),
            'reason' => $request->input('reason'),
            'created_at' => now(),
            'created_by' => $employee_id,
        ]);

        return redirect()->back()->with('success', 'Overtime Generated Successfully!');
    }

    public function edit($id)
    {

        $showOt = Overtime::where('id', $id)
            ->first();

        return $showOt;
    }

    public function updateOT(Request $request, $id)
    {
        $employee_id = auth()->user()->id;
        $updateOT = Overtime::find($id);

        $updateOT->update([
            'shift_date' => $request->input('shift_date'),
            'shift_from' => $request->input('shift_from'),
            'shift_to' => $request->input('shift_to'),
            'time_start' => $request->input('start_time'),
            'time_end' => $request->input('end_time'),
            'status' => 'PENDING',
            'ot_classification' => $request->input('ot_classification'),
            'reason' => $request->input('reason'),
            'created_at' => now(),
            'created_by' => $employee_id,
        ]);

        return redirect()->back()->with('success', 'Overtime Form Has Been Edited!');
    }

    public function deleteOT($id)
    {
        $cancelOT = Overtime::find($id);
        $userId = (auth()->user()->id);

        $cancelOT->update([
            'status' => 'CANCELED',
            'cancelled_by' => $userId,
            'cancelled_at' => now()
        ]);
        return true;
    }
}
