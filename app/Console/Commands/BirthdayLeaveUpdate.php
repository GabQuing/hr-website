<?php

namespace App\Console\Commands;

use App\Models\EmployeeLeaves;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BirthdayLeaveUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:birthday-leave-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update employee birthday leave credits';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ph_date = Carbon::now()->setTimezone('Asia/Manila');
        $date_leave_expires = (clone $ph_date)->subDays(30);
        $birthday_todays = User::leftJoin('basic_information', 'users.id', '=', 'basic_information.user_id')
            ->leftJoin('work_informations', 'users.id', '=', 'work_informations.user_id')
            ->whereRaw("MONTH(basic_information.date_of_birth) = $ph_date->month")
            ->whereRaw("DAY(basic_information.date_of_birth) = $ph_date->day")
            ->where('work_informations.employment_status_id', '=', '9')
            ->pluck('users.id')
            ->toArray();

        $birthday_30_days_ago = User::leftJoin('basic_information', 'users.id', '=', 'basic_information.user_id')
            ->leftJoin('work_informations', 'users.id', '=', 'work_informations.user_id')
            ->whereRaw("MONTH(basic_information.date_of_birth) = $date_leave_expires->month")
            ->whereRaw("DAY(basic_information.date_of_birth) = $date_leave_expires->day")
            ->where('work_informations.employment_status_id', '=', '9')
            ->pluck('users.id')
            ->toArray();


        foreach ($birthday_todays as $user_id) {
            EmployeeLeaves::updateOrInsert(['user_id' => $user_id], ['user_id' => $user_id, 'sick_credit' => 1]);
        }

        foreach ($birthday_30_days_ago as $user_id) {
            EmployeeLeaves::updateOrInsert(['user_id' => $user_id], ['user_id' => $user_id, 'sick_credit' => 0]);
        }
        Log::info("Birthday Leave Updated Successfully.");
    }
}
