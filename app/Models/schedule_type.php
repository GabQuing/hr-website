<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule_type extends Model
{
    use HasFactory;
    protected $table = 'schedule_types';
    protected $guarded = [];
}
