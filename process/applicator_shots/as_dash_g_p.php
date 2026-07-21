<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

$full_view = false;

// Check Session if shop then full data view else required on viewer page only
if (isset($_SESSION['role']) && $_SESSION['role'] == 'Shop') {
    $full_view = true;
}

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

    $sql = "";

    if ($full_view) {
        // full view
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
    } else {
        // non full view
        $sql = "SELECT 
                    COUNT(
                        CASE 
                            WHEN 
                                [shotcnt_u_ee_status] = 'Good' AND 
                                [shotcnt_d_ee_status] = 'Good' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Good' AND 
                                [shotcnt_d_ee_status] = 'Good') AND 
                                is_priority = 1 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_prio_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Good' AND 
                                [shotcnt_d_ee_status] = 'Good') AND 
                                is_prod_priority = 1 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_prod_prio_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Good' AND 
                                [shotcnt_d_ee_status] = 'Good') AND 
                                is_priority = 0 AND is_prod_priority = 0 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_normal_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                [shotcnt_u_qa_status] = 'Good' AND 
                                [shotcnt_d_qa_status] = 'Good' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_qa,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Good' AND 
                                [shotcnt_d_qa_status] = 'Good') AND 
                                is_priority = 1 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_prio_qa,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Good' AND 
                                [shotcnt_d_qa_status] = 'Good') AND 
                                is_prod_priority = 1 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_prod_prio_qa,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Good' AND 
                                [shotcnt_d_qa_status] = 'Good') AND 
                                is_priority = 0 AND is_prod_priority = 0
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_normal_qa,
                    COUNT(CASE WHEN [shotcnt_u_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_u_ee_good,
                    COUNT(CASE WHEN [shotcnt_d_ee_status] = 'Good' THEN applicator_no END) AS total_shotcnt_d_ee_good,
                    COUNT(CASE WHEN [shotcnt_u_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_u_qa_good,
                    COUNT(CASE WHEN [shotcnt_d_qa_status] = 'Good' THEN applicator_no END) AS total_shotcnt_d_qa_good,
                    COUNT(
                        CASE 
                            WHEN 
                                [shotcnt_u_ee_status] = 'Exceeded' OR 
                                [shotcnt_d_ee_status] = 'Exceeded' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Exceeded' OR 
                                [shotcnt_d_ee_status] = 'Exceeded') AND 
                                is_priority = 1 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_prio_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Exceeded' OR 
                                [shotcnt_d_ee_status] = 'Exceeded') AND 
                                is_prod_priority = 1 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_prod_prio_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Exceeded' OR 
                                [shotcnt_d_ee_status] = 'Exceeded') AND 
                                is_priority = 0 AND is_prod_priority = 0 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_normal_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                [shotcnt_u_qa_status] = 'Exceeded' OR 
                                [shotcnt_d_qa_status] = 'Exceeded'  
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_qa,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Exceeded' OR 
                                [shotcnt_d_qa_status] = 'Exceeded') AND 
                                is_priority = 1 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_prio_qa,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Exceeded' OR 
                                [shotcnt_d_qa_status] = 'Exceeded') AND 
                                is_prod_priority = 1 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_prod_prio_qa,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Exceeded' OR 
                                [shotcnt_d_qa_status] = 'Exceeded') AND 
                                is_priority = 0 AND is_prod_priority = 0
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_normal_qa,
                    COUNT(CASE WHEN [shotcnt_u_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_u_ee_exceeded,
                    COUNT(CASE WHEN [shotcnt_d_ee_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_d_ee_exceeded,
                    COUNT(CASE WHEN [shotcnt_u_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_u_qa_exceeded,
                    COUNT(CASE WHEN [shotcnt_d_qa_status] = 'Exceeded' THEN applicator_no END) AS total_shotcnt_d_qa_exceeded 
                FROM v_t_applicator_shots";
    }

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
            'total_shotcnt_i_u_ee_good' => (isset($row['total_shotcnt_i_u_ee_good'])) ? intval($row['total_shotcnt_i_u_ee_good']) : 0,
            'total_shotcnt_i_d_ee_good' => (isset($row['total_shotcnt_i_d_ee_good'])) ? intval($row['total_shotcnt_i_d_ee_good']) : 0,
            'total_shotcnt_c_ee_good' => (isset($row['total_shotcnt_c_ee_good'])) ? intval($row['total_shotcnt_c_ee_good']) : 0,
            'total_shotcnt_u_qa_good' => intval($row['total_shotcnt_u_qa_good']),
            'total_shotcnt_d_qa_good' => intval($row['total_shotcnt_d_qa_good']),
            'total_shotcnt_i_u_qa_good' => (isset($row['total_shotcnt_i_u_qa_good'])) ? intval($row['total_shotcnt_i_u_qa_good']) : 0,
            'total_shotcnt_i_d_qa_good' => (isset($row['total_shotcnt_i_d_qa_good'])) ? intval($row['total_shotcnt_i_d_qa_good']) : 0,
            'total_shotcnt_c_qa_good' => (isset($row['total_shotcnt_c_qa_good'])) ? intval($row['total_shotcnt_c_qa_good']) : 0,
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
            'total_shotcnt_i_u_ee_exceeded' => (isset($row['total_shotcnt_i_u_ee_exceeded'])) ? intval($row['total_shotcnt_i_u_ee_exceeded']) : 0,
            'total_shotcnt_i_d_ee_exceeded' => (isset($row['total_shotcnt_i_d_ee_exceeded'])) ? intval($row['total_shotcnt_i_d_ee_exceeded']) : 0,
            'total_shotcnt_c_ee_exceeded' => (isset($row['total_shotcnt_c_ee_exceeded'])) ? intval($row['total_shotcnt_c_ee_exceeded']) : 0,
            'total_shotcnt_u_qa_exceeded' => intval($row['total_shotcnt_u_qa_exceeded']),
            'total_shotcnt_d_qa_exceeded' => intval($row['total_shotcnt_d_qa_exceeded']),
            'total_shotcnt_i_u_qa_exceeded' => (isset($row['total_shotcnt_i_u_qa_exceeded'])) ? intval($row['total_shotcnt_i_u_qa_exceeded']) : 0,
            'total_shotcnt_i_d_qa_exceeded' => (isset($row['total_shotcnt_i_d_qa_exceeded'])) ? intval($row['total_shotcnt_i_d_qa_exceeded']) : 0,
            'total_shotcnt_c_qa_exceeded' => (isset($row['total_shotcnt_c_qa_exceeded'])) ? intval($row['total_shotcnt_c_qa_exceeded']) : 0 
        ];
    }

    echo json_encode($data);
}

if ($method == 'get_shotcnt_good_vs_exceeded_ee_chart') {
    $data = [];
    $categories = [];

    $sql = "";

    if ($full_view) {
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
    } else {
        $sql = "SELECT 
                    car_maker,
                    car_model,
                    COUNT(
                        CASE 
                            WHEN 
                                [shotcnt_u_ee_status] = 'Good' AND 
                                [shotcnt_d_ee_status] = 'Good' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_good_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                [shotcnt_u_ee_status] = 'Exceeded' OR 
                                [shotcnt_d_ee_status] = 'Exceeded' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_ee 
                FROM 
                    v_t_applicator_shots
                GROUP BY 
                    car_maker, 
                    car_model";
    }

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

    if ($full_view) {
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
    } else {
        // Create the final data structure
        $finalData = [
            'categories' => $categories,
            'data' => [
                [
                    'name' => 'Exceeded',
                    'data' => $data['Exceeded']
                ]
            ]
        ];
    }

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_good_vs_exceeded_qa_chart') {
    $data = [];
    $categories = [];

    $sql = "";

    if ($full_view) {
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
    } else {
        $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_qa_status] = 'Good' AND 
                            [shotcnt_d_qa_status] = 'Good' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_good_qa,
                COUNT(
                    CASE 
                        WHEN 
                            [shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded' 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_qa 
            FROM 
                v_t_applicator_shots
            GROUP BY 
                car_maker, 
                car_model";
    }

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

    if ($full_view) {
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
    } else {
        // Create the final data structure
        $finalData = [
            'categories' => $categories,
            'data' => [
                [
                    'name' => 'Exceeded',
                    'data' => $data['Exceeded']
                ]
            ]
        ];
    }

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_exceeded_prio_ee_chart') {
    $data = [];
    $categories = [];

    $sql = "";

    if ($full_view) {
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
    } else {
        $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded') AND 
                            is_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prio_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded') AND 
                            is_prod_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prod_prio_ee,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_ee_status] = 'Exceeded' OR 
                            [shotcnt_d_ee_status] = 'Exceeded') AND 
                            is_priority = 0 AND is_prod_priority = 0 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_normal_ee 
            FROM 
                v_t_applicator_shots
            GROUP BY 
                car_maker, 
                car_model";
    }

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

    if ($full_view) {
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
    } else {
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
                ]
            ]
        ];
    }

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_exceeded_prio_qa_chart') {
    $data = [];
    $categories = [];

    $sql = "";

    if ($full_view) {
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
    } else {
        $sql = "SELECT 
                car_maker,
                car_model,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded') AND 
                            is_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prio_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded') AND 
                            is_prod_priority = 1 
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_prod_prio_qa,
                COUNT(
                    CASE 
                        WHEN 
                            ([shotcnt_u_qa_status] = 'Exceeded' OR 
                            [shotcnt_d_qa_status] = 'Exceeded') AND 
                            is_priority = 0 AND is_prod_priority = 0
                        THEN applicator_no 
                    END
                ) AS total_appshot_exceeded_normal_qa 
            FROM 
                v_t_applicator_shots
            GROUP BY 
                car_maker, 
                car_model";
    }

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

    if ($full_view) {
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
    } else {
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
                ]
            ]
        ];
    }

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

    $sql = "";

    if ($full_view) {
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
    } else {
        $sql = "SELECT 
                    car_maker,
                    car_model,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Exceeded' OR 
                                [shotcnt_d_ee_status] = 'Exceeded') AND 
                                status = 'Ready To Use' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_rtu_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Exceeded' OR 
                                [shotcnt_d_ee_status] = 'Exceeded') AND 
                                status = 'Out' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_out_ee,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_ee_status] = 'Exceeded' OR 
                                [shotcnt_d_ee_status] = 'Exceeded') AND 
                                status = 'Pending' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_pending_ee
                FROM 
                    v_t_applicator_shots
                GROUP BY 
                    car_maker, 
                    car_model";
    }

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

    if ($full_view) {
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
    } else {
            $finalData = [
            'categories' => $categories,
            'data' => [
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
    }

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_shotcnt_exceeded_appstat_qa_chart') {
    $data = [];
    $categories = [];

    $sql = "";

    if ($full_view) {
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
    } else {
        $sql = "SELECT 
                    car_maker,
                    car_model,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Exceeded' OR 
                                [shotcnt_d_qa_status] = 'Exceeded') AND 
                                status = 'Ready To Use' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_rtu_qa,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Exceeded' OR 
                                [shotcnt_d_qa_status] = 'Exceeded') AND 
                                status = 'Out' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_out_qa,
                    COUNT(
                        CASE 
                            WHEN 
                                ([shotcnt_u_qa_status] = 'Exceeded' OR 
                                [shotcnt_d_qa_status] = 'Exceeded') AND 
                                status = 'Pending' 
                            THEN applicator_no 
                        END
                    ) AS total_appshot_exceeded_pending_qa
                FROM 
                    v_t_applicator_shots
                GROUP BY 
                    car_maker, 
                    car_model";
    }

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

    if ($full_view) {
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
    } else {
        // Create the final data structure
        $finalData = [
            'categories' => $categories,
            'data' => [
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
    }

    // Encode the categories and data as JSON
    echo json_encode($finalData);
}

if ($method == 'get_current_hourly_exceeded_chart') {
    $data = [];
    $categories = [];

    $sql = "DECLARE @day DATE = CAST(DATEADD(HOUR, -6, GETDATE()) AS DATE);

            WITH AllHours AS (
                SELECT 
                    RIGHT('0' + CAST(n AS VARCHAR(2)), 2) AS hour_start,
                    CASE 
                        WHEN n >= 6 THEN n - 6  -- Hours 06-23 will retain their natural order
                        ELSE n + 18             -- Hours 00-05 will appear after hour 23
                    END AS sort_order
                FROM 
                    (SELECT TOP 24 ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) - 1 AS n FROM master.dbo.spt_values) AS Numbers
            ),
            Categories AS
            (
                SELECT DISTINCT
                    car_maker,
                    car_model
                FROM m_applicator
            ),
            ShotCategories AS
            (
                SELECT *
                FROM (VALUES
                    ('100K Shots'),
                    ('50K Shots')
                ) v(shotcnt_category)
            ),
            Exceeded AS
            (
                SELECT
                    FORMAT(exceeded_date_time, 'HH') AS hour_start, 
                    car_maker,
                    car_model,
                    shotcnt_category,
                    COUNT(DISTINCT applicator_no) AS total_count
                FROM t_applicator_shots_h
                WHERE 
                    shotcnt_type IN ('Wire Crimper', 'Wire Anvil') AND 
                    exceeded_date_time >= DATEADD(HOUR, 6, CAST(@day AS DATETIME)) AND 
                    exceeded_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(@day AS DATETIME))) 
                GROUP BY 
                    FORMAT(exceeded_date_time, 'HH'), 
                    car_maker,
                    car_model,
                    shotcnt_category
            )
            SELECT
                h.hour_start, 
                c.car_maker,
                c.car_model,
                s.shotcnt_category,
                ISNULL(e.total_count, 0) AS total_count
            FROM AllHours h
            CROSS JOIN Categories c
            CROSS JOIN ShotCategories s
            LEFT JOIN Exceeded e
                ON h.hour_start = e.hour_start
                AND e.car_maker = c.car_maker
                AND e.car_model = c.car_model
                AND e.shotcnt_category = s.shotcnt_category
            ORDER BY 
                CASE 
                    WHEN CAST(h.hour_start AS INT) >= 6 THEN CAST(h.hour_start AS INT)
                    ELSE CAST(h.hour_start AS INT) + 24
                END,
                c.car_maker,
                c.car_model,
                s.shotcnt_category DESC;";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'] . " " . $row['shotcnt_category'];
        } else {
            $maker_model_label = $row['car_maker'] . " " . $row['shotcnt_category'];
        }

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        $hour = $row['hour_start'];   // Extract the hour from the row
        $value = (int)$row['total_count']; // Extract the value and cast it to an integer

        // Check if the route key already exists in the data array
        if (!isset($data[$maker_model_label])) {
            // Initialize labels and values arrays for the route if it doesn't exist
            $data[$maker_model_label] = [
                "categories" => [],
                "data" => []
            ];
        }

        // Add hour and value to the respective arrays
        $data[$maker_model_label]['categories'][] = $hour;
        $data[$maker_model_label]['data'][] = $value;
    }

    // Encode the categories and data as JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
}

