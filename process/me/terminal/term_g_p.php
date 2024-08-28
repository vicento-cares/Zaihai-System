<?php
require '../../conn.php';

$method = $_GET['method'];

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
    $terminal_name = $_GET['terminal_name'];
    $line_address = $_GET['line_address'];

    $c = 0;

    $sql = "SELECT id, terminal_name, line_address, date_updated FROM m_terminal";

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
                    onclick="get_terminal_details(&quot;'.$row['id'].'~!~'.$row['terminal_name'].'~!~'.$row['line_address'].'&quot;)">';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['terminal_name'].'</td>';
            echo '<td>'.$row['line_address'].'</td>';
            echo '<td>'.$row['date_updated'].'</td>';
            echo '</tr>';
        }
    }
}

$conn = null;