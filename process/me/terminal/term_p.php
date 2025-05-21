<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_terminal') {
	$car_maker = trim($_POST['car_maker']);
	$car_model = trim($_POST['car_model']);
	$terminal_name = trim($_POST['terminal_name']);
	$line_address = trim($_POST['line_address']);
	
	$check = "SELECT id FROM m_terminal WHERE line_address = ?";

	$stmt = $conn->prepare($check);
	$params = array($line_address);
	$stmt->execute($params);

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		echo 'Already Exist';
	} else {
		$stmt = NULL;

		$query = "INSERT INTO m_terminal (car_maker, car_model, terminal_name, line_address) 
				VALUES (?, ?, ?, ?)";

		$stmt = $conn->prepare($query);
		$params = array($car_maker, $car_model, $terminal_name, $line_address);

		if ($stmt->execute($params)) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'update_terminal') {
	$id = $_POST['id'];
	$car_maker = trim($_POST['car_maker']);
	$car_model = trim($_POST['car_model']);
	$terminal_name = trim($_POST['terminal_name']);
	$line_address = trim($_POST['line_address']);
	
	$check = "SELECT id FROM m_terminal WHERE line_address = ?";

	$stmt = $conn->prepare($check);
	$params = array($line_address);
	$stmt->execute($params);

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		echo 'Duplicate';
	} else {
		$query = "UPDATE m_terminal 
					SET car_maker = ?, car_model = ?, 
					terminal_name = ?, line_address = ? 
					WHERE id = ?";

		$stmt = $conn->prepare($query);
		$params = array($car_maker, $car_model, $terminal_name, $line_address, $id);

		if ($stmt->execute($params)) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'delete_terminal') {
	$id = $_POST['id'];

	$query = "DELETE FROM m_terminal WHERE id = ?";

	$stmt = $conn->prepare($query);
	$params = array($id);

	if ($stmt->execute()) {
		echo 'success';
	} else {
		echo 'error';
	}
}

$conn = null;
