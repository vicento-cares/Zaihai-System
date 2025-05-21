<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';

$method = $_GET['method'];

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT car_maker FROM m_applicator GROUP BY car_maker ORDER BY car_maker ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo '<option selected value="">All</option>';
		do {
			echo '<option value="'.htmlspecialchars($row['car_maker']).'">'.htmlspecialchars($row['car_maker']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Car Model Dropdown
if ($method == 'get_car_model_dropdown_search') {
	$sql = "SELECT car_model FROM m_applicator GROUP BY car_model ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo '<option selected value="">All</option>';
		do {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Applicator No. Datalist
if ($method == 'get_applicator_no_datalist_search') {
	$car_maker = '';
    $car_model = '';

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
        }
    }

	$sql = "SELECT applicator_no FROM m_applicator WHERE applicator_no != ''";
	$params = [];

	if (!empty($car_maker)) {
        $sql .= " AND car_maker = ?";
		$params[] = $car_maker;
    }
    if (!empty($car_model)) {
        $sql .= " AND car_model = ?";
		$params[] = $car_model;
    }

	$sql .= " GROUP BY applicator_no ORDER BY applicator_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);

	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
		echo '<option value="'.$row['applicator_no'].'">';
	}
}

// Get Applicator No. Dropdown
if ($method == 'get_applicator_no_dropdown') {
	$sql = "SELECT applicator_no FROM m_applicator 
            GROUP BY applicator_no ORDER BY applicator_no ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option selected value=""></option>';
		do {
			echo '<option value="'.htmlspecialchars($row['applicator_no']).'">'.htmlspecialchars($row['applicator_no']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value=""></option>';
	}
}

// Get Zaihai Stock Address Dropdown By Applicator No
if ($method == 'get_zaihai_stock_address_dropdown') {
    $applicator_no = addslashes($_GET['applicator_no']);

	$sql = "SELECT zaihai_stock_address FROM m_applicator";
	$params = [];

    if (!empty($applicator_no)) {
		$sql .= " WHERE applicator_no = ?";
		$params[] = $applicator_no;
	}

    $sql .= " GROUP BY zaihai_stock_address ORDER BY zaihai_stock_address ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option selected value=""></option>';
		do {
			echo '<option value="'.htmlspecialchars($row['zaihai_stock_address']).'">'.htmlspecialchars($row['zaihai_stock_address']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
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
	$params = [];

    if (!empty($applicator_no)) {
        $sql .= " WHERE applicator_no LIKE ?";
		$applicator_no_param = $applicator_no . "%";
        $params[] = $applicator_no_param;
    } else {
        $sql .= " WHERE applicator_no != ''";
    }
    if (!empty($car_maker)) {
        $sql .= " AND car_maker LIKE ?";
		$car_maker_param = $car_maker . '%';
    	$params[] = $car_maker_param;
    }
    if (!empty($car_model)) {
        $sql .= " AND car_model LIKE ?";
		$car_model_param = $car_model . '%';
    	$params[] = $car_model_param;
    }
    if (!empty($zaihai_stock_address)) {
        $sql .= " AND zaihai_stock_address LIKE ?";
		$zaihai_stock_address_param = $zaihai_stock_address . '%';
    	$params[] = $zaihai_stock_address_param;
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql);
	$stmt->execute($params);

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
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

$conn = null;
