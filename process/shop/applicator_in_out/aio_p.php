<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

include '../../conn.php';
include '../../lib/main.php';

$method = $_POST['method'];

if ($method == 'out_applicator') {
    $location = $_POST['location'];
    $applicator_no = $_POST['applicator_no'];
    $terminal_name = $_POST['terminal_name'];
    $operator_out = $_SESSION['emp_no'];

    if (is_valid_applicator_no($applicator_no) == false) {
        echo 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        echo 'Invalid Terminal Name';
    } else {
        $applicator_no = split_applicator_no($applicator_no);
        $terminal_name = split_terminal_name($terminal_name);

        $sql = "SELECT id FROM m_applicator WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $sql = "SELECT id FROM t_applicator_in_out 
                    WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'
                    AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
            $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $serial_no = date("ymdh");
                $rand = substr(md5(microtime()),rand(0,26),5);
                $serial_no = 'MEI-295-AC-'.$serial_no;
                $serial_no = $serial_no.''.$rand;

                $sql = "INSERT INTO t_applicator_in_out (serial_no, applicator_no, terminal_name, trd_no, operator_out) 
                        VALUES ('$serial_no', '$applicator_no', '$terminal_name', '$location', '$operator_out')";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute();

                $sql = "UPDATE t_applicator_list 
                        SET location = '$location', date_updated = '$server_date_time'
                        WHERE applicator_no = '$applicator_no'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo 'success';
            } else {
                echo 'Applicator Already Out';
            }
        } else {
            echo 'Applicator Not Found';
        }
    }
}

if ($method == 'in_applicator') {
    $location_before = $_GET['location_before'];
    $location = $_POST['location'];
    $applicator_no = $_POST['applicator_no'];
    $terminal_name = $_POST['terminal_name'];
    $operator_in = $_SESSION['emp_no'];

    $serial_no = $_POST['serial_no'];
    $equipment_no = $_POST['equipment_no'];
    $inspection_date_time = $_POST['inspection_date_time'];
    $inspection_shift = $_POST['inspection_shift'];

    $adjustment_content = $_POST['adjustment_content'];
    $cross_section_result = $_POST['cross_section_result'];
    $inspected_by = $_POST['inspected_by'];
    $inspected_by_no = $_POST['inspected_by_no'];
    $checked_by = $_POST['checked_by'];
    
    $ac1 = $_POST['ac1'];
    $ac2 = $_POST['ac2'];
    $ac3 = $_POST['ac3'];
    $ac4 = $_POST['ac4'];
    $ac5 = $_POST['ac5'];
    $ac6 = $_POST['ac6'];
    $ac7 = $_POST['ac7'];
    $ac8 = $_POST['ac8'];
    $ac9 = $_POST['ac9'];
    $ac10 = $_POST['ac10'];

    if (is_valid_applicator_no($applicator_no) == false) {
        echo 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        echo 'Invalid Terminal Name';
    } else {
        $applicator_no = split_applicator_no($applicator_no);
        $terminal_name = split_terminal_name($terminal_name);

        $sql = "SELECT id FROM m_applicator WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $sql = "SELECT TOP 1 id FROM t_applicator_in_out 
                    WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'
                    AND zaihai_stock_address IS NULL AND date_time_in IS NULL
                    ORDER BY id DESC";
            $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                if ($location_before == $row['trd_no']) {
                    $sql = "INSERT INTO t_applicator_c 
                            (serial_no, equipment_no, machine_no, terminal_name, inspection_date_time, inspection_shift, 
                            adjustment_content, cross_section_result, inspected_by, inspected_by_no, checked_by, 
                            ac1, ac2, ac3, ac4, ac5, ac6, ac7, ac8, ac9, ac10) 
                            VALUES ('$serial_no', '$equipment_no', '$applicator_no', '$terminal_name', '$inspection_date_time', '$inspection_shift', 
                            '$adjustment_content', '$cross_section_result', '$inspected_by', '$inspected_by_no', '$checked_by', 
                            '$ac1', '$ac2', '$ac3', '$ac4', '$ac5', '$ac6', '$ac7', '$ac8', '$ac9', '$ac10')";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute();

                    $sql = "UPDATE t_applicator_in_out 
                            SET zaihai_stock_address = '$location', operator_in = '$operator_in', date_time_in = '$server_date_time'
                            WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'
                            AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute();

                    $sql = "UPDATE t_applicator_list 
                            SET location = '$location', date_updated = '$server_date_time'
                            WHERE applicator_no = '$applicator_no'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    
                    echo 'success';
                } else {
                    echo 'Unmatched TRD / Cart Location';
                }
            } else {
                echo 'Applicator Already In';
            }
        } else {
            echo 'Applicator Not Found';
        }
    }
}
