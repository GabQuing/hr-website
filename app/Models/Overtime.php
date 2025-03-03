<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Overtime extends Model
{
    use HasFactory;
    protected $table = 'overtimes';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->user;
    }

    public function approver(): HasOne
    {
        return $this->hasOne(User::class, 'approved_by', 'id');
    }

    public function workSchedule(): HasMany
    {
        return $this->hasMany(WorkSchedule::class, 'schedule_types_id', 'schedule_types_id');
    }
}
