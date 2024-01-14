<?php

namespace Database\Seeders;

use App\Models\LogType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $log_types = ['CLOCK IN', 'CLOCK OUT', 'BREAK START', 'BREAK END'];

        foreach ($log_types as $log_type) {
            LogType::updateOrInsert(['description' => $log_type], [
                'description' => $log_type,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
