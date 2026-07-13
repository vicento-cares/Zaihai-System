<?php
// error_reporting(0);
set_time_limit(0);

require '../lib/main.php';

function check_csv ($file, $conn) {
    // READ FILE
    $csvFile = fopen($file,'r');

    // SKIP FIRST LINE (HEADER)
    $first_line = fgets($csvFile);
    // Remove UTF-8 BOM from First Line
    $first_line = removeBomUtf8($first_line);

    $hasError = 0; $hasBlankError = 0; $isExistsOnDb = 0; $isDuplicateOnCsv = 0;
    $hasBlankErrorArr = array();
    $isExistsOnDbArr = array();
    $isDuplicateOnCsvArr = array();
    $dup_temp_arr = array();

    $row_valid_arr = array(0, 0, 0);

    $notExistsApplicatorArr = array();
    $readyToUseOnlyArr = array();
    $invalidPriorityArr = array();

    $message = "";
    $check_csv_row = 1;

    // CHECK CSV BASED ON HEADER
    $first_line = preg_replace('/[\t\n\r]+/', '', $first_line);
    $valid_first_line = "Car Maker,Car Model,Applicator No.,Zaihai Stock Address,Car Maker New,Car Model New,Applicator No. New,Zaihai Stock Address New,Priority Status";
    $valid_first_line2 = '"Car Maker","Car Model","Applicator No.","Zaihai Stock Address","Car Maker New","Car Model New","Applicator No. New","Zaihai Stock Address New","Priority Status"';
    if ($first_line == $valid_first_line || $first_line == $valid_first_line2) {
        while (($line = fgetcsv($csvFile)) !== false) {
            // Check if the row is blank or consists only of whitespace
            if (empty(implode('', $line))) {
                continue; // Skip blank lines
            }

            $check_csv_row++;
            
            $car_maker = $line[0];
            $car_model = $line[1];
            $applicator_no = $line[2];
            $zaihai_stock_address = $line[3];
            $car_maker_new = $line[4];
            $car_model_new = $line[5];
            $applicator_no_new = $line[6];
            $zaihai_stock_address_new = $line[7];
            $priority_status = $line[8];

            if (empty($car_maker_new) && empty($car_model_new) 
                && empty($applicator_no_new) && empty($zaihai_stock_address_new)) {
                // 2
                if (!empty($priority_status) && strtolower($priority_status) != 'priority') {
                    $hasError = 1;
                    $row_valid_arr[2] = 1;
                    array_push($invalidPriorityArr, $check_csv_row);
                }
                
                continue; // Skip blank lines
            } else if (empty($car_maker_new)) {
                $car_maker_new = $car_maker;
            } else if (empty($car_model_new)) {
                $car_model_new = $car_model;
            } else if (empty($applicator_no_new)) {
                $applicator_no_new = $applicator_no;
            } else if (empty($zaihai_stock_address_new)) {
                $zaihai_stock_address_new = $zaihai_stock_address;
            }

            if ($car_maker == '' || $car_model == '' || 
                $applicator_no == '' || $zaihai_stock_address == '') {
                // IF BLANK DETECTED ERROR += 1
                $hasBlankError++;
                $hasError = 1;
                array_push($hasBlankErrorArr, $check_csv_row);
            }

            // CHECK ROW VALIDATION
            // 0
            $sql = "SELECT id FROM m_applicator_terminal 
                    WHERE applicator_no = ?";
            $stmt = $conn -> prepare($sql);
            $params = array($applicator_no_new);
            $stmt -> execute($params);

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $hasError = 1;
                $row_valid_arr[0] = 1;
                array_push($notExistsApplicatorArr, $check_csv_row);
            }

            // 1
            // $sql = "SELECT status FROM t_applicator_list 
            //         WHERE applicator_no = ?";
            // $stmt = $conn -> prepare($sql);
            // $params = array($applicator_no);
            // $stmt -> execute($params);

            // $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            // if ($row && $row['status'] != 'Ready To Use') {
            //     $hasError = 1;
            //     $row_valid_arr[1] = 1;
            //     array_push($readyToUseOnlyArr, $check_csv_row);
            // } else if (!$row) {
            //     $hasError = 1;
            //     $row_valid_arr[1] = 1;
            //     array_push($readyToUseOnlyArr, $check_csv_row);
            // }

            // 2
            if (!empty($priority_status) && strtolower($priority_status) != 'priority') {
                $hasError = 1;
                $row_valid_arr[2] = 1;
                array_push($invalidPriorityArr, $check_csv_row);
            }
            
            // Joining all row values for checking duplicated rows
            $whole_line = join(',', $line);

            // CHECK ROWS IF IT HAS DUPLICATE ON CSV
            if (isset($dup_temp_arr[$whole_line])) {
                $isDuplicateOnCsv = 1;
                $hasError = 1;
                array_push($isDuplicateOnCsvArr, $check_csv_row);
            } else {
                $dup_temp_arr[$whole_line] = 1;
            }

            // CHECK ROWS IF EXISTS
            // $sql = "SELECT id FROM m_applicator 
            //         WHERE zaihai_stock_address = ?";
            // $stmt = $conn -> prepare($sql);
            // $params = array($zaihai_stock_address);
            // $stmt -> execute($params);
            // if ($stmt -> rowCount() > 0) {
            //     $isExistsOnDb = 1;
            //     $hasError = 1;
            //     array_push($isExistsOnDbArr, $check_csv_row);
            // }
        }
    } else {
        //$message = $first_line;
        $message = $message . 'Invalid CSV Table Header. Maybe an incorrect CSV file or incorrect CSV header ';
    }
    
    fclose($csvFile);

    if ($hasError == 1) {
        if ($row_valid_arr[0] == 1) {
            $message = $message . 'Applicator No. not found on row/s ' . implode(", ", $notExistsApplicatorArr) . '. ';
        }
        if ($row_valid_arr[1] == 1) {
            $message = $message . 'Ready to use status only on Applicator List to continue on row/s ' . implode(", ", $readyToUseOnlyArr) . '. ';
        }
        if ($row_valid_arr[2] == 1) {
            $message = $message . 'Invalid Priority Status on row/s ' . implode(", ", $invalidPriorityArr) . '. ';
        }

        // if ($isExistsOnDb == 1) {
        //     $message = $message . 'Record Already Exist on row/s ' . implode(", ", $isExistsOnDbArr) . '. ';
        // }
        if ($hasBlankError >= 1) {
            $message = $message . 'Blank Cell Exists on row/s ' . implode(", ", $hasBlankErrorArr) . '. ';
        }
        if ($isDuplicateOnCsv == 1) {
            $message = $message . 'Duplicated Record/s on row/s ' . implode(", ", $isDuplicateOnCsvArr) . '. ';
        }
    }
    return $message;
}

