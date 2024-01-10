<?php

namespace App\Http\Controllers;

use App\Models\cr;
use App\Models\schedule_type;
use Illuminate\Http\Request;
use App\Models\WorkSchedule;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\User;

class ScheduleProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        $data['work_days'] = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $data['schedule_types'] = schedule_type::get();

        // $data['work_schedule'] = schedule_type::where

        // $data['work_schedule'] = User::where('users.id',$id)
        // ->leftJoin('schedule_types', 'schedule_types.id', 'users.schedule_types_id')
        // ->leftJoin('work_schedules', 'work_schedules.schedule_types_id', 'schedule_types.id')
        // ->get()
        // ->toArray();
        // dd($data['work_schedules']);
        return view('schedule_profile', $data);
    }

    public function viewSchedule(Request $request)
    {
        $user_request = $request->all();
        $user_schedule_type = $user_request['scheduleType'];
        $working_hours = schedule_type::where('id',$user_schedule_type)->pluck('working_hours')->first();
        $work_schedules = WorkSchedule::where('schedule_types_id',$user_schedule_type)->get();

        return response()->json(['working_hours' => $working_hours, 'entry'=>$work_schedules]);
        // return view('schedule_profile', $user_schedule_type );
    }
    public function createSchedule (Request $request){


        $scheduleName = strtoupper($request->input('input_sched_name'));
        $wordDaysArray = [];
        $workDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        $scheduleType = new schedule_type();
        $scheduleType->name = $scheduleName;
        $scheduleType->working_hours = $request->input('create_sched_hour');
        $scheduleType->status = 'active';
        $scheduleType->created_by = auth()->user()->id;
        $scheduleType->created_at = date('Y-m-d H:i:s');
        $scheduleType->save();

        foreach($workDays as $workDay){
            
            WorkSchedule::insert([
                'schedule_types_id' => $scheduleType->id,
                'work_day' => $workDay,
                'work_from' => $request->input($workDay . '_from'),
                'work_to' => $request->input($workDay . '_to'),
                'break_start' => $request->input($workDay . '_start'),
                'break_end' => $request->input($workDay . '_end'),
                'rest_day' => $request->has($workDay . '_rest'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->back()->with('success', 'New schedule added successfully');
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
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $cr)
    {
        $return_inputs = $cr->all();
        $workDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        schedule_type::where('id',$return_inputs['edit_schedule_profile'])
            ->update([
                'name'=>$return_inputs['edit_profile_name'],
                'working_hours'=>$return_inputs['input_sched_hour']
            ]);
        $array_keys = array_keys($cr->all());
        foreach($workDays as $workDay){
            $work_schedule = WorkSchedule::where('schedule_types_id', $return_inputs['edit_schedule_profile'])
                ->where('work_day', $workDay)
                ->update([
                    'work_from' => $return_inputs[$workDay . '_from'],
                    'work_to' => $return_inputs[$workDay . '_to'],
                    'break_start' => $return_inputs[$workDay . '_start'],
                    'break_end' => $return_inputs[$workDay . '_end'],
                    'rest_day' => in_array($workDay . '_rest', array_keys($return_inputs)) ? 1 : 0
                ]);
        }

        // dd($return_inputs, $work_schedule);
        return redirect()->back()->with('success', 'Existing schedule edited successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }
}
