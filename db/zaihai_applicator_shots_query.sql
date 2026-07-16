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
