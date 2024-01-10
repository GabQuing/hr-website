<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OvertimesController extends Controller
{
    
    public function index(Request $request)
    {
        return view('my_overtimes');
    }
}
