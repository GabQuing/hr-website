<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class immediate_supervisor extends Model
{
    use HasFactory;
    protected $table = 'immediate_supervisors';
    protected $guarded = [];
}
