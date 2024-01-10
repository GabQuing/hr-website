<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficialBusinessController extends Controller
{
    public function index(){
        
        return view('my_official_business');
    }
}
