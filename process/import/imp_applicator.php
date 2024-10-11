<?php
// error_reporting(0);
set_time_limit(0);

require '../conn.php';
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

    $row_valid_arr = array(0, 0);

    $notExistsApplicatorArr = array();
    // $readyToUseOnlyArr = array();

    $message = "";
    $check_csv_row = 0;

    // CHECK CSV BASED ON HEADER
    $first_line = preg_replace('/[\t\n\r]+/', '', $first_line);
    $valid_first_line = "Car Maker,Car Model,Applicator No.,Zaihai Stock Address";
    $valid_first_line2 = '"Car Maker","Car Model","Applicator No.","Zaihai Stock Address"';
    if ($first_line == $valid_first_line || $first_line == $valid_first_line2) {
        while (($line = fgetcsv($csvFile)) !== false) {
            // Check if the row is blank or consists only of whitespace
            if (empty(implode('', $line))) {
                continue; // Skip blank lines
            }

            $check_csv_row++;
            
            $car_maker = addslashes($line[0]);
            $car_model = addslashes($line[1]);
            $applicator_no = addslashes($line[2]);
            $zaihai_stock_address = addslashes($line[3]);

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
                    WHERE applicator_no = '$applicator_no'";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $hasError = 1;
                $row_valid_arr[0] = 1;
                array_push($notExistsApplicatorArr, $check_csv_row);
            }

            // 1
            // $sql = "SELECT status FROM t_applicator_list 
            //         WHERE zaihai_stock_address = '$zaihai_stock_address'";
            // $stmt = $conn -> prepare($sql);
            // $stmt -> execute();

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
            //         WHERE zaihai_stock_address = '$zaihai_stock_address'";
            // $stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            // $stmt -> execute();
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
        // if ($row_valid_arr[1] == 1) {
        //     $message = $message . 'Ready to use status only on Applicator List to continue on row/s ' . implode(", ", $readyToUseOnlyArr) . '. ';
        // }

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

if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)) {

    if (is_uploaded_file($_FILES['file']['tmp_name'])) {

        $chkCsvMsg = check_csv($_FILES['file']['tmp_name'], $conn);

        if ($chkCsvMsg == '') {

            //READ FILE
            $csvFile = fopen($_FILES['file']['tmp_name'],'r');

            // SKIP FIRST LINE (HEADER)
            fgets($csvFile);

            // PARSE
            $error = 0;
            while (($line = fgetcsv($csvFile)) !== false) {
                // Check if the row is blank or consists only of whitespace
                if (empty(implode('', $line))) {
                    continue; // Skip blank lines
                }

                $car_maker = addslashes($line[0]);
                $car_model = addslashes($line[1]);
                $applicator_no = addslashes($line[2]);
                $zaihai_stock_address = addslashes($line[3]);

                // $conn->beginTransaction();

                $sql = "SELECT id FROM m_applicator 
                        WHERE zaihai_stock_address = '$zaihai_stock_address'";
                $stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $stmt -> execute();

                $row = $stmt -> fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $query = "UPDATE t_applicator_list 
                        SET car_maker = '$car_maker', car_model = '$car_model', applicator_no = '$applicator_no'
                        WHERE location = '$zaihai_stock_address'";

                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute()) {
                        $stmt = NULL;
            
                        $sql = "UPDATE m_applicator 
                            SET car_maker = '$car_maker', car_model = '$car_model', 
                            applicator_no = '$applicator_no'
                            WHERE zaihai_stock_address = '$zaihai_stock_address'";
            
                        $stmt = $conn->prepare($query);
                        if (!$stmt->execute()) {
                            $error++;
                        }
                    } else {
                        $error++;
                    }
                } else {
                    $sql = "INSERT INTO m_applicator (car_maker, car_model, applicator_no, zaihai_stock_address) 
                        VALUES ('$car_maker','$car_model','$applicator_no','$zaihai_stock_address')";

                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute()) {
                        $stmt = NULL;
            
                        $query = "INSERT INTO t_applicator_list (car_maker, car_model, applicator_no, location, status) 
                                VALUES ('$car_maker','$car_model','$applicator_no','$zaihai_stock_address','Ready To Use')";
            
                        $stmt = $conn->prepare($query);
                        if (!$stmt->execute()) {
                            $error++;
                        }
                    } else {
                        $error++;
                    }
                }

                // $conn->commit();
            }
            
            fclose($csvFile);

            if ($error > 0) {
                echo 'error ' . $error;
            }

        } else {
            echo $chkCsvMsg; 
        }
    } else {
        echo 'CSV FILE NOT UPLOADED!';
    }
} else {
    echo 'INVALID FILE FORMAT!';
}

// KILL CONNECTION
$conn = null;
