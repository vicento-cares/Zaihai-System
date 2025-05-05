<?php

require '../conn.php';

$method = $_GET['method'];

$color_map = array(
    'Suzuki YV7' => '#f8bbd0', // Light Pink
    'Mazda J12' => '#ffc107', // Warning
    'Mazda Merge' => '#d8cbaf', // Dark Beige
    'Toyota' => '#28a745', // Success
    'Subaru' => '#fd7e14', // orange
    'Honda T20' => '#8a2be2', // violet
    'Honda Old' => '#dc3545', // Danger
    'Honda TKRA' => '#007bff', // Primary
    'Daihatsu D01L' => '#e83e8c', // Dark Pink
);

if ($method == 'get_applicator_list_status_count') {
    $data = [];

    $sql = "SELECT 
                COUNT(CASE WHEN status = 'Ready To Use' THEN id END) AS total_rtu,
                COUNT(CASE WHEN status = 'Out' THEN id END) AS total_out,
                COUNT(CASE WHEN status = 'Pending' AND location LIKE '%Zaihai%' THEN id END) AS total_pending_zaihai,
                COUNT(CASE WHEN status = 'Pending' AND location LIKE '%BM%' THEN id END) AS total_pending_bm,
                COUNT(CASE WHEN status = 'Ready To Use' THEN id END) + COUNT(CASE WHEN status = 'Pending' THEN id END) AS total_in
            FROM t_applicator_list";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $data = [
            'total_rtu' => intval($row['total_rtu']),
            'total_out' => intval($row['total_out']),
            'total_pending_zaihai' => intval($row['total_pending_zaihai']),
            'total_pending_bm' => intval($row['total_pending_bm']),
            'total_in' => intval($row['total_in'])
        ];
    }

    echo json_encode($data);
}

