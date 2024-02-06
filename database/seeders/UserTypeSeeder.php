<?php

namespace Database\Seeders;

use App\Models\user_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_types = [
            'ADMIN',
            'CONSULTANT',
            'EMPLOYEE',
            'INTERN (ACTIVE)',
            'INTERN (ENDED)',
            'MANAGER',
        ];

        foreach ($user_types as $user_type) {
            $data = ['name' => $user_type];
            user_type::updateOrInsert($data, $data);
        }
    }
}