if ($method == 'get_current_week_exceeded_chart') {
    $data = [];
    $categories = [];

    $sql = "DECLARE @StartDate DATE = DATEADD(DAY, -(DATEPART(WEEKDAY, GETDATE()) - 1), CAST(GETDATE() AS DATE));
            DECLARE @EndDate DATE = DATEADD(DAY, 6, @StartDate);

            WITH DateRange AS
            (
                SELECT @StartDate AS SampleDate
                UNION ALL
                SELECT DATEADD(DAY, 1, SampleDate)
                FROM DateRange
                WHERE SampleDate < @EndDate
            ),
            Categories AS
            (
                SELECT DISTINCT
                    car_maker,
                    car_model
                FROM m_applicator
            ),
            ShotCategories AS
            (
                SELECT *
                FROM (VALUES
                    ('100K Shots'),
                    ('50K Shots')
                ) v(shotcnt_category)
            ),
            Exceeded AS
            (
                SELECT
                    CAST(exceeded_date_time AS DATE) AS [Day],
                    car_maker,
                    car_model,
                    shotcnt_category,
                    COUNT(DISTINCT applicator_no) AS total_count
                FROM t_applicator_shots_h
                WHERE 
                    shotcnt_type IN ('Wire Crimper', 'Wire Anvil') AND 
                    exceeded_date_time >= DATEADD(HOUR, 6, CAST(@StartDate AS DATETIME)) AND 
                    exceeded_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(@EndDate AS DATETIME))) 
                GROUP BY 
                    CAST(exceeded_date_time AS DATE), 
                    car_maker,
                    car_model,
                    shotcnt_category
            )
            SELECT
                d.SampleDate,
                c.car_maker,
                c.car_model,
                s.shotcnt_category,
                ISNULL(e.total_count, 0) AS total_count
            FROM DateRange d
            CROSS JOIN Categories c
            CROSS JOIN ShotCategories s
            LEFT JOIN Exceeded e
                ON d.SampleDate = e.Day
                AND e.car_maker = c.car_maker
                AND e.car_model = c.car_model
                AND e.shotcnt_category = s.shotcnt_category
            ORDER BY 
                d.SampleDate,
                c.car_maker,
                c.car_model,
                s.shotcnt_category DESC 
            OPTION (MAXRECURSION 7);";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker_model_label = '';

        if ($row['car_maker'] != $row['car_model']) {
            $maker_model_label = $row['car_maker'] . " " . $row['car_model'];
        } else {
            $maker_model_label = $row['car_maker'];
        }

        $color = $color_map[$maker_model_label] ?? '#6c757d'; // Default gray

        $maker_model_label .= " " . $row['shotcnt_category'];

        // Add unique report_date to categories
        if (!in_array($maker_model_label, $categories)) {
            $categories[] = $maker_model_label;
        }

        $SampleDate = $row['SampleDate']; 
        $value = (int)$row['total_count']; // Extract the value and cast it to an integer

        // Check if the route key already exists in the data array
        if (!isset($data[$maker_model_label])) {
            // Initialize labels and values arrays for the route if it doesn't exist
            $data[$maker_model_label] = [
                "categories" => [],
                "data" => [],
                "color" => $color
            ];
        }

        // Add day and value to the respective arrays
        $data[$maker_model_label]['categories'][] = $SampleDate;
        $data[$maker_model_label]['data'][] = $value;
    }

    // Encode the categories and data as JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
}

