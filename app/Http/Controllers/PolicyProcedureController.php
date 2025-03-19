<?php

namespace App\Http\Controllers;

use App\Models\PayrollCalendar;
use App\Models\PolicyContent;
use Illuminate\Http\Request;

class PolicyProcedureController extends Controller
{
    public function index()
    {
        $data['policies'] = PolicyContent::orderBy('created_at', 'asc')->get();

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

    public function updatePolicy(Request $request, $id)
    {
        $request->validate([
            'edit_policy_title' => 'required|string|max:255',
            'edit_policy_details' => 'required|string',
        ]);
    
        $policy = PolicyContent::findOrFail($id);
        
        $policy->title = $request->edit_policy_title;
        $policy->details = $request->edit_policy_details;
        $policy->save();
    
        return redirect()->back()->with('success', 'Policy successfully updated.');
    }

    public function deletePolicy($id)
    {
        $policy = PolicyContent::find($id);
        if ($policy) {
            $policy->deleted_at = now();
            $policy->save();
            return response()->json(['success' => 'Policy successfully deleted.']);
        }
        return response()->json(['error' => 'Policy not found.'], 404);
    }
    

}
