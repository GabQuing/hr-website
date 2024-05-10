<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS `user_log_view`;");
        DB::statement("
            CREATE VIEW `user_log_view` AS
            select
                user_logs.user_id,
                user_logs.log_type_id,
                user_logs.schedule_types_id,
                user_logs.log_date,
                DAYNAME(user_logs.log_date) as day_name,
                MIN(user_logs.log_time) as earliest,
                MAX(user_logs.log_time) as latest
            from user_logs
            group by
                user_logs.user_id,
                user_logs.log_type_id,
                user_logs.log_date,
                user_logs.schedule_types_id
        ");

        DB::statement("DROP VIEW IF EXISTS `attendance_summary`;");
        DB::statement("
            CREATE VIEW `attendance_summary` AS
            SELECT
                user_log_view.`user_id`,
                user_log_view.`schedule_types_id`,
                user_log_view.`log_date`,
                DAYNAME(user_log_view.`log_date`) as day_name,
                clock_in.earliest as clock_in,
                break_start.earliest as break_start,
                break_end.latest as break_end,
                clock_out.latest as clock_out
            from
                user_log_view
                left join (
                    select *
                    from user_log_view
                    where
                        `log_type_id` = 1
                ) as clock_in on clock_in.user_id = user_log_view.`user_id`
                and clock_in.`log_date` = user_log_view.`log_date`
                left join (
                    select *
                    from user_log_view
                    where
                        `log_type_id` = 2
                ) as clock_out on clock_out.user_id = user_log_view.`user_id`
                and clock_out.`log_date` = user_log_view.`log_date`
                left join (
                    select *
                    from user_log_view
                    where
                        `log_type_id` = 3
                ) as break_start on break_start.user_id = user_log_view.`user_id`
                and break_start.`log_date` = user_log_view.`log_date`
                left join (
                    select *
                    from user_log_view
                    where
                        `log_type_id` = 4
                ) as break_end on break_end.user_id = user_log_view.`user_id`
                and break_end.`log_date` = user_log_view.`log_date`
            group BY
                user_log_view.`user_id`,
                user_log_view.`log_date`,
                user_log_view.`schedule_types_id`,
                clock_in.earliest,
                break_start.earliest,
                break_end.latest,
                clock_out.latest
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
