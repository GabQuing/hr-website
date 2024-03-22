<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaves extends Model
{
    use HasFactory;
    protected $table = 'employee_leaves';
    protected $guarded = [];
}
