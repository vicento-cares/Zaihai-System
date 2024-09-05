<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_terminal') {
	$car_maker = addslashes(trim($_POST['car_maker']));
	$car_model = addslashes(trim($_POST['car_model']));
	$terminal_name = addslashes(trim($_POST['terminal_name']));
	$line_address = addslashes(trim($_POST['line_address']));
	
	$check = "SELECT id FROM m_terminal WHERE line_address = '$line_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Already Exist';
	} else {
		$stmt = NULL;

		$query = "INSERT INTO m_terminal (car_maker, car_model, terminal_name, line_address) 
				VALUES ('$car_maker','$car_model','$terminal_name','$line_address')";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'update_terminal') {
	$id = $_POST['id'];
	$car_maker = addslashes(trim($_POST['car_maker']));
	$car_model = addslashes(trim($_POST['car_model']));
	$terminal_name = addslashes(trim($_POST['terminal_name']));
	$line_address = addslashes(trim($_POST['line_address']));
	
	$check = "SELECT id FROM m_terminal WHERE line_address = '$line_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Duplicate';
	} else {
		$query = "UPDATE m_terminal 
					SET car_maker = '$car_maker', car_model = '$car_model', 
					terminal_name = '$terminal_name', line_address = '$line_address'
					WHERE id = '$id'";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'delete_terminal') {
	$id = $_POST['id'];

	$query = "DELETE FROM m_terminal WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	} else {
		echo 'error';
	}
}

$conn = null;