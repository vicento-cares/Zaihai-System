<?php
include '../../conn.php';

$method = $_GET['method'];

if ($method == 'get_recent_applicator_list') {
    $sql = "SELECT car_maker, car_model, applicator_no, location, date_updated
            FROM t_applicator_list";
    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            echo '<tr>';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['car_maker'].'</td>';
            echo '<td>'.$row['car_model'].'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['location'].'</td>';
            echo '<td>'.$row['date_updated'].'</td>';
        }
    }
}