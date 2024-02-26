<?php

namespace App\Http\Controllers;
use App\Models\OfficialBusiness; 
use Illuminate\Http\Request;

class OfficialBusinessController extends Controller
{
    public function index(){

        $user_id = auth()->user()->id;
        $data=[];
        $data['pending_logs'] = OfficialBusiness::where('created_by',$user_id)
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'desc')
            ->get();
        $data['approved_logs'] = OfficialBusiness::where('created_by',$user_id)
            ->where('status', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->get();
        $data['rejected_canceled_logs'] = OfficialBusiness::where('created_by',$user_id)
            ->whereIn('status', ['REJECTED','CANCELED'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('my_official_business', $data);
    }
    public function createOB(Request $request)
    {
        $employee_id = auth()->user()->id;
        $employee_name = auth()->user()->name;

        OfficialBusiness::insert([
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'time_from' => $request->input('time_from'),
            'time_to' => $request->input('time_to'),
            'location' => $request->input('location'),
            'reason' => $request->input('reason'),
            'status' => 'PENDING',
            'created_by' => $employee_id,
            'created_at' => now(),
        ]);
        $request->session()->flash('success', 'Official Business Generated Successfully!');
        return redirect()->back();
    }
}
