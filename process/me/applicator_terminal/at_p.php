<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_applicator_terminal') {
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$terminal_name = addslashes(trim($_POST['terminal_name']));
	
	$check = "SELECT id FROM m_applicator_terminal WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Already Exist';
	} else {
		$stmt = NULL;

		$query = "INSERT INTO m_applicator_terminal (applicator_no, terminal_name) 
				VALUES ('$applicator_no','$terminal_name')";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'update_applicator_terminal') {
	$id = $_POST['id'];
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$terminal_name = addslashes(trim($_POST['terminal_name']));
	
	$check = "SELECT id FROM m_applicator_terminal WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Duplicate';
	} else {
		$query = "UPDATE m_applicator_terminal SET applicator_no = '$applicator_no', terminal_name = '$terminal_name'
					WHERE id = '$id'";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'delete_applicator_terminal') {
	$id = $_POST['id'];

	$query = "DELETE FROM m_applicator_terminal WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	} else {
		echo 'error';
	}
}

$conn = null;