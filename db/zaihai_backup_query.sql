-- Insert into select t_error_monitoring 

INSERT INTO zaihai_backup.dbo.t_error_monitoring 
	(
		error_code, 
		serial_no, 
		scanned_applicator_no, 
		scanned_terminal_name, 
		scanned_trd_no, 
		scanned_by_no, 
		interface, 
		zaihai_car_maker, 
		zaihai_car_model, 
		[ip], 
		date_started, 
		started_by_no, 
		it_error_details, 
		date_recorded
	) 
SELECT 
	error_code, 
	serial_no, 
	scanned_applicator_no, 
	scanned_terminal_name, 
	scanned_trd_no, 
	scanned_by_no, 
	interface, 
	zaihai_car_maker, 
	zaihai_car_model, 
	[ip], 
	date_started, 
	started_by_no, 
	it_error_details, 
	date_recorded 
FROM 
	zaihai_db.dbo.t_error_monitoring 
WHERE 
	date_recorded < '2026-01-01';

-- Delete t_error_monitoring where date recorded

DELETE FROM zaihai_db.dbo.t_error_monitoring WHERE date_recorded < '2026-01-01';

-- Insert into select t_applicator_c null as column not exists on current table 

INSERT INTO zaihai_backup.dbo.t_applicator_c
    (
        serial_no
        ,equipment_no
        ,machine_no
        ,terminal_name
        ,zaihai_stock_address
        ,line_address
        ,inspection_date_time
        ,inspection_shift
        ,adjustment_content
        ,adjustment_content_remarks
        ,cross_section_result
        ,inspected_by
        ,inspected_by_no
        ,checked_by
        ,checked_by_no
        ,confirmed_by
        ,confirmed_by_no
        ,pd_verified_by
        ,pd_verified_by_id_no
        ,pd_verified_date_time
        ,created_from_itf
        ,shop_confirmed_by
        ,shop_confirmed_by_no
        ,shop_confirmed_date_time
        ,judgement
        ,ac1
        ,ac1_s
        ,ac1_r
        ,ac2
        ,ac2_s
        ,ac2_r
        ,ac3
        ,ac3_s
        ,ac3_r
        ,ac4
        ,ac4_s
        ,ac4_r
        ,ac5
        ,ac5_s
        ,ac5_r
        ,ac6
        ,ac6_s
        ,ac6_r
        ,ac7
        ,ac7_s
        ,ac7_r
        ,ac8
        ,ac8_s
        ,ac8_r
        ,ac9
        ,ac9_s
        ,ac9_r
        ,ac10
        ,ac10_s
        ,ac10_r
        ,f_inspection_date_time
        ,f_inspection_shift
        ,f_adjustment_content
        ,f_adjustment_content_remarks
        ,f_cross_section_result
        ,fac1
        ,fac1_s
        ,fac1_r
        ,fac2
        ,fac2_s
        ,fac2_r
        ,fac3
        ,fac3_s
        ,fac3_r
        ,fac4
        ,fac4_s
        ,fac4_r
        ,fac5
        ,fac5_s
        ,fac5_r
        ,fac6
        ,fac6_s
        ,fac6_r
        ,fac7
        ,fac7_s
        ,fac7_r
        ,fac8
        ,fac8_s
        ,fac8_r
        ,fac9
        ,fac9_s
        ,fac9_r
        ,fac10
        ,fac10_s
        ,fac10_r
    ) 
SELECT 
    serial_no
    ,equipment_no
    ,machine_no
    ,terminal_name
    ,zaihai_stock_address
    ,line_address
    ,inspection_date_time
    ,inspection_shift
    ,adjustment_content
    ,adjustment_content_remarks
    ,cross_section_result
    ,inspected_by
    ,inspected_by_no
    ,checked_by
    ,checked_by_no
    ,confirmed_by
    ,confirmed_by_no
    ,pd_verified_by
    ,pd_verified_by_id_no
    ,pd_verified_date_time
    ,created_from_itf
    ,shop_confirmed_by
    ,shop_confirmed_by_no
    ,shop_confirmed_date_time
    ,judgement
    ,ac1
    ,ac1_s
    ,ac1_r
    ,ac2
    ,ac2_s
    ,ac2_r
    ,ac3
    ,ac3_s
    ,ac3_r
    ,ac4
    ,ac4_s
    ,ac4_r
    ,ac5
    ,ac5_s
    ,ac5_r
    ,ac6
    ,ac6_s
    ,ac6_r
    ,ac7
    ,ac7_s
    ,ac7_r
    ,ac8
    ,ac8_s
    ,ac8_r
    ,ac9
    ,ac9_s
    ,ac9_r
    ,ac10
    ,ac10_s
    ,ac10_r
    ,NULL AS f_inspection_date_time
    ,NULL AS f_inspection_shift
    ,NULL AS f_adjustment_content
    ,NULL AS f_adjustment_content_remarks
    ,NULL AS f_cross_section_result
    ,NULL AS fac1
    ,NULL AS fac1_s
    ,NULL AS fac1_r
    ,NULL AS fac2
    ,NULL AS fac2_s
    ,NULL AS fac2_r
    ,NULL AS fac3
    ,NULL AS fac3_s
    ,NULL AS fac3_r
    ,NULL AS fac4
    ,NULL AS fac4_s
    ,NULL AS fac4_r
    ,NULL AS fac5
    ,NULL AS fac5_s
    ,NULL AS fac5_r
    ,NULL AS fac6
    ,NULL AS fac6_s
    ,NULL AS fac6_r
    ,NULL AS fac7
    ,NULL AS fac7_s
    ,NULL AS fac7_r
    ,NULL AS fac8
    ,NULL AS fac8_s
    ,NULL AS fac8_r
    ,NULL AS fac9
    ,NULL AS fac9_s
    ,NULL AS fac9_r
    ,NULL AS fac10
    ,NULL AS fac10_s
    ,NULL AS fac10_r 
FROM 
    zaihai_db.dbo.t_applicator_c 
WHERE 
    inspection_date_time < '2026-01-01 06:00:00';

-- Delete t_applicator_c where inspection_date_time 

DELETE FROM zaihai_db.dbo.t_applicator_c WHERE inspection_date_time < '2026-01-01 06:00:00';

-- insert into select t_applicator_in_out_history

INSERT INTO zaihai_backup.dbo.t_applicator_in_out_history 
    (
        serial_no
        ,applicator_no
        ,terminal_name
        ,trd_no
        ,operator_out
        ,date_time_out
        ,zaihai_stock_address
        ,operator_in
        ,date_time_in
        ,inspected_by
        ,confirmation_date
    ) 
SELECT 
    serial_no
    ,applicator_no
    ,terminal_name
    ,trd_no
    ,operator_out
    ,date_time_out
    ,zaihai_stock_address
    ,operator_in
    ,date_time_in
    ,inspected_by
    ,confirmation_date 
FROM 
    zaihai_db.dbo.t_applicator_in_out_history 
WHERE 
    confirmation_date < '2026-01-01 06:00:00';

-- Delete t_applicator_c where inspection_date_time 

DELETE FROM zaihai_db.dbo.t_applicator_in_out_history WHERE confirmation_date < '2026-01-01 06:00:00';
