<?php
include '../../conn.php';

$method = $_GET['method'];

if ($method == 'get_recent_applicator_in_pending') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];
    $location = $_GET['location'];

    $c = 0;

    $sql = "SELECT t1.serial_no, t1.applicator_no, t1.terminal_name, 
                t1.trd_no, t1.operator_out, t1.date_time_out, 
                t1.zaihai_stock_address, t1.operator_in, t1.date_time_in, 
                al.car_maker, al.car_model
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
            LEFT JOIN t_applicator_list al ON t1.applicator_no = al.applicator_no
            WHERE t1.zaihai_stock_address IS NOT NULL AND t1.date_time_in IS NOT NULL";

    if (!empty($car_maker)) {
        $sql .= " AND t1.car_maker='$car_maker'";
    }
    if (!empty($car_model)) {
        $sql .= " AND t1.car_model='$car_model'";
    }
    if (!empty($applicator_no)) {
        $sql .= " AND t1.applicator_no LIKE '%$applicator_no%'";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND t1.terminal_name LIKE '%$terminal_name%'";
    }
    if (!empty($location)) {
        $sql .= " AND t1.location LIKE '%$location%'";
    }

    $sql .= " ORDER BY t1.date_time_in DESC";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;

            echo '<tr style="cursor:pointer;" class="modal-trigger" 
                    onclick="get_applicator_in_pending_details(&quot;'.$row['applicator_no'].'~!~'.$row['terminal_name'].'&quot;)">';
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
            echo '<td>'.$row['operator_in'].'</td>';
            echo '<td>'.$row['date_time_in'].'</td>';
            echo '</tr>';
        }
    }
}