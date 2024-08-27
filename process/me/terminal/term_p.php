<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_terminal') {
	$terminal_name = addslashes(trim($_POST['terminal_name']));
	$line_address = addslashes(trim($_POST['line_address']));
	
	$check = "SELECT id FROM m_terminal WHERE terminal_name = '$terminal_name' AND line_address = '$line_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Already Exist';
	} else {
		$stmt = NULL;

		$query = "INSERT INTO m_terminal (terminal_name, line_address) 
				VALUES ('$terminal_name','$line_address')";

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
	$terminal_name = addslashes(trim($_POST['terminal_name']));
	$line_address = addslashes(trim($_POST['line_address']));
	
	$check = "SELECT id FROM m_terminal WHERE terminal_name = '$terminal_name' AND line_address = '$line_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Duplicate';
	} else {
		$query = "UPDATE m_terminal SET terminal_name = '$terminal_name', line_address = '$line_address'
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