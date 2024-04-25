<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeBenefit;
use App\Models\EmployeeBenefitHistory;

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
            ->leftJoin('users as creator', 'creator.id', 'employee_benefits.created_by')
            ->leftJoin('users as updater', 'updater.id', 'employee_benefits.updated_by')
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
        $employee_benefit = EmployeeBenefit::create([
            'user_id' => $request->input('users_id'),
            'health_care' => $request->input('health_care'),
            'vision' => $request->input('vision'),
            'dental' => $request->input('dental'),
            'pregnancy' => $request->input('pregnancy'),
            'created_by' => $accountId,
            'created_at' =>  now(),
        ]);

        EmployeeBenefitHistory::create([
            'employee_benefit_id' => $employee_benefit->id,
            'after_health_care' => $request->input('health_care'),
            'after_vision' => $request->input('vision'),
            'after_dental' => $request->input('dental'),
            'after_pregnancy' => $request->input('pregnancy'),
            'created_by' => $accountId,
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Employee Benefit Generated Successfully!');
    }

    public function edit($id)
    {

        $employeeBenefit = EmployeeBenefit::where('id', $id)
            ->first();

        return $employeeBenefit;
    }

    public function updateEmployeeBenefit(Request $request, $id)
    {
        // dd($request->all());
        $employee_id = auth()->user()->id;
        $updateEmployeeBenefit = EmployeeBenefit::find($id);
        $return_input = $request->all();
        $data = [
            'employee_benefit_id' => $updateEmployeeBenefit->id,
            'before_health_care' => $updateEmployeeBenefit->health_care,
            'after_health_care' => $request->input('health_care'),
            'before_vision' => $updateEmployeeBenefit->vision,
            'after_vision' => $request->input('vision'),
            'before_dental' => $updateEmployeeBenefit->dental,
            'after_dental' => $request->input('dental'),
            'before_pregnancy' => $updateEmployeeBenefit->pregnancy,
            'after_pregnancy' => $request->input('pregnancy'),
            'note' => $request->input('note'),
            'created_by' => $employee_id,
            'created_at' => now(),
        ];

        if (isset($return_input['file'])) {
            $file = $return_input['file'];
            $time = time();
            $file_name = "$id - $time." . $file->getClientOriginalExtension();
            $file->storeAs('benefit', $file_name);
            $data['file_path'] = storage_path('app/benefit') . "/$file_name";
        }


        $history = EmployeeBenefitHistory::create($data);

        $updateEmployeeBenefit->update([
            'health_care' => $request->input('health_care'),
            'vision' => $request->input('vision'),
            'dental' => $request->input('dental'),
            'pregnancy' => $request->input('pregnancy'),
            'updated_by' => $employee_id,
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Employee Benefit has been edited!');
    }

    public function viewEmployeeBenefit($id)
    {
        $benefit = EmployeeBenefit::where('employee_benefits.id', $id)
            ->leftJoin('users as employee', 'employee.id', 'employee_benefits.user_id')
            ->leftJoin('users as creator', 'creator.id', 'employee_benefits.created_by')
            ->leftJoin('users as updater', 'updater.id', 'employee_benefits.updated_by')
            ->select(
                'employee_benefits.*',
                'employee.name as employee_name',
                'creator.name as creator_name',
                'updater.name as updater_name'
            )->first();
        $histories = EmployeeBenefitHistory::where('employee_benefit_id', $id)
            ->leftJoin('users as creator', 'creator.id', 'employee_benefit_histories.created_by')
            ->select(
                'employee_benefit_histories.*',
                'creator.name as creator_name',
            )
            ->orderBy('employee_benefit_histories.created_at', 'DESC')
            ->paginate(10);

        $data = [
            'benefit' => $benefit,
            'histories' => $histories,
        ];

        return view('employee_benefit_view', $data);
    }

    public function downloadReceipt($history_id)
    {
        $benefit_history = EmployeeBenefitHistory::find($history_id);
        if ($benefit_history->file_path && file_exists($benefit_history->file_path)) {
            return response()->download($benefit_history->file_path);
        } else {
            abort(404, 'File not found');
        }
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
