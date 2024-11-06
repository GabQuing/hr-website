<?php

namespace App\Http\Controllers;

use App\Models\OfficialBusiness;
use Illuminate\Http\Request;
use App\Models\schedule_type;

class OfficialBusinessController extends Controller
{
    public function index()
    {

        $queryParams = request()->all();
        $openTab = sizeof($queryParams) ? array_keys($queryParams)[0] : ['pending'];
        $openTab = in_array($openTab, ['pending', 'approved', 'rejected_canceled']) ? $openTab : 'pending';
        $user_id = auth()->user()->id;
        $server_datetime_today = now();
        $datetime_object = new \DateTime($server_datetime_today);
        $formatted_date = $datetime_object->format('F j Y');
        $server_day = $server_datetime_today->format('l');
        $data = [];
        $data['pending_logs'] = OfficialBusiness::where('created_by', $user_id)
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'pending');
        $data['approved_logs'] = OfficialBusiness::where('created_by', $user_id)
            ->where('status', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'approved');
        $data['rejected_canceled_logs'] = OfficialBusiness::where('created_by', $user_id)
            ->whereIn('status', ['REJECTED', 'CANCELED'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'rejected_canceled');

        $data['serverCurrentDay'] = $server_day;
        $data['serverFormattedDate'] = $formatted_date;
        $data['openTab'] = $openTab;

        return view('my_official_business', $data);
    }
    public function createOB(Request $request)
    {
        $employee_id = auth()->user()->id;
        $employee_name = auth()->user()->name;
        $user_sched_id = auth()->user()->schedule_types_id;


        OfficialBusiness::insert([
            'schedule_types_id' => $user_sched_id,
            'date_from' => $request->input('date_from'),
            'time_from' => $request->input('time_from'),
            'time_to' => $request->input('time_to'),
            'location' => $request->input('location'),
            'reason' => $request->input('reason'),
            'status' => 'PENDING',
            'created_by' => $employee_id,
            'created_at' => now(),
        ]);
        return redirect()->route('officialbusiness')->with('success', 'Official Business Generated Successfully!');
    }

    public function edit($id)
    {
        $showOB = OfficialBusiness::where('id', $id)
            ->first();

        return $showOB;
    }

    public function updateOB(Request $request, $id)
    {
        $employee_id = auth()->user()->id;
        $updateOb = OfficialBusiness::find($id);

        $updateOb->update([
            'date_from' => $request->input('date_from'),
            'time_from' => $request->input('time_from'),
            'time_to' => $request->input('time_to'),
            'location' => $request->input('location'),
            'reason' => $request->input('reason'),
            'updated_by' => $employee_id,
            'updated_at' => now(),

        ]);

        return redirect()->route('officialbusiness')->with('success', 'Official Business Has Been Edited!');
    }

    public function deleteOB($id)
    {
        $cancelOb = OfficialBusiness::find($id);
        $userId = (auth()->user()->id);

        $cancelOb->update([
            'status' => 'CANCELED',
            'cancelled_by' => $userId,
            'cancelled_at' => now()
        ]);
        return true;
    }
}
