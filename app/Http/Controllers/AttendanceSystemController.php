<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\loginAttendance;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;


class AttendanceSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['serverDateTime']=now();

        return view('Attendance', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $uuid = Uuid::uuid4()->toString();
        $ipAddress = $request->ip();
        $user_request = $request->all();
        $entry = [
            'employee_name' => $user_request['inName'],
            'date'=>$user_request['inDate'],
            'time'=>$user_request['inTime'] ?? $user_request['outTime'],
            'store_address'=>$user_request['location'],
            'ip_address' => $ipAddress,
            'uuid' => $uuid,
            // 'store_address'=>$user_request['inLocation'],
        ];
        
        if ($user_request['logType'] == 'Confirm Login') {
            $entry["log_type"] = "Time-In";
        }else {
            $entry["log_type"] = "Time-Out";
        }

        $ID = loginAttendance::insertGetId($entry);

        $imageData = $request->input('image_url');
        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        $directory = 'C:/laragon/www/DMHR/public/attendanceLogs';

        $filename = $uuid. '.png';

        File::put($directory . '/' . $filename, $decodedImage);


        return redirect()->back();
    }


    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->input('name'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
