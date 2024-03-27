<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserLog;
use App\Models\EmployeePayroll;

class EmployeePayrollController extends Controller
{
    public function index()
    {
        $data = [];
        $data['employees'] = (new User())->getAllActiveUsers()->get();
        
        return view('employee_payroll', $data);
    }

    public function add(Request $request)
    {
        $return_input = $request->all();
        $employee_id = $return_input['pr_employee_id'];
        $date_from = $return_input['pr_date_from'];
        $date_to = $return_input['pr_date_to'];
        $file = $return_input['pr_pdf'];
        
        $file_name = "$date_from to $date_to-$employee_id.".$file->getClientOriginalExtension();
        $file->storeAs('payroll', $file_name);

        EmployeePayroll::create([
            'user_id' => $return_input['pr_employee_id'],
            'from_date' => $date_from,
            'to_date' => $date_to,
            'file_path' => storage_path('app/payroll')."/$file_name"
        ]);

        return redirect()->back()->with('success', 'Payroll successfully added.');

    }
}