$csvMimes = array(
    'text/x-comma-separated-values', 
    'text/comma-separated-values', 
    'application/octet-stream', 
    'application/vnd.ms-excel', 
    'application/x-csv', 
    'text/x-csv', 
    'text/csv', 
    'application/csv', 
    'application/excel', 
    'application/vnd.msexcel', 
    'text/plain'
);

$csvMimes = array(
    'text/x-comma-separated-values', 
    'text/comma-separated-values', 
    'application/octet-stream', 
    'application/vnd.ms-excel', 
    'application/x-csv', 
    'text/x-csv', 
    'text/csv', 
    'application/csv', 
    'application/excel', 
    'application/vnd.msexcel', 
    'text/plain'
);

if (empty($_FILES['file']['name']) || !in_array($_FILES['file']['type'], $csvMimes)) {
    exit('INVALID FILE FORMAT!');
}

if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
    exit('CSV FILE NOT UPLOADED!');
}

require '../conn.php';

$chkCsvMsg = check_csv($_FILES['file']['tmp_name'], $conn);

if ($chkCsvMsg != '') {
    $conn = null;
    exit($chkCsvMsg);
}

//READ FILE
$csvFile = fopen($_FILES['file']['tmp_name'],'r');

// SKIP FIRST LINE (HEADER)
fgets($csvFile);

// PARSE
$error = 0;

$isTransactionActive = false;

