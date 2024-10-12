<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_applicator') {
	$car_maker = addslashes(trim($_POST['car_maker']));
    $car_model = addslashes(trim($_POST['car_model']));
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$zaihai_stock_address = addslashes(trim($_POST['zaihai_stock_address']));
	
	$check = "SELECT id FROM m_applicator WHERE zaihai_stock_address = '$zaihai_stock_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Already Exist';
	} else {
		$stmt = NULL;

		$query = "INSERT INTO m_applicator (car_maker, car_model, applicator_no, zaihai_stock_address) 
				VALUES ('$car_maker','$car_model','$applicator_no','$zaihai_stock_address')";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			$stmt = NULL;

            $query = "INSERT INTO t_applicator_list (car_maker, car_model, applicator_no, location, status) 
                    VALUES ('$car_maker','$car_model','$applicator_no','$zaihai_stock_address','Ready To Use')";

            $stmt = $conn->prepare($query);
            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }
		} else {
			echo 'error';
		}
	}
}

if ($method == 'update_applicator') {
	$id = $_POST['id'];
	$car_maker = addslashes(trim($_POST['car_maker']));
    $car_model = addslashes(trim($_POST['car_model']));
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$zaihai_stock_address = addslashes(trim($_POST['zaihai_stock_address']));
	
	$check = "SELECT id FROM m_applicator WHERE zaihai_stock_address = '$zaihai_stock_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row) {
		$check = "SELECT status FROM t_applicator_list WHERE zaihai_stock_address = '$zaihai_stock_address'";
        $stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if ($row['status'] != 'Ready To Use') {
                echo 'Ready To Use Only';
            } else {
                $query = "UPDATE t_applicator_list 
                        SET car_maker = '$car_maker', car_model = '$car_model', applicator_no = '$applicator_no'
                        WHERE zaihai_stock_address = '$zaihai_stock_address'";

                $stmt = $conn->prepare($query);
                if ($stmt->execute()) {
                    $query = "UPDATE m_applicator 
							SET car_maker = '$car_maker', car_model = '$car_model', 
							applicator_no = '$applicator_no', zaihai_stock_address = '$zaihai_stock_address'
							WHERE id = '$id'";

					$stmt = $conn->prepare($query);
					if ($stmt->execute()) {
						echo 'success';
					} else {
						echo 'error';
					}
                } else {
                    echo 'error';
                }
            }
        } else {
            echo 'Ready To Use Only';
        }
	} else {
		echo 'Zaihai Stock Address Not Found';
	}
}

if ($method == 'delete_applicator') {
	$id = $_POST['id'];

	$sql = "SELECT applicator_no, zaihai_stock_address FROM m_applicator WHERE id = '$id'";
	$stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	$applicator_no = addslashes($row['applicator_no']);
	$zaihai_stock_address = addslashes($row['zaihai_stock_address']);

	$check = "SELECT status FROM t_applicator_list 
				WHERE location = '$zaihai_stock_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		if ($row['status'] != 'Ready To Use') {
			echo 'Ready To Use Only';
		} else {
			$query = "DELETE FROM t_applicator_list 
						WHERE location = '$zaihai_stock_address'";
			$stmt = $conn->prepare($query);
			if ($stmt->execute()) {
				$query = "DELETE FROM m_applicator WHERE id = '$id'";
				$stmt = $conn->prepare($query);
				if ($stmt->execute()) {
					echo 'success';
				} else {
					echo 'error';
				}
			} else {
				echo 'error';
			}
		}
	} else {
		echo 'Ready To Use Only';
	}
}

$conn = null;