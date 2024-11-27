-- Count Ready To Use, Out and Pending Status on t_applicator_list

-- All applicators
SELECT 
    COUNT(CASE WHEN status = 'Ready To Use' THEN id END) AS total_rtu,
    COUNT(CASE WHEN status = 'Out' THEN id END) AS total_out,
    COUNT(CASE WHEN status = 'Pending' THEN id END) AS total_pending
FROM 
    t_applicator_list;

-- Group by Car Maker and Car Model
SELECT 
	car_maker,
	car_model,
    COUNT(CASE WHEN status = 'Ready To Use' THEN id END) AS total_rtu,
    COUNT(CASE WHEN status = 'Out' THEN id END) AS total_out,
    COUNT(CASE WHEN status = 'Pending' THEN id END) AS total_pending
FROM 
    t_applicator_list
	GROUP BY 
    car_maker, 
    car_model;

-- Specific Car Maker and Car Model
SELECT 
    COUNT(CASE WHEN status = 'Ready To Use' THEN id END) AS total_rtu,
    COUNT(CASE WHEN status = 'Out' THEN id END) AS total_out,
    COUNT(CASE WHEN status = 'Pending' THEN id END) AS total_pending
FROM 
    t_applicator_list
	WHERE car_maker = ? AND car_model = ?;

-- Count total applicators on m_applicator

-- All applicators
SELECT 
	COUNT(id) AS total_applicator
FROM m_applicator;

-- Group by Car Maker and Car Model
SELECT 
	car_maker,
	car_model,
	COUNT(id) AS total_applicator
FROM m_applicator
	GROUP BY car_maker, car_model;

-- Count total terminals on m_terminal

-- All terminals
SELECT 
	COUNT(id) AS total_terminal
FROM m_terminal;

-- Group by Car Maker and Car Model
SELECT 
	car_maker,
	car_model,
	COUNT(id) AS total_terminal
FROM m_terminal
	GROUP BY car_maker, car_model;

-- Count total applicator with terminal on m_applicator_terminal

-- All applicator with terminal
SELECT 
	COUNT(id) AS total_applicator_terminal
FROM m_applicator_terminal;

-- Count total clean, adjust, replace, repair and beyond the limit on t_applicator_c

-- All results
SELECT 
    COUNT(CASE WHEN adjustment_content = 'Clean' THEN id END) AS total_clean,
    COUNT(CASE WHEN adjustment_content = 'Adjust' THEN id END) AS total_adjust,
	COUNT(CASE WHEN adjustment_content = 'Repair' THEN id END) AS total_replace,
	COUNT(CASE WHEN adjustment_content = 'Replace' THEN id END) AS total_repair,
    COUNT(CASE WHEN adjustment_content = 'Beyond The Limit' THEN id END) AS total_btl
  FROM t_applicator_c;

-- Specific inspection_date_time
SELECT 
    COUNT(CASE WHEN adjustment_content = 'Clean' THEN id END) AS total_clean,
    COUNT(CASE WHEN adjustment_content = 'Adjust' THEN id END) AS total_adjust,
	COUNT(CASE WHEN adjustment_content = 'Repair' THEN id END) AS total_replace,
	COUNT(CASE WHEN adjustment_content = 'Replace' THEN id END) AS total_repair,
    COUNT(CASE WHEN adjustment_content = 'Beyond The Limit' THEN id END) AS total_btl
  FROM t_applicator_c
  WHERE inspection_date_time LIKE '2024-11-03%';

-- Group by Car Maker and Car Model and Specific inspection_date_time
SELECT 
	a.car_maker,
	a.car_model,
    COUNT(CASE WHEN ac.adjustment_content = 'Clean' THEN ac.id END) AS total_clean,
    COUNT(CASE WHEN ac.adjustment_content = 'Adjust' THEN ac.id END) AS total_adjust,
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_replace,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_repair,
    COUNT(CASE WHEN ac.adjustment_content = 'Beyond The Limit' THEN ac.id END) AS total_btl
  FROM t_applicator_c ac
  LEFT JOIN 
    m_applicator a ON 
         ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
         ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
  WHERE ac.inspection_date_time LIKE '2024-11-03%'
  GROUP BY car_maker, car_model;

