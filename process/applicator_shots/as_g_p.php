<?php
require '../conn.php';

$method = $_GET['method'];

if ($method == 'get_recent_applicator_shots') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $status = $_GET['status'];
    $applicator_no = $_GET['applicator_no'];
    $location = $_GET['location'];
    $shot_limit_status = $_GET['shot_limit_status'];

    $c = 0;

    $sql = "WITH applicator_shots AS (
                SELECT 
                    l.[applicator_no],
                    l.[car_maker],
                    l.[car_model],
                    l.[location],
                    l.[status],
                    -- Conditional formatting for elapsed time
                    CASE 
                        WHEN DATEDIFF(MINUTE, l.date_updated, GETDATE()) < 1 THEN '< 1 min' 
                        ELSE 
                            -- Build the elapsed time string conditionally
                            LTRIM(
                                CASE 
                                    WHEN DATEDIFF(MINUTE, l.date_updated, GETDATE()) / 1440 > 0 THEN 
                                        CAST(DATEDIFF(MINUTE, l.date_updated, GETDATE()) / 1440 AS VARCHAR(10)) + ' day' + 
                                        CASE WHEN DATEDIFF(MINUTE, l.date_updated, GETDATE()) / 1440 <> 1 THEN 's' ELSE '' END + 
                                        CASE WHEN (DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 1440) / 60 > 0 OR DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 60 > 0 THEN ', ' ELSE '' END
                                    ELSE '' 
                                END +
                                CASE 
                                    WHEN (DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 1440) / 60 > 0 THEN 
                                        CAST((DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 1440) / 60 AS VARCHAR(10)) + ' hour' + 
                                        CASE WHEN (DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 1440) / 60 <> 1 THEN 's' ELSE '' END + 
                                        CASE WHEN DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 60 > 0 THEN ', ' ELSE '' END
                                    ELSE '' 
                                END +
                                CASE 
                                    WHEN DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 60 > 0 THEN 
                                        CAST(DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 60 AS VARCHAR(10)) + ' min' + 
                                        CASE WHEN DATEDIFF(MINUTE, l.date_updated, GETDATE()) % 60 <> 1 THEN 's' ELSE '' END 
                                    ELSE '' 
                                END
                            ) 
                    END AS elapsed_time,
                    JSON_VALUE(j.[value], '$.SHOTCNT_U') AS SHOTCNT_U,
                    s.shotcnt_u_limit_ee,
                    s.shotcnt_u_limit_qa,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS INT) >= s.shotcnt_u_limit_ee 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_u_ee_status,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_U') AS INT) >= s.shotcnt_u_limit_qa 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_u_qa_status,
                    JSON_VALUE(j.[value], '$.SHOTCNT_D') AS SHOTCNT_D,
                    s.shotcnt_d_limit_ee,
                    s.shotcnt_d_limit_qa,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS INT) >= s.shotcnt_d_limit_ee 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_d_ee_status,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_D') AS INT) >= s.shotcnt_d_limit_qa 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_d_qa_status,
                    JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS SHOTCNT_I_U,
                    s.shotcnt_i_u_limit_ee,
                    s.shotcnt_i_u_limit_qa,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS INT) >= s.shotcnt_i_u_limit_ee 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_i_u_ee_status,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_U') AS INT) >= s.shotcnt_i_u_limit_qa 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_i_u_qa_status,
                    JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS SHOTCNT_I_D,
                    s.shotcnt_i_d_limit_ee,
                    s.shotcnt_i_d_limit_qa,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS INT) >= s.shotcnt_i_d_limit_ee 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_i_d_ee_status,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_I_D') AS INT) >= s.shotcnt_i_d_limit_qa 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_i_d_qa_status,
                    JSON_VALUE(j.[value], '$.SHOTCNT_C') AS SHOTCNT_C,
                    s.shotcnt_c_limit_ee,
                    s.shotcnt_c_limit_qa,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS INT) >= s.shotcnt_c_limit_ee 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_c_ee_status,
                    CASE 
                        WHEN CAST(JSON_VALUE(j.[value], '$.SHOTCNT_C') AS INT) >= s.shotcnt_c_limit_qa 
                        THEN 'Exceeded' 
                        ELSE 'Good' 
                    END AS shotcnt_c_qa_status,
                    JSON_VALUE(j.[value], '$.C_SISKSNUSER') AS C_SISKSNUSER
                FROM t_applicator_shots_temp m
                CROSS APPLY OPENJSON(m.[applicator_shot_json]) AS j
                LEFT JOIN t_applicator_list l 
                    ON JSON_VALUE(j.[value], '$.APPLICATOR_NO') = l.[applicator_no]
                LEFT JOIN t_applicator_shots s 
                    ON JSON_VALUE(j.[value], '$.APPLICATOR_NO') = s.[applicator_no]
                WHERE 
                    m.[id] = (SELECT MAX([id]) FROM t_applicator_shots_temp) AND 
                    l.applicator_no IS NOT NULL
            )

            SELECT 
                * 
            FROM 
                applicator_shots 
            WHERE 
                applicator_no IS NOT NULL";

    if (!empty($shot_limit_status)) {
        switch ($shot_limit_status) {
            case 'Good':
                $sql .= " AND (shotcnt_u_qa_status = 'Good' AND 
                            shotcnt_d_qa_status = 'Good' AND 
                            shotcnt_i_u_qa_status = 'Good' AND 
                            shotcnt_i_d_qa_status = 'Good' AND 
                            shotcnt_c_qa_status = 'Good' AND 
                            shotcnt_u_ee_status = 'Good' AND 
                            shotcnt_d_ee_status = 'Good' AND 
                            shotcnt_i_u_ee_status = 'Good' AND 
                            shotcnt_i_d_ee_status = 'Good' AND 
                            shotcnt_c_ee_status = 'Good')";
                break;
            case 'Good-QA':
                $sql .= " AND (shotcnt_u_qa_status = 'Good' AND 
                            shotcnt_d_qa_status = 'Good' AND 
                            shotcnt_i_u_qa_status = 'Good' AND 
                            shotcnt_i_d_qa_status = 'Good' AND 
                            shotcnt_c_qa_status = 'Good')";
                break;
            case 'Good-EE':
                $sql .= " AND (shotcnt_u_ee_status = 'Good' AND 
                            shotcnt_d_ee_status = 'Good' AND 
                            shotcnt_i_u_ee_status = 'Good' AND 
                            shotcnt_i_d_ee_status = 'Good' AND 
                            shotcnt_c_ee_status = 'Good')";
                break;
            case 'Exceeded':
                $sql .= " AND (shotcnt_u_qa_status = 'Exceeded' OR 
                            shotcnt_d_qa_status = 'Exceeded' OR 
                            shotcnt_i_u_qa_status = 'Exceeded' OR 
                            shotcnt_i_d_qa_status = 'Exceeded' OR 
                            shotcnt_c_qa_status = 'Exceeded' OR 
                            shotcnt_u_ee_status = 'Exceeded' OR 
                            shotcnt_d_ee_status = 'Exceeded' OR 
                            shotcnt_i_u_ee_status = 'Exceeded' OR 
                            shotcnt_i_d_ee_status = 'Exceeded' OR 
                            shotcnt_c_ee_status = 'Exceeded')";
                break;
            case 'Exceeded-QA':
                $sql .= " AND (shotcnt_u_qa_status = 'Exceeded' OR 
                            shotcnt_d_qa_status = 'Exceeded' OR 
                            shotcnt_i_u_qa_status = 'Exceeded' OR 
                            shotcnt_i_d_qa_status = 'Exceeded' OR 
                            shotcnt_c_qa_status = 'Exceeded')";
                break;
            case 'Exceeded-EE':
                $sql .= " AND (shotcnt_u_ee_status = 'Exceeded' OR 
                            shotcnt_d_ee_status = 'Exceeded' OR 
                            shotcnt_i_u_ee_status = 'Exceeded' OR 
                            shotcnt_i_d_ee_status = 'Exceeded' OR 
                            shotcnt_c_ee_status = 'Exceeded')";
                break;
            
            default:
                # code...
                break;
        }
    }

    if (!empty($car_maker)) {
        $sql .= " AND car_maker = '$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND car_model = '$car_model'";
    }
    if (!empty($status)) {
        $sql .= " AND status = '$status'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($location)) {
        $sql .= " AND location LIKE '%$location%'";
    }

    $stmt = $conn->prepare($sql);
	$stmt->execute();

	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
		$c++;

		$row_class = '';
		// if (intval($row['downtime']) == 1 && $row['status'] != 'Ready To Use') {
		// 	$row_class = 'bg-danger';
		// }
		echo '<tr class="'.$row_class.'">';

		echo '<td>'.$c.'</td>';
		echo '<td>'.$row['car_maker'].'</td>';
		echo '<td>'.$row['car_model'].'</td>';
		echo '<td>'.$row['applicator_no'].'</td>';
		echo '<td>'.$row['location'].'</td>';
		echo '<td>'.$row['status'].'</td>';
		echo '<td>'.$row['elapsed_time'].'</td>';
		echo '<td>'.$row['SHOTCNT_U'].'</td>';
        echo '<td>'.$row['shotcnt_u_limit_ee'].'</td>';
        echo '<td>'.$row['shotcnt_u_limit_qa'].'</td>';
        echo '<td>'.$row['shotcnt_u_ee_status'].'</td>';
        echo '<td>'.$row['shotcnt_u_qa_status'].'</td>';
        echo '<td>'.$row['SHOTCNT_D'].'</td>';
        echo '<td>'.$row['shotcnt_d_limit_ee'].'</td>';
        echo '<td>'.$row['shotcnt_d_limit_qa'].'</td>';
        echo '<td>'.$row['shotcnt_d_ee_status'].'</td>';
        echo '<td>'.$row['shotcnt_d_qa_status'].'</td>';
        echo '<td>'.$row['SHOTCNT_I_U'].'</td>';
        echo '<td>'.$row['shotcnt_i_u_limit_ee'].'</td>';
        echo '<td>'.$row['shotcnt_i_u_limit_qa'].'</td>';
        echo '<td>'.$row['shotcnt_i_u_ee_status'].'</td>';
        echo '<td>'.$row['shotcnt_i_u_qa_status'].'</td>';
        echo '<td>'.$row['SHOTCNT_I_D'].'</td>';
        echo '<td>'.$row['shotcnt_i_d_limit_ee'].'</td>';
        echo '<td>'.$row['shotcnt_i_d_limit_qa'].'</td>';
        echo '<td>'.$row['shotcnt_i_d_ee_status'].'</td>';
        echo '<td>'.$row['shotcnt_i_d_qa_status'].'</td>';
        echo '<td>'.$row['SHOTCNT_C'].'</td>';
        echo '<td>'.$row['shotcnt_c_limit_ee'].'</td>';
        echo '<td>'.$row['shotcnt_c_limit_qa'].'</td>';
        echo '<td>'.$row['shotcnt_c_ee_status'].'</td>';
        echo '<td>'.$row['shotcnt_c_qa_status'].'</td>';
		echo '</tr>';
    }
}

$conn = null;
