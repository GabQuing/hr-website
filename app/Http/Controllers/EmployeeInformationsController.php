<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\EditUserAccounts;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Gender;
use App\Models\CivilStatus;
use Spatie\Permission\Models\Role;
use App\Exports\ExcelEditTemplate;
use DB;


class EmployeeInformationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth()->user()->hasRole('employee')){
            return redirect()->back()->with('page_denied', true);
        }else{
            $roleIds = Role::whereIn('name', ['hr', 'employee'])->pluck('id');
            $modelIds = DB::table('model_has_roles')
                ->whereIn('role_id', $roleIds)
                ->pluck('model_id'); 
    
            $data = [];
            $data['user'] = DB::table('users')
                ->whereNull('users.deleted_at')
                ->whereIn('users.id', $modelIds)
                ->leftJoin('model_has_roles as model', 'model.model_id', 'users.id')
                ->leftJoin('roles as privilege', 'privilege.id', 'model.role_id')
                ->select('users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.name',
                    'users.email',
                    'privilege.name as privilege_name',
                    'users.created_at',
                    'users.updated_at')
                ->get();
            return view('employee_information', $data);
        }
    }

    public function downloadEditProfileTemplate() 
    {
        date_default_timezone_set('Asia/Manila');

        $header = [
            'Last Name',
            'Middle Name',
            'First Name',
            'Gender',
            'Civil Status',
            'Date of Birth',
            'Email (Optional)',
            'Mobile Number',
            'Home Address',
            'City',
            'Province',
            'Zip Code',
            'Country',
            'Company',
            'Department',
            'Immediate Supervisor',
            'Designated Work Place',
            'Title',
            'Employee Type',
            'Employment Status',
            'Hire Date',
            'Expected Regularization Date',
            'Regularization Date',
            'User Type',
            'Job Code',
            'Schedule Type',
            'Working Hours',
            'SSS',
            'PhilHealth',
            'TIN',
            'HDMF',
            'Pag-Ibig',
            'Tax Status',
            'Education Type',
            'School',
            'From',
            'To',
            'Degree',
            'Local Trunk Line',
            'Pin',
            'Emergency Contact Number',
            'Emergency Contact Name',
            'Emergency Contact Relationship',
            'Emergency Contact Address'

        ];

        $export = new ExcelEditTemplate([$header]);
        return Excel::download($export, 'Edit-Profile-Template-'.date("Ymd").'-'.date("h.i.sa").'.xls');
    }

    public function editUser(Request $request)
    {
        $excel = $request->all();

        $request->validate([
            'import_accounts' => 'required|mimes:xls,xlsx'
        ]);

        $import = new EditUserAccounts;
        Excel::import($import, $excel['import_accounts']);
        
        return redirect()->back()->with('success', 'Upload Excel Successfully!');
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
