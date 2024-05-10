<?php

namespace App\Http\Controllers;

use App\Models\PayrollCalendar;
use Illuminate\Http\Request;

class PolicyProcedureController extends Controller
{
    public function index()
    {
        $payroll_calendar = PayrollCalendar::orderBy('id', 'desc')->first();
        $data = ['payroll_calendar' => $payroll_calendar];
        // dd($data);

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
}
