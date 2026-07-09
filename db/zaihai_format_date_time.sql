UPDATE 
    t_applicator_in_out 
SET 
    days_elapsed_in = CASE 
                            WHEN DATEDIFF(MINUTE, date_time_out, date_time_in) / 1440 > 0 THEN 
                                DATEDIFF(MINUTE, date_time_out, date_time_in) / 1440
                            ELSE 0 
                        END,
    hours_elapsed_in = CASE 
                            WHEN (DATEDIFF(MINUTE, date_time_out, date_time_in) % 1440) / 60 > 0 THEN 
                                (DATEDIFF(MINUTE, date_time_out, date_time_in) % 1440) / 60
                            ELSE 0
                        END,
    minutes_elapsed_in = CASE 
                            WHEN DATEDIFF(MINUTE, date_time_out, date_time_in) % 60 > 0 THEN 
                                DATEDIFF(MINUTE, date_time_out, date_time_in) % 60
                            ELSE 0
                        END,
    saved_elapsed_time_in = dbo.FormatElapsedTime(date_time_out, date_time_in)
WHERE 
    date_time_out IS NOT NULL AND 
    date_time_in IS NOT NULL;

UPDATE 
    t_applicator_in_out_history 
SET 
    days_elapsed_in = CASE 
                            WHEN DATEDIFF(MINUTE, date_time_out, date_time_in) / 1440 > 0 THEN 
                                DATEDIFF(MINUTE, date_time_out, date_time_in) / 1440
                            ELSE 0 
                        END,
    hours_elapsed_in = CASE 
                            WHEN (DATEDIFF(MINUTE, date_time_out, date_time_in) % 1440) / 60 > 0 THEN 
                                (DATEDIFF(MINUTE, date_time_out, date_time_in) % 1440) / 60
                            ELSE 0
                        END,
    minutes_elapsed_in = CASE 
                            WHEN DATEDIFF(MINUTE, date_time_out, date_time_in) % 60 > 0 THEN 
                                DATEDIFF(MINUTE, date_time_out, date_time_in) % 60
                            ELSE 0
                        END,
    saved_elapsed_time_in = dbo.FormatElapsedTime(date_time_out, date_time_in),
    days_elapsed_confirm = CASE 
                                WHEN DATEDIFF(MINUTE, date_time_in, confirmation_date) / 1440 > 0 THEN 
                                    DATEDIFF(MINUTE, date_time_in, confirmation_date) / 1440
                                ELSE 0 
                            END,
    hours_elapsed_confirm = CASE 
                                WHEN (DATEDIFF(MINUTE, date_time_in, confirmation_date) % 1440) / 60 > 0 THEN 
                                    (DATEDIFF(MINUTE, date_time_in, confirmation_date) % 1440) / 60
                                ELSE 0
                            END,
    minutes_elapsed_confirm = CASE 
                                WHEN DATEDIFF(MINUTE, date_time_in, confirmation_date) % 60 > 0 THEN 
                                    DATEDIFF(MINUTE, date_time_in, confirmation_date) % 60
                                ELSE 0
                            END,
    saved_elapsed_time_confirm = dbo.FormatElapsedTime(date_time_in, confirmation_date)
WHERE 
    date_time_out IS NOT NULL AND 
    date_time_in IS NOT NULL AND 
    confirmation_date IS NOT NULL;