<?php
require '../../conn.php';
include '../../lib/main.php';

$method = $_POST['method'];

if ($method == 'make_checksheet') {
    $location = $_POST['location'];
    $line_address = $_POST['line_address'];
    $applicator_no = $_POST['applicator_no'];
    $terminal_name = $_POST['terminal_name'];

    $applicator_no_split = split_applicator_no($applicator_no);

    $serial_no = $_POST['serial_no'];
    $equipment_no = $_POST['equipment_no'];
    $inspection_date_time = $_POST['inspection_date_time'];
    $inspection_shift = $_POST['inspection_shift'];

    $adjustment_content = $_POST['adjustment_content'];
    $adjustment_content_remarks = $_POST['adjustment_content_remarks'];
    $cross_section_result = $_POST['cross_section_result'];
    $inspected_by = $_POST['inspected_by'];
    $inspected_by_no = $_POST['inspected_by_no'];

    $ac_s_3 = 'Replace';
    
    $ac_arr = [
        $_POST['ac1'],
        $_POST['ac2'],
        $_POST['ac3'],
        $_POST['ac4'],
        $_POST['ac5'],
        $_POST['ac6'],
        $_POST['ac7'],
        $_POST['ac8'],
        $_POST['ac9'],
        $_POST['ac10'],
    ];

    $ac_s_arr = [
        $_POST['ac1_s'],
        $_POST['ac2_s'],
        $_POST['ac3_s'],
        $_POST['ac4_s'],
        $_POST['ac5_s'],
        $_POST['ac6_s'],
        $_POST['ac7_s'],
        $_POST['ac8_s'],
        $_POST['ac9_s'],
        $_POST['ac10_s'],
    ];

    $ac_r_arr = [
        $_POST['ac1_r'],
        $_POST['ac2_r'],
        $_POST['ac3_r'],
        $_POST['ac4_r'],
        $_POST['ac5_r'],
        $_POST['ac6_r'],
        $_POST['ac7_r'],
        $_POST['ac8_r'],
        $_POST['ac9_r'],
        $_POST['ac10_r'],
    ];

    foreach ($ac_arr as $key => $value) {
        if ($value == 3) {
            $ac_s_arr[$key] = $ac_s_3;
        }
    }

    try {
        $conn->beginTransaction();
    
        $sql = "INSERT INTO t_applicator_c 
            (serial_no, equipment_no, machine_no, terminal_name, zaihai_stock_address, line_address, inspection_date_time, inspection_shift, 
            adjustment_content, adjustment_content_remarks, cross_section_result, inspected_by, inspected_by_no,  
            ac1, ac2, ac3, ac4, ac5, ac6, ac7, ac8, ac9, ac10,
            ac1_s, ac2_s, ac3_s, ac4_s, ac5_s, ac6_s, ac7_s, ac8_s, ac9_s, ac10_s,
            ac1_r, ac2_r, ac3_r, ac4_r, ac5_r, ac6_r, ac7_r, ac8_r, ac9_r, ac10_r) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn -> prepare($sql);
        $params = array($serial_no, $equipment_no, $applicator_no_split, $terminal_name, $location, $line_address, $inspection_date_time, $inspection_shift, 
                        $adjustment_content, $adjustment_content_remarks, $cross_section_result, $inspected_by, $inspected_by_no, 
                        $ac_arr[0], $ac_arr[1], $ac_arr[2], $ac_arr[3], $ac_arr[4], $ac_arr[5], $ac_arr[6], $ac_arr[7], $ac_arr[8], $ac_arr[9], 
                        $ac_s_arr[0], $ac_s_arr[1], $ac_s_arr[2], $ac_s_arr[3], $ac_s_arr[4], $ac_s_arr[5], $ac_s_arr[6], $ac_s_arr[7], $ac_s_arr[8], $ac_s_arr[9], 
                        $ac_r_arr[0], $ac_r_arr[1], $ac_r_arr[2], $ac_r_arr[3], $ac_r_arr[4], $ac_r_arr[5], $ac_r_arr[6], $ac_r_arr[7], $ac_r_arr[8], $ac_r_arr[9]);
        $stmt -> execute($params);

        $sql = "INSERT INTO t_applicator_in_out_history 
                (serial_no, applicator_no, terminal_name, trd_no, operator_out, date_time_out, zaihai_stock_address, operator_in, date_time_in, inspected_by, confirmation_date)
                SELECT serial_no, applicator_no, terminal_name, trd_no, operator_out, date_time_out, zaihai_stock_address, operator_in, date_time_in, inspected_by, confirmation_date
                FROM t_applicator_in_out
                WHERE serial_no = ?";
        $stmt = $conn -> prepare($sql);
        $params = array($serial_no);
        $stmt -> execute($params);

        $sql = "UPDATE t_applicator_in_out_history 
                SET zaihai_stock_address = ?, inspected_by = ?, confirmation_date = ?
                WHERE serial_no = ?";
        $stmt = $conn -> prepare($sql);
        $params = array($location, $inspected_by_no, $server_date_time, $serial_no);
        $stmt -> execute($params);

        $sql = "DELETE FROM t_applicator_in_out WHERE serial_no = ?";
        $stmt = $conn -> prepare($sql);
        $params = array($serial_no);
        $stmt -> execute($params);

        $sql = "UPDATE t_applicator_list 
                SET location = ?, status = 'Ready To Use', date_updated = ?
                WHERE applicator_no = ?";
        $stmt = $conn->prepare($sql);
        $params = array($location, $server_date_time, $applicator_no);
        $stmt->execute($params);
    
        $conn->commit();
        echo 'success';
    } catch (Exception $e) {
        $conn->rollBack();
        echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
    }
}