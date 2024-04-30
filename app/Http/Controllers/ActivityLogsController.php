<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ActivityLogsExport;
use App\Models\UserLog;
use Illuminate\Support\Facades\DB;

class ActivityLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $data = [];
        $data['user_logs'] = (new UserLog())
            ->getByUserId($user_id)
            ->paginate(10);

        // dd(auth()->user()->employee_name);
        return view('my_activity_logs', $data);
    }


    public function generateFile(Request $request)
    {
        $user_id = auth()->user()->id;
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $data = [];
        $data['user_logs'] = (new UserLog())
            ->getByUserId($user_id)
            ->whereBetween('log_date',[$fromDate,$toDate])
            ->paginate(10)
            ->appends($request->all());


        $dataEntry = [];
        $dataEntry['fromDate'] = $fromDate;
        $dataEntry['toDate'] = $toDate;
        $dataEntry['has_generated'] = true;
        
        $data['success'] = '"Export File" generated successfully!';

        return view('my_activity_logs', $dataEntry, $data);
    }

    public function exportFile(Request $request)
    {
        $dataEntry = $request->input('data_entry');
        $employeeName = auth()->user()->employee_name;
        $data = [];
        $data['from_date'] = $request->input('from_date');
        $data['to_date'] = $request->input('to_date');

        return Excel::download(new ActivityLogsExport($data), "$employeeName-activity-log-summary.xlsx");
    }

    // public function myActivityGoogleImages(Request $request)
    // {
    //     $uuids = json_decode($request->get('uuids'));
    //     $response = [];
    //     foreach ($uuids as $uuid) {
    //         if (Storage::disk('google')->exists('attendanceLogs/' . $uuid . '.png')) {
    //             $response[$uuid] = Storage::disk('google')->url('attendanceLogs/' . $uuid . '.png');
    //         }
    //     }
    //     return json_encode($response);
    // }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
