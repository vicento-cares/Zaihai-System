<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_applicator') {
	$car_maker = addslashes(trim($_POST['car_maker']));
    $car_model = addslashes(trim($_POST['car_model']));
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$zaihai_stock_address = addslashes(trim($_POST['zaihai_stock_address']));
	
	$check = "SELECT id FROM m_applicator WHERE zaihai_stock_address = '$zaihai_stock_address'";
	$stmt = $conn->prepare($check);
	$stmt->execute();

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

			$query = "INSERT INTO m_applicator (car_maker, car_model, applicator_no, zaihai_stock_address) 
				VALUES ('$car_maker','$car_model','$applicator_no','$zaihai_stock_address')";

			$stmt = $conn->prepare($query);
			$stmt->execute();
				
			$query = "INSERT INTO t_applicator_list (car_maker, car_model, applicator_no, location, status) 
					VALUES ('$car_maker','$car_model','$applicator_no','$zaihai_stock_address','Ready To Use')";

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
	$car_maker = addslashes(trim($_POST['car_maker']));
    $car_model = addslashes(trim($_POST['car_model']));
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$zaihai_stock_address = addslashes(trim($_POST['zaihai_stock_address']));
	
	$check = "SELECT applicator_no, zaihai_stock_address FROM m_applicator WHERE id = '$id'";
	$stmt = $conn->prepare($check);
	$stmt->execute();

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row) {
		$applicator_no_old = $row['applicator_no'];
		$zaihai_stock_address_old = $row['zaihai_stock_address'];

		$check = "SELECT id, status FROM t_applicator_list WHERE applicator_no = '$applicator_no_old'";
        $stmt = $conn->prepare($check);
        $stmt->execute();

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

					$query = "UPDATE t_applicator_list 
                        	SET car_maker = '$car_maker', 
								car_model = '$car_model', 
								applicator_no = '$applicator_no'";

					if ($zaihai_stock_address_old != $zaihai_stock_address) {
						$query .= ", location = '$zaihai_stock_address'";
					}

					$query .= "WHERE id = '$id_al'";
					
					$stmt = $conn->prepare($query);
					$stmt->execute();

					$query = "UPDATE m_applicator 
								SET car_maker = '$car_maker', 
									car_model = '$car_model', 
									applicator_no = '$applicator_no'";
					
					if ($zaihai_stock_address_old != $zaihai_stock_address) {
						$query .= ", zaihai_stock_address = '$zaihai_stock_address'";
					}

					$query .= "WHERE id = '$id'";

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
        } else {
            echo 'Ready To Use Only';
        }
	} else {
		echo 'Record Not Found';
	}
}

if ($method == 'delete_applicator') {
	$id = $_POST['id'];

	$sql = "SELECT applicator_no, zaihai_stock_address FROM m_applicator WHERE id = '$id'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	$applicator_no = addslashes($row['applicator_no']);
	$zaihai_stock_address = addslashes($row['zaihai_stock_address']);

	$check = "SELECT id, status FROM t_applicator_list 
				WHERE applicator_no = '$applicator_no'";
	$stmt = $conn->prepare($check);
	$stmt->execute();

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

				$query = "DELETE FROM t_applicator_list WHERE id = '$id_al'";
				$stmt = $conn->prepare($query);
				$stmt->execute();

				$query = "DELETE FROM m_applicator WHERE id = '$id'";
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
	} else {
		echo 'Ready To Use Only';
	}
}

$conn = null;