if ($method == 'get_current_month_exceeded_chart') {
    $categories = [];

    $statusCounts = [];
    $statusCounts2 = [];

    $data = [];
    $data2 = [];

    $sql = "DECLARE @Year INT = YEAR(GETDATE());  -- Specify the year
            DECLARE @Month INT = MONTH(GETDATE());   -- Specify the month (July)

            WITH DateRange AS (
                SELECT 
                    DATEADD(DAY, number, DATEFROMPARTS(@Year, @Month, 1)) AS report_date
                FROM 
                    master.dbo.spt_values
                WHERE 
                    type = 'P' AND 
                    number < DAY(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)))  -- Generate dates for the month
            ),
            Categories AS
            (
                SELECT DISTINCT
                    car_maker,
                    car_model
                FROM m_applicator
            ),
            ShotCategories AS
            (
                SELECT *
                FROM (VALUES
                    ('100K Shots'),
                    ('50K Shots')
                ) v(shotcnt_category)
            ),
            Exceeded AS
            (
                SELECT
                    CAST(exceeded_date_time AS DATE) AS [Day],
                    car_maker,
                    car_model,
                    shotcnt_category,
                    COUNT(DISTINCT applicator_no) AS total_count
                FROM t_applicator_shots_h
                WHERE 
                    shotcnt_type IN ('Wire Crimper', 'Wire Anvil') AND 
                    exceeded_date_time >= DATEADD(HOUR, 6, CAST(DATEFROMPARTS(@Year, @Month, 1) AS DATETIME)) AND 
                    exceeded_date_time < DATEADD(HOUR, 6, DATEADD(DAY, 1, CAST(EOMONTH(DATEFROMPARTS(@Year, @Month, 1)) AS DATETIME2))) 
                GROUP BY 
                    CAST(exceeded_date_time AS DATE), 
                    car_maker,
                    car_model,
                    shotcnt_category
            )
            SELECT
                d.report_date,
                c.car_maker,
                c.car_model,
                s.shotcnt_category,
                ISNULL(e.total_count, 0) AS total_count
            FROM DateRange d
            CROSS JOIN Categories c
            CROSS JOIN ShotCategories s
            LEFT JOIN Exceeded e
                ON d.report_date = e.Day
                AND e.car_maker = c.car_maker
                AND e.car_model = c.car_model
                AND e.shotcnt_category = s.shotcnt_category
            ORDER BY 
                d.report_date,
                c.car_maker,
                c.car_model,
                s.shotcnt_category DESC";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $date = $row['report_date'];

        if (!in_array($date, $categories)) {
            $categories[] = $date;
        }
    }

    $dateMap = array_flip($categories);
    $totalDays = count($categories);

    foreach ($rows as $row) {
        $shotCategory = $row['shotcnt_category'];

        $carKey = ($row['car_maker'] == $row['car_model'])
            ? $row['car_maker']
            : $row['car_maker'] . ' ' . $row['car_model'];
        
        if (!isset($statusCounts[$shotCategory])) {
            $statusCounts[$shotCategory] = [];
        }

        if (!isset($statusCounts[$shotCategory][$carKey])) {
            $statusCounts[$shotCategory][$carKey] = [];
        }

        $seriesKey = $carKey . ' ' . $row['shotcnt_category'];

        $statusCounts[$shotCategory][$carKey][$row['report_date']] = (int)$row['total_count'];
    }

    foreach ($statusCounts as $shotCategory => $cars) {
        $data[$shotCategory] = [];

        foreach ($cars as $carKey => $dates) {
            $series = [];

            foreach ($categories as $date) {
                $series[] = $dates[$date] ?? 0;
            }

            $data[$shotCategory][] = [
                'name' => $carKey,
                'data' => $series
            ];
        }
    }

    // Encode the categories and data as JSON
    echo json_encode(['categories' => $categories, 'data' => $data, 'colorMap' => $color_map]);
}

$conn = null;
