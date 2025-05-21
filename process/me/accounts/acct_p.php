<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_account') {
	$emp_no = trim($_POST['emp_no']);
	$full_name = trim($_POST['full_name']);
	$role = trim($_POST['role']);
	
	$check = "SELECT id FROM m_accounts WHERE emp_no = ?";

	$stmt = $conn->prepare($check);
	$params = array($emp_no);
	$stmt->execute($params);

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo 'Already Exist';
	} else {
		$stmt = NULL;

		$query = "INSERT INTO m_accounts (emp_no, full_name, role) 
				VALUES (?, ?, ?)";

		$stmt = $conn->prepare($query);
		$params = array($emp_no, $full_name, $role);

		if ($stmt->execute($params)) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'update_account') {
	$id = $_POST['id'];
	$emp_no = trim($_POST['emp_no']);
	$full_name = trim($_POST['full_name']);
	$role = trim($_POST['role']);
	
	$check = "SELECT id FROM m_accounts WHERE emp_no = ?";
	
	$stmt = $conn->prepare($check);
	$params = array($emp_no);
	$stmt->execute($params);

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		$query = "UPDATE m_accounts SET full_name = ?, role = ? 
					WHERE id = ?";

		$stmt = $conn->prepare($query);
		$params = array($full_name, $role, $id);

		if ($stmt->execute($params)) {
			echo 'success';
		}else{
			echo 'error';
		}
	} else {
		$query = "UPDATE m_accounts SET emp_no = ?, full_name = ?, 
					role = ? 
					WHERE id = ?";

		$stmt = $conn->prepare($query);
		$params = array($emp_no, $full_name, $role, $id);

		if ($stmt->execute($params)) {
			echo 'success';
		}else{
			echo 'error';
		}
	}
}

if ($method == 'delete_account') {
	$id = $_POST['id'];

	$query = "DELETE FROM m_accounts WHERE id = ?";

	$stmt = $conn->prepare($query);
	$params = array($id);

	if ($stmt->execute($params)) {
		echo 'success';
	}else{
		echo 'error';
	}
}

$conn = null;
