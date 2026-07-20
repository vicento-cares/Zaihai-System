<?php
require '../conn.php';

$method = $_POST['method'];

if ($method == 'log_applicator_maintenance') {
	$id = $_POST['id'];
	$applicator_no = trim($_POST['applicator_no']);
    $maintenance_by = trim($_POST['maintenance_by']);
    $maintenance_date = $_POST['maintenance_date'];

	$isTransactionActive = false;
	
	try {
		if (!$isTransactionActive) {
			$conn->beginTransaction();
			$isTransactionActive = true;
		}

		$query = "INSERT INTO t_applicator_shots_mch 
						(applicator_no, detected_by, scan_date_detected, maintenance_by, maintenance_date)
					SELECT applicator_no, detected_by, scan_date_detected, ? AS maintenance_by, ? AS maintenance_date 
					FROM t_applicator_shots_mc 
					WHERE applicator_no = ? AND id = ?";

		$stmt = $conn->prepare($query);
		$stmt->execute([$maintenance_by, $maintenance_date, $applicator_no, $id]);

		// Update History Logs
		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_U AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '100K Shots' AND 
						sh.shotcnt_type = 'Wire Crimper' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_D AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '100K Shots' AND 
						sh.shotcnt_type = 'Wire Anvil' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_I_U AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '100K Shots' AND 
						sh.shotcnt_type = 'Insulation Crimper' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_I_D AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '100K Shots' AND 
						sh.shotcnt_type = 'Insulation Anvil' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_C AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '100K Shots' AND 
						sh.shotcnt_type = 'Slide Cutter' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE s
					SET 
						s.shotcnt_u_limit_ee = CASE 
							WHEN CAST(m.SHOTCNT_U AS INT) >= s.shotcnt_u_limit_ee 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_U AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_U AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_u_limit_ee 
						END,
						s.shotcnt_d_limit_ee = CASE 
							WHEN CAST(m.SHOTCNT_D AS INT) >= s.shotcnt_d_limit_ee 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_D AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_D AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_d_limit_ee 
						END,
						s.shotcnt_i_u_limit_ee = CASE 
							WHEN CAST(m.SHOTCNT_I_U AS INT) >= s.shotcnt_i_u_limit_ee 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_I_U AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_I_U AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_i_u_limit_ee 
						END,
						s.shotcnt_i_d_limit_ee = CASE 
							WHEN CAST(m.SHOTCNT_I_D AS INT) >= s.shotcnt_i_d_limit_ee 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_I_D AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_I_D AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_i_d_limit_ee 
						END,
						s.shotcnt_c_limit_ee = CASE 
							WHEN CAST(m.SHOTCNT_C AS INT) >= s.shotcnt_c_limit_ee 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_C AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_C AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_c_limit_ee 
						END
					FROM t_applicator_shots s 
					INNER JOIN v_m_apri_ccis_data m 
						ON s.applicator_no = m.APPLICATOR_NO 
					WHERE s.applicator_no = ? AND m.APPLICATOR_NO = ?";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);
			
		$query = "DELETE FROM t_applicator_shots_mc WHERE applicator_no = ? AND id = ?";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $id]);
				
		$conn->commit();
		$isTransactionActive = false;
		echo 'success';
	} catch (Exception $e) {
		if ($isTransactionActive) {
			$conn->rollBack();
			$isTransactionActive = false;
		}
		echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
		exit();
	}
}

if ($method == 'log_applicator_appearance') {
	$applicator_no = trim($_POST['applicator_no']);
    $inspected_by = trim($_POST['inspected_by']);
    $inspection_date = $_POST['inspection_date'];

	$isTransactionActive = false;
	
	try {
		if (!$isTransactionActive) {
			$conn->beginTransaction();
			$isTransactionActive = true;
		}

		$query = "INSERT INTO t_applicator_shots_qah 
						(applicator_no, inspected_by, inspection_date)
					VALUES
						(?, ?, ?)";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $inspected_by, $inspection_date]);

		// Update History Logs
		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_U AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '50K Shots' AND 
						sh.shotcnt_type = 'Wire Crimper' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_D AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '50K Shots' AND 
						sh.shotcnt_type = 'Wire Anvil' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_I_U AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '50K Shots' AND 
						sh.shotcnt_type = 'Insulation Crimper' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_I_D AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '50K Shots' AND 
						sh.shotcnt_type = 'Insulation Anvil' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE sh 
						SET sh.is_limit_reset = CASE WHEN CAST(m.SHOTCNT_C AS INT) >= sh.shotcnt_limit THEN 1 ELSE sh.is_limit_reset END 
					FROM t_applicator_shots_h sh 
					INNER JOIN v_t_applicator_shots m 
						ON sh.applicator_no = m.applicator_no 
					WHERE 
						sh.applicator_no = ? AND 
						m.applicator_no = ? AND 
						sh.shotcnt_category = '50K Shots' AND 
						sh.shotcnt_type = 'Slide Cutter' AND 
						sh.is_limit_reset = 0";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);

		$query = "UPDATE s
					SET 
						s.shotcnt_u_limit_qa = CASE 
							WHEN CAST(m.SHOTCNT_U AS INT) >= s.shotcnt_u_limit_qa 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_U AS INT) < 50000 
									THEN 50000
								ELSE CEILING(CAST(m.SHOTCNT_U AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_u_limit_qa 
						END,
						s.shotcnt_d_limit_qa = CASE 
							WHEN CAST(m.SHOTCNT_D AS INT) >= s.shotcnt_d_limit_qa 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_D AS INT) < 50000 
									THEN 50000
								ELSE CEILING(CAST(m.SHOTCNT_D AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_d_limit_qa 
						END,
						s.shotcnt_i_u_limit_qa = CASE 
							WHEN CAST(m.SHOTCNT_I_U AS INT) >= s.shotcnt_i_u_limit_qa 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_I_U AS INT) < 50000 
									THEN 50000
								ELSE CEILING(CAST(m.SHOTCNT_I_U AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_i_u_limit_qa 
						END,
						s.shotcnt_i_d_limit_qa = CASE 
							WHEN CAST(m.SHOTCNT_I_D AS INT) >= s.shotcnt_i_d_limit_qa 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_I_D AS INT) < 50000 
									THEN 50000
								ELSE CEILING(CAST(m.SHOTCNT_I_D AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_i_d_limit_qa 
						END,
						s.shotcnt_c_limit_qa = CASE 
							WHEN CAST(m.SHOTCNT_C AS INT) >= s.shotcnt_c_limit_qa 
							THEN CASE 
								WHEN CAST(m.SHOTCNT_C AS INT) < 50000 
									THEN 50000
								ELSE CEILING(CAST(m.SHOTCNT_C AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_c_limit_qa 
						END
					FROM t_applicator_shots s 
					INNER JOIN v_m_apri_ccis_data m 
						ON s.applicator_no = m.APPLICATOR_NO 
					WHERE s.applicator_no = ? AND m.APPLICATOR_NO = ?";

		$stmt = $conn->prepare($query);
		$stmt->execute([$applicator_no, $applicator_no]);
				
		$conn->commit();
		$isTransactionActive = false;
		echo 'success';
	} catch (Exception $e) {
		if ($isTransactionActive) {
			$conn->rollBack();
			$isTransactionActive = false;
		}
		echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
		exit();
	}
}

$conn = null;
