<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyProcedureController extends Controller
{
    public function index(){
        
        return view('policy_procedure');
    }
}
