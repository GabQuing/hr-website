<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'ADMIN',
                'last_name' => 'CONTROL',
                'name' => 'ADMIN CONTROL',
                'mobile_number' => '09111111111',
                'email' => 'admincontrol@gmail.com',
                'password' => '$2y$10$/iSIo6bLDl.CDyCsTBDct.6OMMXstmhwRNSFwWfQJ9ai7Cim9dQRe',
                'employee_name' => 'CONTROL_ADMIN',
                'schedule_types_id' => '1',
                'biometric_register' => '1',
                'approval_status' => 'APPROVED',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrInsert(['email' => $user['email']], $user);
            $id = User::where('email', $user['email'])->pluck('id')->first();
            $role = ['role_id' => 4, 'model_type' => 'App\Models\User', 'model_id' => $id];
            DB::table('model_has_roles')->updateOrInsert($role, $role);
            DB::table('basic_information')->updateOrInsert(['user_id' => $id], ['user_id' => $id]);
            DB::table('contact_information')->updateOrInsert(['user_id' => $id], ['user_id' => $id]);
            DB::table('education_backgrounds')->updateOrInsert(['user_id' => $id], ['user_id' => $id]);
            DB::table('government_information')->updateOrInsert(['user_id' => $id], ['user_id' => $id]);
            DB::table('work_informations')->updateOrInsert(['user_id' => $id], ['user_id' => $id]);
        }
    }
}
