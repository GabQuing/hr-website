<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\EmployeeActivityLogsExport;
use App\Models\UserLog;
use DB;

class LogUserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        $data['user_logs'] = (new UserLog())
            ->getAllLogs()
            ->paginate(10);

        $data['has_generated'] = false;
        return view('log_user_access', $data);
    }

    public function generateEmployeeFile(Request $request)
    {
        $data=[];

        $data['user_logs'] = (new UserLog())
            ->getAllLogs()
            ->paginate(10)
            ->appends($request->all());

        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $numEntry = DB::table('user_log_view')
            ->whereBetween('log_date',[$fromDate,$toDate])
            ->select('user_id',
                'log_date',
                'latest',
                'log_type_id')
            ->get();

        $dataEntry=[];

            
        $dataEntry['fromDate'] = $fromDate;
        $dataEntry['toDate'] = $toDate;
        $dataEntry['numEntry'] = $numEntry;
        $dataEntry['has_generated'] = true;
        
        $request->session()->flash('success', '"Export File" generated successfully!');

        return view ('log_user_access', $dataEntry, $data);
    }

    public function exportEmployeeFile(Request $request)
    {
        $dataEntry = $request->input('data_entry');
        $data = [];
        $data['from_date'] = $request->input('from_date');
        $data['to_date'] = $request->input('to_date');

        return Excel::download(new EmployeeActivityLogsExport($data), "Employee-activity-log-summary.xlsx");
    }



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

    // public function getGoogleImages(Request $request)  {
    //     $uuids = json_decode($request->get('uuids'));
    //     $response = [];
    //     foreach ($uuids as $uuid) {
    //         if (Storage::disk('google')->exists('attendanceLogs/' . $uuid . '.png')) {
    //             $response[$uuid] = Storage::disk('google')->url('attendanceLogs/' . $uuid . '.png');
    //         }
    //     }
    //     return json_encode($response);
    // }
}
