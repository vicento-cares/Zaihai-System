<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';

$method = $_GET['method'];

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT a.car_maker FROM t_applicator_list al
			LEFT JOIN m_applicator a ON al.applicator_no = a.applicator_no 
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

// Get Car Model Dropdown
if ($method == 'get_car_model_dropdown_search') {
	$sql = "SELECT a.car_model FROM t_applicator_list al
			LEFT JOIN m_applicator a ON al.applicator_no = a.applicator_no 
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

// Get Applicator No. Datalist
if ($method == 'get_applicator_no_datalist_search') {
	$car_maker = '';
    $car_model = '';

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
        }
    }

	$sql = "SELECT applicator_no FROM t_applicator_list WHERE 1=1";

	if (!empty($car_maker)) {
		$sql .= " AND car_maker='$car_maker'";
	}
	if (!empty($car_model)) {
		$sql .= " AND car_model='$car_model'";
	}

	$sql .= " GROUP BY applicator_no ORDER BY applicator_no ASC";

	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['applicator_no'].'">';
		}
	}
}

// Get Location Datalist
if ($method == 'get_location_datalist_search') {
	$car_maker = '';
    $car_model = '';

    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        if (isset($_SESSION['car_maker'])) {
            $car_maker = $_SESSION['car_maker'];
        }
    
        if (isset($_SESSION['car_model'])) {
            $car_model = $_SESSION['car_model'];
        }
    }

	$sql = "SELECT location FROM t_applicator_list WHERE 1=1";

	if (!empty($car_maker)) {
		$sql .= " AND car_maker='$car_maker'";
	}
	if (!empty($car_model)) {
		$sql .= " AND car_model='$car_model'";
	}

	$sql .= " GROUP BY location ORDER BY location ASC";

	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['location'].'">';
		}
	}
}

if ($method == 'get_recent_applicator_list') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $status = $_GET['status'];
    $applicator_no = $_GET['applicator_no'];
    $location = $_GET['location'];

    $c = 0;

    $sql = "SELECT a.car_maker, a.car_model, al.applicator_no, al.location, al.status, al.date_updated
            FROM t_applicator_list al
            LEFT JOIN m_applicator a ON al.applicator_no = a.applicator_no
            WHERE 1=1";

    if (!empty($car_maker)) {
        $sql .= " AND a.car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND a.car_model='$car_model'";
    }
    if (!empty($status)) {
        $sql .= " AND al.status='$status'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND al.applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($location)) {
        $sql .= " AND al.location LIKE '%$location%'";
    }

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;
            echo '<tr>';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['car_maker'].'</td>';
            echo '<td>'.$row['car_model'].'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['location'].'</td>';
            echo '<td>'.$row['status'].'</td>';
            echo '<td>'.$row['date_updated'].'</td>';
            echo '</tr>';
        }
    }
}
