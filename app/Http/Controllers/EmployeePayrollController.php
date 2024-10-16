<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserLog;
use App\Models\EmployeePayroll;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class EmployeePayrollController extends Controller
{

    public function index()
    {
        $data = [];
        $data['employees'] = (new User())
            ->getActiveEmployees()
            ->orderBy('users.name', 'asc')
            ->paginate(10);
        $data['payrolls'] = EmployeePayroll::leftJoin('users as employee', 'employee.id', 'employee_payrolls.user_id')
            ->leftJoin('users as head', 'head.id', 'employee_payrolls.created_by')
            ->select(
                'employee_payrolls.*',
                'employee.name as name',
                'head.name as created_by_head'
            )
            ->orderBy('id', 'desc')
            ->whereNull('employee_payrolls.deleted_at')
            ->paginate(10);

        return view('employee_payroll', $data);
    }

    public function add(Request $request, $id)
    {
        $return_input = $request->all();
        $employee_id = $id;
        // $employee_id = $return_input['pr_employee_id'];
        $date_from = $return_input['pr_date_from'];
        $date_to = $return_input['pr_date_to'];
        $file = $return_input['pr_pdf'];

        $file_name = "$date_from to $date_to-$employee_id." . $file->getClientOriginalExtension();
        $file->storeAs('payroll', $file_name);

        EmployeePayroll::create([
            'user_id' => $id,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'file_name' => $file_name,
            'file_path' => storage_path('app/payroll') . "/$file_name",
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Payroll successfully added.');
    }

    public function update(Request $request, $id)
    {
        $return_input = $request->all();
        $date_from = $return_input['pr_date_from'];
        $date_to = $return_input['pr_date_to'];
        $hasFile = $request->hasFile('pr_pdf');

        $employee_payroll = EmployeePayroll::find($id);
        $employee_id = $employee_payroll->user_id;

        $employee_payroll->update([
            'from_date' => $date_from,
            'to_date' => $date_to,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($hasFile) {
            $file = $return_input['pr_pdf'];
            $file_name = "$date_from to $date_to-$employee_id." . $file->getClientOriginalExtension();
            $file->storeAs('payroll', $file_name);

            $employee_payroll->update([
                'file_name' => $file_name,
                'file_path' => storage_path('app/payroll') . "/$file_name",
            ]);
        }

        return redirect()->back()->with('success', 'Payroll edited successfully.');
    }

    public function edit($id)
    {
        $data = [];
        $data['employees'] = (new User())->getActiveEmployees()->get();
        $data['payroll'] = EmployeePayroll::find($id);
        $file_name = $data['payroll']->file_name;

        return view('employee_payroll_edit', $data);
    }

    public function view($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['user'] = User::with('basic_information')->find($id);
        $data['payroll'] = EmployeePayroll::find($id);
        $data['payrolls'] = EmployeePayroll::where('user_id', $id)->leftJoin('users as employee', 'employee.id', 'employee_payrolls.user_id')
            ->leftJoin('users as head', 'head.id', 'employee_payrolls.created_by')
            ->select(
                'employee_payrolls.*',
                'employee.name as name',
                'head.name as created_by_head'
            )
            ->orderBy('id', 'desc')
            ->whereNull('employee_payrolls.deleted_at')
            ->paginate(10);

        return view('employee_payroll_view', $data);
    }

    public function saveEdit(Request $request)
    {
        $return_input = $request->all();
        dd($return_input);
    }

    public function showPDF($file_name)
    {
        $pathToFile = storage_path("app/payroll/$file_name");
        $fileContents = Storage::get("payroll/$file_name");

        return Response::make($fileContents, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $file_name . '"'
        ]);
    }

    public function deletePayroll(Request $request)
    {
        EmployeePayroll::find($request->id)->update(['deleted_at' => now()]);
        return redirect()->back()->with('success', 'Payroll deleted successfully.');
    }

    public function downloadPDF(Request $request)
    {
        $path = storage_path("app/payroll/$request->payroll_name");
        return Response::download($path);
    }
}
