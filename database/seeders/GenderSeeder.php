<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = ['MALE', 'FEMALE'];

        foreach ($genders as $gender) {
            $data = ['name' => $gender];
            Gender::updateOrInsert($data, $data);
        }
    }
}
