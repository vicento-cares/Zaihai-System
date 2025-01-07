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
    $car_maker = $_SESSION['car_maker'];
    $car_model = $_SESSION['car_model'];

    if (empty($location)) {
        echo 'Please Select Borrowed By or Remarks';
    } else if (is_valid_applicator_no($applicator_no) == false) {
        echo 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        echo 'Invalid Terminal Name';
    } else if (empty($operator_out)) {
        echo 'Session was expired. Please Re-Login your account.';
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
                        $sql = "SELECT id FROM t_applicator_in_out 
                                WHERE trd_no = ?";
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
                            $serial_no = date("ymdh");
                            $rand = substr(md5(microtime()),rand(0,26),5);
                            $serial_no = 'MEI-295-AC-'.$serial_no;
                            $serial_no = $serial_no.''.$rand;

                            $isTransactionActive = false;

                            try {
                                if (!$isTransactionActive) {
                                    $conn->beginTransaction();
                                    $isTransactionActive = true;
                                }
                            
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
                        } else {
                            echo 'TRD Cart Currently Used';
                        }
                    } else {
                        echo 'Applicator Already Out';
                    }
                } else if ($status == 'Out') {
                    echo 'Applicator Already Out';
                } else {
                    echo 'Applicator Still Pending';
                }
            } else {
                echo 'Applicator Scanned On Wrong Zaihai Shop! Car Maker: ' . $row['car_maker'] . ' Car Model: ' . $row['car_model'];
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
                echo 'Applicator And Terminal Not Found';
            } else if (!$is_applicator_found) {
                echo 'Applicator Not Found';
            } else if (!$is_terminal_found) {
                echo 'Terminal Not Found';
            } else {
                echo 'Unmatched Or Record Not Found On Applicator Terminal';
            }
        }
    }
}

if ($method == 'in_applicator') {
    $location_before = $_POST['location_before'];
    $location = "Zaihai Receiving Area";
    $applicator_no = $_POST['applicator_no'];
    $terminal_name = $_POST['terminal_name'];
    $operator_in = $_SESSION['emp_no'];
    $car_maker = $_SESSION['car_maker'];
    $car_model = $_SESSION['car_model'];

    if (empty($location_before)) {
        echo 'Please Select Borrowed By or Remarks';
    } else if (is_valid_applicator_no($applicator_no) == false) {
        echo 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        echo 'Invalid Terminal Name';
    } else if (empty($operator_in)) {
        echo 'Session was expired. Please Re-Login your account.';
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
                                echo 'Failed. Please Try Again or Call IT Personnel Immediately!';
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
                            echo 'success';
                        } catch (Exception $e) {
                            if ($isTransactionActive) {
                                $conn->rollBack();
                                $isTransactionActive = false;
                            }
                            echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
                            exit();
                        }
                    } else {
                        echo 'Unmatched TRD / Cart Location';
                    }
                } else if ($status == 'Pending') {
                    echo 'Applicator Already In Pending';
                } else {
                    echo 'Applicator Currently Ready To Use';
                }
            } else {
                echo 'Applicator Scanned On Wrong Zaihai Shop! Car Maker: ' . $row['car_maker'] . ' Car Model: ' . $row['car_model'];
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
                echo 'Applicator And Terminal Not Found';
            } else if (!$is_applicator_found) {
                echo 'Applicator Not Found';
            } else if (!$is_terminal_found) {
                echo 'Terminal Not Found';
            } else {
                echo 'Unmatched Or Record Not Found On Applicator Terminal';
            }
        }
    }
}
