<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_applicator') {
	$car_maker = trim($_POST['car_maker']);
    $car_model = trim($_POST['car_model']);
	$applicator_no = trim($_POST['applicator_no']);
	$zaihai_stock_address = trim($_POST['zaihai_stock_address']);
	$is_priority = intval($_POST['is_priority']);
	
	$check = "SELECT id FROM m_applicator WHERE zaihai_stock_address = ?";
	$stmt = $conn->prepare($check);
	$stmt->execute([$zaihai_stock_address]);

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		echo 'Already Exist';
	} else {
		$isTransactionActive = false;
		
		try {
			if (!$isTransactionActive) {
				$conn->beginTransaction();
				$isTransactionActive = true;
			}

			$query = "INSERT INTO m_applicator 
						(car_maker, car_model, applicator_no, zaihai_stock_address, is_priority) 
					VALUES 
						(?,?,?,?,?)";

			$stmt = $conn->prepare($query);
			$stmt->execute([
				$car_maker, $car_model, $applicator_no, $zaihai_stock_address, $is_priority
			]);
				
			$query = "INSERT INTO t_applicator_list 
							(car_maker, car_model, applicator_no, location, status) 
						VALUES 
							(?,?,?,?,?)";

			$stmt = $conn->prepare($query);
			$stmt->execute([
				$car_maker, $car_model, $applicator_no, $zaihai_stock_address, 'Ready To Use'
			]);

			// Applicator Shots Registration
			$query = "INSERT INTO t_applicator_shots 
							(applicator_no, shotcnt_u_limit_ee, shotcnt_u_limit_qa, shotcnt_d_limit_ee, shotcnt_d_limit_qa,
							shotcnt_i_u_limit_ee, shotcnt_i_u_limit_qa, shotcnt_i_d_limit_ee, shotcnt_i_d_limit_qa,
							shotcnt_c_limit_ee, shotcnt_c_limit_qa)
						SELECT 
							al.applicator_no,
							CASE 
								WHEN CAST(m.SHOTCNT_U AS INT) < 50000 THEN 100000
								WHEN CAST(m.SHOTCNT_U AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_U AS FLOAT) / 100000.0) * 100000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_U AS INT) < 50000 THEN 50000
								WHEN CAST(m.SHOTCNT_U AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_U AS FLOAT) / 50000.0) * 50000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_D AS INT) < 50000 THEN 100000
								WHEN CAST(m.SHOTCNT_D AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_D AS FLOAT) / 100000.0) * 100000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_D AS INT) < 50000 THEN 50000
								WHEN CAST(m.SHOTCNT_D AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_D AS FLOAT) / 50000.0) * 50000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_I_U AS INT) < 50000 THEN 100000
								WHEN CAST(m.SHOTCNT_I_U AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_I_U AS FLOAT) / 100000.0) * 100000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_I_U AS INT) < 50000 THEN 50000
								WHEN CAST(m.SHOTCNT_I_U AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_I_U AS FLOAT) / 50000.0) * 50000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_I_D AS INT) < 50000 THEN 100000
								WHEN CAST(m.SHOTCNT_I_D AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_I_D AS FLOAT) / 100000.0) * 100000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_I_D AS INT) < 50000 THEN 50000
								WHEN CAST(m.SHOTCNT_I_D AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_I_D AS FLOAT) / 50000.0) * 50000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_C AS INT) < 50000 THEN 100000
								WHEN CAST(m.SHOTCNT_C AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_C AS FLOAT) / 100000.0) * 100000
							END,
							CASE 
								WHEN CAST(m.SHOTCNT_C AS INT) < 50000 THEN 50000
								WHEN CAST(m.SHOTCNT_C AS INT) < 100000 THEN 100000
								ELSE CEILING(CAST(m.SHOTCNT_C AS FLOAT) / 50000.0) * 50000
							END
						FROM 
							t_applicator_list al
						INNER JOIN v_m_apri_ccis_data m 
							ON al.applicator_no = m.APPLICATOR_NO
						WHERE 
							NOT EXISTS (
								SELECT 1 
								FROM t_applicator_shots aps 
								WHERE al.applicator_no = aps.applicator_no 
							);
						";
			$stmt = $conn->prepare($query);
			$stmt->execute();
		
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
}

