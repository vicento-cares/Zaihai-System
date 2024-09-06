<?php
require '../../conn.php';
include '../../lib/main.php';

$method = $_GET['method'];

if ($method == 'get_applicator_history') {
    $date_time_in_from = $_GET['date_time_in_from'];
    $date_time_in_to = $_GET['date_time_in_to'];
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];
    $trd_no = $_GET['trd_no'];
    $zaihai_stock_address = $_GET['zaihai_stock_address'];

    $c = 0;

    $sql = "SELECT aioh.serial_no, aioh.applicator_no, aioh.terminal_name, 
                aioh.trd_no, aioh.operator_out, aioh.date_time_out, 
                aioh.zaihai_stock_address, aioh.operator_in, aioh.date_time_in, aioh.inspected_by AS inspected_by_no, aioh.confirmation_date, 
                a.car_maker, a.car_model, 
                ac.equipment_no, ac.line_address, ac.inspection_date_time, ac.inspection_shift, ac.adjustment_content, ac.adjustment_content_remarks, ac.cross_section_result, 
                ac.inspected_by, ac.checked_by, ac.confirmed_by, ac.judgement, 
                ac.ac1, ac.ac2, ac.ac3, ac.ac4, ac.ac5, ac.ac6, ac.ac7, ac.ac8, ac.ac9, ac.ac10, 
                ac.ac1_s, ac.ac2_s, ac.ac3_s, ac.ac4_s, ac.ac5_s, ac.ac6_s, ac.ac7_s, ac.ac8_s, ac.ac9_s, ac.ac10_s, 
                ac.ac1_r, ac.ac2_r, ac.ac3_r, ac.ac4_r, ac.ac5_r, ac.ac6_r, ac.ac7_r, ac.ac8_r, ac.ac9_r, ac.ac10_r 
            FROM t_applicator_in_out_history aioh
            LEFT JOIN m_applicator a ON aioh.applicator_no = a.applicator_no
            LEFT JOIN t_applicator_c ac ON aioh.serial_no = ac.serial_no
            WHERE aioh.zaihai_stock_address IS NOT NULL AND aioh.date_time_in IS NOT NULL";
    
    if (!empty($date_time_in_from) && !empty($date_time_in_to)) {
        $date_time_in_from = date('Y-m-d H:i:s',(strtotime($date_time_in_from)));
        $date_time_in_to = date('Y-m-d H:i:s',(strtotime($date_time_in_to)));
        $sql .= " AND (aioh.date_time_in >= '$date_time_in_from' AND aioh.date_time_in <= '$date_time_in_to')";
    }

    if (!empty($car_maker)) {
        $sql .= " AND a.car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND a.car_model='$car_model'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND aioh.applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND aioh.terminal_name LIKE '%$terminal_name%'";
    }
    if (!empty($trd_no)) {
        $sql .= " AND aioh.trd_no LIKE '%$trd_no%'";
    }
    if (!empty($zaihai_stock_address)) {
        $sql .= " AND aioh.zaihai_stock_address LIKE '%$zaihai_stock_address%'";
    }

    $sql .= " ORDER BY aioh.date_time_in DESC";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;

            $inspection_date = '';
            $inspection_time = '';

            if (!empty($row['inspection_date_time'])) {
                $inspection_date_time = new DateTime($row['inspection_date_time']);
                $inspection_date = $inspection_date_time->format('Y-m-d');
                $inspection_time = $inspection_date_time->format('H:i:s');
            }
            
            $applicator_no_split = split_applicator_no($row['applicator_no']);
            $terminal_name_split = split_terminal_name($row['terminal_name']);

            echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#applicator_checksheet_view" 
                    onclick="get_ac_details(&quot;'.$row['serial_no'].'~!~'.$row['equipment_no'].'~!~'.$applicator_no_split.'~!~'.$terminal_name_split.'~!~'.
                    $inspection_date.'~!~'.$inspection_time.'~!~'.$row['inspection_shift'].'~!~'.$row['adjustment_content'].'~!~'.$row['adjustment_content_remarks'].'~!~'.$row['cross_section_result'].'~!~'.
                    $row['inspected_by'].'~!~'.$row['checked_by'].'~!~'.$row['confirmed_by'].'~!~'.$row['judgement'].'~!~'.
                    $row['ac1'].'~!~'.$row['ac2'].'~!~'.$row['ac3'].'~!~'.$row['ac4'].'~!~'.$row['ac5'].'~!~'.$row['ac6'].'~!~'.$row['ac7'].'~!~'.$row['ac8'].'~!~'.$row['ac9'].'~!~'.$row['ac10'].'~!~'.
                    $row['ac1_s'].'~!~'.$row['ac2_s'].'~!~'.$row['ac3_s'].'~!~'.$row['ac4_s'].'~!~'.$row['ac5_s'].'~!~'.$row['ac6_s'].'~!~'.$row['ac7_s'].'~!~'.$row['ac8_s'].'~!~'.$row['ac9_s'].'~!~'.$row['ac10_s'].'~!~'.
                    $row['ac1_r'].'~!~'.$row['ac2_r'].'~!~'.$row['ac3_r'].'~!~'.$row['ac4_r'].'~!~'.$row['ac5_r'].'~!~'.$row['ac6_r'].'~!~'.$row['ac7_r'].'~!~'.$row['ac8_r'].'~!~'.$row['ac9_r'].'~!~'.$row['ac10_r'].'&quot;)">';
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
}