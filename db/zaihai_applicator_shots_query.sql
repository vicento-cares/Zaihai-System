-- Current Applicator Shots Exceeded Count

SELECT 
	COUNT(
		CASE 
			WHEN 
				[shotcnt_u_ee_status] = 'Good' AND 
				[shotcnt_d_ee_status] = 'Good' AND 
				[shotcnt_i_u_ee_status] = 'Good' AND 
				[shotcnt_i_d_ee_status] = 'Good' AND 
				[shotcnt_c_ee_status] = 'Good' 
			THEN applicator_no 
		END
	) AS total_appshot_good_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Good' AND 
				[shotcnt_d_ee_status] = 'Good' AND 
				[shotcnt_i_u_ee_status] = 'Good' AND 
				[shotcnt_i_d_ee_status] = 'Good' AND 
				[shotcnt_c_ee_status] = 'Good') AND 
				is_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_good_prio_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Good' AND 
				[shotcnt_d_ee_status] = 'Good' AND 
				[shotcnt_i_u_ee_status] = 'Good' AND 
				[shotcnt_i_d_ee_status] = 'Good' AND 
				[shotcnt_c_ee_status] = 'Good') AND 
				is_prod_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_good_prod_prio_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Good' AND 
				[shotcnt_d_ee_status] = 'Good' AND 
				[shotcnt_i_u_ee_status] = 'Good' AND 
				[shotcnt_i_d_ee_status] = 'Good' AND 
				[shotcnt_c_ee_status] = 'Good') AND 
				is_priority = 0 AND is_prod_priority = 0 
			THEN applicator_no 
		END
	) AS total_appshot_good_normal_ee,
	COUNT(
		CASE 
			WHEN 
				[shotcnt_u_qa_status] = 'Good' AND 
				[shotcnt_d_qa_status] = 'Good' AND 
				[shotcnt_i_u_qa_status] = 'Good' AND 
				[shotcnt_i_d_qa_status] = 'Good' AND 
				[shotcnt_c_qa_status] = 'Good' 
			THEN applicator_no 
		END
	) AS total_appshot_good_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Good' AND 
				[shotcnt_d_qa_status] = 'Good' AND 
				[shotcnt_i_u_qa_status] = 'Good' AND 
				[shotcnt_i_d_qa_status] = 'Good' AND 
				[shotcnt_c_qa_status] = 'Good') AND 
				is_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_good_prio_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Good' AND 
				[shotcnt_d_qa_status] = 'Good' AND 
				[shotcnt_i_u_qa_status] = 'Good' AND 
				[shotcnt_i_d_qa_status] = 'Good' AND 
				[shotcnt_c_qa_status] = 'Good') AND 
				is_prod_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_good_prod_prio_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Good' AND 
				[shotcnt_d_qa_status] = 'Good' AND 
				[shotcnt_i_u_qa_status] = 'Good' AND 
				[shotcnt_i_d_qa_status] = 'Good' AND 
				[shotcnt_c_qa_status] = 'Good') AND 
				is_priority = 0 AND is_prod_priority = 0
			THEN applicator_no 
		END
	) AS total_appshot_good_normal_qa,
    COUNT(CASE WHEN [shotcnt_u_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_u_ee_good,
	COUNT(CASE WHEN [shotcnt_d_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_d_ee_good,
	COUNT(CASE WHEN [shotcnt_i_u_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_i_u_ee_good,
	COUNT(CASE WHEN [shotcnt_i_d_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_i_d_ee_good,
	COUNT(CASE WHEN [shotcnt_c_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_c_ee_good,
	COUNT(CASE WHEN [shotcnt_u_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_u_qa_good,
	COUNT(CASE WHEN [shotcnt_d_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_d_qa_good,
	COUNT(CASE WHEN [shotcnt_i_u_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_i_u_qa_good,
	COUNT(CASE WHEN [shotcnt_i_d_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_i_d_qa_good,
	COUNT(CASE WHEN [shotcnt_c_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_c_qa_good, 
	COUNT(
		CASE 
			WHEN 
				[shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				is_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_prio_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				is_prod_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_prod_prio_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				is_priority = 0 AND is_prod_priority = 0 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_normal_ee,
	COUNT(
		CASE 
			WHEN 
				[shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				is_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_prio_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				is_prod_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_prod_prio_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				is_priority = 0 AND is_prod_priority = 0
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_normal_qa,
    COUNT(CASE WHEN [shotcnt_u_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_u_ee_exceeded,
	COUNT(CASE WHEN [shotcnt_d_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_d_ee_exceeded,
	COUNT(CASE WHEN [shotcnt_i_u_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_i_u_ee_exceeded,
	COUNT(CASE WHEN [shotcnt_i_d_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_i_d_ee_exceeded,
	COUNT(CASE WHEN [shotcnt_c_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_c_ee_exceeded,
	COUNT(CASE WHEN [shotcnt_u_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_u_qa_exceeded,
	COUNT(CASE WHEN [shotcnt_d_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_d_qa_exceeded,
	COUNT(CASE WHEN [shotcnt_i_u_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_i_u_qa_exceeded,
	COUNT(CASE WHEN [shotcnt_i_d_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_i_d_qa_exceeded,
	COUNT(CASE WHEN [shotcnt_c_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_c_qa_exceeded 
FROM v_t_applicator_shots;

-- Current Total Applicators Good VS Exceeded EE by Car Maker, Car Model

SELECT 
	car_maker,
	car_model,
	COUNT(
		CASE 
			WHEN 
				[shotcnt_u_ee_status] = 'Good' AND 
				[shotcnt_d_ee_status] = 'Good' AND 
				[shotcnt_i_u_ee_status] = 'Good' AND 
				[shotcnt_i_d_ee_status] = 'Good' AND 
				[shotcnt_c_ee_status] = 'Good' 
			THEN applicator_no 
		END
	) AS total_appshot_good_ee,
	COUNT(
		CASE 
			WHEN 
				[shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_ee 
FROM 
	v_t_applicator_shots
GROUP BY 
	car_maker, 
	car_model;

-- Current Total Applicators Good VS Exceeded QA by Car Maker, Car Model

SELECT 
	car_maker,
	car_model,
	COUNT(
		CASE 
			WHEN 
				[shotcnt_u_qa_status] = 'Good' AND 
				[shotcnt_d_qa_status] = 'Good' AND 
				[shotcnt_i_u_qa_status] = 'Good' AND 
				[shotcnt_i_d_qa_status] = 'Good' AND 
				[shotcnt_c_qa_status] = 'Good' 
			THEN applicator_no 
		END
	) AS total_appshot_good_qa,
	COUNT(
		CASE 
			WHEN 
				[shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_qa 
FROM 
	v_t_applicator_shots
GROUP BY 
	car_maker, 
	car_model;

-- Current Total Applicators Exceeded EE based on priority

SELECT 
	car_maker,
	car_model,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				is_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_prio_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				is_prod_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_prod_prio_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				is_priority = 0 AND is_prod_priority = 0 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_normal_ee 
FROM 
	v_t_applicator_shots
GROUP BY 
	car_maker, 
	car_model;

-- Current Total Applicators Exceeded QA based on priority

SELECT 
	car_maker,
	car_model,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				is_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_prio_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				is_prod_priority = 1 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_prod_prio_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				is_priority = 0 AND is_prod_priority = 0
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_normal_qa 
FROM 
	v_t_applicator_shots
GROUP BY 
	car_maker, 
	car_model;

-- Current Applicator Count based on Applicator Shots Ranges

SELECT 
	car_maker,
	car_model,
	COUNT(CASE WHEN shotcnt_u_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
	COUNT(CASE WHEN shotcnt_u_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
	COUNT(CASE WHEN shotcnt_u_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
	COUNT(CASE WHEN shotcnt_u_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
	COUNT(CASE WHEN shotcnt_u_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
	COUNT(CASE WHEN shotcnt_u_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
FROM [v_t_applicator_shots]
GROUP BY car_maker, car_model;

SELECT 
	car_maker,
	car_model,
	COUNT(CASE WHEN shotcnt_d_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
	COUNT(CASE WHEN shotcnt_d_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
	COUNT(CASE WHEN shotcnt_d_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
	COUNT(CASE WHEN shotcnt_d_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
	COUNT(CASE WHEN shotcnt_d_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
	COUNT(CASE WHEN shotcnt_d_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
FROM [v_t_applicator_shots]
GROUP BY car_maker, car_model;

SELECT 
	car_maker,
	car_model,
	COUNT(CASE WHEN shotcnt_i_u_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
	COUNT(CASE WHEN shotcnt_i_u_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
	COUNT(CASE WHEN shotcnt_i_u_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
	COUNT(CASE WHEN shotcnt_i_u_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
	COUNT(CASE WHEN shotcnt_i_u_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
	COUNT(CASE WHEN shotcnt_i_u_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
FROM [v_t_applicator_shots]
GROUP BY car_maker, car_model;

SELECT 
	car_maker,
	car_model,
	COUNT(CASE WHEN shotcnt_i_d_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
	COUNT(CASE WHEN shotcnt_i_d_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
	COUNT(CASE WHEN shotcnt_i_d_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
	COUNT(CASE WHEN shotcnt_i_d_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
	COUNT(CASE WHEN shotcnt_i_d_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
	COUNT(CASE WHEN shotcnt_i_d_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
FROM [v_t_applicator_shots]
GROUP BY car_maker, car_model;

SELECT 
	car_maker,
	car_model,
	COUNT(CASE WHEN shotcnt_c_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
	COUNT(CASE WHEN shotcnt_c_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
	COUNT(CASE WHEN shotcnt_c_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
	COUNT(CASE WHEN shotcnt_c_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
	COUNT(CASE WHEN shotcnt_c_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
	COUNT(CASE WHEN shotcnt_c_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
FROM [v_t_applicator_shots]
GROUP BY car_maker, car_model;

-- Current Applicator Count based on Applicator List Status with exceeded shot count EE

SELECT 
	car_maker,
	car_model,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				status = 'Ready To Use' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_rtu_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				status = 'Out' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_out_ee,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_ee_status] = 'Exceeded' OR 
				[shotcnt_d_ee_status] = 'Exceeded' OR 
				[shotcnt_i_u_ee_status] = 'Exceeded' OR 
				[shotcnt_i_d_ee_status] = 'Exceeded' OR 
				[shotcnt_c_ee_status] = 'Exceeded') AND 
				status = 'Pending' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_pending_ee
FROM 
	v_t_applicator_shots
GROUP BY 
	car_maker, 
	car_model;

-- Current Applicator Count based on Applicator List Status with exceeded shot count QA

SELECT 
	car_maker,
	car_model,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				status = 'Ready To Use' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_rtu_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				status = 'Out' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_out_qa,
	COUNT(
		CASE 
			WHEN 
				([shotcnt_u_qa_status] = 'Exceeded' OR 
				[shotcnt_d_qa_status] = 'Exceeded' OR 
				[shotcnt_i_u_qa_status] = 'Exceeded' OR 
				[shotcnt_i_d_qa_status] = 'Exceeded' OR 
				[shotcnt_c_qa_status] = 'Exceeded') AND 
				status = 'Pending' 
			THEN applicator_no 
		END
	) AS total_appshot_exceeded_pending_qa 
FROM 
	v_t_applicator_shots
GROUP BY 
	car_maker, 
	car_model;

-- Trial Query. Daily Applicator Shot Exceeded Count per type

SELECT 
	CAST(exceeded_date_time AS date) AS Day,
	car_maker,
	car_model,
	shotcnt_category,
	shotcnt_type,
	COUNT(DISTINCT applicator_no) AS total
FROM 
	t_applicator_shots_h
GROUP BY
	CAST(exceeded_date_time AS date),
	car_maker,
	car_model,
	shotcnt_category,
	shotcnt_type
ORDER BY
	CAST(exceeded_date_time AS date);

-- Trial Query. Daily Applicator Shot Exceeded Count distinct applicator count

SELECT 
	CAST(exceeded_date_time AS date) AS Day,
	car_maker,
	car_model,
	shotcnt_category,
	COUNT(DISTINCT applicator_no) AS total
FROM 
	t_applicator_shots_h 
GROUP BY
	CAST(exceeded_date_time AS date),
	car_maker,
	car_model,
	shotcnt_category
ORDER BY
	CAST(exceeded_date_time AS date);

-- Hourly Applicator Shot Exceeded Count distinct applicator count specific day

DECLARE @day DATE = '2026-07-20';

WITH AllHours AS (
	SELECT 
		RIGHT('0' + CAST(n AS VARCHAR(2)), 2) AS hour_start,
		CASE 
			WHEN n >= 6 THEN n - 6  -- Hours 06-23 will retain their natural order
			ELSE n + 18             -- Hours 00-05 will appear after hour 23
		END AS sort_order
	FROM 
		(SELECT TOP 24 ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) - 1 AS n FROM master.dbo.spt_values) AS Numbers
),
Categories AS
(
    SELECT DISTINCT
        car_maker,
        car_model
    FROM m_applicator
),
ShotCategories AS
(
    SELECT *
    FROM (VALUES
        ('100K Shots'),
        ('50K Shots')
    ) v(shotcnt_category)
),
Exceeded AS
(
    SELECT
        FORMAT(exceeded_date_time, 'HH') AS hour_start, 
		car_maker,
		car_model,
		shotcnt_category,
        COUNT(DISTINCT applicator_no) AS Total
    FROM t_applicator_shots_h
    WHERE 
		shotcnt_type IN ('Wire Crimper', 'Wire Anvil') AND 
		exceeded_date_time >= DATEADD(HOUR, 6, CAST(@day AS DATETIME)) AND 
		exceeded_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(@day AS DATETIME))) 
    GROUP BY 
		FORMAT(exceeded_date_time, 'HH'), 
		car_maker,
		car_model,
		shotcnt_category
)
SELECT
    h.hour_start, 
	c.car_maker,
    c.car_model,
    s.shotcnt_category,
    ISNULL(e.Total, 0) AS Total
FROM AllHours h
CROSS JOIN Categories c
CROSS JOIN ShotCategories s
LEFT JOIN Exceeded e
    ON h.hour_start = e.hour_start
	AND e.car_maker = c.car_maker
	AND e.car_model = c.car_model
	AND e.shotcnt_category = s.shotcnt_category
ORDER BY 
	CASE 
		WHEN CAST(h.hour_start AS INT) >= 6 THEN CAST(h.hour_start AS INT)
		ELSE CAST(h.hour_start AS INT) + 24
	END,
	c.car_maker,
	c.car_model,
	s.shotcnt_category;

-- This Week Applicator Shot Exceeded Count distinct applicator count

DECLARE @StartDate DATE = DATEADD(DAY, -(DATEPART(WEEKDAY, GETDATE()) - 1), CAST(GETDATE() AS DATE));
DECLARE @EndDate DATE = DATEADD(DAY, 6, @StartDate);

WITH DateRange AS
(
    SELECT @StartDate AS SampleDate
    UNION ALL
    SELECT DATEADD(DAY, 1, SampleDate)
    FROM DateRange
    WHERE SampleDate < @EndDate
),
Categories AS
(
    SELECT DISTINCT
        car_maker,
        car_model
    FROM m_applicator
),
ShotCategories AS
(
    SELECT *
    FROM (VALUES
        ('100K Shots'),
        ('50K Shots')
    ) v(shotcnt_category)
),
Exceeded AS
(
    SELECT
        CAST(exceeded_date_time AS DATE) AS [Day],
		car_maker,
		car_model,
		shotcnt_category,
        COUNT(DISTINCT applicator_no) AS Total
    FROM t_applicator_shots_h
    WHERE 
		shotcnt_type IN ('Wire Crimper', 'Wire Anvil') AND 
		exceeded_date_time >= DATEADD(HOUR, 6, CAST(@StartDate AS DATETIME)) AND 
		exceeded_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(@EndDate AS DATETIME))) 
    GROUP BY 
		CAST(exceeded_date_time AS DATE), 
		car_maker,
		car_model,
		shotcnt_category
)
SELECT
    d.SampleDate,
	c.car_maker,
    c.car_model,
    s.shotcnt_category,
    ISNULL(e.Total, 0) AS Total
FROM DateRange d
CROSS JOIN Categories c
CROSS JOIN ShotCategories s
LEFT JOIN Exceeded e
    ON d.SampleDate = e.Day
	AND e.car_maker = c.car_maker
	AND e.car_model = c.car_model
	AND e.shotcnt_category = s.shotcnt_category
ORDER BY 
	d.SampleDate,
	c.car_maker,
	c.car_model,
	s.shotcnt_category
OPTION (MAXRECURSION 7);

-- Monthly Applicator Shot Exceeded Count distinct applicator count

DECLARE @Year INT = 2026;  -- Specify the year
DECLARE @Month INT = 7;   -- Specify the month (July)

WITH DateRange AS (
    SELECT 
        DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
    FROM 
        master.dbo.spt_values
    WHERE 
        type = 'P' AND 
        number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
),
Categories AS
(
    SELECT DISTINCT
        car_maker,
        car_model
    FROM m_applicator
),
ShotCategories AS
(
    SELECT *
    FROM (VALUES
        ('100K Shots'),
        ('50K Shots')
    ) v(shotcnt_category)
),
Exceeded AS
(
    SELECT
        CAST(exceeded_date_time AS DATE) AS [Day],
		car_maker,
		car_model,
		shotcnt_category,
        COUNT(DISTINCT applicator_no) AS Total
    FROM t_applicator_shots_h
    WHERE 
		shotcnt_type IN ('Wire Crimper', 'Wire Anvil') AND 
		exceeded_date_time >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME)) AND 
		exceeded_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) 
    GROUP BY 
		CAST(exceeded_date_time AS DATE), 
		car_maker,
		car_model,
		shotcnt_category
)
SELECT
    d.report_date,
	c.car_maker,
    c.car_model,
    s.shotcnt_category,
    ISNULL(e.Total, 0) AS Total
FROM DateRange d
CROSS JOIN Categories c
CROSS JOIN ShotCategories s
LEFT JOIN Exceeded e
    ON d.report_date = e.Day
	AND e.car_maker = c.car_maker
	AND e.car_model = c.car_model
	AND e.shotcnt_category = s.shotcnt_category
ORDER BY 
	d.report_date,
	c.car_maker,
	c.car_model,
	s.shotcnt_category;
