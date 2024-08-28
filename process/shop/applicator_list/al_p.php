<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_applicator_list') {
    $car_maker = addslashes(trim($_POST['car_maker']));
    $car_model = addslashes(trim($_POST['car_model']));
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$location = addslashes(trim($_POST['location']));

    $check = "SELECT id FROM m_applicator 
                WHERE applicator_no = '$applicator_no' AND zaihai_stock_address = '$location'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $check = "SELECT id FROM t_applicator_list WHERE applicator_no = '$applicator_no'";
        $stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo 'Already Exist';
        } else {
            $stmt = NULL;

            $query = "INSERT INTO t_applicator_list (car_maker, car_model, applicator_no, location, status) 
                    VALUES ('$car_maker','$car_model','$applicator_no','$location','Ready To Use')";

            $stmt = $conn->prepare($query);
            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    } else {
        echo 'Applicator and location not found';
    }
}

if ($method == 'update_applicator_list') {
	$id = $_POST['id'];
    $car_maker = addslashes(trim($_POST['car_maker']));
    $car_model = addslashes(trim($_POST['car_model']));
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$location = addslashes(trim($_POST['location']));

    $check = "SELECT id FROM m_applicator 
                WHERE applicator_no = '$applicator_no' AND zaihai_stock_address = '$location'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $check = "SELECT status FROM t_applicator_list WHERE applicator_no = '$applicator_no'";
        $stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if ($row['status'] != 'Ready To Use') {
                echo 'Ready To Use Only';
            } else {
                $query = "UPDATE t_applicator_list 
                        SET car_maker = '$car_maker', car_model = '$car_model', 
                        location = '$location'
                        WHERE id = '$id'";

                $stmt = $conn->prepare($query);
                if ($stmt->execute()) {
                    echo 'success';
                } else {
                    echo 'error';
                }
            }
        } else {
            $check = "SELECT status FROM t_applicator_list WHERE id = '$id'";
            $stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row['status'] != 'Ready To Use') {
                echo 'Ready To Use Only';
            } else {
                $query = "UPDATE t_applicator_list 
                        SET car_maker = '$car_maker', car_model = '$car_model', 
                        applicator_no = '$applicator_no', location = '$location'
                        WHERE id = '$id'";

                $stmt = $conn->prepare($query);
                if ($stmt->execute()) {
                    echo 'success';
                } else {
                    echo 'error';
                }
            }
        }
    } else {
        echo 'Applicator and location not found';
    }
}

if ($method == 'delete_applicator_list') {
	$id = $_POST['id'];

    $check = "SELECT status FROM t_applicator_list WHERE applicator_no = '$applicator_no'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row['status'] != 'Ready To Use') {
		echo 'Ready To Use Only';
	} else {
        $query = "DELETE FROM t_applicator_list WHERE id = '$id'";
        $stmt = $conn->prepare($query);
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
	
}

$conn = null;