<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_applicator_terminal') {
	$applicator_no = trim($_POST['applicator_no']);
	$terminal_name = trim($_POST['terminal_name']);
	
	$check = "SELECT id FROM m_applicator_terminal WHERE applicator_no = ? AND terminal_name = ?";
	$stmt = $conn->prepare($check);
	$params = array($applicator_no, $terminal_name);
	$stmt->execute($params);

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		echo 'Already Exist';
	} else {
		$stmt = NULL;

		$query = "INSERT INTO m_applicator_terminal (applicator_no, terminal_name) 
				VALUES (?, ?)";

		$stmt = $conn->prepare($query);
		$params = array($applicator_no, $terminal_name);

		if ($stmt->execute($params)) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'update_applicator_terminal') {
	$id = $_POST['id'];
	$applicator_no = trim($_POST['applicator_no']);
	$terminal_name = trim($_POST['terminal_name']);
	$applicator_no_exists = false;
	$terminal_name_exists = false;
	
	$check = "SELECT id FROM m_applicator_terminal WHERE applicator_no = ? AND terminal_name = ?";
	$stmt = $conn->prepare($check);
	$params = array($applicator_no, $terminal_name);
	$stmt->execute($params);

	$row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		echo 'Duplicate';
	} else {
		$query = "UPDATE m_applicator_terminal SET applicator_no = ?, terminal_name = ? 
				WHERE id = ?";

		$stmt = $conn->prepare($query);
		$params = array($applicator_no, $terminal_name, $id);

		if ($stmt->execute($params)) {
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
	
	$query = "DELETE FROM m_applicator_terminal WHERE id = ?";

	$stmt = $conn->prepare($query);
	$params = array($id);

	if ($stmt->execute($params)) {
		echo 'success';
	} else {
		echo 'error';
	}
}

$conn = null;
