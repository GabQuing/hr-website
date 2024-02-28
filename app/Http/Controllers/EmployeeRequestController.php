<?php

namespace App\Http\Controllers;

use App\Models\OfficialBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EmployeeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        $data['official_businesses'] = OfficialBusiness::get();
        $data['overtimes'] = collect([
            ['id' => 1, 'status' => 'PENDING', 'shift_date' => '2024-02-28', 'ot_classification' => '1', 'start_date' => '2024-02-28' , 'start_end' => '2024-02-28', 'created_at' => '2024-02-28 H:i:s'],
            ['id' => 2, 'status' => 'PENDING', 'shift_date' => '2024-03-01', 'ot_classification' => '2', 'start_date' => '2024-03-01' , 'start_end' => '2024-03-01', 'created_at' => '2024-03-01 H:i:s'],
            ['id' => 3, 'status' => 'PENDING', 'shift_date' => '2024-03-02', 'ot_classification' => '3', 'start_date' => '2024-03-02' , 'start_end' => '2024-03-02', 'created_at' => '2024-03-02 H:i:s'],
            ['id' => 4, 'status' => 'PENDING', 'shift_date' => '2024-03-03', 'ot_classification' => '4', 'start_date' => '2024-03-03' , 'start_end' => '2024-03-03', 'created_at' => '2024-03-03 H:i:s'],
            ['id' => 5, 'status' => 'PENDING', 'shift_date' => '2024-03-04', 'ot_classification' => '5', 'start_date' => '2024-03-04' , 'start_end' => '2024-03-04', 'created_at' => '2024-03-04 H:i:s'],
        ]);

        $data['overtimes'] = collect(json_decode(json_encode($data['overtimes']), FALSE));

       
        // dd($dummyCollection);
        return view('employee_request', $data);
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

    public function officialBusinessData(Request $request, string $id){
        return OfficialBusiness::find($id);
    }

    public function overtimeData(Request $request, string $id){
        return OfficialBusiness::find($id);
    }
}
