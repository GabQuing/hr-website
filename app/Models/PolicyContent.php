<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'policy_contents';

    protected $fillable = [
        'details',
        'created_by',
        'updated_by',
    ];

    // Relationship with User (Optional)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
