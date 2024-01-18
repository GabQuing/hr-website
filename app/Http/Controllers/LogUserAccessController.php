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

        // $data['has_generated'] = false;
        return view('log_user_access', $data);
    }

    public function generateEmployeeFile(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $numEntry = DB::table('login_attendances')
            ->whereBetween('date',[$fromDate,$toDate])
            ->select('employee_name',
                'date',
                'time',
                'log_type',
                'store_address')
            ->get();

        $dataEntry=[];
        $data=[];

        $data['user'] = DB::table('login_attendances')
        ->get();
        $dataEntry['fromDate'] = $fromDate;
        $dataEntry['toDate'] = $toDate;
        $dataEntry['numEntry'] = $numEntry;
        $dataEntry['has_generated'] = true;
        
        return view ('log_user_access', $dataEntry, $data);

    }

    public function exportEmployeeFile(Request $request)
    {
        $dataEntry = $request->input('data_entry');
        $data = [];
        $data['data_entry'] = $dataEntry;
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
