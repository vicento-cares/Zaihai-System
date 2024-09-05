<?php
require '../../conn.php';

$method = $_GET['method'];

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT car_maker FROM m_terminal GROUP BY car_maker ORDER BY car_maker ASC";
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
	$sql = "SELECT car_model FROM m_terminal GROUP BY car_model ORDER BY car_model ASC";
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

// Get Terminal Name Datalist
if ($method == 'get_terminal_name_datalist_search') {
	$sql = "SELECT terminal_name FROM m_terminal 
            GROUP BY terminal_name ORDER BY terminal_name ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['terminal_name'].'">';
		}
	}
}

// Get Terminal Name Dropdown
if ($method == 'get_terminal_name_dropdown') {
	$sql = "SELECT terminal_name FROM m_terminal 
            GROUP BY terminal_name ORDER BY terminal_name ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
        echo '<option selected value=""></option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['terminal_name']).'">'.htmlspecialchars($row['terminal_name']).'</option>';
		}
	} else {
		echo '<option selected value=""></option>';
	}
}

// Get Line Address By Terminal Name Dropdown
if ($method == 'get_line_address_dropdown') {
    $terminal_name = $_GET['terminal_name'];
	$sql = "SELECT line_address FROM m_terminal WHERE terminal_name = '$terminal_name' ORDER BY line_address ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
        echo '<option selected value=""></option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['line_address']).'">'.htmlspecialchars($row['line_address']).'</option>';
		}
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

    if (!empty($car_maker)) {
        $sql .= " AND car_maker LIKE '$car_maker%'";
    }
    if (!empty($car_model)) {
        $sql .= " AND car_model LIKE '$car_model%'";
    }
    if (!empty($terminal_name)) {
        $sql .= " WHERE terminal_name LIKE '$terminal_name%'";
    } else {
        $sql .= " WHERE terminal_name != ''";
    }
    if (!empty($line_address)) {
        $sql .= " AND line_address LIKE '$line_address%'";
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
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
}

$conn = null;