if ($method == 'get_current_applicator_list_status_count_chart') {
    $data = [];
    $categories = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(CASE WHEN status = 'Ready To Use' THEN id END) AS total_rtu,
                COUNT(CASE WHEN status = 'Out' THEN id END) AS total_out,
                COUNT(CASE WHEN status = 'Pending' AND location = 'Zaihai Receiving Area' THEN id END) AS total_pending,
                COUNT(CASE WHEN status = 'Pending' AND location = 'BM Receiving Area' THEN id END) AS total_pending_bm 
            FROM 
                t_applicator_list
            GROUP BY 
                car_maker, 
                car_model";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add total_applicator and total_terminal values to data
        $data['ReadyToUse'][] = (int)$row['total_rtu'];
        $data['Out'][] = (int)$row['total_out'];
        $data['Pending'][] = (int)$row['total_pending'];
        $data['PendingBm'][] = (int)$row['total_pending_bm'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'Ready To Use',
                'data' => $data['ReadyToUse']
            ],
            [
                'name' => 'Out',
                'data' => $data['Out']
            ],
            [
                'name' => 'Pending Zaihai',
                'data' => $data['Pending']
            ],
            [
                'name' => 'Pending BM',
                'data' => $data['PendingBm']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_current_applicator_list_status_count_chart2') {
    $data = [];

    $sql = "WITH 
                applicator_count AS (SELECT COUNT(id) AS total_applicator FROM m_applicator)

            SELECT 
                (SELECT total_applicator FROM applicator_count) AS total_applicator,
                COUNT(CASE WHEN at.status = 'Ready To Use' THEN at.id END) + 
                COUNT(CASE WHEN at.status = 'Pending' THEN at.id END) AS total_in,
                COUNT(CASE WHEN at.status = 'Out' THEN at.id END) AS total_out
            FROM 
                t_applicator_list at";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $data['TotalApplicator'][] = (int)$row['total_applicator'];
        $data['In'][] = 0; // or some default value
        $data['Out'][] = 0; // or some default value
        $data['TotalApplicator'][] = 0; // or some default value
        $data['In'][] = (int)$row['total_in'];
        $data['Out'][] = (int)$row['total_out'];
    } else {
        // Handle the case where no results are returned
        $data['TotalApplicator'][] = 0; // or some default value
        $data['In'][] = 0; // or some default value
        $data['Out'][] = 0; // or some default value
    }

    // Create the final data structure
    $finalData = [
        'categories' => [
            "Total Applicator",
            "In + Out"
        ],
        'data' => [
            [
                'name' => 'Total Applicator',
                'data' => $data['TotalApplicator']
            ],
            [
                'name' => 'In',
                'data' => $data['In']
            ],
            [
                'name' => 'Out',
                'data' => $data['Out']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_current_applicator_out_charts') {
    $finalData = [];

    $sql = "SELECT
                a.car_maker,
                a.car_model,
                SUM(CASE WHEN aio.trd_no LIKE '%[_]R1%' THEN 1 ELSE 0 END) AS total_r1,
                SUM(CASE WHEN aio.trd_no LIKE '%[_]R2%' THEN 1 ELSE 0 END) AS total_r2,
                SUM(CASE WHEN aio.trd_no LIKE '%[_]F1%' THEN 1 ELSE 0 END) AS total_f1,
                SUM(CASE WHEN aio.trd_no LIKE '%[_]F2%' THEN 1 ELSE 0 END) AS total_f2
            FROM 
                t_applicator_in_out aio
            LEFT JOIN
                m_applicator AS a ON aio.applicator_no = a.applicator_no
            WHERE
                aio.date_time_in IS NULL AND 
                aio.zaihai_stock_address IS NULL
            GROUP BY
                a.car_maker, a.car_model";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Populate the data array with total values
        $data = [
            (int)$row['total_r1'],
            (int)$row['total_r2'],
            (int)$row['total_f1'],
            (int)$row['total_f2']
        ];

        $maker_model_data = [
            'name' => $maker_model_label,
            'categories' => ['R1', 'R2', 'F1', 'F2'],
            'data' => $data
        ];

        $finalData[] = $maker_model_data;
    }

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_current_trd_carts_reuse_count_chart') {
    $data = [];
    $categories = [];

    $sql = "SELECT
                a.car_maker,
                a.car_model,
                (
                    CASE 
                    WHEN CHARINDEX('TRD', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TRD', trd_no), 6)),'_', '')
                    WHEN CHARINDEX('TR', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TR', trd_no), 5)), '_', '')
                    ELSE '__FAILURE__'
                    END
                ) AS trd_no_parsed,
                COUNT(aio.trd_no) - 4 AS total_trd_carts_reuse
            FROM 
                t_applicator_in_out aio
            LEFT JOIN
                m_applicator AS a ON aio.applicator_no = a.applicator_no
            WHERE
                aio.date_time_in IS NULL AND 
                aio.zaihai_stock_address IS NULL
            GROUP BY 
                a.car_maker, a.car_model, (
                    CASE 
                    WHEN CHARINDEX('TRD', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TRD', trd_no), 6)),'_', '')
                    WHEN CHARINDEX('TR', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TR', trd_no), 5)), '_', '')
                    ELSE '__FAILURE__'
                    END
                )
            HAVING 
                COUNT(aio.trd_no) > 4 -- Show Greater Than 4 
            ORDER BY 
                total_trd_carts_reuse DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'] . " " . $row['trd_no_parsed'];
        } else {
            $maker_model_label = $row['car_maker'] . " " . $row['trd_no_parsed'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add total_applicator and total_terminal values to data
        $data['TotalTrdCartsReuse'][] = (int)$row['total_trd_carts_reuse'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'TRD Carts Reuse',
                'data' => $data['TotalTrdCartsReuse']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_current_active_trd_count_chart') {
    $data = [];
    $categories = [];

    $sql = "WITH FilteredApplicatorInOut AS (
                SELECT
                    a.car_maker,
                    a.car_model,
                    (
                        CASE 
                        WHEN CHARINDEX('TRD', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TRD', trd_no), 6)),'_', '')
                        WHEN CHARINDEX('TR', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TR', trd_no), 5)), '_', '')
                        ELSE '__FAILURE__'
                        END
                    ) AS trd_no_parsed
                FROM 
                    t_applicator_in_out aio
                LEFT JOIN
                    m_applicator AS a ON aio.applicator_no = a.applicator_no
                WHERE
                    aio.date_time_in IS NULL AND 
                    aio.zaihai_stock_address IS NULL
                GROUP BY
                    a.car_maker, a.car_model, (
                        CASE 
                        WHEN CHARINDEX('TRD', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TRD', trd_no), 6)),'_', '')
                        WHEN CHARINDEX('TR', aio.trd_no) > 0 THEN REPLACE(UPPER(SUBSTRING(aio.trd_no, CHARINDEX('TR', trd_no), 5)), '_', '')
                        ELSE '__FAILURE__'
                        END
                    )
            )
                
            SELECT
                car_maker,
                car_model,
                COUNT(trd_no_parsed) AS total_active_trd
            FROM
                FilteredApplicatorInOut
            GROUP BY
                car_maker, car_model
            ORDER BY 
                total_active_trd DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add total_applicator and total_terminal values to data
        $data[] = (int)$row['total_active_trd'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $data,
        'colorMap' => $color_map
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_total_applicator_terminal_count') {
    $data = [];

    $sql = "WITH 
                applicator_count AS (SELECT COUNT(id) AS total_applicator FROM m_applicator),
                terminal_count AS (SELECT COUNT(id) AS total_terminal FROM m_terminal),
                applicator_terminal_count AS (SELECT COUNT(id) AS total_applicator_terminal FROM m_applicator_terminal)

            SELECT 
                a.total_applicator,
                t.total_terminal,
                at.total_applicator_terminal
            FROM 
                applicator_count a,
                terminal_count t,
                applicator_terminal_count at";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $data = [
            'total_applicator' => intval($row['total_applicator']), 
            'total_terminal' => intval($row['total_terminal']), 
            'total_applicator_terminal' => intval($row['total_applicator_terminal'])
        ];
    }

    echo json_encode($data);
}

if ($method == 'get_current_applicators_terminals_count_chart') {
    $data = [];
    $categories = [];

    $sql = "WITH 
                applicator_counts AS (
                    SELECT 
                        car_maker,
                        car_model,
                        COUNT(id) AS total_applicator
                    FROM m_applicator
                    GROUP BY car_maker, car_model
                ),
                terminal_counts AS (
                    SELECT 
                        car_maker,
                        car_model,
                        COUNT(id) AS total_terminal
                    FROM m_terminal
                    GROUP BY car_maker, car_model
                )

            SELECT 
                COALESCE(a.car_maker, t.car_maker) AS car_maker,
                COALESCE(a.car_model, t.car_model) AS car_model,
                COALESCE(a.total_applicator, 0) AS total_applicator,
                COALESCE(t.total_terminal, 0) AS total_terminal
            FROM 
                applicator_counts a
            FULL OUTER JOIN 
                terminal_counts t ON a.car_maker = t.car_maker AND a.car_model = t.car_model
            ORDER BY
                total_applicator DESC, total_terminal DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add total_applicator and total_terminal values to data
        $data['Applicator'][] = (int)$row['total_applicator'];
        $data['Terminal'][] = (int)$row['total_terminal'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'Applicator',
                'data' => $data['Applicator']
            ],
            [
                'name' => 'Terminal',
                'data' => $data['Terminal']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_current_applicators_terminals_count_chart2') {
    $data = [];
    $categories = [];

    $sql = "WITH 
                applicator_counts AS (
                    SELECT 
                        car_maker,
                        car_model,
                        COUNT(id) AS total_applicator
                    FROM m_applicator
                    GROUP BY car_maker, car_model
                ),
                terminal_counts AS (
                    SELECT 
                        car_maker,
                        car_model,
                        COUNT(id) AS total_terminal
                    FROM m_terminal
                    GROUP BY car_maker, car_model
                )

            SELECT 
                COALESCE(a.car_maker, t.car_maker) AS car_maker,
                COALESCE(a.car_model, t.car_model) AS car_model,
                COALESCE(a.total_applicator, 0) AS total_applicator,
                COALESCE(t.total_terminal, 0) AS total_terminal
            FROM 
                applicator_counts a
            FULL OUTER JOIN 
                terminal_counts t ON a.car_maker = t.car_maker AND a.car_model = t.car_model
            ORDER BY
                total_applicator DESC, total_terminal DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add total_applicator and total_terminal values to data
        $data[] = (int)$row['total_applicator'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $data,
        'colorMap' => $color_map
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_month_a_adj_cnt_chart_year_dropdown') {
    $sql = "SELECT DISTINCT YEAR(inspection_date_time) AS Year
            FROM t_applicator_c
            ORDER BY Year";
    $stmt = $conn -> prepare($sql);
	$stmt -> execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($results) > 0) {
		echo '<option selected value="">Select Year</option>';
		foreach ($results as $row) {
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
    $params = [];

	if (!empty($car_maker)) {
        $sql .= " AND car_maker = ?";
        $params[] = $car_maker;
    }

    if (!empty($car_model)) {
        $sql .= " AND car_model = ?";
        $params[] = $car_model;
    }

	$sql .= " GROUP BY applicator_no ORDER BY applicator_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute($params);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($results) > 0) {
		echo '<option selected value=""></option>';
		foreach ($results as $row) {
			echo '<option value="'.htmlspecialchars($row['applicator_no']).'">'.htmlspecialchars($row['applicator_no']).'</option>';
		}
	} else {
		echo '<option selected value=""></option>';
	}
}

if ($method == 'get_month_a_adj_cnt_chart') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $applicator_no = $_GET['applicator_no'];
    $adjustment_content = $_GET['adjustment_content'];

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

if ($method == 'get_month_a_adj_cnt2_chart') {
    $year = $_GET['year'];
    $month = $_GET['month'];
   
    $data = [];
    $categories = [];

    $sql = "DECLARE @Year INT = ?;  -- Specify the year
            DECLARE @Month INT = ?;   -- Specify the month (November)

            SELECT 
                a.car_maker,
                a.car_model,
                COUNT(CASE WHEN ac.adjustment_content = 'Adjust' THEN ac.id END) AS total_adjust,
                COUNT(CASE WHEN ac.adjustment_content = 'Repair' THEN ac.id END) AS total_repair,
                COUNT(CASE WHEN ac.adjustment_content = 'Replace' THEN ac.id END) AS total_replace,
                COUNT(CASE WHEN ac.adjustment_content = 'Beyond The Limit' THEN ac.id END) AS total_btl
            FROM t_applicator_c ac
            LEFT JOIN 
                m_applicator a ON 
                    ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
                    ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
            WHERE 
                ac.inspection_date_time >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                ac.inspection_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))
            GROUP BY a.car_maker, a.car_model";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Add unique maker_model_label to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add values to data
        $data['Adjust'][] = (int)$row['total_adjust'];
        $data['Repair'][] = (int)$row['total_repair'];
        $data['Replace'][] = (int)$row['total_replace'];
        $data['BeyondTheLimit'][] = (int)$row['total_btl'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'Adjust',
                'data' => $data['Adjust']
            ],
            [
                'name' => 'Repair',
                'data' => $data['Repair']
            ],
            [
                'name' => 'Replace',
                'data' => $data['Replace']
            ],
            [
                'name' => 'Beyond The Limit',
                'data' => $data['BeyondTheLimit']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_month_a_adj_cnt3_chart') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];

    $categories = [];
    $applicatorData = [
        'total_adjust' => [],
        'total_repair' => [],
        'total_replace' => [],
        'total_btl' => []
    ];

    $maker_model_sql = "";
    if (!empty($car_maker) AND !empty($car_model)) {
        $maker_model_sql = " AND a.car_maker = ? AND a.car_model = ?";
    }

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
                    ac.id,
                    a.car_maker,
                    a.car_model,
                    ac.adjustment_content,
                    CAST(ac.inspection_date_time AS DATETIME2(2)) AS date_inspected
                FROM t_applicator_c ac
                LEFT JOIN 
                    m_applicator a ON 
                    ac.equipment_no = SUBSTRING(a.applicator_no, 1, CHARINDEX('/', a.applicator_no) - 1) AND
                    ac.machine_no = SUBSTRING(a.applicator_no, CHARINDEX('/', a.applicator_no) + 1, LEN(a.applicator_no))
                WHERE 
                    ac.inspection_date_time >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    ac.inspection_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))$maker_model_sql
            )

            SELECT 
                CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
                fah.car_maker,
                fah.car_model,
                COUNT(CASE WHEN fah.adjustment_content = 'Adjust' THEN fah.id END) AS total_adjust,
                COUNT(CASE WHEN fah.adjustment_content = 'Repair' THEN fah.id END) AS total_repair,
                COUNT(CASE WHEN fah.adjustment_content = 'Replace' THEN fah.id END) AS total_replace,
                COUNT(CASE WHEN fah.adjustment_content = 'Beyond The Limit' THEN fah.id END) AS total_btl
            FROM 
                DateRange dr
            LEFT JOIN 
                FilteredApplicatorHistory fah ON 
                    fah.date_inspected >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
                    fah.date_inspected < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
            GROUP BY 
                dr.report_date, fah.car_maker, fah.car_model
            ORDER BY 
                dr.report_date, fah.car_maker, fah.car_model";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month);

    if (!empty($car_maker) AND !empty($car_model)) {
        $params[] = $car_maker;
        $params[] = $car_model;
    }

    $stmt->execute($params);

    // Fetch results and populate the makerModelData array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add unique report_date to categories
        if (!in_array($row['report_date'], $categories)) {
            $categories[] = $row['report_date'];
        }

        // Initialize the data arrays for each total if they don't exist
        if (!isset($applicatorData['total_adjust'][$row['report_date']])) {
            $applicatorData['total_adjust'][$row['report_date']] = 0;
        }
        if (!isset($applicatorData['total_repair'][$row['report_date']])) {
            $applicatorData['total_repair'][$row['report_date']] = 0;
        }
        if (!isset($applicatorData['total_replace'][$row['report_date']])) {
            $applicatorData['total_replace'][$row['report_date']] = 0;
        }
        if (!isset($applicatorData['total_btl'][$row['report_date']])) {
            $applicatorData['total_btl'][$row['report_date']] = 0;
        }

        // Aggregate the totals for each report_date
        $applicatorData['total_adjust'][$row['report_date']] += $row['total_adjust'];
        $applicatorData['total_repair'][$row['report_date']] += $row['total_repair'];
        $applicatorData['total_replace'][$row['report_date']] += $row['total_replace'];
        $applicatorData['total_btl'][$row['report_date']] += $row['total_btl'];
    }

    // Prepare the series data for the chart
    $data = [];
    foreach (['total_adjust', 'total_repair', 'total_replace', 'total_btl'] as $totalType) {
        $data[] = [
            'name' => ucfirst(str_replace('_', ' ', $totalType)), // Capitalize the name for display
            'data' => array_values(array_map(function($date) use ($applicatorData, $totalType) {
                return $applicatorData[$totalType][$date];
            }, $categories))
        ];
    }

    // Encode the categories and data as JSON
    echo json_encode(['categories' => $categories, 'data' => $data]);
}

if ($method == 'get_month_term_usage_chart_year_dropdown') {
    $sql = "SELECT DISTINCT YEAR(date_time_out) AS Year
            FROM t_applicator_in_out_history
            ORDER BY Year";
    $stmt = $conn -> prepare($sql);
	$stmt -> execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($results) > 0) {
		echo '<option selected value="">Select Year</option>';
		foreach ($results as $row) {
			echo '<option value="'.htmlspecialchars($row['Year']).'">'.htmlspecialchars($row['Year']).'</option>';
		}
	} else {
		echo '<option selected value="">Select Year</option>';
	}
}

if ($method == 'get_month_term_usage_chart') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $terminal_name = $_GET['terminal_name'];

    $data = [];
    $categories = [];
    $terminalData = [];

    $maker_model_sql = "";

    if (!empty($car_maker) && !empty($car_model)) {
        $maker_model_sql = " AND a.car_maker = ? AND a.car_model = ?";
    }

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
                    aioh.applicator_no,
                    a.car_maker,
	                a.car_model,
                    SUBSTRING(aioh.terminal_name, 1, CHARINDEX('*', aioh.terminal_name) - 1) AS terminal_name,
                    CAST(aioh.date_time_out AS DATETIME2(2)) AS date_out
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE 
                    aioh.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
                    AND SUBSTRING(aioh.terminal_name, 1, CHARINDEX('*', aioh.terminal_name) - 1) = ?$maker_model_sql
            )

            SELECT 
                CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
                fah.terminal_name,
                fah.car_maker,
	            fah.car_model,
                COUNT(fah.terminal_name) AS total_terminal_usage
            FROM 
                DateRange dr
            LEFT JOIN 
                FilteredApplicatorHistory fah ON 
                    fah.date_out >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
                    fah.date_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
            GROUP BY 
                dr.report_date, fah.car_maker, fah.car_model, fah.terminal_name
            ORDER BY 
                dr.report_date, fah.terminal_name";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month, $terminal_name);

    if (!empty($car_maker) && !empty($car_model)) {
        $params[] = $car_maker;
        $params[] = $car_model;
    }

    $stmt->execute($params);

    // Fetch results and populate the terminalData array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add unique report_date to categories
        if (!in_array($row['report_date'], $categories)) {
            $categories[] = $row['report_date'];
        }

        if (!empty($row['car_maker']) && !empty($row['car_model']) && !empty($row['terminal_name'])) {
            // Create a unique key for each car_maker + car_model combination
            $uniqueKey = $row['car_maker'];
            if ($row['car_maker'] != $row['car_model']) {
                $uniqueKey .= ' ' . $row['car_model'];
            }

            // Initialize the unique key in the terminalData array if not already set
            if (!isset($terminalData[$uniqueKey])) {
                $terminalData[$uniqueKey] = [
                    'name' => $uniqueKey,
                    'data' => array_fill(0, count($categories), 0) // Initialize data array with zeros
                ];
            }

            // Find the index of the current report_date in the categories array
            $dateIndex = array_search($row['report_date'], $categories);
            
            // Update the total_terminal_usage count for the corresponding unique key and report_date
            if ($dateIndex !== false) {
                $terminalData[$uniqueKey]['data'][$dateIndex] = intval($row['total_terminal_usage']);
            }
        }
    }

    // Initialize all terminals with zero values for all dates
    foreach ($terminalData as $uniqueKey => $terminal) {
        // Ensure all terminals have data for all categories
        foreach ($categories as $index => $date) {
            if (!isset($terminalData[$uniqueKey]['data'][$index])) {
                $terminalData[$uniqueKey]['data'][$index] = 0; // Set to zero if not already set
            }
        }
    }

    // Convert the associative array to a simple indexed array
    $data = array_values($terminalData);

    // Encode the categories and data as JSON
    echo json_encode(['categories' => $categories, 'data' => $data, 'colorMap' => $color_map]);
}

if ($method == 'get_month_term_usage_chart2') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $terminal_name = $_GET['terminal_name'];

    $data = [];
    $categories = [];

    $sql = "DECLARE @Year INT = ?;  -- Specify the year
            DECLARE @Month INT = ?;   -- Specify the month (November)

            WITH FilteredApplicatorHistory AS (
                SELECT 
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    SUBSTRING(aioh.terminal_name, 1, CHARINDEX('*', aioh.terminal_name) - 1) AS terminal_name,
                    CAST(aioh.date_time_out AS DATETIME2(2)) AS date_out
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE 
                    aioh.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))  -- Adjusted to include the entire month
                    AND SUBSTRING(aioh.terminal_name, 1, CHARINDEX('*', aioh.terminal_name) - 1) = ?
            )

            SELECT 
                car_maker,
                car_model,
                terminal_name,
                COUNT(terminal_name) AS total_terminal_usage
            FROM 
                FilteredApplicatorHistory
            GROUP BY 
                car_maker, car_model, terminal_name
            ORDER BY 
                total_terminal_usage DESC";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month, $terminal_name);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add total_applicator and total_terminal values to data
        $data[] = (int)$row['total_terminal_usage'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $data,
        'colorMap' => $color_map
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_month_aioi_chart') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $status = $_GET['status'];

    $data = [];
    $categories = [];

    $date_time_column = "";
    $date_time_coumn2 = "";

    if ($status == 'Out') {
        $date_time_column = "date_time_out";
        $date_time_coumn2 = "date_out";
    } else if ($status == 'In') {
        $date_time_column = "date_time_in";
        $date_time_coumn2 = "date_in";
    } else if ($status == 'Inspected') {
        $date_time_column = "confirmation_date";
        $date_time_coumn2 = "date_inspected";
    }

    $maker_model_sql = "";
    if (!empty($car_maker) && !empty($car_model)) {
        $maker_model_sql = " AND a.car_maker = ? AND a.car_model = ?";
    }

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
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    CAST(aioh.$date_time_column AS DATETIME2(2)) AS $date_time_coumn2
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE 
                    aioh.$date_time_column >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.$date_time_column < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))$maker_model_sql -- Adjusted to include the entire month
            )

            SELECT 
                CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
                fah.car_maker,
                fah.car_model,
                COUNT(fah.applicator_no) AS total
            FROM 
                DateRange dr
            LEFT JOIN 
                FilteredApplicatorHistory fah ON 
                    fah.$date_time_coumn2 >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
                    fah.$date_time_coumn2 < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
            GROUP BY 
                dr.report_date, fah.car_maker, fah.car_model 
            ORDER BY 
                dr.report_date";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month);

    if (!empty($car_maker) && !empty($car_model)) {
        $params[] = $car_maker;
        $params[] = $car_model;
    }

    $stmt->execute($params);

    // Get the number of days in the specified month and year
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Initialize an array to hold the counts for each car maker and model
    $statusCounts = [];

    // Fetch results and populate the terminalData array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add unique report_date to categories
        if (!in_array($row['report_date'], $categories)) {
            $categories[] = $row['report_date'];
        }

        if (!empty($row['car_maker']) && !empty($row['car_model'])) {
            // Create a unique key for car maker and model
            $carKey = '';
            if ($row['car_maker'] != $row['car_model']) {
                $carKey = $row['car_maker'] . " " . $row['car_model'];
            } else {
                $carKey = $row['car_maker'];
            }

            // Initialize the statusCounts for this carKey if it doesn't exist
            if (!isset($statusCounts[$carKey])) {
                $statusCounts[$carKey] = array_fill(0, $daysInMonth, 0);
            }

            // Update the count for the specified status
            $dateIndex = array_search($row['report_date'], $categories);
            if ($dateIndex !== false) {
                $statusCounts[$carKey][$dateIndex] += intval($row['total']); // Use total for counts
            }
        }
    }

    // Create the final data structure
    foreach ($statusCounts as $carKey => $counts) {
        $data[] = [
            'name' => $carKey,
            'data' => $counts
        ];
    }

    // Encode the categories and data as JSON
    echo json_encode(['categories' => $categories, 'data' => $data, 'colorMap' => $color_map]);
}

