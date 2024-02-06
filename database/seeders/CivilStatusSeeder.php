<?php

namespace Database\Seeders;

use App\Models\CivilStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CivilStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $civil_statuses = ['SINGLE', 'MARRIED', 'WIDOWED'];

        foreach ($civil_statuses as $civil_status) {
            CivilStatus::updateOrInsert(['name' => $civil_status], ['name' => $civil_status]);
        }
    }
}
