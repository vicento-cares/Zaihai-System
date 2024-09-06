<?php
require '../../conn.php';

$method = $_GET['method'];

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT car_maker FROM m_applicator GROUP BY car_maker ORDER BY car_maker ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">All</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_maker']).'">'.htmlspecialchars($row['car_maker']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Car Model Dropdown
if ($method == 'get_car_model_dropdown_search') {
	$sql = "SELECT car_model FROM m_applicator GROUP BY car_model ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">All</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Applicator No. Datalist
if ($method == 'get_applicator_no_datalist_search') {
	$sql = "SELECT applicator_no FROM m_applicator 
            GROUP BY applicator_no ORDER BY applicator_no ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['applicator_no'].'">';
		}
	}
}

// Get Applicator No. Dropdown
if ($method == 'get_applicator_no_dropdown') {
	$sql = "SELECT applicator_no FROM m_applicator 
            GROUP BY applicator_no ORDER BY applicator_no ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
        echo '<option selected value=""></option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['applicator_no']).'">'.htmlspecialchars($row['applicator_no']).'</option>';
		}
	} else {
		echo '<option selected value=""></option>';
	}
}

// Get Zaihai Stock Address Dropdown By Applicator No
if ($method == 'get_zaihai_stock_address_dropdown') {
    $applicator_no = addslashes($_GET['applicator_no']);

	$sql = "SELECT zaihai_stock_address FROM m_applicator";
    if (!empty($applicator_no)) {
		$sql .= " WHERE applicator_no = '$applicator_no'";
	}
    $sql .= " GROUP BY zaihai_stock_address ORDER BY zaihai_stock_address ASC";

	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
        echo '<option selected value=""></option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['zaihai_stock_address']).'">'.htmlspecialchars($row['zaihai_stock_address']).'</option>';
		}
	} else {
		echo '<option selected value=""></option>';
	}
}

if ($method == 'get_applicators') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $applicator_no = $_GET['applicator_no'];
    $zaihai_stock_address = $_GET['zaihai_stock_address'];

    $c = 0;

    $sql = "SELECT id, car_maker, car_model, applicator_no, zaihai_stock_address, date_updated FROM m_applicator";

    if (!empty($applicator_no)) {
        $sql .= " WHERE applicator_no LIKE '$applicator_no%'";
    } else {
        $sql .= " WHERE applicator_no != ''";
    }
    if (!empty($car_maker)) {
        $sql .= " AND car_maker LIKE '$car_maker%'";
    }
    if (!empty($car_model)) {
        $sql .= " AND car_model LIKE '$car_model%'";
    }
    if (!empty($zaihai_stock_address)) {
        $sql .= " AND zaihai_stock_address LIKE '$zaihai_stock_address%'";
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;

            echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_applicator"
                    onclick="get_applicator_details(&quot;'.$row['id'].'~!~'.$row['car_maker'].'~!~'.$row['car_model'].'~!~'.$row['applicator_no'].'~!~'.$row['zaihai_stock_address'].'&quot;)">';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['car_maker'].'</td>';
            echo '<td>'.$row['car_model'].'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['zaihai_stock_address'].'</td>';
            echo '<td>'.$row['date_updated'].'</td>';
            echo '</tr>';
        }
    }
}

$conn = null;