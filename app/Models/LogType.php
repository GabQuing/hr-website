<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getByDescription($descripion)
    {
        return $this->where('description', $descripion)->first();
    }
}
