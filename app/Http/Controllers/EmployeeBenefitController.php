<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeBenefit;


class EmployeeBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['usernames'] = (new User())
        ->getAllActiveUsers()
        ->leftJoin('employee_benefits', 'employee_benefits.user_id', 'users.id')
        ->select(
            'users.id',
            'users.name',
            'employee_benefits.id as employee_benefits_id',
        )
        ->get();

        $data['users'] = EmployeeBenefit::leftJoin('users as employee', 'employee.id', 'employee_benefits.user_id')
        ->whereNull('employee.deleted_at')
        ->leftJoin('users as creator', 'creator.id' ,'employee_benefits.created_by')
        ->leftJoin('users as updater', 'updater.id' ,'employee_benefits.updated_by')
        ->select(
            'employee_benefits.*',
            'employee.name as employee_name',
            'creator.name as employee_benefits_created_by',
            'employee_benefits.created_at as employee_benefits_created_at',
            'updater.name as employee_benefits_updated_by',
            'employee_benefits.updated_at as employee_benefits_updated_at',
        )
        ->orderBy('employee_name', 'ASC')
        ->paginate(10);


        return view('employee_benefit', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add(request $request)
    {
        $test = $request->all();
        $accountId = (auth()->user()->id);
        EmployeeBenefit::insert([
            'user_id' => $request->input('users_id'),
            'health_care' => $request->input('health_care'),
            'vision' => $request->input('vision'),
            'dental' => $request->input('dental'),
            'pregnancy' => $request->input('pregnancy'),
            'created_by' => $accountId,
            'created_at' =>  now(),
        ]);
        
        return redirect()->back()->with('success', 'Employee Benefit Generated Successfully!');

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
