<?php

namespace App\Http\Controllers;
use App\Models\loginAttendance;
use DateTime;
use DateInterval;
use DateTimeZone;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ActivityLogsExport;
use DB;
use Storage;

class ActivityLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[];
        $data['user'] = DB::table('login_attendances')
            ->where('employee_name', auth()->user()->employee_name)
            ->OrderBy('date','desc')
            ->paginate(10);

        // dd(auth()->user()->employee_name);
        return view ('my_activity_logs', $data);
    }


    public function generateFile(Request $request)
    {
        $empName = $request->input('employeeName');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $numEntry = DB::table('login_attendances')
            ->where('employee_name',$empName)
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
        ->where('employee_name', auth()->user()->employee_name)
        ->get();
        $dataEntry['fromDate'] = $fromDate;
        $dataEntry['toDate'] = $toDate;
        $dataEntry['numEntry'] = $numEntry;
        $dataEntry['has_generated'] = true;
        
        return view ('my_activity_logs', $dataEntry, $data);

    }

    public function exportFile(Request $request)
    {
        $dataEntry = $request->input('data_entry');
        $employeeName = auth()->user()->employee_name;
        $data = [];
        $data['data_entry'] = $dataEntry;
        $data['from_date'] = $request->input('from_date');
        $data['to_date'] = $request->input('to_date');
        
        return Excel::download(new ActivityLogsExport($data), "$employeeName-activity-log-summary.xlsx");
    }

    public function myActivityGoogleImages(Request $request)  {
        $uuids = json_decode($request->get('uuids'));
        $response = [];
        foreach ($uuids as $uuid) {
            if (Storage::disk('google')->exists('attendanceLogs/' . $uuid . '.png')) {
                $response[$uuid] = Storage::disk('google')->url('attendanceLogs/' . $uuid . '.png');
            }
        }
        return json_encode($response);
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
}
