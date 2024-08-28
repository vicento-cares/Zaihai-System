<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'add_applicator') {
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$zaihai_stock_address = addslashes(trim($_POST['zaihai_stock_address']));
	
	$check = "SELECT id FROM m_applicator WHERE applicator_no = '$applicator_no' AND zaihai_stock_address = '$zaihai_stock_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Already Exist';
	} else {
		$stmt = NULL;

		$query = "INSERT INTO m_applicator (applicator_no, zaihai_stock_address) 
				VALUES ('$applicator_no','$zaihai_stock_address')";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'update_applicator') {
	$id = $_POST['id'];
	$applicator_no = addslashes(trim($_POST['applicator_no']));
	$zaihai_stock_address = addslashes(trim($_POST['zaihai_stock_address']));
	
	$check = "SELECT id FROM m_applicator WHERE applicator_no = '$applicator_no' AND zaihai_stock_address = '$zaihai_stock_address'";
	$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo 'Duplicate';
	} else {
		$query = "UPDATE m_applicator SET applicator_no = '$applicator_no', zaihai_stock_address = '$zaihai_stock_address'
					WHERE id = '$id'";

		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
}

if ($method == 'delete_applicator') {
	$id = $_POST['id'];

	$query = "DELETE FROM m_applicator WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	} else {
		echo 'error';
	}
}

$conn = null;