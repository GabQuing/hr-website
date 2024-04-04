<?php

namespace App\Http\Controllers;

use App\Imports\CreateUserAccounts;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BasicInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExcelTemplate;
use DB;
use Storage;

class UserAccountsController extends Controller
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
                ->where('approval_status', 'APPROVED')
                ->leftJoin('model_has_roles as model', 'model.model_id', 'users.id')
                ->leftJoin('roles as privilege', 'privilege.id', 'model.role_id')
                ->select('users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.name',
                    'users.email',
                    'privilege.name as privilege_name',
                    'users.created_at',
                    'users.updated_at',
                    'users.deleted_at',
                    'users.approval_status')
                ->get();
                $data['privilege_roles'] = Role::orderBy('name','DESC')
                ->whereIn('name' ,['employee','admin'])
                ->get();
            
            return view('user_accounts', $data);
        }

    }


    public function retakePhoto(string $id)
    {
        $user = User::withTrashed()->find($id);

        User::find($id)
            ->update(['approval_status' => 'REJECTED',
                'biometric_register' => 0
            ]);
        
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */


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
        $user = User::withTrashed()->find($id);
        $roles = $user->roles;

        return response()->json([
            'user' => $user,
            'roles' => $roles,
        ]);
    
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!is_null(User::find($id))){
            
            $user = User::find($id);
            if(!($user->email == $request->input('email'))){

                $request->validate([
                    'email' => ['required', 'email', 'unique:users,email'],
                ]);

                $user->update([
                    'email' => $request->input('email')
                ]);
                
            }

            // Update user account basic credentials
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'name' => $request->input('first_name').' '.$request->input('last_name'),
                'employee_name' => $request->input('last_name').'_'.$request->input('first_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            // Change Password
            if ($request->has('password') && !empty($request->input('password'))) {
                // Update the password only if a new one is provided
                    $user->password = Hash::make($request->input('password'));
            }

            // Upate user role
            $new_role = Role::where('name', $request->input('privilege_role'))->first();
            $user->roles()->detach();
            $user->syncRoles([$new_role]);
            $user->save();

            return back()->with('success', 'User account has been updated successfully.');
        }else{
            return back()->with('deactivate', "Account is currently deactivated. Updating is not allowed until reactivation.");
        }
        



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::withTrashed()->find($id);
        
        if ($user) {
            $user->updated_at = now();
            $user->delete();
            return back()->with('deactivate', 'User account deactivated successfully.');
        } else {
            return back()->with('deactivate', 'User account not found.');
        }
    }

    public function activate(string $id){
        $user = User::withTrashed()->find($id);
        
        if ($user) {
            $user->updated_at = now();
            $user->deleted_at = null;
            $user->save();
            return back()->with('activate', 'User account activated successfully.');
        } else {
            return back()->with('activate', 'User account not found.');
        }
    }
}
