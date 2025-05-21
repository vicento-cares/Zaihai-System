<?php
require '../../conn.php';

$method = $_GET['method'];

// Get Applicator No. Dropdown
if ($method == 'get_applicator_no_dropdown') {
	$sql = "SELECT applicator_no FROM m_applicator_terminal 
            GROUP BY applicator_no ORDER BY applicator_no ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option selected value=""></option>';
		do {
			echo '<option value="'.htmlspecialchars($row['applicator_no']).'">'.htmlspecialchars($row['applicator_no']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value=""></option>';
	}
}

// Get Applicator No. Datalist
if ($method == 'get_applicator_no_datalist_search') {
	$sql = "SELECT applicator_no FROM m_applicator_terminal 
            GROUP BY applicator_no ORDER BY applicator_no ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['applicator_no'].'">';
	}
}

// Get Terminal Name Dropdown
if ($method == 'get_terminal_name_dropdown') {
	$sql = "SELECT terminal_name FROM m_applicator_terminal 
            GROUP BY terminal_name ORDER BY terminal_name ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option selected value=""></option>';
		do {
			echo '<option value="'.htmlspecialchars($row['terminal_name']).'">'.htmlspecialchars($row['terminal_name']).'</option>';
		} while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
	} else {
		echo '<option selected value=""></option>';
	}
}

// Get Terminal Name Datalist
if ($method == 'get_terminal_name_datalist_search') {
	$sql = "SELECT terminal_name FROM m_applicator_terminal 
            GROUP BY terminal_name ORDER BY terminal_name ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="'.$row['terminal_name'].'">';
	}
}

if ($method == 'get_applicator_terminal') {
    $applicator_no = $_GET['applicator_no'];
    $terminal_name = $_GET['terminal_name'];

    $c = 0;

    $sql = "SELECT id, applicator_no, terminal_name, date_updated FROM m_applicator_terminal";
	$params = [];

    if (!empty($applicator_no)) {
        $sql .= " WHERE applicator_no LIKE ?";
		$applicator_no_param = $applicator_no . '%';
    	$params[] = $applicator_no_param;
    } else {
        $sql .= " WHERE applicator_no != ''";
    }
    if (!empty($terminal_name)) {
        $sql .= " AND terminal_name LIKE ?";
		$terminal_name_param = $terminal_name . '%';
    	$params[] = $terminal_name_param;
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql);
	$stmt->execute($params);

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
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

$conn = null;
