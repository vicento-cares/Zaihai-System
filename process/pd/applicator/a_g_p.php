<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require '../../conn.php';

$method = $_GET['method'];

if ($method == 'get_applicators') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $applicator_no = $_GET['applicator_no'];
    $zaihai_stock_address = $_GET['zaihai_stock_address'];

    $is_prod_priority = $_GET['is_prod_priority'] ?? '';
    $priority_value = intval($is_prod_priority);

    $c = 0;

    $sql = "SELECT 
				id, 
				car_maker, 
				car_model, 
				applicator_no, 
				zaihai_stock_address, 
				is_prod_priority, 
				CASE WHEN CAST(is_prod_priority AS INT) > 0 THEN 'Priority' ELSE 'Non-Priority' END AS priority_status, 
				date_updated 
			FROM 
				m_applicator
			WHERE 
				is_priority = 0";

    if (!empty($applicator_no)) {
        $sql .= " AND applicator_no LIKE '$applicator_no%'";
    }
    if (!empty($car_maker)) {
        $sql .= " AND car_maker LIKE '$car_maker%'";
    }
    if (!empty($car_model)) {
        $sql .= " AND car_model LIKE '$car_model%'";
    }
    if (!empty($zaihai_stock_address)) {
        $sql .= " AND zaihai_stock_address LIKE '$zaihai_stock_address%'";
    }
    // Only add to query if the value is 0 or 1 (not empty string)
    if ($is_prod_priority !== '' && in_array($priority_value, [0, 1])) {
        $sql .= " AND is_prod_priority = '$is_prod_priority'";
        // Add $priority_value to your parameters array for the prepared statement
    }

    $sql .= " ORDER BY date_updated DESC";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
    if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $row){
            $c++;

			$checked = '';
			$is_prod_priority = intval($row['is_prod_priority']);
			if ($is_prod_priority > 0) {
				$checked = 'checked';
			}

            echo '<tr>';
            echo '<td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck" id="a_chkbx_'.$c.'" 
							value="'.$is_prod_priority.'" data-id="'.$row['id'].'" onclick="update_applicator('.$c.', this)" ' . $checked . '/><span></span></label></p></td>';
			echo '<td>'.$c.'</td>';
            echo '<td>'.$row['car_maker'].'</td>';
            echo '<td>'.$row['car_model'].'</td>';
            echo '<td>'.$row['applicator_no'].'</td>';
            echo '<td>'.$row['zaihai_stock_address'].'</td>';
			echo '<td id="a_priority_status_row_'.$c.'">'.$row['priority_status'].'</td>';
            echo '<td>'.$row['date_updated'].'</td>';
            echo '</tr>';
        }
    }
}

$conn = null;