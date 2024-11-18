<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeaves;
use Illuminate\Http\Request;
use App\Models\Leave;

class LeavesController extends Controller
{
    public function index()
    {
        $queryParams = request()->all();
        $openTab = sizeof($queryParams) ? array_keys($queryParams)[0] : ['pending'];
        $openTab = in_array($openTab, ['pending', 'approved', 'rejected_canceled']) ? $openTab : 'pending';
        $data = [];

        $user_id = auth()->user()->id;
        $server_datetime_today = now();
        $datetime_object = new \DateTime($server_datetime_today);
        $formatted_date = $datetime_object->format('F j Y');
        $server_day = $server_datetime_today->format('l');


        $data['pending_logs'] = Leave::where('created_by', $user_id)
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'pending');

        $data['approved_logs'] = Leave::where('created_by', $user_id)
            ->where('status', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'approved');

        $data['rejected_canceled_logs'] = Leave::where('created_by', $user_id)
            ->whereIn('status', ['REJECTED', 'CANCELED'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'rejected_canceled');

        $data['employee_leaves'] = EmployeeLeaves::where('user_id', $user_id)->first();
        $data['serverCurrentDay'] = $server_day;
        $data['serverFormattedDate'] = $formatted_date;
        $data['openTab'] = $openTab;

        return view('my_leaves', $data);
    }
    public function createLeave(Request $request)
    {
        $employee_id = auth()->user()->id;
        $employee_name = auth()->user()->name;
        $user_sched_id = auth()->user()->schedule_types_id;

        $employee_leaves = EmployeeLeaves::where('user_id', $employee_id)->first();

        if (($request->input('leave_type') == 'BIRTHDAY' && $employee_leaves->sick_credit == 0) || ($request->input('leave_type') == 'VACATION' && $employee_leaves->vacation_credit == 0)) {
            return redirect()->back()->with('failed', 'No more credits!');
        }

        Leave::insert([
            'schedule_types_id' => $user_sched_id,
            'leave_type' => $request->input('leave_type'),
            'duration' => $request->input('duration'),
            'leave_from' => $request->input('leave_from'),
            'reason' => $request->input('reason'),
            'status' => 'PENDING',
            'created_at' => now(),
            'created_by' => $employee_id,

        ]);

        return redirect()->route('leaves')->with('success', 'Leave Generated Successfully!');
    }

    public function edit($id)
    {
        $showLeave = Leave::leftJoin('employee_leaves', 'employee_leaves.user_id', 'leaves.created_by')
            ->where('leaves.id', $id)
            ->select(
                'leaves.*',
                'employee_leaves.sick_credit',
                'employee_leaves.vacation_credit',
            )
            ->first();

        // dd($showLeave);
        return $showLeave;
    }

    public function updateLeave(Request $request, $id)
    {
        $employee_id = auth()->user()->id;
        $updateLeave = Leave::find($id);

        $updateLeave->update([
            'leave_type' => $request->input('leave_type'),
            'duration' => $request->input('duration'),
            'leave_from' => $request->input('leave_from'),
            'reason' => $request->input('reason'),
            'updated_by' => $employee_id,
            'updated_at' => now(),
        ]);

        return redirect()->route('leaves')->with('success', 'Leave Updated Successfully!');
    }

    public function deleteLeave($id)
    {
        $cancelLeave = Leave::find($id);
        $userId = (auth()->user()->id);

        $cancelLeave->update([
            'status' => 'CANCELED',
            'cancelled_by' => $userId,
            'cancelled_at' => now()
        ]);
        return true;
    }
}
