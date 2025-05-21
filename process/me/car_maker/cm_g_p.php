<?php
require '../../conn.php';

$method = $_GET['method'];

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown') {
	$sql = "SELECT car_maker FROM m_car_maker GROUP BY car_maker ORDER BY car_maker ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo '<option selected value="">Select Car Maker</option>';
		do {
			echo '<option value="'.htmlspecialchars($row['car_maker']).'">'.htmlspecialchars($row['car_maker']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value="">Select Car Maker</option>';
	}
}

// Get Car Model Dropdown
if ($method == 'get_car_model_dropdown') {
	$sql = "SELECT car_model FROM m_car_maker GROUP BY car_model ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo '<option selected value="">Select Car Model</option>';
		do {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value="">Select Car Model</option>';
	}
}

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT car_maker FROM m_car_maker GROUP BY car_maker ORDER BY car_maker ASC";
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
	$sql = "SELECT car_model FROM m_car_maker GROUP BY car_model ORDER BY car_model ASC";
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

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo '<option disabled selected value="">Select Borrowed By</option>';
		do {
			echo '<option value="'.htmlspecialchars($row['car_maker_model']).'">'.htmlspecialchars($row['car_maker_model']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option disabled selected value="">Select Borrowed By</option>';
	}
}
