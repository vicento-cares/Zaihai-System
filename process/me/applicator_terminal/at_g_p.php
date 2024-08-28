<?php
require '../../conn.php';

$method = $_GET['method'];

if ($method == 'get_applicator_terminal') {
    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];

    $c = 0;

    $sql = "SELECT id, applicator_no, terminal_name, date_updated FROM m_applicator_terminal";

    if (!empty($applicator_no)) {
        $sql .= " WHERE applicator_no LIKE '$applicator_no%'";
    } else {
        $sql .= " WHERE applicator_no != ''";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND terminal_name LIKE '$terminal_name%'";
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;

            echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_applicator_terminal"
                    onclick="get_applicator_terminal_details(&quot;'.$row['id'].'~!~'.$row['applicator_no'].'~!~'.$row['terminal_name'].'&quot;)">';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['terminal_name'].'</td>';
            echo '<td>'.$row['date_updated'].'</td>';
            echo '</tr>';
        }
    }
}

$conn = null;