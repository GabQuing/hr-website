<?php

namespace App\Http\Controllers;

use App\Models\OfficialBusiness;
use App\Models\Overtime;
use App\Models\User;
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
        $data['official_businesses'] = OfficialBusiness::leftJoin('users','users.id','official_businesses.created_by')
            ->select(
                'users.*',
                'users.name',
                'official_businesses.*'
            )
            ->where('status', 'PENDING')
            ->get();
        $data['overtimes'] = Overtime::leftJoin('users','users.id','overtimes.created_by')
            ->select(
            'users.*',
            'users.name',
            'overtimes.*'
            )
            ->where('status', 'PENDING')
            ->get();

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

    public function officialBusinessData(Request $request, string $id)
    {
        return OfficialBusiness::find($id);
    }

    public function overtimeData(Request $request, string $id)
    {
        return Overtime::find($id);
    }

    public function obForm(Request $request)
    {
        $user_input = $request->all();
        $ob = OfficialBusiness::find($user_input['ob_id']);
        
        if ($user_input['ob_form_btn'] == 'approve'){
            $ob->update([
                'status' => 'APPROVED',
                'approved_at' => date('Y-m-d H:i:s'),
                'approved_by' => auth()->user()->id
            ]);
        }else {
            $ob->update([
                'status' => 'REJECTED',
                'rejected_at' => date('Y-m-d H:i:s'),
                'rejected_by' => auth()->user()->id
            ]);
        }

        return redirect()->back()->with('ob-success', 'The request has been updated.');
    }

    public function otForm(Request $request)
    {
        $user_input = $request->all();
        $ob = Overtime::find($user_input['ot_id']);
        
        if ($user_input['ot_form_btn'] == 'approve'){
            $ob->update([
                'status' => 'APPROVED',
                'approved_at' => date('Y-m-d H:i:s'),
                'approved_by' => auth()->user()->id
            ]);
        }else {
            $ob->update([
                'status' => 'REJECTED',
                'rejected_at' => date('Y-m-d H:i:s'),
                'rejected_by' => auth()->user()->id
            ]);
        }

        return redirect()->back()->with('ot-success', 'The request has been updated.');    }
}
