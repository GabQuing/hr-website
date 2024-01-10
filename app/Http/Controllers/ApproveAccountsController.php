<?php

namespace App\Http\Controllers;

use App\Imports\CreateUserAccounts;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BasicInformation;
use App\Models\work_information;
use App\Models\GovernmentInformation;
use App\Models\EducationBackground;
use App\Models\ContactInformation;
use App\Models\WorkSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExcelTemplate;
use DB;
use Storage;

class ApproveAccountsController extends Controller
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
                ->whereIn('users.approval_status', ['PENDING', 'REJECTED'])
                ->whereIn('users.id', $modelIds)
                ->leftJoin('model_has_roles as model', 'model.model_id', 'users.id')
                ->leftJoin('roles as privilege', 'privilege.id', 'model.role_id')
                ->select('users.id',
                    'users.mobile_number',
                    'users.first_name',
                    'users.last_name',
                    'users.email',
                    'privilege.name as privilege_name',
                    'users.created_at',
                    'users.updated_at',
                    'users.biometric_register',
                    'users.deleted_at',
                    'users.approval_status')
                ->get();
            $data['privilege_roles'] = Role::orderBy('name')
                ->where('name', '!=' ,'admin')
                ->where('name', '!=', 'user')
                ->get();
    
            return view('approve_accounts', $data);
        }

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
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number' => ['required', 'max:11', 'min:11', 'unique:users' ],
            'password' => ['required', 'string', 'min:8']
        ]);
        
        $id = User::insertGetId([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'name' => $request->input('first_name').' '.$request->input('last_name'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $user = User::find((int)$id);
        $user->assignRole($request->input('privilege_role'));

        $basic_information = BasicInformation::insert([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return back()->with('success', 'New account has been added.');

    }

    public function add(Request $request)
    {
        $firstName = strtoupper($request->input('first_name'));
        $lastName = strtoupper($request->input('last_name'));

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number' => ['max:11', 'min:11', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        

        $id = User::insertGetId([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $firstName.' '.$lastName,
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'employee_name' => $lastName.'_'.$firstName,
            'approval_status' => 'PENDING',
            'password' => Hash::make($request->input('password')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $user = User::find((int)$id);
        $user->assignRole($request->input('privilege_role'));

        $basic_information = new BasicInformation([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $work_information = new work_information([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $government_information = new GovernmentInformation([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $education_background = new EducationBackground([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $contact_information = new ContactInformation([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // $workDaysArray=[];

        // $workDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        // foreach($workDays as $days){
        //     $workDaysArray[] = [
        //         'user_id' => $id,
        //         'work_day' => $days,
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ];
        // }

        // dd($workDaysArray);




        $basic_information->save();
        $work_information->save();
        $government_information->save();
        $education_background->save();
        $contact_information->save();
        // $work_schedule = WorkSchedule::insert($workDaysArray);

        return redirect()->back()->with('success', 'New account has been added.');

    }
    public function downloadNewEmployeeTemplate() 
    {
        date_default_timezone_set('Asia/Manila');

        $header = ['Email','First Name', 'Last Name', 'Mobile Number','Temporary Password'];

        $export = new ExcelTemplate([$header]);
        return Excel::download($export, 'Add-New-Employee-'.date("Ymd").'-'.date("h.i.sa").'.xls');
    }

    public function importUser(Request $request)
    {
        $excel = $request->all();

        $request->validate([
            'import_accounts' => 'required|mimes:xls,xlsx'
        ]);

        $import = new CreateUserAccounts;
        Excel::import($import, $excel['import_accounts']);
        
        return redirect()->back()->with('success', 'Upload Excel Successfully!');
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
    public function edit($id)
    {

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function decline(string $id)
    {
        $user = User::withTrashed()->find($id);

        User::find($id)
            ->update(['approval_status' => 'REJECTED',
                'biometric_register' => 0
            ]);
        
        return redirect()->back();
        // if ($user) {
        //     $user->updated_at = now();
        //     $user->delete();
        //     return back()->with('deactivate', 'User account deactivated successfully.');
        // } else {
        //     return back()->with('deactivate', 'User account not found.');
        // }
    }
    public function displayPhoto(Request $request)
    {
        $user_id = $request->input('userId');
    
        $user_info = DB::table('users')->where('id', $user_id)->first();
    
        $photoPath1 = Storage::disk('google')->url("labels/{$user_info->employee_name}/1.png");
        $photoPath2 = Storage::disk('google')->url("labels/{$user_info->employee_name}/2.png");
        
        return response()->json(['photo' => $photoPath1, 'photo2' => $photoPath2, 'id' => $user_id]);
    }

    public function accept(string $id){
        $user = User::withTrashed()->find($id);
        
        User::find($id)
            ->update(['approval_status' => 'APPROVED',
                'approved_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back();
        // if ($user) {
        //     $user->updated_at = now();
        //     $user->deleted_at = null;
        //     $user->save();
        //     return back()->with('activate', 'User account activated successfully.');
        // } else {
        //     return back()->with('activate', 'User account not found.');
        // }
    }
}
