<?php
require '../../conn.php';

$method = $_POST['method'];

// Access Locations

if ($method == 'add_access_location') {
    $car_maker = trim($_POST['car_maker']);
    $car_model = trim($_POST['car_model']);
    $ip = trim($_POST['ip']);

    $query = "SELECT id FROM m_access_locations WHERE ip = ?";

    $stmt = $conn->prepare($query);
    $params = array($ip);

    $stmt->execute($params);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo 'Already Exist';
    } else {
        $stmt = NULL;

        $query = "INSERT INTO m_access_locations (car_maker, car_model, ip) 
					VALUES (?, ?, ?)";

        $stmt = $conn->prepare($query);
        $params = array($car_maker, $car_model, $ip);

        if ($stmt->execute($params)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}

if ($method == 'update_access_location') {
    $id = $_POST['id'];
    $car_maker = trim($_POST['car_maker']);
    $car_model = trim($_POST['car_model']);
    $ip = trim($_POST['ip']);

    $query = "SELECT id FROM m_access_locations WHERE car_maker = ? AND car_model = ? AND ip = ?";

    $stmt = $conn->prepare($query);
    $params = array($car_maker, $car_model, $ip);

    $stmt->execute($params);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo 'duplicate';
    } else {
        $stmt = NULL;

        $query = "UPDATE m_access_locations 
					SET car_maker = ?, car_model = ?, ip = ?, date_updated = ? 
					WHERE id = ?";

        $stmt = $conn->prepare($query);
        $params = array($car_maker, $car_model, $ip, $server_date_time, $id);

        if ($stmt->execute($params)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}

if ($method == 'delete_access_location') {
    $id = $_POST['id'];

    $query = "DELETE FROM m_access_locations WHERE id = ?";

    $stmt = $conn->prepare($query);
    $params = array($id);

    if ($stmt->execute($params)) {
        echo 'success';
    } else {
        echo 'error';
    }
}

$conn = NULL;
