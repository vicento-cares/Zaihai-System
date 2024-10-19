<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_applicator_terminal') {
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$terminal_name = addslashes(trim($_POST['terminal_name']));
	
	$check = "SELECT id FROM m_applicator_terminal WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
	$stmt = $conn->prepare($check);
	$stmt->execute();

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
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
	$applicator_no_exists = false;
	$terminal_name_exists = false;
	
	$check = "SELECT id FROM m_applicator_terminal WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
	$stmt = $conn->prepare($check);
	$stmt->execute();

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
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
	$applicator_no_exists = false;
	$terminal_name_exists = false;
	
	$query = "DELETE FROM m_applicator_terminal WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	} else {
		echo 'error';
	}
}

$conn = null;