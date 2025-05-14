<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';
include '../../lib/main.php';

// REMOTE IP ADDRESS
$ip = $_SERVER['REMOTE_ADDR'];

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
    $created_from_itf = 0;

    $create_f_checksheet = false;

    $car_maker = "";
    $car_model = "";
    if (isset($_SESSION['car_maker']) && !empty($_SESSION['car_maker'])) {
        $car_maker = $_SESSION['car_maker'];
    }
    if (isset($_SESSION['car_model']) && !empty($_SESSION['car_model'])) {
        $car_model = $_SESSION['car_model'];
    }

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

    $inspector = $_SESSION['emp_no'];
    $role = $_SESSION['role'];

    if (empty($inspector)) {
        echo 'Session was expired. Please Re-Login your account.';
    } else {
        if ($role == 'BM') {
            $sql = "SELECT serial_no FROM t_applicator_c WHERE serial_no = ?";
            $stmt = $conn -> prepare($sql);
            $params = array($serial_no);
            $stmt -> execute($params);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $create_f_checksheet = true;
            }

            $created_from_itf = 1;
        } else if ($adjustment_content != 'Clean') {
            $created_from_itf = 2;
        }

        $isTransactionActive = false;

        try {
            if (!$isTransactionActive) {
                $conn->beginTransaction();
                $isTransactionActive = true;
            }

            if ($create_f_checksheet) {
                $sql = "UPDATE t_applicator_c
                        SET f_inspection_date_time = ?, f_inspection_shift = ?, 
                            f_adjustment_content = ?, f_adjustment_content_remarks = ?, 
                            f_cross_section_result = ?, checked_by = ?, checked_by_no = ?, created_from_itf = ?, 
                            fac1 = ?, fac2 = ?, fac3 = ?, fac4 = ?, fac5 = ?, fac6 = ?, fac7 = ?, fac8 = ?, fac9 = ?, fac10 = ?, 
                            fac1_s = ?, fac2_s = ?, fac3_s = ?, fac4_s = ?, fac5_s = ?, fac6_s = ?, fac7_s = ?, fac8_s = ?, fac9_s = ?, fac10_s = ?, 
                            fac1_r = ?, fac2_r = ?, fac3_r = ?, fac4_r = ?, fac5_r = ?, fac6_r = ?, fac7_r = ?, fac8_r = ?, fac9_r = ?, fac10_r = ? 
                        WHERE serial_no = ?";
                $stmt = $conn -> prepare($sql);
                $params = array($inspection_date_time, $inspection_shift, 
                                $adjustment_content, $adjustment_content_remarks, 
                                $cross_section_result, $inspected_by, $inspected_by_no, $created_from_itf, 
                                $ac_arr[0], $ac_arr[1], $ac_arr[2], $ac_arr[3], $ac_arr[4], $ac_arr[5], $ac_arr[6], $ac_arr[7], $ac_arr[8], $ac_arr[9], 
                                $ac_s_arr[0], $ac_s_arr[1], $ac_s_arr[2], $ac_s_arr[3], $ac_s_arr[4], $ac_s_arr[5], $ac_s_arr[6], $ac_s_arr[7], $ac_s_arr[8], $ac_s_arr[9], 
                                $ac_r_arr[0], $ac_r_arr[1], $ac_r_arr[2], $ac_r_arr[3], $ac_r_arr[4], $ac_r_arr[5], $ac_r_arr[6], $ac_r_arr[7], $ac_r_arr[8], $ac_r_arr[9], 
                                $serial_no);
                $stmt -> execute($params);
            } else {
                $sql = "INSERT INTO t_applicator_c 
                    (serial_no, equipment_no, machine_no, terminal_name, zaihai_stock_address, line_address, inspection_date_time, inspection_shift, 
                    adjustment_content, adjustment_content_remarks, cross_section_result, inspected_by, inspected_by_no, created_from_itf, 
                    ac1, ac2, ac3, ac4, ac5, ac6, ac7, ac8, ac9, ac10,
                    ac1_s, ac2_s, ac3_s, ac4_s, ac5_s, ac6_s, ac7_s, ac8_s, ac9_s, ac10_s,
                    ac1_r, ac2_r, ac3_r, ac4_r, ac5_r, ac6_r, ac7_r, ac8_r, ac9_r, ac10_r) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 
                    ?, ?, ?, ?, ?, ?, 
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn -> prepare($sql);
                $params = array($serial_no, $equipment_no, $applicator_no_split, $terminal_name, $location, $line_address, $inspection_date_time, $inspection_shift, 
                                $adjustment_content, $adjustment_content_remarks, $cross_section_result, $inspected_by, $inspected_by_no, $created_from_itf, 
                                $ac_arr[0], $ac_arr[1], $ac_arr[2], $ac_arr[3], $ac_arr[4], $ac_arr[5], $ac_arr[6], $ac_arr[7], $ac_arr[8], $ac_arr[9], 
                                $ac_s_arr[0], $ac_s_arr[1], $ac_s_arr[2], $ac_s_arr[3], $ac_s_arr[4], $ac_s_arr[5], $ac_s_arr[6], $ac_s_arr[7], $ac_s_arr[8], $ac_s_arr[9], 
                                $ac_r_arr[0], $ac_r_arr[1], $ac_r_arr[2], $ac_r_arr[3], $ac_r_arr[4], $ac_r_arr[5], $ac_r_arr[6], $ac_r_arr[7], $ac_r_arr[8], $ac_r_arr[9]);
                $stmt -> execute($params);
            }
        
            if ($created_from_itf == 0) {
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
            } else if (!$create_f_checksheet) {
                $location_bm = "BM Receiving Area";

                $sql = "UPDATE t_applicator_in_out 
                        SET zaihai_stock_address = ? 
                        WHERE serial_no = ?";
                $stmt = $conn->prepare($sql);
                $params = array($location_bm, $serial_no);
                $stmt->execute($params);

                $sql = "UPDATE t_applicator_list 
                        SET location = ? 
                        WHERE applicator_no = ?";
                $stmt = $conn->prepare($sql);
                $params = array($location_bm, $applicator_no);
                $stmt->execute($params);
            }
        
            $conn->commit();
            $isTransactionActive = false;
            echo 'success';
        } catch (Exception $e) {
            if ($isTransactionActive) {
                $conn->rollBack();
                $isTransactionActive = false;
            }
            $error_status = 1;
            $message = 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
            $interface = 'Shop Applicator Checksheet';

            if ($role == 'BM') {
                $interface = 'BM Applicator Checksheet';
            }

            $error_log_arr = [
                'error_status' => $error_status,
                'error_name' => $message,
                'serial_no' => $serial_no,
                'scanned_applicator_no' => $applicator_no,
                'scanned_terminal_name' => $terminal_name,
                'scanned_trd_no' => $location,
                'scanned_by_no' => $inspected_by_no,
                'interface' => $interface,
                'zaihai_car_maker' => $car_maker,
                'zaihai_car_model' => $car_model,
                'ip' => $ip
            ];
    
            insert_error_log($error_log_arr, $conn);
            echo $message;
            $conn = null;
            exit();
        }
    }
}

