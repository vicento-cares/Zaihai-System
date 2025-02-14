<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';
include '../../lib/main.php';

// REMOTE IP ADDRESS
$ip = $_SERVER['REMOTE_ADDR'];

$method = $_POST['method'];

if ($method == 'in_applicator') {
    $id = $_POST['id'];
    $location = "BM Receiving Area";
    $operator_bm = $_SESSION['emp_no'];
    $applicator_no_new = trim($_POST['applicator_no_new']);
    $serial_no = '';

    $message = '';
    $error_status = 0;
    $error_log_arr = [];

    if (is_valid_applicator_no($applicator_no_new) == false) {
        $message = 'Invalid Applicator No.';
    } else if (empty($operator_bm)) {
        $message = 'Session was expired. Please Re-Login your account.';
    } else {
        $sql = "SELECT applicator_no, terminal_name, trd_no FROM t_applicator_in_out WHERE id = ?
                AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
        $stmt = $conn->prepare($sql);
        $params = array($id);
        $stmt->execute($params);

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $applicator_no = $row['applicator_no'];
            $terminal_name = $row['terminal_name'];
            $location_new = $row['trd_no'];

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
            $params = array($applicator_no_new, $terminal_name_split);
            $stmt->execute($params);

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $car_maker = $row['car_maker'];
                $car_model = $row['car_model'];

                $status = get_applicator_list_status($applicator_no, $conn);
                $status2 = get_applicator_list_status($applicator_no_new, $conn);

                if ($status == 'Out' && $status2 == 'Ready To Use') {
                    $sql = "SELECT TOP 1 
                                aio.id, 
                                a.car_maker, 
                                a.car_model
                            FROM 
                                t_applicator_in_out aio 
                            LEFT JOIN 
                                m_applicator a ON aio.applicator_no = a.applicator_no
                            WHERE 
                                aio.applicator_no = ? AND 
                                aio.zaihai_stock_address IS NULL 
                                AND aio.date_time_in IS NULL
                            ORDER BY 
                                aio.id DESC";
                    $stmt = $conn->prepare($sql);
                    $params = array($applicator_no);
                    $stmt->execute($params);

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($car_maker != $row['car_maker'] && $car_model != $row['car_model']) {
                        $message = 'Unmatched Applicator New and Applicator Old on Car Maker / Car Model! Car Maker: ' . $row['car_maker'] . ' Car Model: ' . $row['car_model'];
                    } else {
                        $isTransactionActive = false;

                        try {
                            if (!$isTransactionActive) {
                                $conn->beginTransaction();
                                $isTransactionActive = true;
                            }

                            $id = $row['id'];
                        
                            // Applicator In Pending (BM)
                            $sql = "UPDATE t_applicator_in_out 
                                    SET zaihai_stock_address = ?, operator_in = ?, date_time_in = ?
                                    WHERE id = ?";
                            $stmt = $conn -> prepare($sql);
                            $params = array($location, $operator_bm, $server_date_time, $id);
                            $stmt -> execute($params);
    
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
                                    'scanned_trd_no' => $location,
                                    'scanned_by_no' => $operator_bm,
                                    'interface' => 'BM Applicator In',
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

                            // Applicator New Out (BM)
                            // $serial_no = date("ymdh");
                            // $rand = substr(md5(microtime()),rand(0,26),5);
                            // $serial_no = 'MEI-295-AC-'.$serial_no;
                            // $serial_no = $serial_no.''.$rand;
                            $serial_no = str_replace('.', '', uniqid('MEI-295-AC-', true));

                            $sql = "INSERT INTO t_applicator_in_out (serial_no, applicator_no, terminal_name, trd_no, operator_out) 
                                    VALUES (?, ?, ?, ?, ?)";
                            $stmt = $conn -> prepare($sql);
                            $params = array($serial_no, $applicator_no_new, $terminal_name, $location_new, $operator_bm);
                            $stmt -> execute($params);

                            $sql = "UPDATE t_applicator_list 
                                    SET location = ?, status = 'Out', date_updated = ?
                                    WHERE applicator_no = ?";
                            $stmt = $conn->prepare($sql);
                            $params = array($location_new, $server_date_time, $applicator_no_new);
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
                                'serial_no' => $serial_no,
                                'scanned_applicator_no' => $applicator_no,
                                'scanned_terminal_name' => $terminal_name,
                                'scanned_trd_no' => $location,
                                'scanned_by_no' => $operator_bm,
                                'interface' => 'BM Applicator In',
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
                } else if ($status == 'Pending' && $status2 == 'Out') {
                    $message = 'Applicator Already In Pending or Applicator New Already Out';
                } else if ($status == 'Out' && $status2 == 'Out') {
                    $message = 'Applicator or Applicator New Already Out';
                } else {
                    $message = 'Applicator Currently Ready To Use or Applicator New Still Pending';
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
                    $message = 'Applicator New And Terminal Not Found';
                } else if (!$is_applicator_found) {
                    $message = 'Applicator New Not Found';
                } else if (!$is_terminal_found) {
                    $message = 'Terminal Not Found';
                } else {
                    $message = 'Unmatched Or Record Not Found On Applicator Terminal (Applicator New)';
                }

                $error_status = 1;
            }
        } else {
            $message = 'Applicator Out Record was lost or already in';
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
            'scanned_by_no' => $operator_bm,
            'interface' => 'BM Applicator In',
            'zaihai_car_maker' => $car_maker,
            'zaihai_car_model' => $car_model,
            'ip' => $ip
        ];

        insert_error_log($error_log_arr, $conn);
    }

    echo $message;
}
