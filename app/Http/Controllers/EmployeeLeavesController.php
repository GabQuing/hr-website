<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeLeaves;

class EmployeeLeavesController extends Controller
{
    public function index()
    {

        $data=[];

        $data['usernames'] = (new User())
        ->getAllActiveUsers()
        ->leftJoin('employee_leaves', 'employee_leaves.user_id', 'users.id')
        ->select(
            'users.id',
            'users.name',
            'employee_leaves.id as employee_leaves_id',
        )
        ->get();

        $data['users'] = EmployeeLeaves::leftJoin('users as employee', 'employee.id', 'employee_leaves.user_id')
        ->whereNull('employee.deleted_at')
        ->leftJoin('users as creator', 'creator.id' ,'employee_leaves.created_by')
        ->leftJoin('users as updater', 'updater.id' ,'employee_leaves.updated_by')
        ->select(
            'employee_leaves.*',
            'employee.name as employee_name',
            'creator.name as employee_leaves_created_by',
            'employee_leaves.created_at as employee_leaves_created_at',
            'updater.name as employee_leaves_updated_by',
            'employee_leaves.updated_at as employee_leaves_updated_at',
        )
            ->paginate(10);

        return view('employee_leaves', $data);
    }
    public function add(Request $request)
    {
        $accountId = (auth()->user()->id);
        EmployeeLeaves::insert([
            'user_id' => $request->input('users_id'),
            'vacation_credit' => $request->input('vacation_leave'),
            'sick_credit' => $request->input('sick_leave'),
            'created_by' => $accountId,
            'created_at' => now(),
        ]);
        $request->session()->flash('success', 'Leave Profile Generated Successfully!');
        return redirect()->back();
    }

    public function edit ($id){

        $employeeLeave = EmployeeLeaves::where('id',$id)
        ->first();

        return $employeeLeave;
    }

    public function updateEmployeeLeave(Request $request, $id)
    {
        $employee_id = auth()->user()->id;
        $updateEmployeeLeave = EmployeeLeaves::find($id);

        $updateEmployeeLeave->update([
            'vacation_credit' => $request->input('vacation_leave'),
            'sick_credit' => $request->input('sick_leave'),
            'updated_by' => $employee_id,
            'updated_at' => now(),
        ]);
        $request->session()->flash('success', 'Employee Leave Profile Been Edited!');
        return redirect()->back();
    }
}
