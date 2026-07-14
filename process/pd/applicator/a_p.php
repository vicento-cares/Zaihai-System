<?php
require '../../conn.php';

$method = $_POST['method'];

if ($method == 'update_applicator') {
	$id = $_POST['id'];
	$is_prod_priority = intval($_POST['is_prod_priority']);
	
	$isTransactionActive = false;
	
	try {
		if (!$isTransactionActive) {
			$conn->beginTransaction();
			$isTransactionActive = true;
		}

		// Only priority update applied
		$query = "UPDATE m_applicator 
					SET 
						is_prod_priority = ?
					WHERE 
						id = ? AND is_prod_priority != ?";
		$stmt = $conn->prepare($query);
		$stmt->execute([$is_prod_priority, $id, $is_prod_priority]);
				
		$conn->commit();
		$isTransactionActive = false;
		echo 'success';
	} catch (Exception $e) {
		if ($isTransactionActive) {
			$conn->rollBack();
			$isTransactionActive = false;
		}
		echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
		exit();
	}
}

$conn = null;
