<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_type extends Model
{
    use HasFactory;
    protected $table = 'employee_types';
    protected $guarded = [];
}
