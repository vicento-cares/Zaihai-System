<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';
include '../../lib/main.php';

$method = $_POST['method'];

if ($method == 'in_applicator') {
    $id = $_POST['id'];
    $location = "BM Receiving Area";
    $operator_bm = $_SESSION['emp_no'];
    $applicator_no_new = $_POST['applicator_no_new'];

    if (is_valid_applicator_no($applicator_no_new) == false) {
        echo 'Invalid Applicator No.';
    } else if (empty($operator_bm)) {
        echo 'Session was expired. Please Re-Login your account.';
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

            $sql = "SELECT id FROM m_applicator_terminal WHERE applicator_no = ? AND terminal_name = ?";
            $stmt = $conn->prepare($sql);
            $params = array($applicator_no_new, $terminal_name_split);
            $stmt->execute($params);

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $status = get_applicator_list_status($applicator_no, $conn);
                $status2 = get_applicator_list_status($applicator_no_new, $conn);

                if ($status == 'Out' && $status2 == 'Ready To Use') {
                    try {
                        $conn->beginTransaction();

                        $terminal_name_param = $terminal_name_split . '%';
                    
                        // Applicator In Pending (BM)
                        $sql = "UPDATE t_applicator_in_out 
                        SET zaihai_stock_address = ?, operator_in = ?, date_time_in = ?
                        WHERE applicator_no = ? AND terminal_name LIKE ?
                        AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
                        $stmt = $conn -> prepare($sql);
                        $params = array($location, $operator_bm, $server_date_time, $applicator_no, $terminal_name_param);
                        $stmt -> execute($params);

                        // Check the count of updated rows
                        $updated_rows = $stmt->rowCount();

                        if ($updated_rows === 0) {
                            // No rows were updated
                            echo 'Failed. Unmatched Out And Scanned Terminal';
                        } else {
                            $sql = "UPDATE t_applicator_list 
                                SET location = ?, status = 'Pending', date_updated = ?
                                WHERE applicator_no = ?";
                            $stmt = $conn->prepare($sql);
                            $params = array($location, $server_date_time, $applicator_no);
                            $stmt->execute($params);

                            // Applicator New Out (BM)
                            $serial_no = date("ymdh");
                            $rand = substr(md5(microtime()),rand(0,26),5);
                            $serial_no = 'MEI-295-AC-'.$serial_no;
                            $serial_no = $serial_no.''.$rand;

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
                            echo 'success';
                        }
                    } catch (Exception $e) {
                        $conn->rollBack();
                        echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
                    }
                } else if ($status == 'Pending' && $status2 == 'Out') {
                    echo 'Applicator Already In Pending or Applicator New Already Out';
                } else if ($status == 'Out' && $status2 == 'Out') {
                    echo 'Applicator or Applicator New Already Out';
                } else {
                    echo 'Applicator Currently Ready To Use or Applicator New Still Pending';
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
                    echo 'Applicator New And Terminal Not Found';
                } else if (!$is_applicator_found) {
                    echo 'Applicator New Not Found';
                } else if (!$is_terminal_found) {
                    echo 'Terminal Not Found';
                } else {
                    echo 'Unmatched Or Record Not Found On Applicator Terminal (Applicator New)';
                }
            }
        } else {
            echo 'Applicator Out Record was lost or already in';
        }
    }
}
