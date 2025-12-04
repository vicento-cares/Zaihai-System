<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';

$method = $_GET['method'];

$role = "";

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
}

if ($method == 'get_recent_applicator_in_pending') {
    $car_maker = '';
    $car_model = '';

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker']) || isset($_SESSION['car_model']) || isset($_SESSION['role'])) {
            $car_maker = $_SESSION['car_maker'];
            $car_model = $_SESSION['car_model'];
            $role = $_SESSION['role'];
        } else {
            echo 'Session was expired. Please Re-Login your account.';
            $conn = null;
            exit();
        }
    } else {
        $car_maker = addslashes($_GET['car_maker']);
        $car_model = addslashes($_GET['car_model']);
    }

    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];
    $location = $_GET['location'];
    // $role = $_SESSION['role'];

    $c = 0;

    $sql = "SELECT t1.serial_no, t1.applicator_no, t1.terminal_name, 
                t1.trd_no, t1.operator_out, t1.date_time_out, 
                t1.zaihai_stock_address, t1.operator_in, t1.date_time_in, 
                -- Downtime column
                CASE 
                    WHEN DATEDIFF(MINUTE, t1.date_time_in, GETDATE()) > 1440 THEN 1 
                    ELSE 0 
                END AS downtime, 
                a.car_maker, a.car_model
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
            LEFT JOIN m_applicator a ON t1.applicator_no = a.applicator_no
            LEFT JOIN t_applicator_c ac ON t1.serial_no = ac.serial_no
            LEFT JOIN m_accounts acct ON t1.operator_in = acct.emp_no
            WHERE t1.zaihai_stock_address IS NOT NULL AND t1.date_time_in IS NOT NULL 
            AND ac.serial_no IS NULL";

    if (!empty($car_maker)) {
        $sql .= " AND a.car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND a.car_model='$car_model'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND t1.applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND t1.terminal_name LIKE '%$terminal_name%'";
    }
    if (!empty($location)) {
        $sql .= " AND t1.trd_no LIKE '%$location%'";
    }
    if ($role == 'BM') {
        $sql .= " AND acct.role = '$role'";
    } else if ($role == 'Shop' || $role == 'Inspector') {
        $sql .= " AND acct.role IN ('Shop', 'Inspector')";
    }

    $sql .= " ORDER BY t1.date_time_in ASC";

    $stmt = $conn->prepare($sql);
	$stmt->execute();

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $c++;

        $row_class = '';
        if (intval($row['downtime']) == 1) {
            $row_class = 'bg-danger';
        }

        // Add Slashes if has Slashes Symbol Existed
        $terminal_name = addslashes($row['terminal_name']);
        // Add Slashes after if has backticks (Resolve get_applicator_in_pending_details function error)
        $terminal_name = htmlspecialchars(str_replace("`", "\\`", $terminal_name));

        echo '<tr style="cursor:pointer;" class="modal-trigger '.$row_class.'" 
                onclick="get_applicator_in_pending_details(&#96;'.htmlspecialchars($row['applicator_no']).'~!~'.$terminal_name.'&#96;)">';
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

