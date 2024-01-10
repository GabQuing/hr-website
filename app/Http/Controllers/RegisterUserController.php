<?php

namespace App\Http\Controllers;

use App\Models\BasicInformation; 
use App\Models\work_information; 
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use DB;

class RegisterUserController extends Controller
{
    //
    public function index(){

        return view('register');
    }

    public function store(Request $request){

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number' => ['required', 'max:11', 'min:11', 'unique:users' ],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);



        $id = User::insertGetId([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'name' => $request->input('first_name').' '.$request->input('last_name'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'employee_name'=>$request->input('last_name').'_'.$request->input('first_name'),
            'approval_status' => 'PENDING',
            'password' => Hash::make($request->input('password')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $user = User::find((int)$id);
        $user->assignRole('employee');

        $basic_information = new BasicInformation([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $work_information = new work_information([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $basic_information->save();
        $work_information->save();

        return redirect('/register')->with('success', "$id");
    }
}
