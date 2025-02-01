<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../conn.php';

$method = $_GET['method'];

$role = "";

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
}

// Get Car Maker Dropdown Out
if ($method == 'get_car_maker_dropdown_out_search') {
	$sql = "SELECT a.car_maker FROM t_applicator_in_out aio
            LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no
            WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL
            GROUP BY a.car_maker ORDER BY a.car_maker ASC";
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
	$sql = "SELECT a.car_model FROM t_applicator_in_out aio
            LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no
            WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL
            GROUP BY a.car_model ORDER BY a.car_model ASC";
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
	$sql = "SELECT aio.applicator_no FROM t_applicator_in_out aio";

    if (isset($_GET['page']) && ($_GET['page'] == 'shop')) {
        $sql .= " LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no";
    }

    $sql .= " WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL";

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
    
    $sql .= " GROUP BY aio.applicator_no ORDER BY aio.applicator_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['applicator_no'].'">';
	}
}

// Get Terminal Name Datalist Out
if ($method == 'get_terminal_name_datalist_out_search') {
	$sql = "SELECT aio.terminal_name FROM t_applicator_in_out aio";

    if (isset($_GET['page']) && ($_GET['page'] == 'shop')) {
        $sql .= " LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no";
    }

    $sql .= " WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL";

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
    
    $sql .= " GROUP BY aio.terminal_name ORDER BY aio.terminal_name ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['terminal_name'].'">';
	}
}

// Get Location Datalist Out
if ($method == 'get_location_datalist_out_search') {
	$sql = "SELECT aio.trd_no FROM t_applicator_in_out aio";
    
    if (isset($_GET['page']) && ($_GET['page'] == 'shop')) {
        $sql .= " LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no";
    }

    $sql .= " WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL";

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

    $sql .= " GROUP BY aio.trd_no ORDER BY aio.trd_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['trd_no'].'">';
	}
}

if ($method == 'get_recent_applicator_out') {
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

    $applicator_no = addslashes($_GET['applicator_no']);
    $terminal_name = addslashes($_GET['terminal_name']);
    $location = addslashes($_GET['location']);

    $c = 0;

    $sql = "SELECT aio.id, aio.serial_no, aio.applicator_no, aio.terminal_name, aio.trd_no, aio.operator_out, aio.date_time_out,
            a.car_maker, a.car_model, 
            -- Downtime column
            CASE 
                WHEN DATEDIFF(MINUTE, aio.date_time_out, GETDATE()) > 1440 THEN 1 
                ELSE 0 
            END AS downtime
            FROM t_applicator_in_out aio
            LEFT JOIN m_applicator a ON aio.applicator_no = a.applicator_no
            WHERE aio.zaihai_stock_address IS NULL AND aio.date_time_in IS NULL";
    if (!empty($car_maker)) {
        $sql .= " AND a.car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND a.car_model='$car_model'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND aio.applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND aio.terminal_name LIKE '%$terminal_name%'";
    }
    if (!empty($location)) {
        $sql .= " AND aio.trd_no LIKE '%$location%'";
    }
    $sql .= " ORDER BY aio.date_time_out ASC";

    $stmt = $conn->prepare($sql);
	$stmt->execute();

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $c++;

        $row_class = '';
        if (intval($row['downtime']) == 1) {
            $row_class = 'bg-danger';
        }

        // If Role is BM
        if ($role == 'BM') {
            echo '<tr style="cursor:pointer;" class="modal-trigger '.$row_class.'" data-toggle="modal" data-target="#applicator_in_bm"
                onclick="get_applicator_out_details(&quot;'.$row['id'].'&quot;)">';
        } else {
            echo '<tr class="'.$row_class.'">';
        }
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

$conn = null;
