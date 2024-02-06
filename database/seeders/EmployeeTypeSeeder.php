<?php

namespace Database\Seeders;

use App\Models\employee_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee_types = [
            'EXECUTIVE',
            'MANAGER',
            'OFFICER/SUPERVISOR',
            'RANK AND FILE',
            'RETAINER/CONSULTANT',
        ];

        foreach ($employee_types as $employee_type) {
            $data = ['name' => $employee_type];
            employee_type::updateOrInsert($data, $data);
        }
    }
}