if ($method == 'shop_confirm_checksheet') {
    $serial_no = $_POST['serial_no'];

    $shop_confirmed_by = $_SESSION['full_name'];
    $shop_confirmed_by_no = $_SESSION['emp_no'];

    $car_maker = $_SESSION['car_maker'];
    $car_model = $_SESSION['car_model'];

    if (empty($shop_confirmed_by)) {
        echo 'Session was expired. Please Re-Login your account.';
    } else {
        $sql = "SELECT a.zaihai_stock_address, a.applicator_no, ac.terminal_name, ac.inspected_by_no 
                FROM t_applicator_in_out aio
                LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no 
                LEFT JOIN t_applicator_c ac ON aio.serial_no = ac.serial_no 
                WHERE aio.serial_no = ?";
        $stmt = $conn -> prepare($sql);
        $params = array($serial_no);
        $stmt -> execute($params);

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $location = $row['zaihai_stock_address'];
            $applicator_no = $row['applicator_no'];
            $terminal_name = $row['terminal_name'];
            $inspected_by_no = $row['inspected_by_no'];

            $isTransactionActive = false;

            try {
                if (!$isTransactionActive) {
                    $conn->beginTransaction();
                    $isTransactionActive = true;
                }

                $sql = "UPDATE t_applicator_c 
                        SET shop_confirmed_by = ?, shop_confirmed_by_no = ?, shop_confirmed_date_time = ?
                        WHERE serial_no = ?";
                $stmt = $conn -> prepare($sql);
                $params = array($shop_confirmed_by, $shop_confirmed_by_no, $server_date_time, $serial_no);
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
                $isTransactionActive = false;
                echo 'success';
            } catch (Exception $e) {
                if ($isTransactionActive) {
                    $conn->rollBack();
                    $isTransactionActive = false;
                }
                $error_status = 1;
                $message = 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();

                $error_log_arr = [
                    'error_status' => $error_status,
                    'error_name' => $message,
                    'serial_no' => $serial_no,
                    'scanned_applicator_no' => $applicator_no,
                    'scanned_terminal_name' => $terminal_name,
                    'scanned_trd_no' => $location,
                    'scanned_by_no' => $shop_confirmed_by_no,
                    'interface' => 'Shop Confirm Applicator Checksheet',
                    'zaihai_car_maker' => $car_maker,
                    'zaihai_car_model' => $car_model,
                    'ip' => $ip
                ];
        
                insert_error_log($error_log_arr, $conn);
                echo $message;
                $conn = null;
                exit();
            }
        } else {
            echo 'Checksheet Not Found. Please Try Again or Call IT Personnel Immediately!';
        }
    }
}

$conn = null;
