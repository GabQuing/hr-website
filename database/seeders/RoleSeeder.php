<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['user', 'employee', 'hr', 'admin'];

        foreach ($roles as $role) {
            $data = ['name' => $role];
            DB::table('roles')->updateOrInsert($data, $data + ['guard_name' => 'web']);
        }
    }
}
