SELECT
    user_log_view.`user_id`,
    user_log_view.`log_date`,
    clock_in.earliest as clock_in,
    break_start.earliest as break_start,
    break_end.latest as break_end,
    clock_out.latest as clock_out
from user_log_view
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
    clock_in.earliest,
    break_start.earliest,
    break_end.latest,
    clock_out.latest