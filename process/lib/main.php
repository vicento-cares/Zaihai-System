<?php
function get_shift($server_time) {
	if ($server_time >= '06:00:00' && $server_time < '18:00:00') {
		return 'DS';
	} else if ($server_time >= '18:00:00' && $server_time <= '23:59:59') {
		return 'NS';
	} else if ($server_time >= '00:00:00' && $server_time < '06:00:00') {
		return 'NS';
	}
}

function is_valid_applicator_no($applicator_no) {
    $pos = strpos($applicator_no, "/");

    if ($pos === false) {
        return false;
    } else {
        return true;
    }
}

function is_valid_terminal_name($terminal_name) {
    $pos = strpos($terminal_name, "*");

    if ($pos === false) {
        return false;
    } else {
        return true;
    }
}

function split_equipment_no($applicator_no) {
    $applicator_no_arr = explode("/", $applicator_no);
    return $applicator_no_arr[0];
}

function split_applicator_no($applicator_no) {
    $applicator_no_arr = explode("/", $applicator_no);
    return $applicator_no_arr[1];
}

function split_terminal_name($terminal_name) {
    $terminal_name_arr = explode("*", $terminal_name);
    return $terminal_name_arr[0];
}

function get_applicator_list_status($applicator_no, $conn) {
    $sql = "SELECT status FROM t_applicator_list WHERE applicator_no = ?";
    $stmt = $conn->prepare($sql);
    $params = array($applicator_no);
    $stmt->execute($params);
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    return $row['status'];
}

// Remove UTF-8 BOM
function removeBomUtf8($s){
    if (substr($s,0,3) == chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF'))) {
        return substr($s,3);
    } else {
        return $s;
    }
}

function containsBorrowed($string) {
    // Use strpos to find the position of "Borrowed" in the string
    $position = strpos($string, "Borrowed");
    
    // Check if the position is not false (meaning the word was found)
    if ($position !== false) {
        return true; // The word "Borrowed" is found
    } else {
        return false; // The word "Borrowed" is not found
    }
}

function insert_error_log($error_log_arr, $conn) {
    if ($error_log_arr['error_status'] == 0) {
        return;
    }
    
    $sql = "SELECT error_code FROM m_errors WHERE error_name = ?";
    $stmt = $conn->prepare($sql);
    $params = array($error_log_arr['error_name']);
    $stmt->execute($params);

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $error_code = $row['error_code'];

        $isTransactionActive = false;
    
        try {
            if (!$isTransactionActive) {
                $conn->beginTransaction();
                $isTransactionActive = true;
            }
            $sql = "INSERT INTO t_error_monitoring 
                        (error_code, serial_no, 
                        scanned_applicator_no, scanned_terminal_name, scanned_trd_no, scanned_by_no, 
                        interface, zaihai_car_maker, zaihai_car_model, ip) 
                    VALUES 
                        (?, ?, 
                        ?, ?, ?, ?, 
                        ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $params = array(
                        $error_code, 
                        $error_log_arr['serial_no'], 
                        $error_log_arr['scanned_applicator_no'], 
                        $error_log_arr['scanned_terminal_name'], 
                        $error_log_arr['scanned_trd_no'], 
                        $error_log_arr['scanned_by_no'], 
                        $error_log_arr['interface'], 
                        $error_log_arr['zaihai_car_maker'], 
                        $error_log_arr['zaihai_car_model'], 
                        $error_log_arr['ip']
                    );
            $stmt->execute($params);
        } catch (Exception $e) {
            if ($isTransactionActive) {
                $conn->rollBack();
                $isTransactionActive = false;
            }
            echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
            $conn = null;
            exit();
        }
    }
}