if ($method == 'update_applicator') {
	$id = $_POST['id'];
	$car_maker = trim($_POST['car_maker']);
    $car_model = trim($_POST['car_model']);
	$applicator_no = trim($_POST['applicator_no']);
	$zaihai_stock_address = trim($_POST['zaihai_stock_address']);
	$is_priority = intval($_POST['is_priority']);
	
	$check = "SELECT applicator_no, zaihai_stock_address FROM m_applicator WHERE id = ?";
	$stmt = $conn->prepare($check);
	$stmt->execute([$id]);

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row) {
		$applicator_no_old = $row['applicator_no'];
		$zaihai_stock_address_old = $row['zaihai_stock_address'];

		$check = "SELECT id FROM t_applicator_list WHERE applicator_no = ?";
        $stmt = $conn->prepare($check);
        $stmt->execute([$applicator_no_old]);

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

		// if ($row) {
		// 	if ($row['status'] != 'Ready To Use') {
        //         echo 'Ready To Use Only';
        //     } else {

		// 	}
		// } else {
        //     echo 'Ready To Use Only';
        // }

        if ($row) {
			$id_al = $row['id'];

			$isTransactionActive = false;
	
			try {
				if (!$isTransactionActive) {
					$conn->beginTransaction();
					$isTransactionActive = true;
				}

				// Only priority update applied
				$query = "UPDATE m_applicator 
							SET 
								is_priority = ?
							WHERE 
								id = ? AND is_priority != ?";
				$stmt = $conn->prepare($query);
				$stmt->execute([$is_priority, $id, $is_priority]);

				// Update applicator details if status is ready to use
				$query = "UPDATE 
							t_applicator_list 
						SET 
							car_maker = ?, 
							car_model = ?, 
							applicator_no = ?";
				
				$params = [$car_maker, $car_model, $applicator_no];

				if ($zaihai_stock_address_old != $zaihai_stock_address) {
					$query .= ", location = ?";
					$params[] = $zaihai_stock_address;
				}

				$query .= " WHERE id = ? AND 
							EXISTS (
								SELECT 1
								FROM t_applicator_list a
								WHERE a.applicator_no = t_applicator_list.applicator_no
								AND a.status = 'Ready To Use'
							)";
							
				$params[] = $id_al;
				
				$stmt = $conn->prepare($query);
				$stmt->execute($params);

				$rowsAffected = $stmt->rowCount();

				if ($rowsAffected > 0) {
					$query = "UPDATE m_applicator 
							SET car_maker = ?, 
								car_model = ?, 
								applicator_no = ?";

					$params = [$car_maker, $car_model, $applicator_no];
					
					if ($zaihai_stock_address_old != $zaihai_stock_address) {
						$query .= ", zaihai_stock_address = ?";
						$params[] = $zaihai_stock_address;
					}

					$query .= " WHERE id = ? AND 
								EXISTS (
									SELECT 1
									FROM t_applicator_list a
									WHERE a.applicator_no = m_applicator.applicator_no
									AND a.status = 'Ready To Use'
								)";

					$params[] = $id;

					$stmt = $conn->prepare($query);
					$stmt->execute($params);
				}
						
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
        } else {
            echo 'Record Not Found On Applicator List! Call IT Personnel Immediately!!!';
        }
	} else {
		echo 'Record Not Found';
	}
}

if ($method == 'delete_applicator') {
	$id = $_POST['id'];

	$sql = "SELECT applicator_no, zaihai_stock_address FROM m_applicator WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	$applicator_no = addslashes($row['applicator_no']);
	$zaihai_stock_address = addslashes($row['zaihai_stock_address']);

	$check = "SELECT id, status FROM t_applicator_list 
				WHERE applicator_no = ?";
	$stmt = $conn->prepare($check);
	$stmt->execute([$applicator_no]);

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		$id_al = $row['id'];

		if ($row['status'] != 'Ready To Use') {
			echo 'Ready To Use Only';
		} else {

			$isTransactionActive = false;
		
			try {
				if (!$isTransactionActive) {
					$conn->beginTransaction();
					$isTransactionActive = true;
				}

				$query = "DELETE FROM t_applicator_shots WHERE applicator_no = ?";
				$stmt = $conn->prepare($query);
				$stmt->execute([$applicator_no]);

				$query = "DELETE FROM t_applicator_list WHERE id = ?";
				$stmt = $conn->prepare($query);
				$stmt->execute([$id_al]);

				$query = "DELETE FROM m_applicator WHERE id = ?";
				$stmt = $conn->prepare($query);
				$stmt->execute([$id]);

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
	} else {
		echo 'Record Not Found On Applicator List! Call IT Personnel Immediately!!!';
	}
}

$conn = null;