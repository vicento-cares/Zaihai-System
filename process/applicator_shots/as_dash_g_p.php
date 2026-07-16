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

if ($method == 'get_current_overall_shotcnt') {
    $data = [];

    $sql = "SELECT 
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_ee_status] = 'Good' AND 
                            [shotcnt_d_ee_status] = 'Good' AND 
                            [shotcnt_i_u_ee_status] = 'Good' AND 
                            [shotcnt_i_d_ee_status] = 'Good' AND 
                            [shotcnt_c_ee_status] = 'Good' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Good' AND 
                            [shotcnt_d_ee_status] = 'Good' AND 
                            [shotcnt_i_u_ee_status] = 'Good' AND 
                            [shotcnt_i_d_ee_status] = 'Good' AND 
                            [shotcnt_c_ee_status] = 'Good') AND 
                            is_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_prio_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Good' AND 
                            [shotcnt_d_ee_status] = 'Good' AND 
                            [shotcnt_i_u_ee_status] = 'Good' AND 
                            [shotcnt_i_d_ee_status] = 'Good' AND 
                            [shotcnt_c_ee_status] = 'Good') AND 
                            is_prod_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_prod_prio_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Good' AND 
                            [shotcnt_d_ee_status] = 'Good' AND 
                            [shotcnt_i_u_ee_status] = 'Good' AND 
                            [shotcnt_i_d_ee_status] = 'Good' AND 
                            [shotcnt_c_ee_status] = 'Good') AND 
                            is_priority = 0 AND is_prod_priority = 0 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_normal_ee,
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_qa_status] = 'Good' AND 
                            [shotcnt_d_qa_status] = 'Good' AND 
                            [shotcnt_i_u_qa_status] = 'Good' AND 
                            [shotcnt_i_d_qa_status] = 'Good' AND 
                            [shotcnt_c_qa_status] = 'Good' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Good' AND 
                            [shotcnt_d_qa_status] = 'Good' AND 
                            [shotcnt_i_u_qa_status] = 'Good' AND 
                            [shotcnt_i_d_qa_status] = 'Good' AND 
                            [shotcnt_c_qa_status] = 'Good') AND 
                            is_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_prio_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Good' AND 
                            [shotcnt_d_qa_status] = 'Good' AND 
                            [shotcnt_i_u_qa_status] = 'Good' AND 
                            [shotcnt_i_d_qa_status] = 'Good' AND 
                            [shotcnt_c_qa_status] = 'Good') AND 
                            is_prod_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_prod_prio_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Good' AND 
                            [shotcnt_d_qa_status] = 'Good' AND 
                            [shotcnt_i_u_qa_status] = 'Good' AND 
                            [shotcnt_i_d_qa_status] = 'Good' AND 
                            [shotcnt_c_qa_status] = 'Good') AND 
                            is_priority = 0 AND is_prod_priority = 0
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_normal_qa,
                COUNT(CASE WHEN [shotcnt_u_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_u_ee_good,
                COUNT(CASE WHEN [shotcnt_d_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_d_ee_good,
                COUNT(CASE WHEN [shotcnt_i_u_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_i_u_ee_good,
                COUNT(CASE WHEN [shotcnt_i_d_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_i_d_ee_good,
                COUNT(CASE WHEN [shotcnt_c_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_c_ee_good,
                COUNT(CASE WHEN [shotcnt_u_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_u_qa_good,
                COUNT(CASE WHEN [shotcnt_d_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_d_qa_good,
                COUNT(CASE WHEN [shotcnt_i_u_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_i_u_qa_good,
                COUNT(CASE WHEN [shotcnt_i_d_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_i_d_qa_good,
                COUNT(CASE WHEN [shotcnt_c_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_c_qa_good, 
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            is_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prio_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            is_prod_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prod_prio_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            is_priority = 0 AND is_prod_priority = 0 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_normal_ee,
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            is_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prio_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            is_prod_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prod_prio_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            is_priority = 0 AND is_prod_priority = 0
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_normal_qa,
                COUNT(CASE WHEN [shotcnt_u_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_u_ee_exceeded,
                COUNT(CASE WHEN [shotcnt_d_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_d_ee_exceeded,
                COUNT(CASE WHEN [shotcnt_i_u_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_i_u_ee_exceeded,
                COUNT(CASE WHEN [shotcnt_i_d_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_i_d_ee_exceeded,
                COUNT(CASE WHEN [shotcnt_c_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_c_ee_exceeded,
                COUNT(CASE WHEN [shotcnt_u_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_u_qa_exceeded,
                COUNT(CASE WHEN [shotcnt_d_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_d_qa_exceeded,
                COUNT(CASE WHEN [shotcnt_i_u_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_i_u_qa_exceeded,
                COUNT(CASE WHEN [shotcnt_i_d_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_i_d_qa_exceeded,
                COUNT(CASE WHEN [shotcnt_c_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_c_qa_exceeded 
            FROM v_t_applicator_shots";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $data = [
            'total_appshot_good_ee' => intval($row['total_appshot_good_ee']),
            'total_appshot_good_prio_ee' => intval($row['total_appshot_good_prio_ee']),
            'total_appshot_good_prod_prio_ee' => intval($row['total_appshot_good_prod_prio_ee']),
            'total_appshot_good_normal_ee' => intval($row['total_appshot_good_normal_ee']),
            'total_appshot_good_qa' => intval($row['total_appshot_good_qa']),
            'total_appshot_good_prio_qa' => intval($row['total_appshot_good_prio_qa']),
            'total_appshot_good_prod_prio_qa' => intval($row['total_appshot_good_prod_prio_qa']),
            'total_appshot_good_normal_qa' => intval($row['total_appshot_good_normal_qa']),
            'total_shotcnt_u_ee_good' => intval($row['total_shotcnt_u_ee_good']),
            'total_shotcnt_d_ee_good' => intval($row['total_shotcnt_d_ee_good']),
            'total_shotcnt_i_u_ee_good' => intval($row['total_shotcnt_i_u_ee_good']),
            'total_shotcnt_i_d_ee_good' => intval($row['total_shotcnt_i_d_ee_good']),
            'total_shotcnt_c_ee_good' => intval($row['total_shotcnt_c_ee_good']),
            'total_shotcnt_u_qa_good' => intval($row['total_shotcnt_u_qa_good']),
            'total_shotcnt_d_qa_good' => intval($row['total_shotcnt_d_qa_good']),
            'total_shotcnt_i_u_qa_good' => intval($row['total_shotcnt_i_u_qa_good']),
            'total_shotcnt_i_d_qa_good' => intval($row['total_shotcnt_i_d_qa_good']),
            'total_shotcnt_c_qa_good' => intval($row['total_shotcnt_c_qa_good']),
            'total_appshot_exceeded_ee' => intval($row['total_appshot_exceeded_ee']),
            'total_appshot_exceeded_prio_ee' => intval($row['total_appshot_exceeded_prio_ee']),
            'total_appshot_exceeded_prod_prio_ee' => intval($row['total_appshot_exceeded_prod_prio_ee']),
            'total_appshot_exceeded_normal_ee' => intval($row['total_appshot_exceeded_normal_ee']),
            'total_appshot_exceeded_qa' => intval($row['total_appshot_exceeded_qa']),
            'total_appshot_exceeded_prio_qa' => intval($row['total_appshot_exceeded_prio_qa']),
            'total_appshot_exceeded_prod_prio_qa' => intval($row['total_appshot_exceeded_prod_prio_qa']),
            'total_appshot_exceeded_normal_qa' => intval($row['total_appshot_exceeded_normal_qa']),
            'total_shotcnt_u_ee_exceeded' => intval($row['total_shotcnt_u_ee_exceeded']),
            'total_shotcnt_d_ee_exceeded' => intval($row['total_shotcnt_d_ee_exceeded']),
            'total_shotcnt_i_u_ee_exceeded' => intval($row['total_shotcnt_i_u_ee_exceeded']),
            'total_shotcnt_i_d_ee_exceeded' => intval($row['total_shotcnt_i_d_ee_exceeded']),
            'total_shotcnt_c_ee_exceeded' => intval($row['total_shotcnt_c_ee_exceeded']),
            'total_shotcnt_u_qa_exceeded' => intval($row['total_shotcnt_u_qa_exceeded']),
            'total_shotcnt_d_qa_exceeded' => intval($row['total_shotcnt_d_qa_exceeded']),
            'total_shotcnt_i_u_qa_exceeded' => intval($row['total_shotcnt_i_u_qa_exceeded']),
            'total_shotcnt_i_d_qa_exceeded' => intval($row['total_shotcnt_i_d_qa_exceeded']),
            'total_shotcnt_c_qa_exceeded' => intval($row['total_shotcnt_c_qa_exceeded'])
        ];
    }

    echo json_encode($data);
}

if ($method == 'get_shotcnt_good_vs_exceeded_ee_chart') {
    $data = [];
    $categories = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_ee_status] = 'Good' AND 
                            [shotcnt_d_ee_status] = 'Good' AND 
                            [shotcnt_i_u_ee_status] = 'Good' AND 
                            [shotcnt_i_d_ee_status] = 'Good' AND 
                            [shotcnt_c_ee_status] = 'Good' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_ee,
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_ee 
            FROM 
                v_t_applicator_shots
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
        $data['Good'][] = (int)$row['total_appshot_good_ee'];
        $data['Exceeded'][] = (int)$row['total_appshot_exceeded_ee'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'Good',
                'data' => $data['Good']
            ],
            [
                'name' => 'Exceeded',
                'data' => $data['Exceeded']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_good_vs_exceeded_qa_chart') {
    $data = [];
    $categories = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_qa_status] = 'Good' AND 
                            [shotcnt_d_qa_status] = 'Good' AND 
                            [shotcnt_i_u_qa_status] = 'Good' AND 
                            [shotcnt_i_d_qa_status] = 'Good' AND 
                            [shotcnt_c_qa_status] = 'Good' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_qa,
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_qa 
            FROM 
                v_t_applicator_shots
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
        $data['Good'][] = (int)$row['total_appshot_good_qa'];
        $data['Exceeded'][] = (int)$row['total_appshot_exceeded_qa'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'Good',
                'data' => $data['Good']
            ],
            [
                'name' => 'Exceeded',
                'data' => $data['Exceeded']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_exceeded_prio_ee_chart') {
    $data = [];
    $categories = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            is_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prio_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            is_prod_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prod_prio_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            is_priority = 0 AND is_prod_priority = 0 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_normal_ee 
            FROM 
                v_t_applicator_shots
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
        $data['Priority'][] = (int)$row['total_appshot_exceeded_prio_ee'];
        $data['ProdPriority'][] = (int)$row['total_appshot_exceeded_prod_prio_ee'];
        $data['Normal'][] = (int)$row['total_appshot_exceeded_normal_ee'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'Priority',
                'data' => $data['Priority']
            ],
            [
                'name' => 'Prod Priority',
                'data' => $data['ProdPriority']
            ],
            [
                'name' => 'Normal',
                'data' => $data['Normal']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_exceeded_prio_qa_chart') {
    $data = [];
    $categories = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            is_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prio_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            is_prod_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prod_prio_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            is_priority = 0 AND is_prod_priority = 0
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_normal_qa 
            FROM 
                v_t_applicator_shots
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
        $data['Priority'][] = (int)$row['total_appshot_exceeded_prio_qa'];
        $data['ProdPriority'][] = (int)$row['total_appshot_exceeded_prod_prio_qa'];
        $data['Normal'][] = (int)$row['total_appshot_exceeded_normal_qa'];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => [
            [
                'name' => 'Priority',
                'data' => $data['Priority']
            ],
            [
                'name' => 'Prod Priority',
                'data' => $data['ProdPriority']
            ],
            [
                'name' => 'Normal',
                'data' => $data['Normal']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_u_ranges_chart') {
    $data = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(CASE WHEN shotcnt_u_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
                COUNT(CASE WHEN shotcnt_u_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
                COUNT(CASE WHEN shotcnt_u_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
                COUNT(CASE WHEN shotcnt_u_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
                COUNT(CASE WHEN shotcnt_u_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
                COUNT(CASE WHEN shotcnt_u_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
            FROM [v_t_applicator_shots]
            GROUP BY car_maker, car_model";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // Define the column headers (price ranges)
    $columnHeaders = [
        'shotcnt_below_50k' => 'Below 50K',
        'shotcnt_50k_100k' => '50K-100K',
        'shotcnt_100k_300k' => '100K-300K',
        'shotcnt_300k_600k' => '300K-600K',
        'shotcnt_600k_900k' => '600K-900K',
        'shotcnt_above_900k' => 'Above 900K'
    ];

    // Build categories (car_maker + car_model)
    $categories = [];
    foreach ($data as $row) {
        if ($row['car_maker'] != $row['car_model']) {
            $categories[] = $row['car_maker'] . ' ' . $row['car_model'];
        } else {
            $categories[] = $row['car_maker'];
        }
    }

    // Build series
    $series = [];
    foreach ($columnHeaders as $columnName => $displayName) {
        $seriesData = [];
        foreach ($data as $row) {
            $seriesData[] = $row[$columnName];
        }
        $series[] = [
            'name' => $displayName,
            'data' => $seriesData
        ];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $series
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_d_ranges_chart') {
    $data = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(CASE WHEN shotcnt_d_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
                COUNT(CASE WHEN shotcnt_d_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
                COUNT(CASE WHEN shotcnt_d_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
                COUNT(CASE WHEN shotcnt_d_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
                COUNT(CASE WHEN shotcnt_d_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
                COUNT(CASE WHEN shotcnt_d_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
            FROM [v_t_applicator_shots]
            GROUP BY car_maker, car_model";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // Define the column headers (price ranges)
    $columnHeaders = [
        'shotcnt_below_50k' => 'Below 50K',
        'shotcnt_50k_100k' => '50K-100K',
        'shotcnt_100k_300k' => '100K-300K',
        'shotcnt_300k_600k' => '300K-600K',
        'shotcnt_600k_900k' => '600K-900K',
        'shotcnt_above_900k' => 'Above 900K'
    ];

    // Build categories (car_maker + car_model)
    $categories = [];
    foreach ($data as $row) {
        if ($row['car_maker'] != $row['car_model']) {
            $categories[] = $row['car_maker'] . ' ' . $row['car_model'];
        } else {
            $categories[] = $row['car_maker'];
        }
    }

    // Build series
    $series = [];
    foreach ($columnHeaders as $columnName => $displayName) {
        $seriesData = [];
        foreach ($data as $row) {
            $seriesData[] = $row[$columnName];
        }
        $series[] = [
            'name' => $displayName,
            'data' => $seriesData
        ];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $series
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_i_u_ranges_chart') {
    $data = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(CASE WHEN shotcnt_i_u_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
                COUNT(CASE WHEN shotcnt_i_u_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
                COUNT(CASE WHEN shotcnt_i_u_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
                COUNT(CASE WHEN shotcnt_i_u_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
                COUNT(CASE WHEN shotcnt_i_u_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
                COUNT(CASE WHEN shotcnt_i_u_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
            FROM [v_t_applicator_shots]
            GROUP BY car_maker, car_model";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // Define the column headers (price ranges)
    $columnHeaders = [
        'shotcnt_below_50k' => 'Below 50K',
        'shotcnt_50k_100k' => '50K-100K',
        'shotcnt_100k_300k' => '100K-300K',
        'shotcnt_300k_600k' => '300K-600K',
        'shotcnt_600k_900k' => '600K-900K',
        'shotcnt_above_900k' => 'Above 900K'
    ];

    // Build categories (car_maker + car_model)
    $categories = [];
    foreach ($data as $row) {
        if ($row['car_maker'] != $row['car_model']) {
            $categories[] = $row['car_maker'] . ' ' . $row['car_model'];
        } else {
            $categories[] = $row['car_maker'];
        }
    }

    // Build series
    $series = [];
    foreach ($columnHeaders as $columnName => $displayName) {
        $seriesData = [];
        foreach ($data as $row) {
            $seriesData[] = $row[$columnName];
        }
        $series[] = [
            'name' => $displayName,
            'data' => $seriesData
        ];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $series
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_i_d_ranges_chart') {
    $data = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(CASE WHEN shotcnt_i_d_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
                COUNT(CASE WHEN shotcnt_i_d_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
                COUNT(CASE WHEN shotcnt_i_d_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
                COUNT(CASE WHEN shotcnt_i_d_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
                COUNT(CASE WHEN shotcnt_i_d_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
                COUNT(CASE WHEN shotcnt_i_d_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
            FROM [v_t_applicator_shots]
            GROUP BY car_maker, car_model";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // Define the column headers (price ranges)
    $columnHeaders = [
        'shotcnt_below_50k' => 'Below 50K',
        'shotcnt_50k_100k' => '50K-100K',
        'shotcnt_100k_300k' => '100K-300K',
        'shotcnt_300k_600k' => '300K-600K',
        'shotcnt_600k_900k' => '600K-900K',
        'shotcnt_above_900k' => 'Above 900K'
    ];

    // Build categories (car_maker + car_model)
    $categories = [];
    foreach ($data as $row) {
        if ($row['car_maker'] != $row['car_model']) {
            $categories[] = $row['car_maker'] . ' ' . $row['car_model'];
        } else {
            $categories[] = $row['car_maker'];
        }
    }

    // Build series
    $series = [];
    foreach ($columnHeaders as $columnName => $displayName) {
        $seriesData = [];
        foreach ($data as $row) {
            $seriesData[] = $row[$columnName];
        }
        $series[] = [
            'name' => $displayName,
            'data' => $seriesData
        ];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $series
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_c_ranges_chart') {
    $data = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(CASE WHEN shotcnt_c_range = 'below 50k' THEN applicator_no END) AS shotcnt_below_50k,
                COUNT(CASE WHEN shotcnt_c_range = '50k - 100k' THEN applicator_no END) AS shotcnt_50k_100k,
                COUNT(CASE WHEN shotcnt_c_range = '100k - 300k' THEN applicator_no END) AS shotcnt_100k_300k,
                COUNT(CASE WHEN shotcnt_c_range = '300k - 600k' THEN applicator_no END) AS shotcnt_300k_600k,
                COUNT(CASE WHEN shotcnt_c_range = '600k - 900k' THEN applicator_no END) AS shotcnt_600k_900k,
                COUNT(CASE WHEN shotcnt_c_range = 'above 900k' THEN applicator_no END) AS shotcnt_above_900k 
            FROM [v_t_applicator_shots]
            GROUP BY car_maker, car_model";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();

    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // Define the column headers (price ranges)
    $columnHeaders = [
        'shotcnt_below_50k' => 'Below 50K',
        'shotcnt_50k_100k' => '50K-100K',
        'shotcnt_100k_300k' => '100K-300K',
        'shotcnt_300k_600k' => '300K-600K',
        'shotcnt_600k_900k' => '600K-900K',
        'shotcnt_above_900k' => 'Above 900K'
    ];

    // Build categories (car_maker + car_model)
    $categories = [];
    foreach ($data as $row) {
        if ($row['car_maker'] != $row['car_model']) {
            $categories[] = $row['car_maker'] . ' ' . $row['car_model'];
        } else {
            $categories[] = $row['car_maker'];
        }
    }

    // Build series
    $series = [];
    foreach ($columnHeaders as $columnName => $displayName) {
        $seriesData = [];
        foreach ($data as $row) {
            $seriesData[] = $row[$columnName];
        }
        $series[] = [
            'name' => $displayName,
            'data' => $seriesData
        ];
    }

    // Create the final data structure
    $finalData = [
        'categories' => $categories,
        'data' => $series
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_exceeded_appstat_ee_chart') {
    $data = [];
    $categories = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            status = 'Ready To Use' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_rtu_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            status = 'Out' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_out_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_i_d_ee_status] = 'Exceeded' OR 
                            [shotcnt_c_ee_status] = 'Exceeded') AND 
                            status = 'Pending' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_pending_ee
            FROM 
                v_t_applicator_shots
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
        $data['ReadyToUse'][] = (int)$row['total_appshot_exceeded_rtu_ee'];
        $data['Out'][] = (int)$row['total_appshot_exceeded_out_ee'];
        $data['Pending'][] = (int)$row['total_appshot_exceeded_pending_ee'];
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
                'name' => 'Pending',
                'data' => $data['Pending']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_exceeded_appstat_qa_chart') {
    $data = [];
    $categories = [];

    $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            status = 'Ready To Use' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_rtu_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            status = 'Out' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_out_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_i_d_qa_status] = 'Exceeded' OR 
                            [shotcnt_c_qa_status] = 'Exceeded') AND 
                            status = 'Pending' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_pending_qa
            FROM 
                v_t_applicator_shots
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
        $data['ReadyToUse'][] = (int)$row['total_appshot_exceeded_rtu_qa'];
        $data['Out'][] = (int)$row['total_appshot_exceeded_out_qa'];
        $data['Pending'][] = (int)$row['total_appshot_exceeded_pending_qa'];
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
                'name' => 'Pending',
                'data' => $data['Pending']
            ]
        ]
    ];

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

$conn = null;
