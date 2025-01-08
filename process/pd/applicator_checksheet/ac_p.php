<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';
include '../../lib/main.php';

$method = $_POST['method'];

if ($method == 'verify_checksheet') {
    $serial_no = $_POST['serial_no'];

    $pd_verified_by = $_SESSION['full_name'];
    $pd_verified_by_id_no = $_SESSION['emp_no'];

    $isTransactionActive = false;

    try {
        if (!$isTransactionActive) {
            $conn->beginTransaction();
            $isTransactionActive = true;
        }

        $sql = "UPDATE t_applicator_c 
                SET pd_verified_by = ?, pd_verified_by_id_no = ?, pd_verified_date_time = ?
                WHERE serial_no = ?";
        $stmt = $conn -> prepare($sql);
        $params = array($pd_verified_by, $pd_verified_by_id_no, $server_date_time, $serial_no);
        $stmt -> execute($params);
    
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