<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_account') {
	$emp_no = addslashes(trim($_POST['emp_no']));
	$full_name = addslashes(trim($_POST['full_name']));
	$role = addslashes(trim($_POST['role']));
	
	$check = "SELECT id FROM m_accounts WHERE emp_no = '$emp_no'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Already Exist';
	}else{
		$stmt = NULL;

		$query = "INSERT INTO m_accounts (emp_no, full_name, role) 
				VALUES ('$emp_no','$full_name','$role')";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		}else{
			echo 'error';
		}
	}
}

if ($method == 'update_account') {
	$id = $_POST['id'];
	$emp_no = addslashes(trim($_POST['emp_no']));
	$full_name = addslashes(trim($_POST['full_name']));
	$role = addslashes(trim($_POST['role']));
	
	$check = "SELECT id FROM m_accounts WHERE emp_no = '$emp_no'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		$query = "UPDATE m_accounts SET full_name = '$full_name', role = '$role'
					WHERE id = '$id'";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		}else{
			echo 'error';
		}
	}else{
		$query = "UPDATE m_accounts SET emp_no = '$emp_no', full_name = '$full_name', 
					role = '$role'
					WHERE id = '$id'";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		}else{
			echo 'error';
		}
	}
}

if ($method == 'delete_account') {
	$id = $_POST['id'];

	$query = "DELETE FROM m_accounts WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	}else{
		echo 'error';
	}
}

$conn = null;