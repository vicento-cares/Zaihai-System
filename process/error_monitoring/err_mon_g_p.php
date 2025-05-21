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
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT zaihai_car_maker FROM t_error_monitoring
            WHERE date_started IS NULL AND 
                (date_recorded >= DATEADD(DAY, -7, GETDATE()) AND date_recorded <= GETDATE())
            GROUP BY zaihai_car_maker ORDER BY zaihai_car_maker ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo '<option selected value="">All</option>';
		do {
			echo '<option value="'.htmlspecialchars($row['zaihai_car_maker']).'">'.htmlspecialchars($row['zaihai_car_maker']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Car Model Dropdown Out
if ($method == 'get_car_model_dropdown_search') {
	$sql = "SELECT zaihai_car_model FROM t_error_monitoring
            WHERE date_started IS NULL AND 
                (date_recorded >= DATEADD(DAY, -7, GETDATE()) AND date_recorded <= GETDATE())
            GROUP BY zaihai_car_model ORDER BY zaihai_car_model ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo '<option selected value="">All</option>';
		do {
			echo '<option value="'.htmlspecialchars($row['zaihai_car_model']).'">'.htmlspecialchars($row['zaihai_car_model']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value="">All</option>';
	}
}

// Get Applicator No. Datalist Out
if ($method == 'get_applicator_no_datalist_search') {
	$sql = "SELECT scanned_applicator_no FROM t_error_monitoring WHERE date_started IS NULL AND 
                (date_recorded >= DATEADD(DAY, -7, GETDATE()) AND date_recorded <= GETDATE())";
    $params = [];

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
            $sql .= " AND zaihai_car_maker = ?";
            $params[] = $car_maker;
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
            $sql .= " AND zaihai_car_model = ?";
            $params[] = $car_model;
        }
    }
    
    $sql .= " GROUP BY scanned_applicator_no ORDER BY scanned_applicator_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['scanned_applicator_no'].'">';
	}
}

// Get Terminal Name Datalist Out
if ($method == 'get_terminal_name_datalist_search') {
	$sql = "SELECT scanned_terminal_name FROM t_error_monitoring WHERE date_started IS NULL AND 
                (date_recorded >= DATEADD(DAY, -7, GETDATE()) AND date_recorded <= GETDATE())";
    $params = [];

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
            $sql .= " AND zaihai_car_maker = ?";
            $params[] = $car_maker;
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
            $sql .= " AND zaihai_car_model = ?";
            $params[] = $car_model;
        }
    }
    
    $sql .= " GROUP BY scanned_terminal_name ORDER BY scanned_terminal_name ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['scanned_terminal_name'].'">';
	}
}

// Get Location Datalist Out
if ($method == 'get_location_datalist_search') {
	$sql = "SELECT scanned_trd_no FROM t_error_monitoring WHERE date_started IS NULL AND 
                (date_recorded >= DATEADD(DAY, -7, GETDATE()) AND date_recorded <= GETDATE())";
    $params = [];

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
            $sql .= " AND zaihai_car_maker = ?";
            $params[] = $car_maker;
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
            $sql .= " AND zaihai_car_model = ?";
            $params[] = $car_model;
        }
    }

    $sql .= " GROUP BY scanned_trd_no ORDER BY scanned_trd_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['scanned_trd_no'].'">';
	}
}

// Get Error Name Dropdown
if ($method == 'get_error_name_dropdown_search') {
	$sql = "SELECT err.error_name FROM t_error_monitoring em 
            LEFT JOIN m_errors err ON em.error_code = err.error_code 
            WHERE em.date_started IS NULL AND 
                (em.date_recorded >= DATEADD(DAY, -7, GETDATE()) AND em.date_recorded <= GETDATE())
            GROUP BY err.error_name ORDER BY err.error_name ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		echo '<option selected value="">All</option>';
		do {
			echo '<option value="'.htmlspecialchars($row['error_name']).'">'.htmlspecialchars($row['error_name']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value="">All</option>';
	}
}

if ($method == 'get_recent_applicator_err_mon') {
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
    $error_name = addslashes($_GET['error_name']);

    $c = 0;

    $sql = "SELECT 
                em.error_code, em.serial_no, em.scanned_applicator_no, em.scanned_terminal_name, em.scanned_trd_no, em.scanned_by_no, 
                em.interface, em.date_recorded, em.zaihai_car_maker, em.zaihai_car_model, em.it_error_details, 
                err.error_name 
            FROM 
                t_error_monitoring em 
            LEFT JOIN 
                m_errors err ON em.error_code = err.error_code 
            WHERE 
                em.date_started IS NULL AND 
                (em.date_recorded >= DATEADD(DAY, -7, GETDATE()) AND em.date_recorded <= GETDATE())";
    $params = [];

    if (!empty($car_maker)) {
        $sql .= " AND em.zaihai_car_maker = ?";
        $params[] = $car_maker;
    }
    if (!empty($car_model)) {
        $sql .= " AND em.zaihai_car_model = ?";
        $params[] = $car_model;
    }
    if (!empty($applicator_no)) {
        $sql .= " AND em.scanned_applicator_no LIKE ?";
        $applicator_no_param = "%" . $applicator_no . "%";
        $params[] = $applicator_no_param;
    }
    if (!empty($terminal_name)) {
        $sql .= " AND em.scanned_terminal_name LIKE ?";
        $terminal_name_param = "%" . $terminal_name . "%";
        $params[] = $terminal_name_param;
    }
    if (!empty($location)) {
        $sql .= " AND em.scanned_trd_no LIKE ?";
        $location_param = "%" . $location . "%";
        $params[] = $location_param;
    }
    if (!empty($error_name)) {
        $sql .= " AND err.error_name = ?";
        $params[] = $error_name;
    }
    $sql .= " ORDER BY em.date_recorded ASC";

    $stmt = $conn->prepare($sql);
	$stmt->execute($params);

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $c++;

        echo '<tr>';
        echo '<td>'.$c.'</td>';
        echo '<td>'.$row['error_code'].'</td>';
        echo '<td>'.$row['error_name'].'</td>';
        echo '<td>'.$row['serial_no'].'</td>';
        echo '<td>'.$row['zaihai_car_maker'].'</td>';
        echo '<td>'.$row['zaihai_car_model'].'</td>';
        echo '<td>'.$row['scanned_applicator_no'].'</td>';
        echo '<td>'.$row['scanned_terminal_name'].'</td>';
        echo '<td>'.$row['scanned_trd_no'].'</td>';
        echo '<td>'.$row['scanned_by_no'].'</td>';
        echo '<td>'.$row['interface'].'</td>';
        echo '<td>'.$row['date_recorded'].'</td>';
        echo '<td>'.$row['it_error_details'].'</td>';
        echo '</tr>';
    }
}

$conn = null;
