<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

include '../../conn.php';
include '../../lib/main.php';

$method = $_GET['method'];

if ($method == 'get_recent_applicator_out') {
    $c = 0;

    $sql = "SELECT serial_no, applicator_no, terminal_name, trd_no, operator_out, date_time_out
            FROM t_applicator_in_out
            WHERE zaihai_stock_address IS NULL AND date_time_in IS NULL
            ORDER BY id DESC";
    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;
            echo '<tr>';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['serial_no'].'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['terminal_name'].'</td>';
            echo '<td>'.$row['trd_no'].'</td>';
            echo '<td>'.$row['operator_out'].'</td>';
            echo '<td>'.$row['date_time_out'].'</td>';
            echo '</tr>';
        }
    }
}

if ($method == 'get_single_recent_applicator_out') {
    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];

    $applicator_out_data_arr = array();
    $message = '';

    if (isset($_SESSION['emp_no'])) {
        $operator_in = $_SESSION['emp_no'];
        $operator_in_name = $_SESSION['full_name'];

        if (is_valid_applicator_no($applicator_no) == false) {
            $message = 'Invalid Applicator No';
        } else if (is_valid_terminal_name($terminal_name) == false) {
            $message = 'Invalid Terminal Name';
        } else {
            $applicator_no = split_applicator_no($applicator_no);
            $terminal_name = split_terminal_name($terminal_name);
    
            $sql = "SELECT id FROM m_applicator WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
            $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
    
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                $sql = "SELECT TOP 1 serial_no, applicator_no, terminal_name, trd_no, operator_out, date_time_out 
                        FROM t_applicator_in_out 
                        WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'
                        AND zaihai_stock_address IS NULL AND date_time_in IS NULL
                        ORDER BY id DESC";
                $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $stmt->execute();
    
                $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
                if ($row) {
                    $applicator_out_data_arr = array(
                        "serial_no" => $row['serial_no'],
                        "applicator_no" => $row['applicator_no'],
                        "terminal_name" => $row['terminal_name'],
                        "trd_no" => $row['trd_no'],
                        "operator_out" => $row['operator_out'],
                        "date_time_out" => $row['date_time_out'],
                        "inspection_date_time" => $server_date_time,
                        "inspection_date" => $server_date_only,
                        "inspection_time" => $server_time,
                        "inspection_shift" => get_shift($server_time),
                        "inspected_by" => $operator_in_name,
                        "inspected_by_no" => $operator_in
                    );
                    $message = 'success';
                } else {
                    $message = 'Applicator Already In';
                }
            } else {
                $message = 'Applicator Not Found';
            }
        }
    } else {
        $message = 'Session Timeout';
    }

    $message_arr = array(
        "message" => $message
    );

    $response_arr = array_merge($applicator_out_data_arr, $message_arr);

    echo json_encode($response_arr, JSON_FORCE_OBJECT);
}

if ($method == 'get_recent_applicator_in') {
    $c = 0;

    $sql = "SELECT t1.serial_no, t1.applicator_no, t1.terminal_name, 
                t1.trd_no, t1.operator_out, t1.date_time_out, 
                t1.zaihai_stock_address, t1.operator_in, t1.date_time_in,
                ac.equipment_no, ac.inspection_date_time, ac.inspection_shift, ac.adjustment_content, ac.cross_section_result, 
                ac.inspected_by, ac.checked_by, ac.confirmed_by, ac.judgement, 
                ac.ac1, ac.ac2, ac.ac3, ac.ac4, ac.ac5, ac.ac6, ac.ac7, ac.ac8, ac.ac9, ac.ac10 
            FROM t_applicator_in_out t1
            JOIN (
                SELECT applicator_no, terminal_name, MAX(date_time_in) AS max_date_time_in
                FROM t_applicator_in_out
                WHERE zaihai_stock_address IS NOT NULL AND date_time_in IS NOT NULL
                GROUP BY applicator_no, terminal_name
            ) t2
            ON t1.applicator_no = t2.applicator_no
            AND t1.terminal_name = t2.terminal_name
            AND t1.date_time_in = t2.max_date_time_in
            LEFT JOIN t_applicator_c ac ON t1.serial_no = ac.serial_no
            WHERE t1.zaihai_stock_address IS NOT NULL AND t1.date_time_in IS NOT NULL
            ORDER BY t1.date_time_in DESC";
    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;

            $inspection_date_time = new DateTime($row['inspection_date_time']);
            $inspection_date = $inspection_date_time->format('Y-m-d');
            $inspection_time = $inspection_date_time->format('H:i:s');

            echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#applicator_checksheet_view" 
                    onclick="get_ac_details(&quot;'.$row['serial_no'].'~!~'.$row['equipment_no'].'~!~'.$row['applicator_no'].'~!~'.$row['terminal_name'].'~!~'.
                    $inspection_date.'~!~'.$inspection_time.'~!~'.$row['inspection_shift'].'~!~'.$row['adjustment_content'].'~!~'.$row['cross_section_result'].'~!~'.
                    $row['inspected_by'].'~!~'.$row['checked_by'].'~!~'.$row['confirmed_by'].'~!~'.$row['judgement'].'~!~'.
                    $row['ac1'].'~!~'.$row['ac2'].'~!~'.$row['ac3'].'~!~'.$row['ac4'].'~!~'.$row['ac5'].'~!~'.$row['ac6'].'~!~'.$row['ac7'].'~!~'.$row['ac8'].'~!~'.$row['ac9'].'~!~'.$row['ac10'].'&quot;)">';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['serial_no'].'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['terminal_name'].'</td>';
            echo '<td>'.$row['trd_no'].'</td>';
            echo '<td>'.$row['operator_out'].'</td>';
            echo '<td>'.$row['date_time_out'].'</td>';
            echo '<td>'.$row['zaihai_stock_address'].'</td>';
            echo '<td>'.$row['operator_in'].'</td>';
            echo '<td>'.$row['date_time_in'].'</td>';
            echo '</tr>';
        }
    }
}