<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

include '../../conn.php';
include '../../lib/main.php';

$method = $_GET['method'];

// Get Car Maker Dropdown Out
if ($method == 'get_car_maker_dropdown_out_search') {
	$sql = "SELECT al.car_maker FROM t_applicator_in_out aio
            LEFT JOIN t_applicator_list al ON aio.applicator_no = al.applicator_no
            WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL
            GROUP BY al.car_maker ORDER BY al.car_maker ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">All</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_maker']).'">'.htmlspecialchars($row['car_maker']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Car Model Dropdown Out
if ($method == 'get_car_model_dropdown_out_search') {
	$sql = "SELECT al.car_model FROM t_applicator_in_out aio
            LEFT JOIN t_applicator_list al ON aio.applicator_no = al.applicator_no
            WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL
            GROUP BY al.car_model ORDER BY al.car_model ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">All</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Applicator No. Datalist Out
if ($method == 'get_applicator_no_datalist_out_search') {
	$sql = "SELECT applicator_no FROM t_applicator_in_out 
            WHERE zaihai_stock_address IS NULL AND date_time_in IS NULL
            GROUP BY applicator_no ORDER BY applicator_no ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['applicator_no'].'">';
		}
	}
}

// Get Terminal Name Datalist Out
if ($method == 'get_terminal_name_datalist_out_search') {
	$sql = "SELECT terminal_name FROM t_applicator_in_out 
            WHERE zaihai_stock_address IS NULL AND date_time_in IS NULL
            GROUP BY terminal_name ORDER BY terminal_name ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['terminal_name'].'">';
		}
	}
}

// Get Location Datalist Out
if ($method == 'get_location_datalist_out_search') {
	$sql = "SELECT trd_no FROM t_applicator_in_out 
            WHERE zaihai_stock_address IS NULL AND date_time_in IS NULL
            GROUP BY trd_no ORDER BY trd_no ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['trd_no'].'">';
		}
	}
}

// Get Car Maker Dropdown In
if ($method == 'get_car_maker_dropdown_in_search') {
	$sql = "SELECT al.car_maker FROM t_applicator_in_out aio
            LEFT JOIN t_applicator_list al ON aio.applicator_no = al.applicator_no
            WHERE aio.zaihai_stock_address IS NOT NULL AND aio.date_time_in IS NOT NULL
            GROUP BY al.car_maker ORDER BY al.car_maker ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">All</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_maker']).'">'.htmlspecialchars($row['car_maker']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Car Model Dropdown In
if ($method == 'get_car_model_dropdown_in_search') {
	$sql = "SELECT al.car_model FROM t_applicator_in_out aio
            LEFT JOIN t_applicator_list al ON aio.applicator_no = al.applicator_no
            WHERE aio.zaihai_stock_address IS NOT NULL AND aio.date_time_in IS NOT NULL
            GROUP BY al.car_model ORDER BY al.car_model ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="">All</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Applicator No. Datalist In
if ($method == 'get_applicator_no_datalist_in_search') {
	$sql = "SELECT applicator_no FROM t_applicator_in_out 
            WHERE zaihai_stock_address IS NOT NULL AND date_time_in IS NOT NULL
            GROUP BY applicator_no ORDER BY applicator_no ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['applicator_no'].'">';
		}
	}
}

// Get Terminal Name Datalist In
if ($method == 'get_terminal_name_datalist_in_search') {
	$sql = "SELECT terminal_name FROM t_applicator_in_out 
            WHERE zaihai_stock_address IS NOT NULL AND date_time_in IS NOT NULL
            GROUP BY terminal_name ORDER BY terminal_name ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['terminal_name'].'">';
		}
	}
}

// Get Location Datalist In
if ($method == 'get_location_datalist_in_search') {
	$sql = "SELECT trd_no FROM t_applicator_in_out 
            WHERE zaihai_stock_address IS NOT NULL AND date_time_in IS NOT NULL
            GROUP BY trd_no ORDER BY trd_no ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['trd_no'].'">';
		}
	}
}

if ($method == 'get_recent_applicator_out') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];
    $location = $_GET['location'];

    $c = 0;

    $sql = "SELECT aio.serial_no, aio.applicator_no, aio.terminal_name, aio.trd_no, aio.operator_out, aio.date_time_out,
            al.car_maker, al.car_model
            FROM t_applicator_in_out aio
            LEFT JOIN t_applicator_list al ON aio.applicator_no = al.applicator_no
            WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL";
    if (!empty($car_maker)) {
        $sql .= " AND al.car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND al.car_model='$car_model'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND aio.applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND aio.terminal_name LIKE '%$terminal_name%'";
    }
    if (!empty($location)) {
        $sql .= " AND aio.location LIKE '%$location%'";
    }
    $sql .= " ORDER BY aio.date_time_out DESC";
    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;
            echo '<tr>';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['serial_no'].'</td>';
            echo '<td>'.$row['car_maker'].'</td>';
            echo '<td>'.$row['car_model'].'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['terminal_name'].'</td>';
            echo '<td>'.$row['trd_no'].'</td>';
            echo '<td>'.$row['operator_out'].'</td>';
            echo '<td>'.$row['date_time_out'].'</td>';
            echo '</tr>';
        }
    }
}

