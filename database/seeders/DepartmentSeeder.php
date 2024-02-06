<?php

namespace Database\Seeders;

use App\Models\department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['ADMINISTRATION', 'FOUNDER/OWNER', 'MARKETING', 'OPERATIONS'];

        foreach ($departments as $department) {
            $data = ['name' => $department];
            department::updateOrInsert($data, $data);
        }
    }
}
