<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';
include '../../lib/main.php';

// REMOTE IP ADDRESS
$ip = $_SERVER['REMOTE_ADDR'];

$method = $_POST['method'];

if ($method == 'out_applicator') {
    $location = trim($_POST['location']);
    $applicator_no = trim($_POST['applicator_no']);
    $terminal_name = trim($_POST['terminal_name']);
    $operator_out = $_SESSION['emp_no'];
    $car_maker = $_SESSION['car_maker'];
    $car_model = $_SESSION['car_model'];
    $serial_no = '';

    $message = '';
    $error_status = 0;
    $error_log_arr = [];

    if (empty($location)) {
        $message = 'Please Select Borrowed By or Remarks';
    } else if (is_valid_applicator_no($applicator_no) == false) {
        $message = 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        $message = 'Invalid Terminal Name';
    } else if (empty($operator_out)) {
        $message = 'Session was expired. Please Re-Login your account.';
    } else {
        $terminal_name_split = split_terminal_name($terminal_name);

        $sql = "SELECT 
                    at.id,
                    a.car_maker,
                    a.car_model
                FROM 
                    m_applicator_terminal at 
                LEFT JOIN
                    m_applicator a ON at.applicator_no = a.applicator_no
                WHERE 
                    at.applicator_no = ? AND 
                    at.terminal_name = ?";
        $stmt = $conn->prepare($sql);
        $params = array($applicator_no, $terminal_name_split);
        $stmt->execute($params);

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if ($car_maker == $row['car_maker'] && $car_model == $row['car_model']) {
                $status = get_applicator_list_status($applicator_no, $conn);

                if ($status == 'Ready To Use') {
                    $sql = "SELECT id FROM t_applicator_in_out 
                        WHERE applicator_no = ? AND terminal_name = ?
                        AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
                    $stmt = $conn->prepare($sql);
                    $params = array($applicator_no, $terminal_name);
                    $stmt->execute($params);

                    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

                    if (!$row) {
                        $sql = "SELECT id, serial_no FROM t_applicator_in_out 
                                WHERE trd_no = ?";
                        $params = [];
                        $params[] = $location;

                        // Check "Borrowed" Keyword on Location
                        if (containsBorrowed($location)) {
                            $sql .= " AND applicator_no = ?";
                            $params[] = $applicator_no;
                        }
                        
                        $sql .= " AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
                        
                        $stmt = $conn->prepare($sql);
                        $stmt->execute($params);

                        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

                        if (!$row) {
                            // $serial_no = date("ymdh");
                            // $rand = substr(md5(microtime()),rand(0,26),5);
                            // $serial_no = 'MEI-295-AC-'.$serial_no;
                            // $serial_no = $serial_no.''.$rand;
                            $serial_no = str_replace('.', '', uniqid('MEI-295-AC-', true));

                            $isTransactionActive = false;

                            try {
                                if (!$isTransactionActive) {
                                    $conn->beginTransaction();
                                    $isTransactionActive = true;
                                }

                                $locationToUpper = strtoupper($location); //ToUpper Update
                            
                                $sql = "INSERT INTO t_applicator_in_out (serial_no, applicator_no, terminal_name, trd_no, operator_out) 
                                    VALUES (?, ?, ?, ?, ?)";
                                $stmt = $conn -> prepare($sql);
                                $params = array($serial_no, $applicator_no, $terminal_name, $locationToUpper, $operator_out);
                                $stmt -> execute($params);

                                $sql = "UPDATE t_applicator_list 
                                        SET location = ?, status = 'Out', date_updated = ?
                                        WHERE applicator_no = ?";
                                $stmt = $conn->prepare($sql);
                                $params = array($locationToUpper, $server_date_time, $applicator_no);
                                $stmt->execute($params);
                            
                                $conn->commit();
                                $isTransactionActive = false;
                                $message = 'success';
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
                                    'serial_no' => "",
                                    'scanned_applicator_no' => $applicator_no,
                                    'scanned_terminal_name' => $terminal_name,
                                    'scanned_trd_no' => $location,
                                    'scanned_by_no' => $operator_out,
                                    'interface' => 'Shop Applicator Out',
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
                            $serial_no = $row['serial_no'];
                            $error_status = 1;
                            $message = 'TRD Cart Currently Used';
                        }
                    } else {
                        $message = 'Applicator Already Out';
                    }
                } else if ($status == 'Out') {
                    $message = 'Applicator Already Out';
                } else {
                    $message = 'Applicator Still Pending';
                }
            } else {
                $message = 'Applicator Scanned On Wrong Zaihai Shop! Car Maker: ' . $row['car_maker'] . ' Car Model: ' . $row['car_model'];
            }
        } else {
            $sql = "SELECT id FROM m_applicator_terminal WHERE applicator_no = ?";
            $stmt = $conn->prepare($sql);
            $params = array($applicator_no);
            $stmt->execute($params);

            $is_applicator_found = $stmt -> fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT id FROM m_applicator_terminal WHERE terminal_name = ?";
            $stmt = $conn->prepare($sql);
            $params = array($terminal_name_split);
            $stmt->execute($params);

            $is_terminal_found = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$is_applicator_found && !$is_terminal_found) {
                $message = 'Applicator And Terminal Not Found';
            } else if (!$is_applicator_found) {
                $message = 'Applicator Not Found';
            } else if (!$is_terminal_found) {
                $message = 'Terminal Not Found';
            } else {
                $message = 'Unmatched Or Record Not Found On Applicator Terminal';
            }

            $error_status = 1;
        }
    }

    if ($message != 'success') {
        $error_log_arr = [
            'error_status' => $error_status,
            'error_name' => $message,
            'serial_no' => $serial_no,
            'scanned_applicator_no' => $applicator_no,
            'scanned_terminal_name' => $terminal_name,
            'scanned_trd_no' => $location,
            'scanned_by_no' => $operator_out,
            'interface' => 'Shop Applicator Out',
            'zaihai_car_maker' => $car_maker,
            'zaihai_car_model' => $car_model,
            'ip' => $ip
        ];

        insert_error_log($error_log_arr, $conn);
    }

    echo $message;
}

