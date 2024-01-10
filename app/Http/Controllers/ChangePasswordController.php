<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;


class ChangePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data= [];
        $data['user_info'] = User::where('id', $id)->first();

        return view('/change_password', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function newPassword(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password'
        ]);
        
        $user->password = Hash::make($request->get('password'));
        $user->save();

        DB::table('users')->where('id',$id)->update(['biometric_register' => 1 , 'approval_status' => 'PENDING']);

        return redirect()->back()->with('success','Password Updated, You Will Be Logged-Out.');
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
