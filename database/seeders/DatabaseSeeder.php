<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\LogTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LogTypeSeeder::class);
        $this->call(CivilStatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(EducationTypeSeeder::class);
        $this->call(EmployeeTypeSeeder::class);
        $this->call(EmploymenStatusSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserTypeSeeder::class);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
