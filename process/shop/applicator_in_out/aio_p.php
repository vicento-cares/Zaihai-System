<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

include '../../conn.php';
include '../../lib/main.php';

$method = $_POST['method'];

if ($method == 'out_applicator') {
    $location = $_POST['location'];
    $applicator_no = $_POST['applicator_no'];
    $terminal_name = $_POST['terminal_name'];
    $operator_out = $_SESSION['emp_no'];

    if (is_valid_applicator_no($applicator_no) == false) {
        echo 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        echo 'Invalid Terminal Name';
    } else {
        $applicator_no = split_applicator_no($applicator_no);
        $terminal_name = split_terminal_name($terminal_name);

        $sql = "SELECT id FROM m_applicator WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $sql = "SELECT id FROM t_applicator_in_out 
                    WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'
                    AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
            $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $serial_no = date("ymdh");
                $rand = substr(md5(microtime()),rand(0,26),5);
                $serial_no = 'MEI-295-AC-'.$serial_no;
                $serial_no = $serial_no.''.$rand;

                $sql = "INSERT INTO t_applicator_in_out (serial_no, applicator_no, terminal_name, trd_no, operator_out) 
                        VALUES ('$serial_no', '$applicator_no', '$terminal_name', '$location', '$operator_out')";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute();

                $sql = "UPDATE t_applicator_list 
                        SET location = '$location', date_updated = '$server_date_time'
                        WHERE applicator_no = '$applicator_no'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo 'success';
            } else {
                echo 'Applicator Already Out';
            }
        } else {
            echo 'Applicator Not Found';
        }
    }
}

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

if ($method == 'in_applicator') {
    $location = $_POST['location'];
    $applicator_no = $_POST['applicator_no'];
    $terminal_name = $_POST['terminal_name'];
    $operator_in = $_SESSION['emp_no'];

    if (is_valid_applicator_no($applicator_no) == false) {
        echo 'Invalid Applicator No.';
    } else if (is_valid_terminal_name($terminal_name) == false) {
        echo 'Invalid Terminal Name';
    } else {
        $applicator_no = split_applicator_no($applicator_no);
        $terminal_name = split_terminal_name($terminal_name);

        $sql = "SELECT id FROM m_applicator WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'";
        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $sql = "SELECT TOP 1 id FROM t_applicator_in_out 
                    WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'
                    AND zaihai_stock_address IS NULL AND date_time_in IS NULL
                    ORDER BY id DESC";
            $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $sql = "UPDATE t_applicator_in_out 
                        SET zaihai_stock_address = '$location', operator_in = '$operator_in', date_time_in = '$server_date_time'
                        WHERE applicator_no = '$applicator_no' AND terminal_name = '$terminal_name'
                        AND zaihai_stock_address IS NULL AND date_time_in IS NULL";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute();

                $sql = "UPDATE t_applicator_list 
                        SET location = '$location', date_updated = '$server_date_time'
                        WHERE applicator_no = '$applicator_no'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo 'success';
            } else {
                echo 'Applicator Already In';
            }
        } else {
            echo 'Applicator Not Found';
        }
    }
}

if ($method == 'get_recent_applicator_in') {
    $c = 0;

    $sql = "SELECT t1.serial_no, t1.applicator_no, t1.terminal_name, 
                t1.trd_no, t1.operator_out, t1.date_time_out, 
                t1.zaihai_stock_address, t1.operator_in, t1.date_time_in 
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
            WHERE t1.zaihai_stock_address IS NOT NULL AND t1.date_time_in IS NOT NULL
            ORDER BY t1.date_time_in DESC";
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
            echo '<td>'.$row['zaihai_stock_address'].'</td>';
            echo '<td>'.$row['operator_in'].'</td>';
            echo '<td>'.$row['date_time_in'].'</td>';
            echo '</tr>';
        }
    }
}