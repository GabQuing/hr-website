<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\BasicInformation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function basic_information()
    {
        return $this->hasOne(BasicInformation::class);
    }

    public function getAllActiveUsers()
    {
        return $this->whereNull('users.deleted_at');
    }

    public function getActiveEmployees()
    {
        $user_id = DB::table('model_has_roles')->where('role_id', 2)->pluck('model_id');
        return $this->whereNull('users.deleted_at')->whereIn('id', $user_id);
    }

    public function userPayroll()
    {
        return $this->hasMany(EmployeePayroll::class);
    }

    public function workSchedule(): HasMany
    {
        return $this->hasMany(WorkSchedule::class, 'schedule_types_id', 'schedule_types_id');
    }

    public function holidays(): HasMany
    {
        return $this->hasMany(Holiday::class);
    }
}
