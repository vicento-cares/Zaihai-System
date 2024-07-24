<?php
require '../../conn.php';

$method = $_GET['method'];

// Get Zaihai Stock Address By Applicator No Dropdown
if ($method == 'get_zaihai_stock_address_dropdown') {
    $applicator_no = $_GET['applicator_no'];
	$sql = "SELECT zaihai_stock_address FROM m_applicator WHERE applicator_no = '$applicator_no' ORDER BY zaihai_stock_address ASC";
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