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

-- All applicators updated
SELECT 
    COUNT(CASE WHEN status = 'Ready To Use' THEN id END) AS total_rtu,
    COUNT(CASE WHEN status = 'Out' THEN id END) AS total_out,
    COUNT(CASE WHEN status = 'Pending' AND location LIKE '%Zaihai%' THEN id END) AS total_pending_zaihai,
    COUNT(CASE WHEN status = 'Pending' AND location LIKE '%BM%' THEN id END) AS total_pending_bm,
    COUNT(CASE WHEN status = 'Ready To Use' THEN id END) + COUNT(CASE WHEN status = 'Pending' THEN id END) AS total_in
FROM t_applicator_list;

-- Total Applicator, Out and In Counts
WITH 
    applicator_count AS (SELECT COUNT(id) AS total_applicator FROM m_applicator)

SELECT 
    (SELECT total_applicator FROM applicator_count) AS total_applicator,
    COUNT(CASE WHEN at.status = 'Ready To Use' THEN at.id END) + 
    COUNT(CASE WHEN at.status = 'Pending' THEN at.id END) AS total_in,
    COUNT(CASE WHEN at.status = 'Out' THEN at.id END) AS total_out
FROM 
    t_applicator_list at;

-- Applicator Out Count by Car Maker, Car Model and TRD CART Positions on t_applicator_in_out
SELECT
	a.car_maker,
	a.car_model,
    SUM(CASE WHEN aio.trd_no LIKE '%_R1%' THEN 1 ELSE 0 END) AS total_r1,
    SUM(CASE WHEN aio.trd_no LIKE '%_R2%' THEN 1 ELSE 0 END) AS total_r2,
    SUM(CASE WHEN aio.trd_no LIKE '%_F1%' THEN 1 ELSE 0 END) AS total_f1,
    SUM(CASE WHEN aio.trd_no LIKE '%_F2%' THEN 1 ELSE 0 END) AS total_f2
FROM 
	t_applicator_in_out aio
LEFT JOIN
	m_applicator AS a ON aio.applicator_no = a.applicator_no
WHERE
	aio.date_time_in IS NULL AND 
	aio.zaihai_stock_address IS NULL
GROUP BY
	a.car_maker, a.car_model;

