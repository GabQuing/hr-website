<?php

namespace App\Http\Controllers;

use App\Models\EmployeeBenefit;
use App\Models\EmployeeBenefitHistory;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        $user_id = auth()->user()->id;

        $data['employee_benefits'] = EmployeeBenefit::where('user_id', $user_id)
            ->first();

        $data['histories'] = EmployeeBenefitHistory::leftJoin('employee_benefits', 'employee_benefits.id', 'employee_benefit_histories.employee_benefit_id')
            ->leftJoin('users as creator', 'creator.id', 'employee_benefit_histories.created_by')
            ->select(
                'employee_benefit_histories.*',
                'creator.name as creator_name',
            )
            ->where('employee_benefits.user_id', $user_id)
            ->orderBy('employee_benefit_histories.created_at', 'DESC')
            ->paginate(10);


        return view('my_benefits', $data);
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
}
