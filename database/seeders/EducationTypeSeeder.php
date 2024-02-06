<?php

namespace Database\Seeders;

use App\Models\education_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Foreach_;

class EducationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $education_types = [
            'SECONDARY (JUNIOR HIGH SCHOOL)',
            'SECONDARY (SENIOR HIGH SCHOOL)',
            'VOCATIONAL',
            'TERTIARY (COLLEGE)',
            'POSTGRADUATE (MASTERAL)',
            'POSTGRADUATE (DOCTORAL)',
        ];

        foreach ($education_types as $education_type) {
            $data = ['name' => $education_type];
            education_type::updateOrInsert($data, $data);
        }
    }
}