-- Group by Applicator No, Car Maker and Car Model and Specific inspection_date_time
SELECT 
	a.car_maker,
	a.car_model,
	a.applicator_no,
    COUNT(CASE WHEN ac.adjustment_content = 'Clean' THEN ac.id END) AS total_clean,
    COUNT(CASE WHEN ac.adjustment_content = 'Adjust' THEN ac.id END) AS total_adjust,
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_replace,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_repair,
    COUNT(CASE WHEN ac.adjustment_content = 'Beyond The Limit' THEN ac.id END) AS total_btl
  FROM t_applicator_c ac
  LEFT JOIN 
    m_applicator a ON 
         ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
         ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
  WHERE ac.inspection_date_time LIKE '2024-11-03%'
  GROUP BY car_maker, car_model, applicator_no;

-- Group by Applicator No, Car Maker and Car Model and Specific inspection_date_time range
SELECT 
	a.car_maker,
	a.car_model,
	a.applicator_no,
    COUNT(CASE WHEN ac.adjustment_content = 'Clean' THEN ac.id END) AS total_clean,
    COUNT(CASE WHEN ac.adjustment_content = 'Adjust' THEN ac.id END) AS total_adjust,
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_replace,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_repair,
    COUNT(CASE WHEN ac.adjustment_content = 'Beyond The Limit' THEN ac.id END) AS total_btl
  FROM t_applicator_c ac
  LEFT JOIN 
    m_applicator a ON 
         ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
         ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
  WHERE (ac.inspection_date_time >= '2024-11-03' AND ac.inspection_date_time <= '2024-11-27')
  GROUP BY car_maker, car_model, applicator_no;

-- Group by Applicator No, Car Maker and Car Model and Specific inspection_date_time and applicator_no
SELECT 
	a.car_maker,
	a.car_model,
	a.applicator_no,
    COUNT(CASE WHEN ac.adjustment_content = 'Clean' THEN ac.id END) AS total_clean,
    COUNT(CASE WHEN ac.adjustment_content = 'Adjust' THEN ac.id END) AS total_adjust,
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_replace,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_repair,
    COUNT(CASE WHEN ac.adjustment_content = 'Beyond The Limit' THEN ac.id END) AS total_btl
  FROM t_applicator_c ac
  LEFT JOIN 
    m_applicator a ON 
         ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
         ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
  WHERE ac.inspection_date_time LIKE '2024-11-03%' AND a.applicator_no = '6W-13659-0M/FS-48700'
  GROUP BY car_maker, car_model, applicator_no;


-- Count terminal_name usage on t_applicator_in_out_history
WITH AiohTerminalNameSplit AS (
    SELECT 
		applicator_no,
        SUBSTRING(terminal_name, 1, CHARINDEX('*', terminal_name) - 1) AS terminal_name
    FROM 
        t_applicator_in_out_history
    WHERE 
        confirmation_date LIKE '2024-11-26%'
)
SELECT 
	a.car_maker,
	a.car_model,
	aioh.terminal_name,
	COUNT(aioh.terminal_name) AS total_terminal_usage
FROM AiohTerminalNameSplit aioh
LEFT JOIN m_applicator a ON aioh.applicator_no = a.applicator_no
GROUP BY a.car_maker, a.car_model, aioh.terminal_name;

-- Count terminal_name usage on t_applicator_in_out_history based on confirmation_date range
WITH AiohTerminalNameSplit AS (
    SELECT 
		applicator_no,
        SUBSTRING(terminal_name, 1, CHARINDEX('*', terminal_name) - 1) AS terminal_name
    FROM 
        t_applicator_in_out_history
    WHERE 
        (confirmation_date >= '2024-11-03' AND confirmation_date <= '2024-11-26')
)
SELECT 
	a.car_maker,
	a.car_model,
	aioh.terminal_name,
	COUNT(aioh.terminal_name) AS total_terminal_usage
