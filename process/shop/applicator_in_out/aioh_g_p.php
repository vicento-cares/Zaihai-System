<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';
include '../../lib/main.php';

$method = $_GET['method'];

if ($method == 'get_applicator_history') {
    $date_time_in_from = $_GET['date_time_in_from'];
    $date_time_in_to = $_GET['date_time_in_to'];

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
    $trd_no = addslashes($_GET['trd_no']);
    $zaihai_stock_address = addslashes($_GET['zaihai_stock_address']);

    $c = 0;

    $sql = "SELECT aioh.serial_no, aioh.applicator_no, aioh.terminal_name, 
                aioh.trd_no, aioh.operator_out, aioh.date_time_out, 
                aioh.zaihai_stock_address, aioh.operator_in, aioh.date_time_in, aioh.inspected_by AS inspected_by_no, aioh.confirmation_date, 
                a.car_maker, a.car_model, 
                ac.equipment_no, ac.line_address, ac.inspection_date_time, ac.inspection_shift, ac.adjustment_content, ac.adjustment_content_remarks, ac.cross_section_result, 
                ac.inspected_by, ac.checked_by, ac.confirmed_by, ac.judgement, 
                ac.ac1, ac.ac2, ac.ac3, ac.ac4, ac.ac5, ac.ac6, ac.ac7, ac.ac8, ac.ac9, ac.ac10, 
                ac.ac1_s, ac.ac2_s, ac.ac3_s, ac.ac4_s, ac.ac5_s, ac.ac6_s, ac.ac7_s, ac.ac8_s, ac.ac9_s, ac.ac10_s, 
                ac.ac1_r, ac.ac2_r, ac.ac3_r, ac.ac4_r, ac.ac5_r, ac.ac6_r, ac.ac7_r, ac.ac8_r, ac.ac9_r, ac.ac10_r, 
                ac.created_from_itf, ac.f_inspection_date_time, ac.f_inspection_shift, ac.f_adjustment_content, ac.f_adjustment_content_remarks, ac.f_cross_section_result, 
                ac.fac1, ac.fac2, ac.fac3, ac.fac4, ac.fac5, ac.fac6, ac.fac7, ac.fac8, ac.fac9, ac.fac10, 
                ac.fac1_s, ac.fac2_s, ac.fac3_s, ac.fac4_s, ac.fac5_s, ac.fac6_s, ac.fac7_s, ac.fac8_s, ac.fac9_s, ac.fac10_s, 
                ac.fac1_r, ac.fac2_r, ac.fac3_r, ac.fac4_r, ac.fac5_r, ac.fac6_r, ac.fac7_r, ac.fac8_r, ac.fac9_r, ac.fac10_r 
            FROM t_applicator_in_out_history aioh";

    $params = [];
    
    if (isset($_GET['page']) && $_GET['page'] == 'shop') {
        $sql .= " JOIN m_applicator a ON aioh.applicator_no = a.applicator_no";
    } else {
        $sql .= " LEFT JOIN m_applicator a ON aioh.applicator_no = a.applicator_no";
    }

    $sql .= " LEFT JOIN t_applicator_c ac ON aioh.serial_no = ac.serial_no 
            WHERE aioh.zaihai_stock_address IS NOT NULL AND aioh.date_time_in IS NOT NULL";
    
    if (!empty($date_time_in_from) && !empty($date_time_in_to)) {
        $date_time_in_from = date('Y-m-d H:i:s',(strtotime($date_time_in_from)));
        $date_time_in_to = date('Y-m-d H:i:s',(strtotime($date_time_in_to)));
        $sql .= " AND (aioh.date_time_in >= ? AND aioh.date_time_in <= ?)";
        $params[] = $date_time_in_from;
        $params[] = $date_time_in_to;
    }

    if (!empty($car_maker)) {
        $sql .= " AND a.car_maker = ?";
        $params[] = $car_maker;
    }
    if (!empty($car_model)) {
        $sql .= " AND a.car_model = ?";
        $params[] = $car_model;
    }
    if (!empty($applicator_no)) {
        $sql .= " AND aioh.applicator_no LIKE ?";
        $applicator_no_param = "%" . $applicator_no . "%";
        $params[] = $applicator_no_param;
    }
    if (!empty($terminal_name)) {
        $sql .= " AND aioh.terminal_name LIKE ?";
        $terminal_name_param = "%" . $terminal_name . "%";
        $params[] = $terminal_name_param;
    }
    if (!empty($trd_no)) {
        $sql .= " AND aioh.trd_no LIKE ?";
        $trd_no_param = "%" . $trd_no . "%";
        $params[] = $trd_no_param;
    }
    if (!empty($zaihai_stock_address)) {
        $sql .= " AND aioh.zaihai_stock_address LIKE ?";
        $zaihai_stock_address_param = "%" . $zaihai_stock_address . "%";
        $params[] = $zaihai_stock_address_param;
    }

    $sql .= " ORDER BY aioh.date_time_in DESC";

    $stmt = $conn->prepare($sql);
	$stmt->execute($params);

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $c++;

        $inspection_date = '';
        $inspection_time = '';
        $f_inspection_date = '';
        $f_inspection_time = '';

        if (!empty($row['inspection_date_time'])) {
            $inspection_date_time = new DateTime($row['inspection_date_time']);
            $inspection_date = $inspection_date_time->format('Y-m-d');
            $inspection_time = $inspection_date_time->format('H:i:s');
        }
        if (!empty($row['f_inspection_date_time'])) {
            $f_inspection_date_time = new DateTime($row['f_inspection_date_time']);
            $f_inspection_date = $f_inspection_date_time->format('Y-m-d');
            $f_inspection_time = $f_inspection_date_time->format('H:i:s');
        }
        
        $applicator_no_split = split_applicator_no($row['applicator_no']);
        $terminal_name_split = split_terminal_name($row['terminal_name']);

        echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#applicator_checksheet_view" 
                onclick="get_ac_details(&quot;'.$row['serial_no'].'~!~'.$row['equipment_no'].'~!~'.$applicator_no_split.'~!~'.$terminal_name_split.'~!~'.
                $inspection_date.'~!~'.$inspection_time.'~!~'.$row['inspection_shift'].'~!~'.$row['adjustment_content'].'~!~'.$row['adjustment_content_remarks'].'~!~'.$row['cross_section_result'].'~!~'.
                $row['inspected_by'].'~!~'.$row['checked_by'].'~!~'.$row['confirmed_by'].'~!~'.$row['judgement'].'~!~'.
                $row['ac1'].'~!~'.$row['ac2'].'~!~'.$row['ac3'].'~!~'.$row['ac4'].'~!~'.$row['ac5'].'~!~'.$row['ac6'].'~!~'.$row['ac7'].'~!~'.$row['ac8'].'~!~'.$row['ac9'].'~!~'.$row['ac10'].'~!~'.
                $row['ac1_s'].'~!~'.$row['ac2_s'].'~!~'.$row['ac3_s'].'~!~'.$row['ac4_s'].'~!~'.$row['ac5_s'].'~!~'.$row['ac6_s'].'~!~'.$row['ac7_s'].'~!~'.$row['ac8_s'].'~!~'.$row['ac9_s'].'~!~'.$row['ac10_s'].'~!~'.
                $row['ac1_r'].'~!~'.$row['ac2_r'].'~!~'.$row['ac3_r'].'~!~'.$row['ac4_r'].'~!~'.$row['ac5_r'].'~!~'.$row['ac6_r'].'~!~'.$row['ac7_r'].'~!~'.$row['ac8_r'].'~!~'.$row['ac9_r'].'~!~'.$row['ac10_r'].'~!~'.
                $row['created_from_itf'].'~!~'.$f_inspection_date.'~!~'.$f_inspection_time.'~!~'.$row['f_inspection_shift'].'~!~'.$row['f_adjustment_content'].'~!~'.$row['f_adjustment_content_remarks'].'~!~'.$row['f_cross_section_result'].'~!~'.
                $row['fac1'].'~!~'.$row['fac2'].'~!~'.$row['fac3'].'~!~'.$row['fac4'].'~!~'.$row['fac5'].'~!~'.$row['fac6'].'~!~'.$row['fac7'].'~!~'.$row['fac8'].'~!~'.$row['fac9'].'~!~'.$row['fac10'].'~!~'.
                $row['fac1_s'].'~!~'.$row['fac2_s'].'~!~'.$row['fac3_s'].'~!~'.$row['fac4_s'].'~!~'.$row['fac5_s'].'~!~'.$row['fac6_s'].'~!~'.$row['fac7_s'].'~!~'.$row['fac8_s'].'~!~'.$row['fac9_s'].'~!~'.$row['fac10_s'].'~!~'.
                $row['fac1_r'].'~!~'.$row['fac2_r'].'~!~'.$row['fac3_r'].'~!~'.$row['fac4_r'].'~!~'.$row['fac5_r'].'~!~'.$row['fac6_r'].'~!~'.$row['fac7_r'].'~!~'.$row['fac8_r'].'~!~'.$row['fac9_r'].'~!~'.$row['fac10_r'].'&quot;)">';
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
        echo '<td>'.$row['line_address'].'</td>';
        echo '<td>'.$row['operator_in'].'</td>';
        echo '<td>'.$row['date_time_in'].'</td>';
        echo '<td>'.$row['inspected_by_no'].'</td>';
        echo '<td>'.$row['confirmation_date'].'</td>';
        echo '<td>'.$row['adjustment_content'].'</td>';
        echo '<td>'.$row['adjustment_content_remarks'].'</td>';
        echo '</tr>';
    }
}

$conn = null;
