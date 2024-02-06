<?php

namespace Database\Seeders;

use App\Models\employment_status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymenStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employment_statuses = [
            'AWOL',
            'CONTRACTUAL/PROJECT BASED',
            'END OF CONTRACT',
            'MATERNITY LEAVE',
            'OJT',
            'PART-TIME',
            'PATERNITY LEAVE',
            'PROBATIONARY',
            'REGULAR',
            'RESIGNED',
            'SABBATICAL LEAVE',
            'TERMINATED',
        ];

        foreach ($employment_statuses as $employment_status) {
            $data = ['name' => $employment_status];
            employment_status::updateOrInsert($data, $data);
        }
    }
}
