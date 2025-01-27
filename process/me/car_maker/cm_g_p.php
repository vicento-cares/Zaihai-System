<?php
require '../../conn.php';

$method = $_GET['method'];

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown') {
	$sql = "SELECT car_maker FROM m_car_maker GROUP BY car_maker ORDER BY car_maker ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">Select Car Maker</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_maker']).'">'.htmlspecialchars($row['car_maker']).'</option>';
		}
	} else {
		echo '<option selected value="">Select Car Maker</option>';
	}
}

// Get Car Model Dropdown
if ($method == 'get_car_model_dropdown') {
	$sql = "SELECT car_model FROM m_car_maker GROUP BY car_model ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">Select Car Model</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option selected value="">Select Car Model</option>';
	}
}

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT car_maker FROM m_car_maker GROUP BY car_maker ORDER BY car_maker ASC";
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
	$sql = "SELECT car_model FROM m_car_maker GROUP BY car_model ORDER BY car_model ASC";
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

// Get Borrowed By Car Maker / Car Model Dropdown
if ($method == 'get_borrowed_by_dropdown') {
	$sql = "SELECT 
				CASE 
					WHEN car_maker = car_model THEN car_maker
					ELSE CONCAT(car_maker, ' ', car_model)
				END AS car_maker_model
			FROM 
				m_car_maker";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($results) > 0) {
		echo '<option disabled selected value="">Select Borrowed By</option>';
		foreach ($results as $row) {
			echo '<option value="'.htmlspecialchars($row['car_maker_model']).'">'.htmlspecialchars($row['car_maker_model']).'</option>';
		}
	} else {
		echo '<option disabled selected value="">Select Borrowed By</option>';
	}
}
