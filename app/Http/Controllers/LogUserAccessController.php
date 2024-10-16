<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\EmployeeActivityLogsExport;
use App\Models\UserLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $data['usernames'] = (new User())
            ->getAllActiveUsers()
            ->select(
                'users.id',
                'users.name',
            )
            ->get();

        $data['has_generated'] = false;
        return view('log_user_access', $data);
    }

    public function generateEmployeeFile(Request $request)
    {
        $data=[];
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $UserId = $request->input('users_id');
    
        $data['user_logs'] = (new UserLog())
            ->getAllLogs()
            ->whereBetween('log_date',[$fromDate,$toDate])
            ->whereIn('user_id',$request->input('users_id'))
            ->paginate(10)
            ->appends($request->all());
    
        $data['usernames'] = (new User())
            ->getAllActiveUsers()
            ->select(
                'users.id',
                'users.name',
            )
            ->get();
    
    
        $numEntry = DB::table('user_log_view')
            ->whereBetween('log_date',[$fromDate,$toDate])
            ->select('user_id',
                'log_date',
                'latest',
                'log_type_id')
            ->get();
    
        $dataEntry=[];
    
            
        $dataEntry['from_date'] = $fromDate;
        $dataEntry['to_date'] = $toDate;
        $dataEntry['users_id'] = $UserId;
        $dataEntry['num_entry'] = $numEntry;
        $dataEntry['has_generated'] = true;
        $data['query_params'] = http_build_query($dataEntry);
        
        $data['success'] = '"Export File" generated successfully!';
    
        return view ('log_user_access', $data);
    }
    

    public function exportEmployeeFile(Request $request)
    {
        $dataEntry = $request->input('data_entry');
        $data = [];
        $data['users_id'] = $request->input('users_id');
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