if ($method == 'in_applicator') {
    $location_before = strtoupper(trim($_POST['location_before'])); //ToUpper Update
    $location = "Zaihai Receiving Area";
    $applicator_no = trim($_POST['applicator_no']);
    $terminal_name = trim($_POST['terminal_name']);
    $operator_in = $_SESSION['emp_no'];
    $car_maker = $_SESSION['car_maker'];
    $car_model = $_SESSION['car_model'];
    $serial_no = '';

    $message = '';
    $error_status = 0;
    $error_log_arr = [];

    if (empty($location_before)) {
        $message = 'Please Select Borrowed By or Remarks';
    } else if (is_valid_applicator_no($applicator_no) == false) {
        $message = 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        $message = 'Invalid Terminal Name';
    } else if (empty($operator_in)) {
        $message = 'Session was expired. Please Re-Login your account.';
    } else {
        $terminal_name_split = split_terminal_name($terminal_name);

        $sql = "SELECT 
                    at.id,
                    a.car_maker,
                    a.car_model
                FROM 
                    m_applicator_terminal at 
                LEFT JOIN
                    m_applicator a ON at.applicator_no = a.applicator_no
                WHERE 
                    at.applicator_no = ? AND 
                    at.terminal_name = ?";
        $stmt = $conn->prepare($sql);
        $params = array($applicator_no, $terminal_name_split);
        $stmt->execute($params);

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if ($car_maker == $row['car_maker'] && $car_model == $row['car_model']) {
                $status = get_applicator_list_status($applicator_no, $conn);

                if ($status == 'Out') {
                    $sql = "SELECT TOP 1 id, trd_no FROM t_applicator_in_out 
                        WHERE applicator_no = ? AND trd_no = ?
                        AND zaihai_stock_address IS NULL AND date_time_in IS NULL
                        ORDER BY id DESC";
                    $stmt = $conn->prepare($sql);
                    $params = array($applicator_no, $location_before);
                    $stmt->execute($params);

                    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

                    if ($row && $location_before == $row['trd_no']) {
                        $isTransactionActive = false;
                        
                        try {
                            if (!$isTransactionActive) {
                                $conn->beginTransaction();
                                $isTransactionActive = true;
                            }
                        
                            $id = $row['id'];
                        
                            $sql = "UPDATE t_applicator_in_out 
                                    SET zaihai_stock_address = ?, operator_in = ?, date_time_in = ?
                                    WHERE id = ?";
                            $stmt = $conn->prepare($sql);
                            $params = array($location, $operator_in, $server_date_time, $id);
                            $stmt->execute($params);
                        
                            // Check the count of updated rows
                            $updated_rows = $stmt->rowCount();
                        
                            if ($updated_rows === 0) {
                                // No rows were updated, roll back the transaction
                                $conn->rollBack();
                                $error_status = 1;
                                $message = 'Failed. Please Try Again or Call IT Personnel Immediately!';

                                $error_log_arr = [
                                    'error_status' => $error_status,
                                    'error_name' => $message,
                                    'serial_no' => $serial_no,
                                    'scanned_applicator_no' => $applicator_no,
                                    'scanned_terminal_name' => $terminal_name,
                                    'scanned_trd_no' => $location_before,
                                    'scanned_by_no' => $operator_in,
                                    'interface' => 'Shop Applicator In',
                                    'zaihai_car_maker' => $car_maker,
                                    'zaihai_car_model' => $car_model,
                                    'ip' => $ip
                                ];
                        
                                insert_error_log($error_log_arr, $conn);
                                echo $message;
                                $conn = null;
                                exit();
                            }
                        
                            $sql = "UPDATE t_applicator_list 
                                    SET location = ?, status = 'Pending', date_updated = ?
                                    WHERE applicator_no = ?";
                            $stmt = $conn->prepare($sql);
                            $params = array($location, $server_date_time, $applicator_no);
                            $stmt->execute($params);
                        
                            // Commit the transaction
                            $conn->commit();
                            $isTransactionActive = false;
                            $message = 'success';
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
                                'scanned_trd_no' => $location_before,
                                'scanned_by_no' => $operator_in,
                                'interface' => 'Shop Applicator In',
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
                        $error_status = 1;
                        $message = 'Unmatched TRD / Cart Location';
                    }
                } else if ($status == 'Pending') {
                    $message = 'Applicator Already In Pending';
                } else {
                    $message = 'Applicator Currently Ready To Use';
                }
            } else {
                $message = 'Applicator Scanned On Wrong Zaihai Shop! Car Maker: ' . $row['car_maker'] . ' Car Model: ' . $row['car_model'];
            }
        } else {
            $sql = "SELECT id FROM m_applicator_terminal WHERE applicator_no = ?";
            $stmt = $conn->prepare($sql);
            $params = array($applicator_no);
            $stmt->execute($params);

            $is_applicator_found = $stmt -> fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT id FROM m_applicator_terminal WHERE terminal_name = ?";
            $stmt = $conn->prepare($sql);
            $params = array($terminal_name_split);
            $stmt->execute($params);

            $is_terminal_found = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$is_applicator_found && !$is_terminal_found) {
                $message = 'Applicator And Terminal Not Found';
            } else if (!$is_applicator_found) {
                $message = 'Applicator Not Found';
            } else if (!$is_terminal_found) {
                $message = 'Terminal Not Found';
            } else {
                $message = 'Unmatched Or Record Not Found On Applicator Terminal';
            }

            $error_status = 1;
        }
    }

    if ($message != 'success') {
        $error_log_arr = [
            'error_status' => $error_status,
            'error_name' => $message,
            'serial_no' => $serial_no,
            'scanned_applicator_no' => $applicator_no,
            'scanned_terminal_name' => $terminal_name,
            'scanned_trd_no' => $location_before,
            'scanned_by_no' => $operator_in,
            'interface' => 'Shop Applicator In',
            'zaihai_car_maker' => $car_maker,
            'zaihai_car_model' => $car_model,
            'ip' => $ip
        ];

        insert_error_log($error_log_arr, $conn);
    }

    echo $message;
}

$conn = null;
