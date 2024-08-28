<?php
require '../../conn.php';

$method = $_GET['method'];

// Get Applicator Name Datalist
if ($method == 'get_applicator_no_datalist_search') {
	$sql = "SELECT applicator_no FROM m_applicator 
            GROUP BY applicator_no ORDER BY applicator_no ASC";
	$stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['applicator_no'].'">';
		}
	}
}

if ($method == 'get_applicators') {
    $applicator_no = $_GET['applicator_no'];
    $zaihai_stock_address = $_GET['zaihai_stock_address'];

    $c = 0;

    $sql = "SELECT id, applicator_no, zaihai_stock_address, date_updated FROM m_applicator";

    if (!empty($applicator_no)) {
        $sql .= " WHERE applicator_no LIKE '$applicator_no%'";
    } else {
        $sql .= " WHERE applicator_no != ''";
    }
    if (!empty($zaihai_stock_address)) {
        $sql .= " AND zaihai_stock_address LIKE '$zaihai_stock_address%'";
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;

            echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_applicator"
                    onclick="get_applicator_details(&quot;'.$row['id'].'~!~'.$row['applicator_no'].'~!~'.$row['zaihai_stock_address'].'&quot;)">';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['zaihai_stock_address'].'</td>';
            echo '<td>'.$row['date_updated'].'</td>';
            echo '</tr>';
        }
    }
}

$conn = null;