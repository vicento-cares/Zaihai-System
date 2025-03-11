<?php
require '../../conn.php';

$method = $_GET['method'];

// Access Locations

function count_access_location_list($search_arr, $conn)
{
    $total = 0;

    $query = "SELECT COUNT(id) AS total FROM m_access_locations WHERE ip != ''";

    $params = [];

    if (!empty($search_arr['ip'])) {
        $query = $query . " AND ip LIKE ?";
        $ip_search = $search_arr['ip'] . '%';
        $params[] = $ip_search;
    }

    if (!empty($search_arr['car_maker'])) {
        $query = $query . " AND car_maker LIKE ?";
        $car_maker_search = $search_arr['car_maker'] . '%';
        $params[] = $car_maker_search;
    }

    if (!empty($search_arr['car_model'])) {
        $query = $query . " AND car_model LIKE ?";
        $car_model_search = $search_arr['car_model'] . '%';
        $params[] = $car_model_search;
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $total = intval($row['total']);
    }

    return $total;
}

// Get Car Maker Dropdown
if ($method == 'get_car_maker_dropdown_search') {
    $sql = "SELECT car_maker FROM m_access_locations GROUP BY car_maker ORDER BY car_maker ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo '<option selected value="">All</option>';
        foreach ($results as $row) {
            echo '<option value="' . htmlspecialchars($row['car_maker']) . '">' . 
                    htmlspecialchars($row['car_maker']) . '</option>';
        }
    } else {
        echo '<option selected value="">All</option>';
    }
}

// Get Car Model Dropdown
if ($method == 'get_car_model_dropdown_search') {
    $sql = "SELECT car_model FROM m_access_locations GROUP BY car_model ORDER BY car_model ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo '<option selected value="">All</option>';
        foreach ($results as $row) {
            echo '<option value="' . htmlspecialchars($row['car_model']) . '">' . 
                    htmlspecialchars($row['car_model']) . '</option>';
        }
    } else {
        echo '<option selected value="">All</option>';
    }
}

if ($method == 'count_access_location_list') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $ip = $_GET['ip'];

    $search_arr = array(
        "car_maker" => $car_maker,
        "car_model" => $car_model,
        "ip" => $ip
    );

    echo count_access_location_list($search_arr, $conn);
}

if ($method == 'access_location_list_last_page') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $ip = $_GET['ip'];

    $search_arr = array(
        "car_maker" => $car_maker,
        "car_model" => $car_model,
        "ip" => $ip
    );

    $results_per_page = 20;

    $number_of_result = intval(count_access_location_list($search_arr, $conn));

    //determine the total number of pages available  
    $number_of_page = ceil($number_of_result / $results_per_page);

    echo $number_of_page;
}

if ($method == 'access_location_list') {
    $car_maker = $_GET['car_maker'];
    $car_model = $_GET['car_model'];
    $ip = $_GET['ip'];

    $current_page = intval($_GET['current_page']);
    $c = 0;

    $results_per_page = 20;

    //determine the sql LIMIT starting number for the results on the displaying page
    $page_first_result = ($current_page - 1) * $results_per_page;

    $c = $page_first_result;

    $query = "SELECT id, car_maker, car_model, ip, date_updated 
				FROM m_access_locations WHERE ip != ''";

    $params = [];

    if (!empty($ip)) {
        $query = $query . " AND ip LIKE ?";
        $ip_search = $ip . '%';
        $params[] = $ip_search;
    }

    if (!empty($car_maker)) {
        $query = $query . " AND car_maker LIKE ?";
        $car_maker_search = $car_maker . '%';
        $params[] = $car_maker_search;
    }

    if (!empty($car_model)) {
        $query = $query . " AND car_model LIKE ?";
        $car_model_search = $car_model . '%';
        $params[] = $car_model_search;
    }

    // MySQL Query
    // $query = $query . " LIMIT ".$page_first_result.", ".$results_per_page;

    // MS SQL Server Query
    $query = $query . " ORDER BY id ASC";
    $query = $query . " OFFSET " . $page_first_result . " ROWS FETCH NEXT " . $results_per_page . " ROWS ONLY";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $c++;

        echo '<tr style="cursor:pointer;" class="modal-trigger" 
                data-toggle="modal" data-target="#update_access_location" 
                onclick="get_access_location_details(&quot;' . 
                $row['id'] . '~!~' . 
                $row['car_maker'] . '~!~' . 
                $row['car_model'] . '~!~' . 
                $row['ip'] . '&quot;)">';
        echo '<td>' . $c . '</td>';
        echo '<td>' . $row['car_maker'] . '</td>';
        echo '<td>' . $row['car_model'] . '</td>';
        echo '<td>' . $row['ip'] . '</td>';
        echo '<td>' . $row['date_updated'] . '</td>';
        echo '</tr>';
    }
}

$conn = NULL;
