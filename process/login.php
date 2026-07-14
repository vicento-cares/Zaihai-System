<?php
session_set_cookie_params(0, "/zaihai");
session_name("zaihai");
session_start();

require 'conn.php';

function get_positions($conn)
{
    $data = array();

    $sql = "SELECT position FROM m_positions WHERE [rank] > 2 ORDER BY position ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['position']);
    }

    return $data;
}

function get_access_location_by_ip($ip, $conn) {
    $can_access = false;
    $car_maker = '';
    $car_model = '';

    $response_arr = array();

    $sql = "SELECT car_maker, car_model FROM m_access_locations WHERE ip = ?";
    $params[] = $ip;

    $stmt = $conn->prepare($sql);
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

    $emp_no = addslashes($_POST['emp_no']);
    $role = $_POST['role'];

    $role_check = '';

    if (empty($emp_no)) {
        echo '<script>alert("Please Scan QR Code or Enter ID Number")</script>';
    } else if ($role == 'PD') {
        include 'conn_emp_mgt.php';

        $check = "SELECT emp_no, full_name, dept, section, line_no, position FROM m_employees 
                    WHERE emp_no = ? COLLATE SQL_Latin1_General_CP1_CS_AS";
        $params[] = $emp_no;

        $stmt = $conn_emp_mgt->prepare($check);
        $stmt->execute($params);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	    if (count($results) > 0) {
            $dept = '';
            $section = '';
            $line_no = '';
            $position = '';

            foreach ($results as $row) {
                $emp_no = $row['emp_no'];
                $full_name = $row['full_name'];
                $dept = $row['dept'];
                $section = $row['section'];
                $line_no = $row['line_no'];
                $position = $row['position'];
            }

            $is_fp = strpos($line_no, "First Process");
            $is_sp = strpos($line_no, "Secondary Process");

            $is_pd = strpos($dept, "PD");

            $position_arr = get_positions($conn_emp_mgt);

            if ($is_fp !== false || $is_sp !== false) {
                $_SESSION['emp_no'] = $emp_no;
                $_SESSION['full_name'] = $full_name;
                $_SESSION['role'] = $role;

                $conn_emp_mgt = null;
                header('location:/zaihai/pd/verify_checksheet.php');
                exit();
            } else if (in_array($position, $position_arr) && $is_pd !== false) {
                // If Staff and Above for Applicator Masterlist Access
                $_SESSION['emp_no'] = $emp_no;
                $_SESSION['full_name'] = $full_name;
                $_SESSION['role'] = $role;
                $_SESSION['line_no'] = $line_no;

                $conn_emp_mgt = null;

                $sql = "SELECT car_maker, car_model FROM m_car_maker WHERE section = ?";

                $stmt = $conn->prepare($sql);
                $stmt->execute([$section]);

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $_SESSION['car_maker'] = $row['car_maker'];
                    $_SESSION['car_model'] = $row['car_model'];
                }

                $conn = null;

                header('location:/zaihai/pd/applicator.php');
                exit();
            } else {
                echo '<script>alert("Sign In Failed. Only First and Secondary Process On Any Section Allowed")</script>';
            }
        } else {
            echo '<script>alert("Sign In Failed. Maybe an incorrect credential or account not found")</script>';
        }
        $conn_emp_mgt = null;
    } else {
        $check = "SELECT emp_no, full_name, role FROM m_accounts 
                    WHERE emp_no = ? COLLATE SQL_Latin1_General_CP1_CS_AS";
        $params[] = $emp_no;

        $stmt = $conn->prepare($check);
        $stmt->execute($params);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            foreach ($results as $row) {
                $emp_no = $row['emp_no'];
                $full_name = $row['full_name'];
                $role_check = $row['role'];
            }

            if ($role_check == 'Shop' || $role_check == 'Inspector') {
                // REMOTE IP ADDRESS
                $ip = $_SERVER['REMOTE_ADDR'];

                // CHECK IP
                $response_arr = get_access_location_by_ip($ip, $conn);

                if ($response_arr['can_access'] == true) {
                    if ($role_check == 'Shop' && ($role == 'Shop' || $role == 'Inspector')) {
                        $_SESSION['emp_no'] = $emp_no;
                        $_SESSION['full_name'] = $full_name;
                        $_SESSION['role'] = $role;
                        $_SESSION['car_maker'] = $response_arr['car_maker'];
                        $_SESSION['car_model'] = $response_arr['car_model'];
                        if ($role == 'Shop') {
                            header('location:/zaihai/shop/applicator_list.php');
                            exit();
                        } else if ($role == 'Inspector') {
                            header('location:/zaihai/inspector/applicator_checksheet.php');
                            exit();
                        }
                    } else if ($role_check == 'Inspector' && ($role == 'Shop' || $role == 'Inspector')) {
                        $_SESSION['emp_no'] = $emp_no;
                        $_SESSION['full_name'] = $full_name;
                        $_SESSION['role'] = $role;
                        $_SESSION['car_maker'] = $response_arr['car_maker'];
                        $_SESSION['car_model'] = $response_arr['car_model'];
                        if ($role == 'Shop') {
                            header('location:/zaihai/shop/applicator_list.php');
                            exit();
                        } else if ($role == 'Inspector') {
                            header('location:/zaihai/inspector/applicator_checksheet.php');
                            exit();
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
                    exit();
                } else if ($role_check == 'ME' && $role == 'ME') {
                    $_SESSION['emp_no'] = $emp_no;
                    $_SESSION['full_name'] = $full_name;
                    $_SESSION['role'] = $role;
                    header('location:/zaihai/me/accounts.php');
                    exit();
                } else if ($role_check == 'QA' && $role == 'QA') {
                    $_SESSION['emp_no'] = $emp_no;
                    $_SESSION['full_name'] = $full_name;
                    $_SESSION['role'] = $role;
                    header('location:/zaihai/qa/applicator_shots_qa.php');
                    exit();
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
    exit();
}
