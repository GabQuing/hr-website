<?php

namespace Database\Seeders;

use App\Models\company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['name' => 'LURTSEMA COMMUNICATIONS'];
        company::updateOrInsert($data, $data);
    }
}
