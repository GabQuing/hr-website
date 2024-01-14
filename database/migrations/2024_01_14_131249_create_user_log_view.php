<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * View name.
     */
    protected $viewName = 'user_log_view';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS $this->viewName");

        $sql = "
        CREATE VIEW $this->viewName AS
        SELECT
            user_logs.user_id,
            user_logs.log_type_id,
            user_logs.log_date,
            MIN(user_logs.log_time) as earliest,
            MAX(user_logs.log_time) as latest
        FROM user_logs
        GROUP BY
            user_logs.user_id,
            user_logs.log_type_id,
            user_logs.log_date        
        ";
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $sql = "DROP VIEW IF EXISTS $this->viewName";

        DB::statement($sql);
    }
};
