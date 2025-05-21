<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';

$method = $_GET['method'];

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT car_maker FROM m_terminal GROUP BY car_maker ORDER BY car_maker ASC";
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
	$sql = "SELECT car_model FROM m_terminal GROUP BY car_model ORDER BY car_model ASC";
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

// Get Terminal Name Datalist
if ($method == 'get_terminal_name_datalist_search') {
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

	$sql = "SELECT terminal_name FROM m_terminal WHERE terminal_name != ''";
	$params = [];

	if (!empty($car_maker)) {
		$sql .= " AND car_maker = ?";
		$params[] = $car_maker;
	}
	if (!empty($car_model)) {
		$sql .= " AND car_model = ?";
		$params[] = $car_model;
	}

	$sql .= " GROUP BY terminal_name ORDER BY terminal_name ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);

	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
		echo '<option value="'.$row['terminal_name'].'">';
	}
}

// Get Terminal Name Dropdown
if ($method == 'get_terminal_name_dropdown') {
	$sql = "SELECT terminal_name FROM m_terminal 
            GROUP BY terminal_name ORDER BY terminal_name ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option selected value=""></option>';
		do {
			echo '<option value="'.htmlspecialchars($row['terminal_name']).'">'.htmlspecialchars($row['terminal_name']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value=""></option>';
	}
}

// Get Line Address By Terminal Name Dropdown
if ($method == 'get_line_address_dropdown') {
    $terminal_name = $_GET['terminal_name'];

	$sql = "SELECT line_address FROM m_terminal WHERE terminal_name = ? ORDER BY line_address ASC";

	$stmt = $conn -> prepare($sql);
	$params = array($terminal_name);
	$stmt -> execute($params);

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option selected value=""></option>';
		do {
			echo '<option value="'.htmlspecialchars($row['line_address']).'">'.htmlspecialchars($row['line_address']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value=""></option>';
	}
}

if ($method == 'get_terminals') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $terminal_name = $_GET['terminal_name'];
    $line_address = $_GET['line_address'];

    $c = 0;

    $sql = "SELECT id, car_maker, car_model, terminal_name, line_address, date_updated FROM m_terminal";
	$params = [];

	if (!empty($terminal_name)) {
        $sql .= " WHERE terminal_name LIKE ?";
		$terminal_name_param = $terminal_name . '%';
    	$params[] = $terminal_name_param;
    } else {
        $sql .= " WHERE terminal_name != ''";
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
    if (!empty($line_address)) {
        $sql .= " AND line_address LIKE ?";
		$line_address_param = $line_address . '%';
    	$params[] = $line_address_param;
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql);
	$stmt->execute($params);

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
		$c++;

		echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_terminal"
				onclick="get_terminal_details(&quot;'.$row['id'].'~!~'.$row['car_maker'].'~!~'.$row['car_model'].'~!~'.$row['terminal_name'].'~!~'.$row['line_address'].'&quot;)">';
		echo '<td>'.$c.'</td>';
		echo '<td>'.$row['car_maker'].'</td>';
		echo '<td>'.$row['car_model'].'</td>';
		echo '<td>'.$row['terminal_name'].'</td>';
		echo '<td>'.$row['line_address'].'</td>';
		echo '<td>'.$row['date_updated'].'</td>';
		echo '</tr>';
	}
}

$conn = null;
