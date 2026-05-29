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

		$query = "UPDATE s
					SET 
						s.shotcnt_u_limit_ee = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS INT) >= s.shotcnt_u_limit_ee 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS INT) < 50000 
									THEN 100000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_u_limit_ee 
						END,
						s.shotcnt_d_limit_ee = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS INT) >= s.shotcnt_d_limit_ee 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS INT) < 50000 
									THEN 100000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_d_limit_ee 
						END,
						s.shotcnt_i_u_limit_ee = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS INT) >= s.shotcnt_i_u_limit_ee 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS INT) < 50000 
									THEN 100000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_i_u_limit_ee 
						END,
						s.shotcnt_i_d_limit_ee = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS INT) >= s.shotcnt_i_d_limit_ee 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS INT) < 50000 
									THEN 100000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_i_d_limit_ee 
						END,
						s.shotcnt_c_limit_ee = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS INT) >= s.shotcnt_c_limit_ee 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS INT) < 50000 
									THEN 100000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS FLOAT) / 100000.0) * 100000
							END
							ELSE s.shotcnt_c_limit_ee 
						END
					FROM t_applicator_shots s
					INNER JOIN t_applicator_shots_temp m
						ON m.[id] = (SELECT MAX([id]) FROM t_applicator_shots_temp)
					CROSS APPLY OPENJSON(m.[applicator_shot_json]) AS j
					WHERE s.[applicator_no] = ? AND JSON_VALUE(j.[value], '$.APPLICATOR_NO') = ?";

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

		$query = "UPDATE s
					SET 
						s.shotcnt_u_limit_qa = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS INT) >= s.shotcnt_u_limit_qa 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS INT) < 50000 
									THEN 50000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_u_limit_qa 
						END,
						s.shotcnt_d_limit_qa = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS INT) >= s.shotcnt_d_limit_qa 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS INT) < 50000 
									THEN 50000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_d_limit_qa 
						END,
						s.shotcnt_i_u_limit_qa = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS INT) >= s.shotcnt_i_u_limit_qa 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS INT) < 50000 
									THEN 50000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_i_u_limit_qa 
						END,
						s.shotcnt_i_d_limit_qa = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS INT) >= s.shotcnt_i_d_limit_qa 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS INT) < 50000 
									THEN 50000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_i_d_limit_qa 
						END,
						s.shotcnt_c_limit_qa = CASE 
							WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS INT) >= s.shotcnt_c_limit_qa 
							THEN CASE 
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS INT) < 50000 
									THEN 50000
								WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS INT) < 100000 
									THEN 100000
								ELSE CEILING(CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS FLOAT) / 50000.0) * 50000
							END
							ELSE s.shotcnt_c_limit_qa 
						END
					FROM t_applicator_shots s
					INNER JOIN t_applicator_shots_temp m
						ON m.[id] = (SELECT MAX([id]) FROM t_applicator_shots_temp)
					CROSS APPLY OPENJSON(m.[applicator_shot_json]) AS j
					WHERE s.[applicator_no] = ? AND JSON_VALUE(j.[value], '$.APPLICATOR_NO') = ?";

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
