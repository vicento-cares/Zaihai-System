<?php
require '../../conn.php';

$method = $_GET['method'];

if ($method == 'get_accounts') {
    $emp_no = $_GET['emp_no'];
    $full_name = $_GET['full_name'];
    $role = $_GET['role'];

    $c = 0;

    $sql = "SELECT id, emp_no, full_name, role, date_updated FROM m_accounts";
    $params = [];

    if (!empty($emp_no)) {
        $sql .= " WHERE emp_no LIKE ?";
        $emp_no_param = $emp_no . '%';
        $params[] = $emp_no_param;
    } else {
        $sql .= " WHERE emp_no != ''";
    }
    if (!empty($full_name)) {
        $sql .= " AND full_name LIKE ?";
        $full_name_param = $full_name . '%';
        $params[] = $full_name_param;
    }
    if (!empty($role)) {
        $sql .= " AND role = ?";
        $params[] = $role;
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql);
	$stmt->execute($params);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
		do {
            $c++;

            echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_account"
                    onclick="get_account_details(&quot;'.$row['id'].'~!~'.$row['emp_no'].'~!~'.$row['full_name'].'~!~'.$row['role'].'&quot;)">';
            echo '<td>'.$c.'</td>';
            echo '<td>'.$row['emp_no'].'</td>';
            echo '<td>'.$row['full_name'].'</td>';
            echo '<td>'.$row['role'].'</td>';
            echo '<td>'.$row['date_updated'].'</td>';
            echo '</tr>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }
}

$conn = null;
