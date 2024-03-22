<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave; 

class LeavesController extends Controller
{
    public function index(){
        
        $data=[];
        $user_id = auth()->user()->id;
        $server_datetime_today = now();
        $datetime_object = new \DateTime($server_datetime_today);
        $formatted_date = $datetime_object->format('F j Y');
        $server_day = $server_datetime_today->format('l');


        $data['pending_logs'] = Leave::where('created_by',$user_id)
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'desc')
            ->get();

        $data['approved_logs'] = Leave::where('created_by',$user_id)
            ->where('status', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->get();

        $data['rejected_canceled_logs'] = Leave::where('created_by',$user_id)
            ->whereIn('status', ['REJECTED','CANCELED'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data['serverCurrentDay'] = $server_day;
        $data['serverFormattedDate'] = $formatted_date;
        return view('my_leaves', $data);
    }
    public function createLeave(Request $request)
    {
        $employee_id = auth()->user()->id;
        $employee_name = auth()->user()->name;
        $user_sched_id = auth()->user()->schedule_types_id;

        Leave::insert([
            'schedule_types_id' => $user_sched_id,
            'leave_type' => $request->input('leave_type'),
            'duration' => $request->input('duration'),
            'leave_from' => $request->input('leave_from'),
            'leave_to' => $request->input('leave_to'),
            'reason' => $request->input('reason'),
            'status' => 'PENDING',
            'created_at' => now(),
            'created_by' => $employee_id,
            
        ]);
        $request->session()->flash('success', 'Leave Generated Successfully!');
        return redirect()->back();
    }

    public function edit ($id){

        $showLeave = Leave::where('id',$id)
        ->first();

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
            'leave_to' => $request->input('leave_to'),
            'reason' => $request->input('reason'),
            'updated_by' => $employee_id,
            'updated_at' => now(),
        ]);
        $request->session()->flash('success', 'Overtime Form Has Been Edited!');
        return redirect()->back();
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
