<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeLeavesController extends Controller
{
    public function index()
    {

        return view('employee_leaves');
    }
}
