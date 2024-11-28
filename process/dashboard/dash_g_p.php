<?php

require '../conn.php';

$method = $_GET['method'];

if ($method == 'get_applicator_adj_cnt_chart_year_dropdown') {
    $sql = "SELECT DISTINCT YEAR(date_time_out) AS Year
            FROM t_applicator_in_out_history
            ORDER BY Year";
    $stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
        echo '<option selected value="">Select Year</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['Year']).'">'.htmlspecialchars($row['Year']).'</option>';
		}
	} else {
		echo '<option selected value="">Select Year</option>';
	}
}

if ($method == 'get_applicator_no_dropdown') {
	$car_maker = addslashes($_GET['car_maker']);
    $car_model = addslashes($_GET['car_model']);

	$sql = "SELECT applicator_no FROM m_applicator WHERE 1=1";

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
        echo '<option selected value=""></option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['applicator_no']).'">'.htmlspecialchars($row['applicator_no']).'</option>';
		}
	} else {
		echo '<option selected value=""></option>';
	}
}

if ($method == 'get_applicator_adj_cnt_chart') {
    $year = addslashes($_GET['year']);
    $month = addslashes($_GET['month']);
    $car_maker = addslashes($_GET['car_maker']);
    $car_model = addslashes($_GET['car_model']);
    $applicator_no = addslashes($_GET['applicator_no']);
    $adjustment_content = addslashes($_GET['adjustment_content']);

    $data = [];
    $categories = [];
    $applicatorData = [];

    $sql = "DECLARE @Year INT = ?;  -- Specify the year
            DECLARE @Month INT = ?;   -- Specify the month (November)

            WITH DateRange AS (
                SELECT 
                    DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
                FROM 
                    master.dbo.spt_values
                WHERE 
                    type = 'P' AND 
                    number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
            ),
            FilteredApplicatorHistory AS (
                SELECT 
                    a.applicator_no,
                    CAST(ac.inspection_date_time AS DATETIME2(2)) AS date_inspected
                FROM 
                    t_applicator_c ac
                LEFT JOIN 
                    m_applicator a ON 
                        ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND 
                        ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
                WHERE 
                    ac.inspection_date_time >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    ac.inspection_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
                    AND a.car_maker = ? AND a.car_model = ? AND ac.adjustment_content = ? AND a.applicator_no = ? 
            )

            SELECT 
                CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
                fah.applicator_no,
                COUNT(fah.applicator_no) AS total_clean
            FROM 
                DateRange dr
            LEFT JOIN 
                FilteredApplicatorHistory fah ON 
                    fah.date_inspected >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
                    fah.date_inspected < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
            GROUP BY 
                dr.report_date, fah.applicator_no
            ORDER BY 
                dr.report_date, fah.applicator_no";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month, $car_maker, $car_model, $adjustment_content, $applicator_no);
    $stmt->execute($params);

    // Fetch results and populate the applicatorData array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add unique report_date to categories
        if (!in_array($row['report_date'], $categories)) {
            $categories[] = $row['report_date'];
        }

        if (!empty($row['applicator_no'])) {
            // Initialize the applicator_no in the applicatorData array if not already set
            if (!isset($applicatorData[$row['applicator_no']])) {
                $applicatorData[$row['applicator_no']] = [
                    'name' => $row['applicator_no'],
                    'data' => array_fill(0, count($categories), 0) // Initialize data array with zeros
                ];
            }

            // Find the index of the current report_date in the categories array
            $dateIndex = array_search($row['report_date'], $categories);
            
            // Update the total_clean count for the corresponding applicator_no and report_date
            if ($dateIndex !== false) {
                $applicatorData[$row['applicator_no']]['data'][$dateIndex] = intval($row['total_clean']);
            }
        }
    }

    // Initialize all applicators with zero values for all dates
    foreach ($applicatorData as $applicatorNo => $applicator) {
        // Ensure all applicators have data for all categories
        foreach ($categories as $index => $date) {
            if (!isset($applicatorData[$applicatorNo]['data'][$index])) {
                $applicatorData[$applicatorNo]['data'][$index] = 0; // Set to zero if not already set
            }
        }
    }

    // Convert the associative array to a simple indexed array
    $data = array_values($applicatorData);

    // Encode the categories and data as JSON
    echo json_encode(['categories' => $categories, 'data' => $data]);
}

$conn = null;
