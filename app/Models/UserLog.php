<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getAllLogs() {
        return $this->leftJoin('users', 'users.id', 'user_logs.user_id')
            ->leftJoin('log_types', 'log_types.id', 'user_logs.log_type_id')
            ->select(
                'user_logs.*',
                'users.name as user_name',
                'log_types.description as log_type_description',
            )
            ->orderBy('id', 'desc');
    }

    public function getByUserId($user_id) {
        return $this->leftJoin('users', 'users.id', 'user_logs.user_id')
            ->leftJoin('log_types', 'log_types.id', 'user_logs.log_type_id')
            ->select(
                'user_logs.*',
                'users.name as user_name',
                'log_types.description as log_type_description',
            )
            ->where('users.id', $user_id)
            ->orderBy('id', 'desc');
    }

    public function getDetails()
    {
        return $this->where('user_logs.id', $this->id)
            ->leftJoin('log_types', 'log_types.id', 'user_logs.log_type_id')
            ->select(
                'user_logs.*',
                'users.name',
                'log_types.description as log_type',
            )
            ->leftJoin('users', 'users.id', 'user_logs.user_id')
            ->first();
    }
    
}