// Get Car Maker Dropdown In
if ($method == 'get_car_maker_dropdown_in_search') {
	$sql = "SELECT a.car_maker FROM t_applicator_in_out aio
            LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no
            LEFT JOIN m_accounts acct ON aio.operator_in = acct.emp_no 
            LEFT JOIN t_applicator_c ac ON aio.serial_no = ac.serial_no 
            WHERE aio.zaihai_stock_address IS NOT NULL AND aio.date_time_in IS NOT NULL 
            AND ac.created_from_itf = 1 AND ac.shop_confirmed_by IS NULL AND ac.shop_confirmed_date_time IS NULL";

    if (isset($_GET['page']) && $_GET['page'] == 'checksheet') {
        if ($role == 'BM') {
            $sql .= " AND acct.role = '$role'";
        } else if ($role == 'Shop' || $role == 'Inspector') {
            $sql .= " AND acct.role IN ('Shop', 'Inspector')";
        }
    }

    $sql .= " GROUP BY a.car_maker ORDER BY a.car_maker ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($results) > 0) {
		echo '<option selected value="">All</option>';
		foreach ($results as $row) {
			echo '<option value="'.htmlspecialchars($row['car_maker']).'">'.htmlspecialchars($row['car_maker']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Car Model Dropdown In
if ($method == 'get_car_model_dropdown_in_search') {
	$sql = "SELECT a.car_model FROM t_applicator_in_out aio
            LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no
            LEFT JOIN m_accounts acct ON aio.operator_in = acct.emp_no 
            LEFT JOIN t_applicator_c ac ON aio.serial_no = ac.serial_no 
            WHERE aio.zaihai_stock_address IS NOT NULL AND aio.date_time_in IS NOT NULL 
            AND ac.created_from_itf = 1 AND ac.shop_confirmed_by IS NULL AND ac.shop_confirmed_date_time IS NULL";

    if (isset($_GET['page']) && $_GET['page'] == 'checksheet') {
        if ($role == 'BM') {
            $sql .= " AND acct.role = '$role'";
        } else if ($role == 'Shop' || $role == 'Inspector') {
            $sql .= " AND acct.role IN ('Shop', 'Inspector')";
        }
    }

    $sql .= " GROUP BY a.car_model ORDER BY a.car_model ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($results) > 0) {
		echo '<option selected value="">All</option>';
		foreach ($results as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Applicator No. Datalist In
if ($method == 'get_applicator_no_datalist_in_search') {
	$sql = "SELECT aio.applicator_no FROM t_applicator_in_out aio";
    
    if (isset($_GET['page']) && ($_GET['page'] == 'shop' || $_GET['page'] == 'checksheet')) {
        $sql .= " LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no";
    }

    $sql .= " LEFT JOIN m_accounts acct ON aio.operator_in = acct.emp_no 
            LEFT JOIN t_applicator_c ac ON aio.serial_no = ac.serial_no 
            WHERE aio.zaihai_stock_address IS NOT NULL AND aio.date_time_in IS NOT NULL 
            AND ac.created_from_itf = 1 AND ac.shop_confirmed_by IS NULL AND ac.shop_confirmed_date_time IS NULL";

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
            $sql .= " AND a.car_maker = '$car_maker'";
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
            $sql .= " AND a.car_model = '$car_model'";
        }
    }
    
    if (isset($_GET['page']) && $_GET['page'] == 'checksheet') {
        if ($role == 'Shop' || $role == 'Inspector') {
            if (isset($_SESSION['car_maker'])) {
                $car_maker = $_SESSION['car_maker'];
                $sql .= " AND a.car_maker = '$car_maker'";
            }
        
            if (isset($_SESSION['car_model'])) {
                $car_model = $_SESSION['car_model'];
                $sql .= " AND a.car_model = '$car_model'";
            }
        }
    }

    $sql .= " GROUP BY aio.applicator_no ORDER BY aio.applicator_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['applicator_no'].'">';
	}
}

// Get Terminal Name Datalist In
if ($method == 'get_terminal_name_datalist_in_search') {
	$sql = "SELECT aio.terminal_name FROM t_applicator_in_out aio";

    if (isset($_GET['page']) && ($_GET['page'] == 'shop' || $_GET['page'] == 'checksheet')) {
        $sql .= " LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no";
    }

    $sql .= " LEFT JOIN m_accounts acct ON aio.operator_in = acct.emp_no 
            LEFT JOIN t_applicator_c ac ON aio.serial_no = ac.serial_no 
            WHERE aio.zaihai_stock_address IS NOT NULL AND aio.date_time_in IS NOT NULL 
            AND ac.created_from_itf = 1 AND ac.shop_confirmed_by IS NULL AND ac.shop_confirmed_date_time IS NULL";
    
    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
            $sql .= " AND a.car_maker = '$car_maker'";
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
            $sql .= " AND a.car_model = '$car_model'";
        }
    }
    
    if (isset($_GET['page']) && $_GET['page'] == 'checksheet') {
        if ($role == 'Shop' || $role == 'Inspector') {
            if (isset($_SESSION['car_maker'])) {
                $car_maker = $_SESSION['car_maker'];
                $sql .= " AND a.car_maker = '$car_maker'";
            }
        
            if (isset($_SESSION['car_model'])) {
                $car_model = $_SESSION['car_model'];
                $sql .= " AND a.car_model = '$car_model'";
            }
        }
    }

    $sql .= " GROUP BY aio.terminal_name ORDER BY aio.terminal_name ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['terminal_name'].'">';
	}
}

// Get Location Datalist In
if ($method == 'get_location_datalist_in_search') {
	$sql = "SELECT aio.trd_no FROM t_applicator_in_out aio";

    if (isset($_GET['page']) && ($_GET['page'] == 'shop' || $_GET['page'] == 'checksheet')) {
        $sql .= " LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no";
    }

    $sql .= " LEFT JOIN m_accounts acct ON aio.operator_in = acct.emp_no 
            LEFT JOIN t_applicator_c ac ON aio.serial_no = ac.serial_no 
            WHERE aio.zaihai_stock_address IS NOT NULL AND aio.date_time_in IS NOT NULL 
            AND ac.created_from_itf = 1 AND ac.shop_confirmed_by IS NULL AND ac.shop_confirmed_date_time IS NULL";
    
    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
            $sql .= " AND a.car_maker = '$car_maker'";
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
            $sql .= " AND a.car_model = '$car_model'";
        }
    }

    if (isset($_GET['page']) && $_GET['page'] == 'checksheet') {
        if ($role == 'Shop' || $role == 'Inspector') {
            if (isset($_SESSION['car_maker'])) {
                $car_maker = $_SESSION['car_maker'];
                $sql .= " AND a.car_maker = '$car_maker'";
            }
        
            if (isset($_SESSION['car_model'])) {
                $car_model = $_SESSION['car_model'];
                $sql .= " AND a.car_model = '$car_model'";
            }
        }
    }

    $sql .= " GROUP BY aio.trd_no ORDER BY aio.trd_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="'.$row['trd_no'].'">';
    }
}

