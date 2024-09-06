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
	$applicator_no_exists = false;
	$terminal_name_exists = false;
	
	$check = "SELECT id FROM m_applicator_terminal WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Duplicate';
	} else {
		$sql = "SELECT applicator_no, terminal_name FROM m_applicator_terminal WHERE id = '$id'";
		$stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();

		$row = $stmt -> fetch(PDO::FETCH_ASSOC);

		$applicator_no_check = addslashes($row['applicator_no']);
		$terminal_name_check = addslashes($row['terminal_name']);

		$check = "SELECT id FROM m_applicator
					WHERE applicator_no = '$applicator_no_check'";
		$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();

		$row = $stmt -> fetch(PDO::FETCH_ASSOC);

		if ($row) {
			$applicator_no_exists = true;
		}

		$check = "SELECT id FROM m_terminal
					WHERE terminal_name = '$terminal_name_check'";
		$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();

		$row = $stmt -> fetch(PDO::FETCH_ASSOC);

		if ($row) {
			$terminal_name_exists = true;
		}

		if ($applicator_no_exists == false && $terminal_name_exists == false) {
			$query = "UPDATE m_applicator_terminal SET applicator_no = '$applicator_no', terminal_name = '$terminal_name'
					WHERE id = '$id'";

			$stmt = $conn->prepare($query);
			if ($stmt->execute()) {
				echo 'success';
			} else {
				echo 'error';
			}
		} else {
			echo 'Applicator No. or Terminal Name in use';
		}
	}
}

if ($method == 'delete_applicator_terminal') {
	$id = $_POST['id'];
	$applicator_no_exists = false;
	$terminal_name_exists = false;

	$sql = "SELECT applicator_no, terminal_name FROM m_applicator_terminal WHERE id = '$id'";
	$stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	$applicator_no = addslashes($row['applicator_no']);
	$terminal_name = addslashes($row['terminal_name']);

	$check = "SELECT id FROM m_applicator
				WHERE applicator_no = '$applicator_no'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		$applicator_no_exists = true;
	}

	$check = "SELECT id FROM m_terminal
				WHERE terminal_name = '$terminal_name'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

	if ($row) {
		$terminal_name_exists = true;
	}

	if ($applicator_no_exists == false && $terminal_name_exists == false) {
		$query = "DELETE FROM m_applicator_terminal WHERE id = '$id'";
		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		} else {
			echo 'error';
		}
	} else {
		echo 'Applicator No. or Terminal Name in use';
	}
}

$conn = null;