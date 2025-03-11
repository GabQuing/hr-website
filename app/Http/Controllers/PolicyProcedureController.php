<?php

namespace App\Http\Controllers;

use App\Models\PayrollCalendar;
use App\Models\PolicyContent;
use Illuminate\Http\Request;

class PolicyProcedureController extends Controller
{
    public function index()
    {
        $payroll_calendar = PayrollCalendar::orderBy('id', 'desc')->first();
        // $attendance_related = AttendanceRelated::orderBy('id', 'desc')->first();

        $data = [
            'payroll_calendar' => $payroll_calendar,
            // 'attendance_related' => $attendance_related,

        ];

        return view('policy_procedure', $data);
    }

    public function addPayrollCalendar(Request $request)
    {
        $image_file = $request->file('image_file');
        $calendar_year = $request->calendar_year;
        $storage_path = 'img/payroll-calendars';
        $image_file_name = "$calendar_year-" . time() . '.' . $image_file->getClientOriginalExtension();
        $image_file->storeAs($storage_path, $image_file_name, 'public');

        PayrollCalendar::create([
            'calendar_year' => $request->calendar_year,
            'file_name' => $image_file_name,
            'file_path' => url('/img/payroll-calendars/' . $image_file_name),
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Payroll calendar successfully updated.');
    }

    public function addNewPolicy(Request $request){

        $request->validate([
            'policy_title' => 'required|string',
            'details' => 'required|string',
        ]);

        $newPolicy = new PolicyContent();
        $newPolicy->title = $request->policy_title;
        $newPolicy->details = $request->details;
        $newPolicy->created_by = auth()->user()->id;
        $newPolicy->save();

        return redirect()->back()->with('success', 'Attendance Related details added successfully!');

    }

    // public function addAttendanceRelated(Request $request){

    // $request->validate([
    //     'details' => 'required|string',
    // ]);

    // // Create new attendance record
    // $attendance = new AttendanceRelated();
    // $attendance->details = $request->details;
    // $attendance->created_by = auth()->user()->id;
    // $attendance->save();

    // return redirect()->back()->with('success', 'Attendance Related details added successfully!');

    // }
    



}