if ($method == 'get_recent_applicator_in_shop_confirm') {
    $car_maker = '';
    $car_model = '';

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
        }
    } else {
        $car_maker = addslashes($_GET['car_maker']);
        $car_model = addslashes($_GET['car_model']);
    }

    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];
    $location = $_GET['location'];

    $c = 0;

    $sql = "SELECT t1.serial_no, t1.applicator_no, t1.terminal_name, 
                t1.trd_no, t1.operator_out, t1.date_time_out, 
                t1.zaihai_stock_address, t1.operator_in, t1.date_time_in, 
                -- Downtime column
                CASE 
                    WHEN DATEDIFF(MINUTE, t1.date_time_in, GETDATE()) > 1440 THEN 1 
                    ELSE 0 
                END AS downtime, 
                a.car_maker, a.car_model
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
            LEFT JOIN m_applicator a ON t1.applicator_no = a.applicator_no
            LEFT JOIN t_applicator_c ac ON t1.serial_no = ac.serial_no
            WHERE t1.zaihai_stock_address IS NOT NULL AND t1.date_time_in IS NOT NULL 
            AND ac.created_from_itf = 1 AND ac.shop_confirmed_by IS NULL AND ac.shop_confirmed_date_time IS NULL";

    if (!empty($car_maker)) {
        $sql .= " AND a.car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND a.car_model='$car_model'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND t1.applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND t1.terminal_name LIKE '%$terminal_name%'";
    }
    if (!empty($location)) {
        $sql .= " AND t1.trd_no LIKE '%$location%'";
    }

    $sql .= " ORDER BY t1.date_time_in ASC";

    $stmt = $conn->prepare($sql);
	$stmt->execute();

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $c++;

        $row_class = '';
        if (intval($row['downtime']) == 1) {
            $row_class = 'bg-danger';
        }

        echo '<tr style="cursor:pointer;" class="modal-trigger '.$row_class.'" 
                onclick="get_applicator_in_shop_confirm_details(&quot;'.htmlspecialchars($row['serial_no']).'&quot;)">';
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

if ($method == 'get_applicator_in_shop_confirm_details') {
    $serial_no = $_GET['serial_no'];

    $data = [];

    $sql = "SELECT *
            FROM 
                t_applicator_c
            WHERE
                serial_no = ?";
    $params[] = $serial_no;

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $row = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($row) { 
        $inspection_date = '';
        $inspection_time = '';

        if (!empty($row['inspection_date_time'])) {
            $inspection_date_time = new DateTime($row['inspection_date_time']);
            $inspection_date = $inspection_date_time->format('Y-m-d');
            $inspection_time = $inspection_date_time->format('H:i:s');
        }
        
        $data = [
            'serial_no' => $row['serial_no'],
            'equipment_no' => $row['equipment_no'],
            'applicator_no' => $row['machine_no'],
            'terminal_name' => $row['terminal_name'],
            'inspection_date' => $inspection_date,
            'inspection_time' => $inspection_time,
            'inspection_shift' => $row['inspection_shift'],
            'adjustment_content' => $row['adjustment_content'],
            'adjustment_content_remarks' => $row['adjustment_content_remarks'],
            'cross_section_result' => intval($row['cross_section_result']),
            'inspected_by' => $row['inspected_by'],
            'checked_by' => $row['checked_by'],
            'confirmed_by' => $row['confirmed_by'],
            'judgement' => intval($row['judgement']),
            'ac1' => intval($row['ac1']),
            'ac2' => intval($row['ac2']),
            'ac3' => intval($row['ac3']),
            'ac4' => intval($row['ac4']),
            'ac5' => intval($row['ac5']),
            'ac6' => intval($row['ac6']),
            'ac7' => intval($row['ac7']),
            'ac8' => intval($row['ac8']),
            'ac9' => intval($row['ac9']),
            'ac10' => intval($row['ac10']),
            'ac1_s' => $row['ac1_s'],
            'ac2_s' => $row['ac2_s'],
            'ac3_s' => $row['ac3_s'],
            'ac4_s' => $row['ac4_s'],
            'ac5_s' => $row['ac5_s'],
            'ac6_s' => $row['ac6_s'],
            'ac7_s' => $row['ac7_s'],
            'ac8_s' => $row['ac8_s'],
            'ac9_s' => $row['ac9_s'],
            'ac10_s' => $row['ac10_s'],
            'ac1_r' => $row['ac1_r'],
            'ac2_r' => $row['ac2_r'],
            'ac3_r' => $row['ac3_r'],
            'ac4_r' => $row['ac4_r'],
            'ac5_r' => $row['ac5_r'],
            'ac6_r' => $row['ac6_r'],
            'ac7_r' => $row['ac7_r'],
            'ac8_r' => $row['ac8_r'],
            'ac9_r' => $row['ac9_r'],
            'ac10_r' => $row['ac10_r'],
            'message' => 'success'
        ];
    }

    if (empty($data)) {
        $data = ['message' => 'Checksheet Not Found'];
    }
    
    echo json_encode($data);
}

$conn = null;