if ($method == 'get_month_aioi_chart2') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $status = $_GET['status'];

    $data = [];
    $categories = [];

    $date_time_column = "";
    $date_time_coumn2 = "";

    if ($status == 'Out') {
        $date_time_column = "date_time_out";
        $date_time_coumn2 = "date_out";
    } else if ($status == 'In') {
        $date_time_column = "date_time_in";
        $date_time_coumn2 = "date_in";
    } else if ($status == 'Inspected') {
        $date_time_column = "confirmation_date";
        $date_time_coumn2 = "date_inspected";
    }

    $sql = "DECLARE @Year INT = ?;  -- Specify the year
            DECLARE @Month INT = ?;   -- Specify the month (November)

            WITH FilteredApplicatorHistory AS (
                SELECT 
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    CAST(aioh.$date_time_column AS DATETIME2(2)) AS $date_time_coumn2
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE 
                    aioh.$date_time_column >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.$date_time_column < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) -- Adjusted to include the entire month
            )

            SELECT 
                car_maker,
                car_model,
                COUNT(applicator_no) AS total
            FROM 
                FilteredApplicatorHistory
            GROUP BY 
                car_maker, car_model";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add values to data
        $data[] = (int)$row['total'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $data,
        'colorMap' => $color_map
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_month_caioi_chart') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $shift = $_GET['shift'];

    $data = [];
    $categories = [];

    $sql = "DECLARE @Year INT = ?;  -- Specify the year
            DECLARE @Month INT = ?;   -- Specify the month (November)
            DECLARE @CarMaker NVARCHAR(255) = ?;
            DECLARE @CarModel NVARCHAR(255) = ?;
            DECLARE @Shift VARCHAR(3) = ?;  -- Set the shift variable to 'ALL', 'DS', or 'NS'

            WITH DateRange AS (
                SELECT 
                    DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
                FROM 
                    master.dbo.spt_values
                WHERE 
                    type = 'P' AND 
                    number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
            ),
            FilteredApplicatorHistoryOut AS (
                SELECT 
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    CAST(aioh.date_time_out AS DATETIME2(2)) AS date_column,
                    'date_out' AS date_type,  -- Indicate the type of date
                    CASE 
                        WHEN CAST(aioh.date_time_out AS TIME) >= '06:00:00' AND CAST(aioh.date_time_out AS TIME) < '18:00:00' THEN 'DS'
                        ELSE 'NS'
                    END AS shift  -- Determine the shift
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE
                    aioh.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) AND 
                    a.car_maker = @CarMaker AND 
                    a.car_model = @CarModel -- Adjusted to include the entire month
            ),
            FilteredApplicatorHistoryIn AS (
                SELECT 
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    CAST(aioh.date_time_in AS DATETIME2(2)) AS date_column,
                    'date_in' AS date_type,  -- Indicate the type of date
                    CASE 
                        WHEN CAST(aioh.date_time_in AS TIME) >= '06:00:00' AND CAST(aioh.date_time_in AS TIME) < '18:00:00' THEN 'DS'
                        ELSE 'NS'
                    END AS shift  -- Determine the shift
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE
                    aioh.date_time_in >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.date_time_in < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) AND 
                    a.car_maker = @CarMaker AND 
                    a.car_model = @CarModel -- Adjusted to include the entire month
            ),
            FilteredApplicatorHistoryInspected AS (
                SELECT 
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    CAST(aioh.confirmation_date AS DATETIME2(2)) AS date_column,
                    'date_inspected' AS date_type,  -- Indicate the type of date
                    CASE 
                        WHEN CAST(aioh.confirmation_date AS TIME) >= '06:00:00' AND CAST(aioh.confirmation_date AS TIME) < '18:00:00' THEN 'DS'
                        ELSE 'NS'
                    END AS shift  -- Determine the shift
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE
                    aioh.confirmation_date >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.confirmation_date < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) AND 
                    a.car_maker = @CarMaker AND 
                    a.car_model = @CarModel -- Adjusted to include the entire month
            ),
            CombinedApplicatorStatus AS (
                SELECT * FROM 
                    FilteredApplicatorHistoryOut
                UNION ALL
                SELECT * FROM 
                    FilteredApplicatorHistoryIn
                UNION ALL
                SELECT * FROM 
                    FilteredApplicatorHistoryInspected
            )

            SELECT 
                CAST(dr.report_date AS DATE) AS report_date,  -- Label the report date as DATE
                cas.car_maker,
                cas.car_model,
                COUNT(CASE 
                    WHEN date_type = 'date_out' AND 
                        (@Shift = 'ALL' OR (shift = 'DS' AND @Shift = 'DS') OR (shift = 'NS' AND @Shift = 'NS')) 
                    THEN cas.applicator_no 
                    END) AS total_out,
                COUNT(CASE 
                    WHEN date_type = 'date_in' AND 
                        (@Shift = 'ALL' OR (shift = 'DS' AND @Shift = 'DS') OR (shift = 'NS' AND @Shift = 'NS')) 
                    THEN cas.applicator_no 
                    END) AS total_in,
                COUNT(CASE 
                    WHEN date_type = 'date_inspected' AND 
                        (@Shift = 'ALL' OR (shift = 'DS' AND @Shift = 'DS') OR (shift = 'NS' AND @Shift = 'NS')) 
                    THEN cas.applicator_no 
                    END) AS total_inspected
            FROM 
                DateRange dr
            LEFT JOIN 
                CombinedApplicatorStatus cas ON 
                    cas.date_column >= DATEADD(HOUR, 6, CAST(dr.report_date AS DATETIME2)) AND 
                    cas.date_column < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(dr.report_date AS DATETIME2)))  -- Adjusted to ensure the range is from 6 AM to just before 6 AM the next day
            GROUP BY 
                dr.report_date, cas.car_maker, cas.car_model 
            ORDER BY 
                dr.report_date";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month, $car_maker, $car_model, $shift);

    $stmt->execute($params);

    // Get the number of days in the specified month and year
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Initialize an array to hold the counts for each car maker and model
    $statusCounts = [];

    // Fetch results and populate the terminalData array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Add unique report_date to categories
        if (!in_array($row['report_date'], $categories)) {
            $categories[] = $row['report_date'];
        }

        if (!empty($row['car_maker']) && !empty($row['car_model'])) {
            // Create a unique key for date types
            $dateOutKey = 'Out';
            $dateInKey = 'In';
            $dateInspectedKey = 'Inspected';

            // Initialize the statusCounts for this dateOutKey if it doesn't exist
            if (!isset($statusCounts[$dateOutKey])) {
                $statusCounts[$dateOutKey] = array_fill(0, $daysInMonth, 0);
            }
            // Initialize the statusCounts for this dateInKey if it doesn't exist
            if (!isset($statusCounts[$dateInKey])) {
                $statusCounts[$dateInKey] = array_fill(0, $daysInMonth, 0);
            }
            // Initialize the statusCounts for this dateInspectedKey if it doesn't exist
            if (!isset($statusCounts[$dateInspectedKey])) {
                $statusCounts[$dateInspectedKey] = array_fill(0, $daysInMonth, 0);
            }

            // Update the count for the specified status
            $dateIndex = array_search($row['report_date'], $categories);
            if ($dateIndex !== false) {
                $statusCounts[$dateOutKey][$dateIndex] += intval($row['total_out']); // Use total for counts
                $statusCounts[$dateInKey][$dateIndex] += intval($row['total_in']); // Use total for counts
                $statusCounts[$dateInspectedKey][$dateIndex] += intval($row['total_inspected']); // Use total for counts
            }
        }
    }

    // Create the final data structure
    foreach ($statusCounts as $dateTypeKey => $counts) {
        $data[] = [
            'name' => $dateTypeKey,
            'data' => $counts
        ];
    }

    // Encode the categories and data as JSON
    echo json_encode(['categories' => $categories, 'data' => $data]);
}

