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
    $sql = "SELECT status FROM t_applicator_list WHERE applicator_no = '$applicator_no'";
    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
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