if ($method == 'get_applicator_in_pending_details') {
    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];

    $applicator_out_data_arr = array();
    $message = '';

    if (isset($_SESSION['emp_no'])) {
        $operator_in = $_SESSION['emp_no'];
        $operator_in_name = $_SESSION['full_name'];

        if (is_valid_applicator_no($applicator_no) == false) {
            $message = 'Invalid Applicator No';
        } else if (is_valid_terminal_name($terminal_name) == false) {
            $message = 'Invalid Terminal Name';
        } else {
            $equipment_no_split = split_equipment_no($applicator_no);
            $applicator_no_split = split_applicator_no($applicator_no);
            $terminal_name_split = split_terminal_name($terminal_name);
    
            $sql = "SELECT zaihai_stock_address, line_address FROM m_applicator WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name_split'";
            $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
    
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                $zaihai_stock_address = $row['zaihai_stock_address'];
                $line_address = $row['line_address'];

                $status = get_applicator_list_status($applicator_no, $conn);

                if ($status == 'Pending') {
                    $sql = "SELECT TOP 1 serial_no FROM t_applicator_in_out 
                        WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'
                        ORDER BY id DESC";
                    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                    $stmt->execute();

                    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        $applicator_out_data_arr = array(
                            "serial_no" => $row['serial_no'],
                            "zaihai_stock_address" => $zaihai_stock_address,
                            "line_address" => $line_address,
                            "equipment_no" => $equipment_no_split,
                            "applicator_no" => $applicator_no_split,
                            "terminal_name" => $terminal_name_split,
                            "inspection_date_time" => $server_date_time,
                            "inspection_date" => $server_date_only,
                            "inspection_time" => $server_time,
                            "inspection_shift" => get_shift($server_time),
                            "inspected_by" => $operator_in_name,
                            "inspected_by_no" => $operator_in
                        );

                        $message = 'success';
                    } else {
                        $message = 'Serial No. Not Found. Call IT Personnel Immediately!';
                    }
                } else if ($status == 'Ready To Use') {
                    $message = 'Applicator Currently Ready To Use';
                } else {
                    $message = 'Applicator Currently Out';
                }
            } else {
                $message = 'Applicator Not Found';
            }
        }
    } else {
        $message = 'Session Timeout';
    }

    $message_arr = array(
        "message" => $message
    );

    $response_arr = array_merge($applicator_out_data_arr, $message_arr);

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'get_recent_applicator_in') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];
    $location = $_GET['location'];

    $c = 0;

    $sql = "SELECT t1.serial_no, t1.applicator_no, t1.terminal_name, 
                t1.trd_no, t1.operator_out, t1.date_time_out, 
                t1.zaihai_stock_address, t1.operator_in, t1.date_time_in, 
                al.car_maker, al.car_model
            FROM t_applicator_in_out t1
            JOIN (
                SELECT applicator_no, terminal_name, MAX(date_time_in) AS max_date_time_in
                FROM t_applicator_in_out
                WHERE zaihai_stock_address IS NOT NULL AND date_time_in IS NOT NULL
                GROUP BY applicator_no, terminal_name
            ) t2
            ON t1.applicator_no = t2.applicator_no
            AND t1.terminal_name = t2.terminal_name
            AND t1.date_time_in = t2.max_date_time_in
            LEFT JOIN t_applicator_list al ON t1.applicator_no = al.applicator_no
            WHERE t1.zaihai_stock_address IS NOT NULL AND t1.date_time_in IS NOT NULL";

    if (!empty($car_maker)) {
        $sql .= " AND t1.car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND t1.car_model='$car_model'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND t1.applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND t1.terminal_name LIKE '%$terminal_name%'";
    }
    if (!empty($location)) {
        $sql .= " AND t1.location LIKE '%$location%'";
    }

    $sql .= " ORDER BY t1.date_time_in DESC";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;

            echo '<tr>';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['serial_no'].'</td>';
            echo '<td>'.$row['car_maker'].'</td>';
            echo '<td>'.$row['car_model'].'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['terminal_name'].'</td>';
            echo '<td>'.$row['trd_no'].'</td>';
            echo '<td>'.$row['operator_out'].'</td>';
            echo '<td>'.$row['date_time_out'].'</td>';
            echo '<td>'.$row['zaihai_stock_address'].'</td>';
            echo '<td>'.$row['operator_in'].'</td>';
            echo '<td>'.$row['date_time_in'].'</td>';
            echo '</tr>';
        }
    }
}