if ($method == 'get_month_caioi_chart2') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $shift = $_GET['shift'];

    $data = [];

    $sql = "DECLARE @Year INT = ?;  -- Specify the year
            DECLARE @Month INT = ?;   -- Specify the month (November)
            DECLARE @CarMaker NVARCHAR(255) = ?;
            DECLARE @CarModel NVARCHAR(255) = ?;
            DECLARE @Shift VARCHAR(3) = ?;  -- Set the shift variable to 'ALL', 'DS', or 'NS'

            WITH FilteredApplicatorHistoryOut AS (
                SELECT 
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    CAST(aioh.date_time_out AS DATETIME2(2)) AS date_column,
                    'date_out' AS date_type,  -- Indicate the type of date
                    CASE 
                        WHEN CAST(aioh.date_time_out AS TIME) >= '06:00:00' AND CAST(aioh.date_time_out AS TIME) < '18:00:00' THEN 'DS'
                        ELSE 'NS'
                    END AS shift  -- Determine the shift
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE
                    aioh.date_time_out >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.date_time_out < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) AND 
                    a.car_maker = @CarMaker AND 
                    a.car_model = @CarModel -- Adjusted to include the entire month
            ),
            FilteredApplicatorHistoryIn AS (
                SELECT 
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    CAST(aioh.date_time_in AS DATETIME2(2)) AS date_column,
                    'date_in' AS date_type,  -- Indicate the type of date
                    CASE 
                        WHEN CAST(aioh.date_time_in AS TIME) >= '06:00:00' AND CAST(aioh.date_time_in AS TIME) < '18:00:00' THEN 'DS'
                        ELSE 'NS'
                    END AS shift  -- Determine the shift
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE
                    aioh.date_time_in >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.date_time_in < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) AND 
                    a.car_maker = @CarMaker AND 
                    a.car_model = @CarModel -- Adjusted to include the entire month
            ),
            FilteredApplicatorHistoryInspected AS (
                SELECT 
                    aioh.applicator_no,
                    a.car_maker,
                    a.car_model,
                    CAST(aioh.confirmation_date AS DATETIME2(2)) AS date_column,
                    'date_inspected' AS date_type,  -- Indicate the type of date
                    CASE 
                        WHEN CAST(aioh.confirmation_date AS TIME) >= '06:00:00' AND CAST(aioh.confirmation_date AS TIME) < '18:00:00' THEN 'DS'
                        ELSE 'NS'
                    END AS shift  -- Determine the shift
                FROM 
                    t_applicator_in_out_history aioh
                LEFT JOIN 
                    m_applicator a ON aioh.applicator_no = a.applicator_no 
                WHERE
                    aioh.confirmation_date >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    aioh.confirmation_date < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) AND 
                    a.car_maker = @CarMaker AND 
                    a.car_model = @CarModel -- Adjusted to include the entire month
            ),
            CombinedApplicatorStatus AS (
                SELECT * FROM 
                    FilteredApplicatorHistoryOut
                UNION ALL
                SELECT * FROM 
                    FilteredApplicatorHistoryIn
                UNION ALL
                SELECT * FROM 
                    FilteredApplicatorHistoryInspected
            )

            SELECT 
                COUNT(CASE 
                    WHEN date_type = 'date_out' AND 
                        (@Shift = 'ALL' OR (shift = 'DS' AND @Shift = 'DS') OR (shift = 'NS' AND @Shift = 'NS')) 
                    THEN applicator_no 
                    END) AS total_out,
                COUNT(CASE 
                    WHEN date_type = 'date_in' AND 
                        (@Shift = 'ALL' OR (shift = 'DS' AND @Shift = 'DS') OR (shift = 'NS' AND @Shift = 'NS')) 
                    THEN applicator_no 
                    END) AS total_in,
                COUNT(CASE 
                    WHEN date_type = 'date_inspected' AND 
                        (@Shift = 'ALL' OR (shift = 'DS' AND @Shift = 'DS') OR (shift = 'NS' AND @Shift = 'NS')) 
                    THEN applicator_no 
                    END) AS total_inspected
            FROM 
                CombinedApplicatorStatus";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month, $car_maker, $car_model, $shift);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categories = ['Out', 'In', 'Inspected'];

        // Add values to data
        $data[] = (int)$row['total_out'];
        $data[] = (int)$row['total_in'];
        $data[] = (int)$row['total_inspected'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $data
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_month_amd_chart') {
    $year = $_GET['year'];
    $month = $_GET['month'];
    $between = $_GET['between'];

    $data = [];
    $categories = [];
    $averageElapsedTimes = [];
    $maxElapsedTimes = [];

    $date_time_column = "";
    $date_time_coumn2 = "";

    if ($between == 1) {
        $date_time_column = "date_time_out";
        $date_time_coumn2 = "date_time_in";
    } else if ($between == 2) {
        $date_time_column = "date_time_in";
        $date_time_coumn2 = "confirmation_date";
    }

    $sql = "DECLARE @Year INT = ?;  -- Specify the year
            DECLARE @Month INT = ?;   -- Specify the month (November)

            WITH AverageData AS (
                SELECT 
                    b.car_maker,
                    b.car_model,
                    AVG(DATEDIFF(MINUTE, $date_time_column, $date_time_coumn2)) AS ave,
                    MAX(DATEDIFF(MINUTE, $date_time_column, $date_time_coumn2)) AS max_diff,
                    STDEV(DATEDIFF(MINUTE, $date_time_column, $date_time_coumn2)) AS std
                FROM 
                    t_applicator_in_out_history AS a 
                LEFT JOIN 
                    m_applicator AS b ON a.applicator_no = b.applicator_no
                WHERE
                    a.$date_time_column >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME2)) AND 
                    a.$date_time_column < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2)))
                GROUP BY b.car_maker, b.car_model
            )

            SELECT 
                car_maker,
                car_model,
                ave,
                -- Use the ave column for ave_elapsed_time
                CASE 
                    WHEN ave < 1 THEN '< 1 min' 
                    ELSE 
                        LTRIM(
                            CASE 
                                WHEN ave / 1440 > 0 THEN 
                                    CAST(ave / 1440 AS VARCHAR(10)) + ' day' + 
                                    CASE WHEN ave / 1440 <> 1 THEN 's' ELSE '' END + 
                                    CASE WHEN (ave % 1440) / 60 > 0 OR ave % 60 > 0 THEN ', ' ELSE '' END
                                ELSE '' 
                            END +
                            CASE 
                                WHEN (ave % 1440) / 60 > 0 THEN 
                                    CAST((ave % 1440) / 60 AS VARCHAR(10)) + ' hour' + 
                                    CASE WHEN (ave % 1440) / 60 <> 1 THEN 's' ELSE '' END + 
                                    CASE WHEN ave % 60 > 0 THEN ', ' ELSE '' END
                                ELSE '' 
                            END +
                            CASE 
                                WHEN ave % 60 > 0 THEN 
                                    CAST(ave % 60 AS VARCHAR(10)) + ' min' + 
                                    CASE WHEN ave % 60 <> 1 THEN 's' ELSE '' END 
                                ELSE '' 
                            END
                        ) 
                END AS ave_elapsed_time,
                max_diff,
                -- Use the ave column for ave_elapsed_time
                CASE 
                    WHEN max_diff < 1 THEN '< 1 min' 
                    ELSE 
                        LTRIM(
                            CASE 
                                WHEN max_diff / 1440 > 0 THEN 
                                    CAST(max_diff / 1440 AS VARCHAR(10)) + ' day' + 
                                    CASE WHEN max_diff / 1440 <> 1 THEN 's' ELSE '' END + 
                                    CASE WHEN (max_diff % 1440) / 60 > 0 OR ave % 60 > 0 THEN ', ' ELSE '' END
                                ELSE '' 
                            END +
                            CASE 
                                WHEN (max_diff % 1440) / 60 > 0 THEN 
                                    CAST((max_diff % 1440) / 60 AS VARCHAR(10)) + ' hour' + 
                                    CASE WHEN (max_diff % 1440) / 60 <> 1 THEN 's' ELSE '' END + 
                                    CASE WHEN max_diff % 60 > 0 THEN ', ' ELSE '' END
                                ELSE '' 
                            END +
                            CASE 
                                WHEN max_diff % 60 > 0 THEN 
                                    CAST(max_diff % 60 AS VARCHAR(10)) + ' min' + 
                                    CASE WHEN max_diff % 60 <> 1 THEN 's' ELSE '' END 
                                ELSE '' 
                            END
                        ) 
                END AS max_diff_elapsed_time,
                std
            FROM 
                AverageData
            ORDER BY max_diff DESC";

    $stmt = $conn->prepare($sql);
    $params = array($year, $month);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        // Add average and max values to data
        $data['Average'][] = (float)$row['ave'];
        $data['Max'][] = (float)$row['max_diff'];
        $averageElapsedTimes[] = $row['ave_elapsed_time'];
        $maxElapsedTimes[] = $row['max_diff_elapsed_time'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'Average',
                'data' => $data['Average'],
                'elapsed_time' => $averageElapsedTimes // Add elapsed time for average
            ],
            [
                'name' => 'Max',
                'data' => $data['Max'],
                'elapsed_time' => $maxElapsedTimes // Add elapsed time for max
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

$conn = null;
