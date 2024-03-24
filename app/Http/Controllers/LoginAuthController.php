<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class LoginAuthController extends Controller
{
    //
    public function index()
    {
        if (auth()->check()) {
            return redirect()->intended('dashboard1');
        }

        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {

            $email = $request->get('email');
            $password = $request->get('password');

            $permission = DB::table('users')
                ->where('email', $email)
                ->get()
                ->first();

            $user_roles = DB::table('model_has_roles')
                ->where('model_id', $permission->id)
                ->first();
            if (($user_roles->role_id == 4 && Auth::attempt($credentials)) || ($permission->approval_status == 'APPROVED' && Auth::attempt($credentials))) {
                $request->session()->regenerate();

                return redirect()->intended('dashboard1');
            } elseif ($permission->biometric_register == 0 && Auth::attempt($credentials) && $permission->approval_status == 'PENDING') {
                $request->session()->regenerate();
                return redirect()->intended('welcome');
            } elseif ($permission->biometric_register == 1 && Auth::attempt($credentials) && $permission->approval_status == 'PENDING' && Auth::attempt($credentials)) {
                Auth::logout();
                return redirect()->intended('login')->with('forApproval', 'Wait For Admin\'s Approval');
            } elseif ($permission->biometric_register == 0 && Auth::attempt($credentials) && $permission->approval_status == 'REJECTED' && Auth::attempt($credentials)) {
                Auth::logout();
                return redirect()->intended('login')->with('rejected', 'Account Has Been Rejected');
            }
        }

        return back()->withErrors([
            'email' => 'The Provided credentials do not match our records',
            'password' => 'Incorrect Password Or Email Address'
        ])->onlyInput(['email', 'password']);
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }
}
