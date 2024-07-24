<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require 'conn.php';

if (isset($_POST['login_btn'])) {

    $emp_no = addslashes($_POST['emp_no']);

    if (empty($emp_no)) {
        echo '<script>alert("Please Scan QR Code or Enter ID Number")</script>';
    } else {
        $check = "SELECT emp_no, full_name, role FROM m_accounts WHERE emp_no = '$emp_no' COLLATE SQL_Latin1_General_CP1_CS_AS";
        $stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach($stmt->fetchALL() as $x){
                $emp_no = $x['emp_no'];
                $full_name = $x['full_name'];
                $role = $x['role'];
            }
            $_SESSION['emp_no'] = $emp_no;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['role'] = $role;
            if ($role == 'Shop') {
                header('location:/zaihai/shop/applicator_list.php');
            } else if ($role == 'Inspector') {
                header('location:/zaihai/inspector/applicator_checksheet.php');
            }
        } else {
            echo '<script>alert("Sign In Failed. Maybe an incorrect credential or account not found")</script>';
        }
    }
}

if (isset($_POST['Logout'])) {
    session_unset();
    session_destroy();
    header('location:/zaihai/login');
}
?>