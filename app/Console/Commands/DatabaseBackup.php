<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a MySQL Backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ds = DIRECTORY_SEPARATOR;

        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD', '');
        $database = env('DB_DATABASE');

        $ts = time();

        $path = storage_path() . $ds . 'backups' . $ds . date('Y', $ts) . $ds . date('m', $ts) . $ds . date('d', $ts) . $ds;
        $file = date('Y-m-d-His', $ts) . '-dump-' . $database . '.sql';
        $command = "mysqldump -h $host -u $username -p $database > $path$ds$file --password=$password --skip-comments --skip-add-locks";

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        exec($command);
    }
}
