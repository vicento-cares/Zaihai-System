<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';
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
        $terminal_name_split = split_terminal_name($terminal_name);

        $sql = "SELECT id FROM m_applicator_terminal WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name_split'";
        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $status = get_applicator_list_status($applicator_no, $conn);

            if ($status == 'Ready To Use') {
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
                            VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn -> prepare($sql);
                    $params = array($serial_no, $applicator_no, $terminal_name, $location, $operator_out);
                    $stmt -> execute($params);

                    $sql = "UPDATE t_applicator_list 
                            SET location = ?, status = 'Out', date_updated = ?
                            WHERE applicator_no = ?";
                    $stmt = $conn->prepare($sql);
                    $params = array($location, $server_date_time, $applicator_no);
                    $stmt->execute($params);
                    
                    echo 'success';
                } else {
                    echo 'Applicator Already Out';
                }
            } else if ($status == 'Out') {
                echo 'Applicator Already Out';
            } else {
                echo 'Applicator Still Pending';
            }
        } else {
            echo 'Applicator Not Found';
        }
    }
}

if ($method == 'in_applicator') {
    $location_before = $_POST['location_before'];
    $location = "Zaihai Receiving Area";
    $applicator_no = $_POST['applicator_no'];
    $terminal_name = $_POST['terminal_name'];
    $operator_in = $_SESSION['emp_no'];

    if (is_valid_applicator_no($applicator_no) == false) {
        echo 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        echo 'Invalid Terminal Name';
    } else {
        $terminal_name_split = split_terminal_name($terminal_name);

        $sql = "SELECT id FROM m_applicator_terminal WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name_split'";
        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $status = get_applicator_list_status($applicator_no, $conn);

            if ($status == 'Out') {
                $sql = "SELECT TOP 1 trd_no FROM t_applicator_in_out 
                    WHERE applicator_no = '$applicator_no' AND trd_no = '$location_before'
                    AND zaihai_stock_address IS NULL AND date_time_in IS NULL
                    ORDER BY id DESC";
                $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $stmt->execute();

                $row = $stmt -> fetch(PDO::FETCH_ASSOC);

                if ($row && $location_before == $row['trd_no']) {
                    $sql = "UPDATE t_applicator_in_out 
                            SET zaihai_stock_address = ?, operator_in = ?, date_time_in = ?
                            WHERE applicator_no = ? AND terminal_name = ?
                            AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
                    $stmt = $conn -> prepare($sql);
                    $params = array($location, $operator_in, $server_date_time, $applicator_no, $terminal_name);
                    $stmt -> execute($params);

                    $sql = "UPDATE t_applicator_list 
                            SET location = ?, status = 'Pending', date_updated = ?
                            WHERE applicator_no = ?";
                    $stmt = $conn->prepare($sql);
                    $params = array($location, $server_date_time, $applicator_no);
                    $stmt->execute($params);
                    
                    echo 'success';
                } else {
                    echo 'Unmatched TRD / Cart Location';
                }
            } else if ($status == 'Pending') {
                echo 'Applicator Already In Pending';
            } else {
                echo 'Applicator Currently Ready To Use';
            }
        } else {
            echo 'Applicator Not Found';
        }
    }
}