-- Total TRD Carts Out Count by Car Maker, Car Model and TRD No. by Applicator Out on t_applicator_in_out
SELECT
	a.car_maker,
	a.car_model,
	(
		CASE 
		WHEN CHARINDEX('TRD', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TRD', trd_no), 6)),'_', '')
		WHEN CHARINDEX('TR', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TR', trd_no), 5)), '_', '')
		ELSE '__FAILURE__'
		END
	) AS trd_no_parsed,
	COUNT(aio.trd_no) - 4 AS total_trd_carts_reuse
FROM 
	t_applicator_in_out aio
LEFT JOIN
	m_applicator AS a ON aio.applicator_no = a.applicator_no
WHERE
	aio.date_time_in IS NULL AND 
	aio.zaihai_stock_address IS NULL
GROUP BY 
    a.car_maker, a.car_model, (
		CASE 
		WHEN CHARINDEX('TRD', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TRD', trd_no), 6)),'_', '')
		WHEN CHARINDEX('TR', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TR', trd_no), 5)), '_', '')
		ELSE '__FAILURE__'
		END
	)
HAVING 
    COUNT(aio.trd_no) > 4 -- Show Greater Than 4 
ORDER BY 
    total_trd_carts_reuse DESC;

-- Total Active TRD Machines Count by Car Maker, Car Model based on t_applicator_in_out Applicator Out Only
WITH FilteredApplicatorInOut AS (
	SELECT
		a.car_maker,
		a.car_model,
		(
			CASE 
			WHEN CHARINDEX('TRD', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TRD', trd_no), 6)),'_', '')
			WHEN CHARINDEX('TR', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TR', trd_no), 5)), '_', '')
			ELSE '__FAILURE__'
			END
		) AS trd_no_parsed
	FROM 
		t_applicator_in_out aio
	LEFT JOIN
		m_applicator AS a ON aio.applicator_no = a.applicator_no
	WHERE
		aio.date_time_in IS NULL AND 
		aio.zaihai_stock_address IS NULL
	GROUP BY
		a.car_maker, a.car_model, (
			CASE 
			WHEN CHARINDEX('TRD', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TRD', trd_no), 6)),'_', '')
			WHEN CHARINDEX('TR', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TR', trd_no), 5)), '_', '')
			ELSE '__FAILURE__'
			END
		)
)
	
SELECT
	car_maker,
	car_model,
	COUNT(trd_no_parsed) AS total_active_trd
FROM
	FilteredApplicatorInOut
GROUP BY
	car_maker, car_model
ORDER BY 
    total_active_trd DESC;





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





-- Combine applicator_counts and terminal_counts Group by Car Maker and Car Model
WITH 
    applicator_counts AS (
        SELECT 
            car_maker,
            car_model,
            COUNT(id) AS total_applicator
        FROM m_applicator
        GROUP BY car_maker, car_model
    ),
    terminal_counts AS (
        SELECT 
            car_maker,
            car_model,
            COUNT(id) AS total_terminal
        FROM m_terminal
        GROUP BY car_maker, car_model
    )

SELECT 
    COALESCE(a.car_maker, t.car_maker) AS car_maker,
    COALESCE(a.car_model, t.car_model) AS car_model,
    COALESCE(a.total_applicator, 0) AS total_applicator,
    COALESCE(t.total_terminal, 0) AS total_terminal
FROM 
    applicator_counts a
FULL OUTER JOIN 
    terminal_counts t ON a.car_maker = t.car_maker AND a.car_model = t.car_model
ORDER BY
	total_applicator DESC, total_terminal DESC;





-- Count total applicator with terminal on m_applicator_terminal

-- All applicator with terminal
SELECT 
	COUNT(id) AS total_applicator_terminal
FROM m_applicator_terminal;





-- Combined Query for applicator_count, terminal_count and applicator_terminal_count
WITH 
    applicator_count AS (SELECT COUNT(id) AS total_applicator FROM m_applicator),
    terminal_count AS (SELECT COUNT(id) AS total_terminal FROM m_terminal),
    applicator_terminal_count AS (SELECT COUNT(id) AS total_applicator_terminal FROM m_applicator_terminal)

SELECT 
    a.total_applicator,
    t.total_terminal,
    at.total_applicator_terminal
FROM 
    applicator_count a,
    terminal_count t,
    applicator_terminal_count at;





-- Count total clean, adjust, replace, repair and beyond the limit on t_applicator_c

-- All results
SELECT 
    COUNT(CASE WHEN adjustment_content = 'Clean' THEN id END) AS total_clean,
    COUNT(CASE WHEN adjustment_content = 'Adjust' THEN id END) AS total_adjust,
	COUNT(CASE WHEN adjustment_content = 'Repair' THEN id END) AS total_repair,
	COUNT(CASE WHEN adjustment_content = 'Replace' THEN id END) AS total_replace,
    COUNT(CASE WHEN adjustment_content = 'Beyond The Limit' THEN id END) AS total_btl
  FROM t_applicator_c;

-- Specific inspection_date_time
SELECT 
    COUNT(CASE WHEN adjustment_content = 'Clean' THEN id END) AS total_clean,
    COUNT(CASE WHEN adjustment_content = 'Adjust' THEN id END) AS total_adjust,
	COUNT(CASE WHEN adjustment_content = 'Repair' THEN id END) AS total_repair,
	COUNT(CASE WHEN adjustment_content = 'Replace' THEN id END) AS total_replace,
    COUNT(CASE WHEN adjustment_content = 'Beyond The Limit' THEN id END) AS total_btl
  FROM t_applicator_c
  WHERE inspection_date_time LIKE '2024-11-03%';

-- Group by Car Maker and Car Model and Specific inspection_date_time
SELECT 
	a.car_maker,
	a.car_model,
    COUNT(CASE WHEN ac.adjustment_content = 'Clean' THEN ac.id END) AS total_clean,
    COUNT(CASE WHEN ac.adjustment_content = 'Adjust' THEN ac.id END) AS total_adjust,
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_repair,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_replace,
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
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_repair,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_replace,
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
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_repair,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_replace,
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
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_repair,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_replace,
    COUNT(CASE WHEN ac.adjustment_content = 'Beyond The Limit' THEN ac.id END) AS total_btl
  FROM t_applicator_c ac
  LEFT JOIN 
    m_applicator a ON 
         ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
         ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
  WHERE ac.inspection_date_time LIKE '2024-11-03%' AND a.applicator_no = '6W-13659-0M/FS-48700'
  GROUP BY car_maker, car_model, applicator_no;

-- Daily Count of (Clean, Adjust, Replace, Repair, Beyond The Limit) Applicator based on t_applicator_c 1 Month (DS & NS) Exact Month
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 10;   -- Specify the month (November)

WITH DateRange AS (
    SELECT 
        DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
    FROM 
        master.dbo.spt_values
    WHERE 
        type = 'P' AND 
        number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
),
FilteredApplicatorHistory AS (
    SELECT 
        a.applicator_no,
        CAST(ac.inspection_date_time AS DATETIME2(2)) AS date_inspected
    FROM 
        t_applicator_c ac
    LEFT JOIN 
        m_applicator a ON 
			ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND 
			ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
    WHERE 
        ac.inspection_date_time >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
        ac.inspection_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
        AND a.car_maker = 'Mazda' AND a.car_model = 'J12' AND ac.adjustment_content = 'Clean'  -- (Clean, Adjust, Replace, Repair, Beyond The Limit)
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
	fah.applicator_no,
    COUNT(fah.applicator_no) AS total_clean
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON 
        fah.date_inspected >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
        fah.date_inspected < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
GROUP BY 
    dr.report_date, fah.applicator_no
ORDER BY 
    dr.report_date, fah.applicator_no;

-- Daily Count per Car Maker, Car Model of (Adjust, Replace, Repair, Beyond The Limit) Applicator 
-- based on t_applicator_c 1 Month (DS & NS) Exact Month
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

SELECT 
	a.car_maker,
	a.car_model,
    COUNT(CASE WHEN ac.adjustment_content = 'Adjust' THEN ac.id END) AS total_adjust,
	COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_repair,
	COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_replace,
    COUNT(CASE WHEN ac.adjustment_content = 'Beyond The Limit' THEN ac.id END) AS total_btl
  FROM t_applicator_c ac
  LEFT JOIN 
    m_applicator a ON 
         ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
         ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
  WHERE 
	ac.inspection_date_time >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
	ac.inspection_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))
  GROUP BY a.car_maker, a.car_model;

-- Daily Count of Car Maker, Car Model (Adjust, Replace, Repair, Beyond The Limit) Applicator 
-- based on t_applicator_c 1 Month (DS & NS) Exact Month
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

WITH DateRange AS (
    SELECT 
        DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
    FROM 
        master.dbo.spt_values
    WHERE 
        type = 'P' AND 
        number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
),
FilteredApplicatorHistory AS (
    SELECT 
		ac.id,
		a.car_maker,
		a.car_model,
		ac.adjustment_content,
		CAST(ac.inspection_date_time AS DATETIME2(2)) AS date_inspected
	FROM t_applicator_c ac
	LEFT JOIN 
		m_applicator a ON 
		ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
		ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
	WHERE 
		ac.inspection_date_time >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
		ac.inspection_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) AND 
        a.car_maker = 'Suzuki' AND a.car_model = 'YV7'
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
	fah.car_maker,
	fah.car_model,
	COUNT(CASE WHEN fah.adjustment_content = 'Adjust' THEN fah.id END) AS total_adjust,
	COUNT(CASE WHEN fah.adjustment_content = 'Repair' THEN fah.id END) AS total_repair,
	COUNT(CASE WHEN fah.adjustment_content = 'Replace' THEN fah.id END) AS total_replace,
	COUNT(CASE WHEN fah.adjustment_content = 'Beyond The Limit' THEN fah.id END) AS total_btl
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON 
        fah.date_inspected >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
        fah.date_inspected < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
GROUP BY 
    dr.report_date, fah.car_maker, fah.car_model
ORDER BY 
    dr.report_date, fah.car_maker, fah.car_model;





-- Count terminal_name usage on t_applicator_in_out_history
WITH AiohTerminalNameSplit AS (
    SELECT 
		applicator_no,
        SUBSTRING(terminal_name, 1, CHARINDEX('*', terminal_name) - 1) AS terminal_name
    FROM 
        t_applicator_in_out_history
    WHERE 
        (date_time_out >= '2024-11-26 06:00:00' AND date_time_out < '2024-11-27 06:00:00')
)
SELECT 
	a.car_maker,
	a.car_model,
	aioh.terminal_name,
	COUNT(aioh.terminal_name) AS total_terminal_usage
FROM AiohTerminalNameSplit aioh
LEFT JOIN m_applicator a ON aioh.applicator_no = a.applicator_no
GROUP BY a.car_maker, a.car_model, aioh.terminal_name;

-- Count terminal_name usage on t_applicator_in_out_history based on date_time_out range
WITH AiohTerminalNameSplit AS (
    SELECT 
		applicator_no,
        SUBSTRING(terminal_name, 1, CHARINDEX('*', terminal_name) - 1) AS terminal_name
    FROM 
        t_applicator_in_out_history
    WHERE 
        (date_time_out >= '2024-11-01 06:00:00' AND date_time_out < '2024-11-30 06:00:00')
)
SELECT 
	a.car_maker,
	a.car_model,
	aioh.terminal_name,
	COUNT(aioh.terminal_name) AS total_terminal_usage
FROM AiohTerminalNameSplit aioh
LEFT JOIN m_applicator a ON aioh.applicator_no = a.applicator_no
GROUP BY a.car_maker, a.car_model, aioh.terminal_name;

-- Daily Count terminal_name usage by Car Maker and Car Model on t_applicator_in_out_history (1 Month - DS & NS) Exact Month
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

WITH DateRange AS (
    SELECT 
        DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
    FROM 
        master.dbo.spt_values
    WHERE 
        type = 'P' AND 
        number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        a.car_maker,
		a.car_model,
		SUBSTRING(aioh.terminal_name, 1, CHARINDEX('*', aioh.terminal_name) - 1) AS terminal_name,
        CAST(aioh.date_time_out AS DATETIME2(2)) AS date_out
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        aioh.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
        aioh.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
        AND SUBSTRING(aioh.terminal_name, 1, CHARINDEX('*', aioh.terminal_name) - 1) = 'ABD-F' AND a.car_maker = 'Mazda' AND a.car_model = 'J12' 
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
	fah.terminal_name,
    fah.car_maker,
	fah.car_model,
    COUNT(fah.terminal_name) AS total_terminal_usage
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON 
        fah.date_out >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
        fah.date_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
GROUP BY 
    dr.report_date, fah.car_maker, fah.car_model, fah.terminal_name
ORDER BY 
    dr.report_date;

-- Daily Count terminal_name usage by All Car Maker and Car Model on t_applicator_in_out_history (1 Month - DS & NS) Exact Month
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

WITH FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
		a.car_maker,
		a.car_model,
		SUBSTRING(aioh.terminal_name, 1, CHARINDEX('*', aioh.terminal_name) - 1) AS terminal_name,
        CAST(aioh.date_time_out AS DATETIME2(2)) AS date_out
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        aioh.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
        aioh.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
        AND SUBSTRING(aioh.terminal_name, 1, CHARINDEX('*', aioh.terminal_name) - 1) = 'ABD-F'
)

SELECT 
	car_maker,
	car_model,
	terminal_name,
    COUNT(terminal_name) AS total_terminal_usage
FROM 
    FilteredApplicatorHistory
GROUP BY 
    car_maker, car_model, terminal_name;





-- Hourly Count of Applicator Out, In and Inspected based on t_applicator_in_out_history (1 Day - DS & NS)

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
        (aioh.date_time_out >= '2024-11-26 06:00:00' AND aioh.date_time_out < '2024-11-27 06:00:00')
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
        (aioh.date_time_in >= '2024-11-26 06:00:00' AND aioh.date_time_in < '2024-11-27 06:00:00')
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
        (aioh.confirmation_date >= '2024-11-26 06:00:00' AND aioh.confirmation_date < '2024-11-27 06:00:00')
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





-- Daily Count of Applicator Out, In and Inspected based on t_applicator_in_out_history (1 Month - DS & NS) Specific Range

-- date_time_out
WITH DateRange AS (
    SELECT CAST('2024-11-01 06:00:00' AS DATETIME2(2)) AS report_date
    UNION ALL
    SELECT DATEADD(DAY, 1, report_date)
    FROM DateRange
    WHERE report_date < '2024-11-28 06:00:00'
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        CAST(aioh.date_time_out AS DATETIME2(2)) AS date_out
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        (aioh.date_time_out >= '2024-11-01 06:00:00' AND aioh.date_time_out < '2024-11-28 06:00:00')
        AND a.car_maker = 'Mazda' AND a.car_model = 'J12'
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
    COUNT(fah.applicator_no) AS total_out
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON fah.date_out >= dr.report_date AND fah.date_out < DATEADD(DAY, 1, dr.report_date)
GROUP BY 
    dr.report_date
ORDER BY 
    dr.report_date;

-- Note: Make sure to enable recursion for the CTE if needed

-- date_time_in
WITH DateRange AS (
    SELECT CAST('2024-11-01 06:00:00' AS DATETIME2(2)) AS report_date
    UNION ALL
    SELECT DATEADD(DAY, 1, report_date)
    FROM DateRange
    WHERE report_date < '2024-11-28 06:00:00'
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        CAST(aioh.date_time_in AS DATETIME2(2)) AS date_in
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        (aioh.date_time_in >= '2024-11-01 06:00:00' AND aioh.date_time_in < '2024-11-28 06:00:00')
        AND a.car_maker = 'Mazda' AND a.car_model = 'J12'
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
    COUNT(fah.applicator_no) AS total_in
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON fah.date_in >= dr.report_date AND fah.date_in < DATEADD(DAY, 1, dr.report_date)
GROUP BY 
    dr.report_date
ORDER BY 
    dr.report_date;

-- Note: Make sure to enable recursion for the CTE if needed

-- confirmation_date
WITH DateRange AS (
    SELECT CAST('2024-11-01 06:00:00' AS DATETIME2(2)) AS report_date
    UNION ALL
    SELECT DATEADD(DAY, 1, report_date)
    FROM DateRange
    WHERE report_date < '2024-11-28 06:00:00'
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        CAST(aioh.confirmation_date AS DATETIME2(2)) AS date_inspected
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        (aioh.confirmation_date >= '2024-11-01 06:00:00' AND aioh.confirmation_date < '2024-11-28 06:00:00')
        AND a.car_maker = 'Mazda' AND a.car_model = 'J12'
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
    COUNT(fah.applicator_no) AS total_inspected
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON fah.date_inspected >= dr.report_date AND fah.date_inspected < DATEADD(DAY, 1, dr.report_date)
GROUP BY 
    dr.report_date
ORDER BY 
    dr.report_date;

-- Note: Make sure to enable recursion for the CTE if needed





-- Daily Count of Applicator Out, In and Inspected based on t_applicator_in_out_history (1 Month - DS & NS) Exact Month

-- date_time_out
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

WITH DateRange AS (
    SELECT 
        DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
    FROM 
        master.dbo.spt_values
    WHERE 
        type = 'P' AND 
        number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        a.car_maker,
        a.car_model,
        CAST(aioh.date_time_out AS DATETIME2(2)) AS date_out
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        aioh.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
        aioh.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
    fah.car_maker,
    fah.car_model,
    COUNT(fah.applicator_no) AS total_inspected
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON 
        fah.date_out >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
        fah.date_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
GROUP BY 
    dr.report_date, fah.car_maker, fah.car_model 
ORDER BY 
    dr.report_date;

-- date_time_in
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

WITH DateRange AS (
    SELECT 
        DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
    FROM 
        master.dbo.spt_values
    WHERE 
        type = 'P' AND 
        number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        a.car_maker,
        a.car_model,
        CAST(aioh.date_time_in AS DATETIME2(2)) AS date_in
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        aioh.date_time_in >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
        aioh.date_time_in < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
        AND a.car_maker = 'Mazda' AND a.car_model = 'J12'
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
    fah.car_maker,
    fah.car_model,
    COUNT(fah.applicator_no) AS total_inspected
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON 
        fah.date_in >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
        fah.date_in < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
GROUP BY 
    dr.report_date, fah.car_maker, fah.car_model 
ORDER BY 
    dr.report_date;

-- confirmation_date
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

WITH DateRange AS (
    SELECT 
        DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
    FROM 
        master.dbo.spt_values
    WHERE 
        type = 'P' AND 
        number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
),
FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        a.car_maker,
        a.car_model,
        CAST(aioh.confirmation_date AS DATETIME2(2)) AS date_inspected
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        aioh.confirmation_date >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
        aioh.confirmation_date < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
        AND a.car_maker = 'Mazda' AND a.car_model = 'J12'
)

SELECT 
    CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
    fah.car_maker,
    fah.car_model,
    COUNT(fah.applicator_no) AS total_inspected
FROM 
    DateRange dr
LEFT JOIN 
    FilteredApplicatorHistory fah ON 
        fah.date_inspected >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
        fah.date_inspected < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
GROUP BY 
    dr.report_date, fah.car_maker, fah.car_model 
ORDER BY 
    dr.report_date;

-- Sample Query for Daily Count of Applicator Out, In and Inspected based on t_applicator_in_out_history All Maker Models 
-- (1 Month - DS & NS) Exact Month
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

WITH FilteredApplicatorHistory AS (
    SELECT 
        aioh.applicator_no,
        a.car_maker,
        a.car_model,
        CAST(aioh.confirmation_date AS DATETIME2(2)) AS date_inspected
    FROM 
        t_applicator_in_out_history aioh
    LEFT JOIN 
        m_applicator a ON aioh.applicator_no = a.applicator_no 
    WHERE 
        aioh.confirmation_date >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
        aioh.confirmation_date < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
)

SELECT 
    car_maker,
    car_model,
    COUNT(applicator_no) AS total
FROM 
    FilteredApplicatorHistory
GROUP BY 
    car_maker, car_model;





-- Average, Max and Standard Deviation of Delay from date_time_out to date_time_in on t_applicator_in_out_history 
-- (1 Month - DS & NS) Specific Range
SELECT 
    b.car_maker,
	b.car_model,
	AVG(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS ave,
    MAX(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS max_diff,
	STDEV(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS std
FROM 
    t_applicator_in_out_history AS a 
LEFT JOIN 
    m_applicator AS b ON a.applicator_no = b.applicator_no
WHERE
    a.date_time_out >= '2024-12-01 06:00:00' AND 
    a.date_time_out < '2025-01-01 06:00:00'
GROUP BY b.car_maker, b.car_model
ORDER BY max_diff DESC;

-- Average, Max and Standard Deviation of Delay from date_time_out to date_time_in on t_applicator_in_out_history 
-- (1 Month - DS & NS) Exact Month
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 11;   -- Specify the month (November)

SELECT 
    b.car_maker,
	b.car_model,
	AVG(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS ave,
    MAX(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS max_diff,
	STDEV(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS std
FROM 
    t_applicator_in_out_history AS a 
LEFT JOIN 
    m_applicator AS b ON a.applicator_no = b.applicator_no
WHERE
    a.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
    a.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))
GROUP BY b.car_maker, b.car_model
ORDER BY max_diff DESC;

-- Average, Max and Standard Deviation of Delay from date_time_out to date_time_in on t_applicator_in_out_history 
-- Per Applicator (1 Month - DS & NS) Exact Month
DECLARE @Year INT = 2024;  -- Specify the year
DECLARE @Month INT = 12;   -- Specify the month (November)

WITH AverageData AS (
    SELECT 
        b.car_maker,
        b.car_model,
		b.applicator_no,
        AVG(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS ave,
        MAX(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS max_diff,
        STDEV(DATEDIFF(MINUTE, date_time_out, date_time_in)) AS std
    FROM 
        t_applicator_in_out_history AS a 
    LEFT JOIN 
        m_applicator AS b ON a.applicator_no = b.applicator_no
    WHERE
        a.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
        a.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))
    GROUP BY b.car_maker, b.car_model, b.applicator_no
)

SELECT 
    car_maker,
    car_model,
	applicator_no,
    ave,
    -- Use the ave column for ave_elapsed_time
    CASE 
        WHEN ave < 1 THEN '< 1 min' 
        ELSE 
            LTRIM(
                CASE 
                    WHEN ave / 1440 > 0 THEN 
                        CAST(ave / 1440 AS VARCHAR(10)) + ' day' + 
                        CASE WHEN ave / 1440 <> 1 THEN 's' ELSE '' END + 
                        CASE WHEN (ave % 1440) / 60 > 0 OR ave % 60 > 0 THEN ', ' ELSE '' END
                    ELSE '' 
                END +
                CASE 
                    WHEN (ave % 1440) / 60 > 0 THEN 
                        CAST((ave % 1440) / 60 AS VARCHAR(10)) + ' hour' + 
                        CASE WHEN (ave % 1440) / 60 <> 1 THEN 's' ELSE '' END + 
                        CASE WHEN ave % 60 > 0 THEN ', ' ELSE '' END
                    ELSE '' 
                END +
                CASE 
                    WHEN ave % 60 > 0 THEN 
                        CAST(ave % 60 AS VARCHAR(10)) + ' min' + 
                        CASE WHEN ave % 60 <> 1 THEN 's' ELSE '' END 
                    ELSE '' 
                END
            ) 
    END AS ave_elapsed_time,
    max_diff,
	-- Use the ave column for ave_elapsed_time
    CASE 
        WHEN max_diff < 1 THEN '< 1 min' 
        ELSE 
            LTRIM(
                CASE 
                    WHEN max_diff / 1440 > 0 THEN 
                        CAST(max_diff / 1440 AS VARCHAR(10)) + ' day' + 
                        CASE WHEN max_diff / 1440 <> 1 THEN 's' ELSE '' END + 
                        CASE WHEN (max_diff % 1440) / 60 > 0 OR ave % 60 > 0 THEN ', ' ELSE '' END
                    ELSE '' 
                END +
                CASE 
                    WHEN (max_diff % 1440) / 60 > 0 THEN 
                        CAST((max_diff % 1440) / 60 AS VARCHAR(10)) + ' hour' + 
                        CASE WHEN (max_diff % 1440) / 60 <> 1 THEN 's' ELSE '' END + 
                        CASE WHEN max_diff % 60 > 0 THEN ', ' ELSE '' END
                    ELSE '' 
                END +
                CASE 
                    WHEN max_diff % 60 > 0 THEN 
                        CAST(max_diff % 60 AS VARCHAR(10)) + ' min' + 
                        CASE WHEN max_diff % 60 <> 1 THEN 's' ELSE '' END 
                    ELSE '' 
                END
            ) 
    END AS max_diff_elapsed_time,
    std
FROM 
    AverageData
ORDER BY max_diff DESC;






-- Elapsed Days of Delay from date_time_out to today on t_applicator_in_out
SELECT
    b.car_maker,
    b.car_model,
    a.applicator_no,
    operator_out AS contact_person,
    -- Conditional formatting for elapsed time
    CASE 
        WHEN DATEDIFF(MINUTE, date_time_out, GETDATE()) < 1 THEN '< 1 min' 
        ELSE 
            -- Build the elapsed time string conditionally
            LTRIM(
                CASE 
                    WHEN DATEDIFF(MINUTE, date_time_out, GETDATE()) / 1440 > 0 THEN 
                        CAST(DATEDIFF(MINUTE, date_time_out, GETDATE()) / 1440 AS VARCHAR(10)) + ' day' + 
                        CASE WHEN DATEDIFF(MINUTE, date_time_out, GETDATE()) / 1440 <> 1 THEN 's' ELSE '' END + 
                        CASE WHEN (DATEDIFF(MINUTE, date_time_out, GETDATE()) % 1440) / 60 > 0 OR DATEDIFF(MINUTE, date_time_out, GETDATE()) % 60 > 0 THEN ', ' ELSE '' END
                    ELSE '' 
                END +
                CASE 
                    WHEN (DATEDIFF(MINUTE, date_time_out, GETDATE()) % 1440) / 60 > 0 THEN 
                        CAST((DATEDIFF(MINUTE, date_time_out, GETDATE()) % 1440) / 60 AS VARCHAR(10)) + ' hour' + 
                        CASE WHEN (DATEDIFF(MINUTE, date_time_out, GETDATE()) % 1440) / 60 <> 1 THEN 's' ELSE '' END + 
                        CASE WHEN DATEDIFF(MINUTE, date_time_out, GETDATE()) % 60 > 0 THEN ', ' ELSE '' END
                    ELSE '' 
                END +
                CASE 
                    WHEN DATEDIFF(MINUTE, date_time_out, GETDATE()) % 60 > 0 THEN 
                        CAST(DATEDIFF(MINUTE, date_time_out, GETDATE()) % 60 AS VARCHAR(10)) + ' min' + 
                        CASE WHEN DATEDIFF(MINUTE, date_time_out, GETDATE()) % 60 <> 1 THEN 's' ELSE '' END 
                    ELSE '' 
                END
            ) 
    END AS elapsed_time
FROM t_applicator_in_out AS a
LEFT JOIN m_applicator AS b ON a.applicator_no = b.applicator_no
WHERE date_time_out IS NOT NULL AND date_time_in IS NULL
ORDER BY date_time_out ASC;

-- Elapsed Days of Delay from date_updated to today on t_applicator_list
SELECT
    car_maker,
    car_model,
    applicator_no,
	location,
	status,
    -- Conditional formatting for elapsed time
    CASE 
        WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) < 1 THEN '< 1 min' 
        ELSE 
            -- Build the elapsed time string conditionally
            LTRIM(
                CASE 
                    WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) / 1440 > 0 THEN 
                        CAST(DATEDIFF(MINUTE, date_updated, GETDATE()) / 1440 AS VARCHAR(10)) + ' day' + 
                        CASE WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) / 1440 <> 1 THEN 's' ELSE '' END + 
                        CASE WHEN (DATEDIFF(MINUTE, date_updated, GETDATE()) % 1440) / 60 > 0 OR DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 > 0 THEN ', ' ELSE '' END
                    ELSE '' 
                END +
                CASE 
                    WHEN (DATEDIFF(MINUTE, date_updated, GETDATE()) % 1440) / 60 > 0 THEN 
                        CAST((DATEDIFF(MINUTE, date_updated, GETDATE()) % 1440) / 60 AS VARCHAR(10)) + ' hour' + 
                        CASE WHEN (DATEDIFF(MINUTE, date_updated, GETDATE()) % 1440) / 60 <> 1 THEN 's' ELSE '' END + 
                        CASE WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 > 0 THEN ', ' ELSE '' END
                    ELSE '' 
                END +
                CASE 
                    WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 > 0 THEN 
                        CAST(DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 AS VARCHAR(10)) + ' min' + 
                        CASE WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 <> 1 THEN 's' ELSE '' END 
                    ELSE '' 
                END
            ) 
    END AS elapsed_time,
	date_updated,
    -- Downtime column
    CASE 
        WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) > 1440 THEN 1 
        ELSE 0 
    END AS downtime
FROM t_applicator_list
ORDER BY status ASC, date_updated ASC;
