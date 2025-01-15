<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';

$method = $_GET['method'];

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
	$sql = "SELECT car_maker FROM t_applicator_list
			GROUP BY car_maker ORDER BY car_maker ASC";
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

// Get Car Model Dropdown
if ($method == 'get_car_model_dropdown_search') {
	$sql = "SELECT car_model FROM t_applicator_list
			GROUP BY car_model ORDER BY car_model ASC";
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

	$sql = "SELECT applicator_no FROM t_applicator_list WHERE car_maker != ''";

	if (!empty($car_maker)) {
		$sql .= " AND car_maker='$car_maker'";
	}
	if (!empty($car_model)) {
		$sql .= " AND car_model='$car_model'";
	}

	$sql .= " GROUP BY applicator_no ORDER BY applicator_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
		echo '<option value="'.$row['applicator_no'].'">';
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

	$sql = "SELECT location FROM t_applicator_list WHERE car_maker != ''";

	if (!empty($car_maker)) {
		$sql .= " AND car_maker='$car_maker'";
	}
	if (!empty($car_model)) {
		$sql .= " AND car_model='$car_model'";
	}

	$sql .= " GROUP BY location ORDER BY location ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
		echo '<option value="'.$row['location'].'">';
	}
}

if ($method == 'get_recent_applicator_list') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $status = $_GET['status'];
    $applicator_no = $_GET['applicator_no'];
    $location = $_GET['location'];

    $c = 0;

    $sql = "SELECT
				car_maker,
				car_model,
				applicator_no,
				location,
				status,
				-- Conditional formatting for elapsed time
				CASE 
					WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) < 1 THEN '< 1 min' 
					ELSE 
						-- Build the elapsed time string conditionally
						LTRIM(
							CASE 
								WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) / 1440 > 0 THEN 
									CAST(DATEDIFF(MINUTE, date_updated, GETDATE()) / 1440 AS VARCHAR(10)) + ' day' + 
									CASE WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) / 1440 <> 1 THEN 's' ELSE '' END + 
									CASE WHEN (DATEDIFF(MINUTE, date_updated, GETDATE()) % 1440) / 60 > 0 OR DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 > 0 THEN ', ' ELSE '' END
								ELSE '' 
							END +
							CASE 
								WHEN (DATEDIFF(MINUTE, date_updated, GETDATE()) % 1440) / 60 > 0 THEN 
									CAST((DATEDIFF(MINUTE, date_updated, GETDATE()) % 1440) / 60 AS VARCHAR(10)) + ' hour' + 
									CASE WHEN (DATEDIFF(MINUTE, date_updated, GETDATE()) % 1440) / 60 <> 1 THEN 's' ELSE '' END + 
									CASE WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 > 0 THEN ', ' ELSE '' END
								ELSE '' 
							END +
							CASE 
								WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 > 0 THEN 
									CAST(DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 AS VARCHAR(10)) + ' min' + 
									CASE WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) % 60 <> 1 THEN 's' ELSE '' END 
								ELSE '' 
							END
						) 
				END AS elapsed_time,
				date_updated,
				-- Downtime column
				CASE 
					WHEN DATEDIFF(MINUTE, date_updated, GETDATE()) > 1440 THEN 1 
					ELSE 0 
				END AS downtime
			FROM t_applicator_list
            WHERE car_maker != ''";

    if (!empty($car_maker)) {
        $sql .= " AND car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND car_model='$car_model'";
    }
    if (!empty($status)) {
        $sql .= " AND status='$status'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($location)) {
        $sql .= " AND location LIKE '%$location%'";
    }

	$sql .= " ORDER BY status ASC, date_updated ASC";

    $stmt = $conn->prepare($sql);
	$stmt->execute();

	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
		$c++;

		$row_class = '';
		if (intval($row['downtime']) == 1 && $row['status'] != 'Ready To Use') {
			$row_class = 'bg-danger';
		}
		echo '<tr class="'.$row_class.'">';

		echo '<td>'.$c.'</td>';
		echo '<td>'.$row['car_maker'].'</td>';
		echo '<td>'.$row['car_model'].'</td>';
		echo '<td>'.$row['applicator_no'].'</td>';
		echo '<td>'.$row['location'].'</td>';
		echo '<td>'.$row['status'].'</td>';
		echo '<td>'.$row['elapsed_time'].'</td>';
		echo '<td>'.$row['date_updated'].'</td>';
		echo '</tr>';
    }
}

$conn = null;
