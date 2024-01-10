<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicInformation extends Model
{
    use HasFactory;
    protected $table = 'basic_information';
    protected $guarded = [];
}