try {
    if (!$isTransactionActive) {
        $conn->beginTransaction();
        $isTransactionActive = true;
    }

    while (($line = fgetcsv($csvFile)) !== false) {
        // Check if the row is blank or consists only of whitespace
        if (empty(implode('', $line))) {
            continue; // Skip blank lines
        }

        $car_maker = $line[0];
        $car_model = $line[1];
        $applicator_no = $line[2];
        $zaihai_stock_address = $line[3];
        $car_maker_new = $line[4];
        $car_model_new = $line[5];
        $applicator_no_new = $line[6];
        $zaihai_stock_address_new = $line[7];
        $priority_status = $line[8];

        $is_priority = 0;

        if (!empty($priority_status) && strtolower($priority_status) == 'priority') {
            $is_priority = 1;
        }

        if (empty($car_maker_new) && empty($car_model_new) 
            && empty($applicator_no_new) && empty($zaihai_stock_address_new)) {
            // Only priority update applied
            $query = "UPDATE m_applicator 
                        SET 
                            is_priority = ?
                        WHERE 
                            applicator_no = ? AND is_priority != ?";

            $stmt = $conn->prepare($query);
            $params = array($is_priority, $applicator_no, $is_priority);
    
            $stmt->execute($params);

            continue; // Skip blank lines
        } else if (empty($car_maker_new)) {
            $car_maker_new = $car_maker;
        } else if (empty($car_model_new)) {
            $car_model_new = $car_model;
        } else if (empty($applicator_no_new)) {
            $applicator_no_new = $applicator_no;
        } else if (empty($zaihai_stock_address_new)) {
            $zaihai_stock_address_new = $zaihai_stock_address;
        }

        // Only priority update applied
        $query = "UPDATE m_applicator 
                    SET 
                        is_priority = ?
                    WHERE 
                        applicator_no = ? AND is_priority != ?";

        $stmt = $conn->prepare($query);
        $params = array($is_priority, $applicator_no, $is_priority);
 
        $stmt->execute($params);

        // Update applicator details if status is ready to use
        $query = "UPDATE t_applicator_list 
                    SET 
                        car_maker = ?, 
                        car_model = ?, 
                        applicator_no = ?, 
                        location = ? 
                    WHERE 
                        car_maker = ? AND 
                        car_model = ? AND 
                        applicator_no = ? AND 
                        location = ? AND 
                        EXISTS (
                            SELECT 1
                            FROM t_applicator_list a
                            WHERE a.applicator_no = t_applicator_list.applicator_no
                            AND a.status = 'Ready To Use'
                        )";

        $stmt = $conn->prepare($query);
        $params = array($car_maker_new, $car_model_new, $applicator_no_new, $zaihai_stock_address_new,
                        $car_maker, $car_model, $applicator_no, $zaihai_stock_address);
        if ($stmt->execute($params)) {

            $rowsAffected = $stmt->rowCount();

            if ($rowsAffected > 0) {
                $stmt = NULL;

                $query = "UPDATE m_applicator 
                            SET 
                                car_maker = ?, 
                                car_model = ?, 
                                applicator_no = ?, 
                                zaihai_stock_address = ? 
                            WHERE 
                                zaihai_stock_address = ? AND 
                                EXISTS (
                                    SELECT 1
                                    FROM t_applicator_list a
                                    WHERE a.applicator_no = m_applicator.applicator_no
                                    AND a.status = 'Ready To Use'
                                )";

                $stmt = $conn->prepare($query);
                $params = array($car_maker_new, $car_model_new, $applicator_no_new, $zaihai_stock_address_new, 
                                $zaihai_stock_address);
                if (!$stmt->execute($params)) {
                    $error++;
                }
            }
        } else {
            $error++;
        }
    }

    if ($error > 0) {
        if ($isTransactionActive) {
            $conn->rollBack();
            $isTransactionActive = false;
        }
        echo 'Failed. Please Try Again or Call IT Personnel Immediately!';
        exit();
    }

    $conn->commit();
    $isTransactionActive = false;
} catch (Exception $e) {
    if ($isTransactionActive) {
        $conn->rollBack();
        $isTransactionActive = false;
    }
    echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
    exit();
}

fclose($csvFile);

if ($error > 0) {
    echo 'error ' . $error;
}

// KILL CONNECTION
$conn = null;
