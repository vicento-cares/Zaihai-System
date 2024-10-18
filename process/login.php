<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require 'conn.php';

function get_access_location_by_ip($ip, $conn) {
    $can_access = false;
    $car_maker = '';
    $car_model = '';

    $response_arr = array();

    $sql = "SELECT car_maker, car_model FROM m_access_locations WHERE ip = ?";
    $stmt = $conn->prepare($sql);
    $params = array($ip);
    $stmt->execute($params);

    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $car_maker = $row['car_maker'];
        $car_model = $row['car_model'];
        $can_access = true;
    }

    $response_arr = array(
        'car_maker' => $car_maker,
        'car_model' => $car_model,
        'can_access' => $can_access
    );

    return $response_arr;
}

if (isset($_POST['login_btn'])) {

    // REMOTE IP ADDRESS
    $ip = $_SERVER['REMOTE_ADDR'];

    $emp_no = addslashes($_POST['emp_no']);
    $role = $_POST['role'];

    // CHECK IP
    $response_arr = get_access_location_by_ip($ip, $conn);
    
    $role_check = '';

    if (empty($emp_no)) {
        echo '<script>alert("Please Scan QR Code or Enter ID Number")</script>';
    } else {
        $check = "SELECT emp_no, full_name, role FROM m_accounts 
                    WHERE emp_no = '$emp_no' COLLATE SQL_Latin1_General_CP1_CS_AS";
        $stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach($stmt->fetchALL() as $x){
                $emp_no = $x['emp_no'];
                $full_name = $x['full_name'];
                $role_check = $x['role'];
            }

            if ($role_check == 'Shop' || $role_check == 'Inspector') {
                if ($response_arr['can_access'] == true) {
                    if ($role_check == 'Shop' && ($role == 'Shop' || $role == 'Inspector')) {
                        $_SESSION['emp_no'] = $emp_no;
                        $_SESSION['full_name'] = $full_name;
                        $_SESSION['role'] = $role;
                        $_SESSION['car_maker'] = $response_arr['car_maker'];
                        $_SESSION['car_model'] = $response_arr['car_model'];
                        if ($role == 'Shop') {
                            header('location:/zaihai/shop/applicator_list.php');
                        } else if ($role == 'Inspector') {
                            header('location:/zaihai/inspector/applicator_checksheet.php');
                        }
                    } else if ($role_check == 'Inspector' && ($role == 'Shop' || $role == 'Inspector')) {
                        $_SESSION['emp_no'] = $emp_no;
                        $_SESSION['full_name'] = $full_name;
                        $_SESSION['role'] = $role;
                        $_SESSION['car_maker'] = $response_arr['car_maker'];
                        $_SESSION['car_model'] = $response_arr['car_model'];
                        if ($role == 'Shop') {
                            header('location:/zaihai/shop/applicator_list.php');
                        } else if ($role == 'Inspector') {
                            header('location:/zaihai/inspector/applicator_checksheet.php');
                        }
                    } else {
                        echo '<script>alert("Incorrect or Unmatched Role Selected on Sign In!!!")</script>';
                    }
                } else {
                    echo '<script>alert("Sign In Failed. Unregistered IP: '.$ip.'! Call IT Personnel Immediately!")</script>';
                }
            } else {
                if ($role_check == 'BM' && $role == 'BM') {
                    $_SESSION['emp_no'] = $emp_no;
                    $_SESSION['full_name'] = $full_name;
                    $_SESSION['role'] = $role;
                    header('location:/zaihai/bm/applicator_in.php');
                } else if ($role_check == 'ME' && $role == 'ME') {
                    $_SESSION['emp_no'] = $emp_no;
                    $_SESSION['full_name'] = $full_name;
                    $_SESSION['role'] = $role;
                    header('location:/zaihai/me/accounts.php');
                } else {
                    echo '<script>alert("Incorrect or Unmatched Role Selected on Sign In!!!")</script>';
                }
            }
        } else {
            echo '<script>alert("Sign In Failed. Maybe an incorrect credential or account not found")</script>';
        }
    }
}

if (isset($_POST['Logout'])) {
    session_unset();
    session_destroy();
    header('location:/zaihai/login');
}