FROM AiohTerminalNameSplit aioh
LEFT JOIN m_applicator a ON aioh.applicator_no = a.applicator_no
GROUP BY a.car_maker, a.car_model, aioh.terminal_name;

-- Hourly Count of Applicator Out, In and Inspected based on t_applicator_in_out_history

-- date_time_out
WITH Hours AS (
    SELECT 
        number AS hour_list
    FROM 
        master..spt_values
    WHERE 
        type = 'P' AND number BETWEEN 0 AND 23
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        aioh.date_time_out
    FROM 
        t_applicator_in_out_history aioh
	LEFT JOIN 
		m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        (aioh.date_time_out >= '2024-11-26 06:00:00' AND aioh.date_time_out <= '2024-11-27 05:59:59')
		AND a.car_maker = 'Mazda' AND a.car_model = 'J12'
)

SELECT 
    h.hour_list,
    COUNT(fah.applicator_no) AS total_out
FROM 
    Hours h
LEFT JOIN 
    FilteredApplicatorHistory fah ON DATEPART(HOUR, fah.date_time_out) = h.hour_list
LEFT JOIN 
    m_applicator a ON fah.applicator_no = a.applicator_no
GROUP BY 
    h.hour_list
ORDER BY 
    CASE 
        WHEN h.hour_list >= 6 THEN h.hour_list - 6
        ELSE h.hour_list + 18  -- Adjusting hours less than 6 to be after 18
    END;

-- date_time_in
WITH Hours AS (
    SELECT 
        number AS hour_list
    FROM 
        master..spt_values
    WHERE 
        type = 'P' AND number BETWEEN 0 AND 23
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        aioh.date_time_in
    FROM 
        t_applicator_in_out_history aioh
	LEFT JOIN 
		m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        (aioh.date_time_in >= '2024-11-26 06:00:00' AND aioh.date_time_in <= '2024-11-27 05:59:59')
		AND a.car_maker = 'Mazda' AND a.car_model = 'J12'
)

SELECT 
    h.hour_list,
    COUNT(fah.applicator_no) AS total_in
FROM 
    Hours h
LEFT JOIN 
    FilteredApplicatorHistory fah ON DATEPART(HOUR, fah.date_time_in) = h.hour_list
LEFT JOIN 
    m_applicator a ON fah.applicator_no = a.applicator_no
GROUP BY 
    h.hour_list
ORDER BY 
    CASE 
        WHEN h.hour_list >= 6 THEN h.hour_list - 6
        ELSE h.hour_list + 18  -- Adjusting hours less than 6 to be after 18
    END;

-- confirmation_date
WITH Hours AS (
    SELECT 
        number AS hour_list
    FROM 
        master..spt_values
    WHERE 
        type = 'P' AND number BETWEEN 0 AND 23
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        aioh.confirmation_date
    FROM 
        t_applicator_in_out_history aioh
	LEFT JOIN 
		m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        (aioh.confirmation_date >= '2024-11-26 06:00:00' AND aioh.confirmation_date <= '2024-11-27 05:59:59')
		AND a.car_maker = 'Mazda' AND a.car_model = 'J12'
)

SELECT 
    h.hour_list,
    COUNT(fah.applicator_no) AS total_inspected
FROM 
    Hours h
LEFT JOIN 
    FilteredApplicatorHistory fah ON DATEPART(HOUR, fah.confirmation_date) = h.hour_list
LEFT JOIN 
    m_applicator a ON fah.applicator_no = a.applicator_no
GROUP BY 
    h.hour_list
ORDER BY 
    CASE 
        WHEN h.hour_list >= 6 THEN h.hour_list - 6
        ELSE h.hour_list + 18  -- Adjusting hours less than 6 to be after 18
    END;
