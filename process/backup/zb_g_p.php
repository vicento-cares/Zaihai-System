<?php
require '../conn.php';

$method = $_GET['method'];

if ($method == 'get_recent_backup_logs') {
    $c = 0;

    $sql = "SELECT TOP 10 
                date_from, 
                date_to, 
                date_backup, 
                backup_by 
            FROM 
                zaihai_backup.dbo.t_backup_logs 
            ORDER BY 
                date_backup DESC";

    $stmt = $conn->prepare($sql);
	$stmt->execute();

	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
		$c++;

        echo '<tr>';
		echo '<td>'.$c.'</td>';
		echo '<td>'.$row['date_from'].'</td>';
		echo '<td>'.$row['date_to'].'</td>';
		echo '<td>'.$row['date_backup'].'</td>';
		echo '<td>'.$row['backup_by'].'</td>';
		echo '</tr>';
    }
}

$conn = null;
