select
    user_logs.user_id,
    user_logs.log_type_id,
    user_logs.log_date,
    MIN(user_logs.log_time) as earliest,
    MAX(user_logs.log_time) as latest
from user_logs
group by
    user_logs.user_id,
    user_logs.log_type_id,
    user_logs.log_date