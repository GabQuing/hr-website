<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeePayroll;

class PayrollController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $data = [];
        $data['payrolls'] = EmployeePayroll::leftJoin('users as head', 'head.id', 'employee_payrolls.created_by')
            ->select(
                'employee_payrolls.*',
                'head.name as created_by_head'
            )
            ->where('user_id', $user_id)
            ->whereNull('employee_payrolls.deleted_at')
            ->paginate(10);

        return view('payroll', $data);
    }
}
