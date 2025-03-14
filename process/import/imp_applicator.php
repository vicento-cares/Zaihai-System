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
    $readyToUseOnlyArr = array();

    $message = "";
    $check_csv_row = 0;

    // CHECK CSV BASED ON HEADER
    $first_line = preg_replace('/[\t\n\r]+/', '', $first_line);
    $valid_first_line = "Car Maker,Car Model,Applicator No.,Zaihai Stock Address,Car Maker New,Car Model New,Applicator No. New,Zaihai Stock Address New";
    $valid_first_line2 = '"Car Maker","Car Model","Applicator No.","Zaihai Stock Address","Car Maker New","Car Model New","Applicator No. New","Zaihai Stock Address New"';
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
            $params = array($applicator_no);
            $stmt -> execute($params);

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $hasError = 1;
                $row_valid_arr[0] = 1;
                array_push($notExistsApplicatorArr, $check_csv_row);
            }

            // 1
            $sql = "SELECT status FROM t_applicator_list 
                    WHERE applicator_no = ?";
            $stmt = $conn -> prepare($sql);
            $params = array($applicator_no);
            $stmt -> execute($params);

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row && $row['status'] != 'Ready To Use') {
                $hasError = 1;
                $row_valid_arr[1] = 1;
                array_push($readyToUseOnlyArr, $check_csv_row);
            } else if (!$row) {
                $hasError = 1;
                $row_valid_arr[1] = 1;
                array_push($readyToUseOnlyArr, $check_csv_row);
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
            $sql = "SELECT id FROM m_applicator 
                    WHERE zaihai_stock_address = ?";
            $stmt = $conn -> prepare($sql);
            $params = array($zaihai_stock_address);
            $stmt -> execute($params);
            if ($stmt -> rowCount() > 0) {
                $isExistsOnDb = 1;
                $hasError = 1;
                array_push($isExistsOnDbArr, $check_csv_row);
            }
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

        if ($isExistsOnDb == 1) {
            $message = $message . 'Record Already Exist on row/s ' . implode(", ", $isExistsOnDbArr) . '. ';
        }
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

            $isTransactionActive = false;
            $chunkSize = 250; // Set your desired chunk size

            try {
                if (!$isTransactionActive) {
                    $conn->beginTransaction();
                    $isTransactionActive = true;
                }

                $sql_insert_applicator = "INSERT INTO m_applicator 
                                            (car_maker, car_model, applicator_no, zaihai_stock_address) 
                                            VALUES ";
                $values = [];
                $placeholders = [];

                $sql_insert_applicator_list = "INSERT INTO t_applicator_list 
                                            (car_maker, car_model, applicator_no, location, status) 
                                            VALUES ";
                $values2 = [];
                $placeholders2 = [];

                while (($line = fgetcsv($csvFile)) !== false) {
                    // Check if the row is blank or consists only of whitespace
                    if (empty(implode('', $line))) {
                        continue; // Skip blank lines
                    }

                    $car_maker = $line[0];
                    $car_model = $line[1];
                    $applicator_no = $line[2];
                    $zaihai_stock_address = $line[3];

                    // Create a temporary array for the current row
                    $currentValues = [
                        $car_maker,
                        $car_model,
                        $applicator_no,
                        $zaihai_stock_address
                    ];

                    // Create a temporary array for the current row
                    $currentValues2 = [
                        $car_maker,
                        $car_model,
                        $applicator_no,
                        $zaihai_stock_address,
                        'Ready To Use'
                    ];

                    // Create placeholders for each row
                    $generated_placeholders = implode(',', array_fill(0, count($currentValues), '?'));
                    $placeholders[] = "($generated_placeholders)";

                    // Create placeholders for each row
                    $generated_placeholders2 = implode(',', array_fill(0, count($currentValues2), '?'));
                    $placeholders2[] = "($generated_placeholders2)";

                    // Add current values to the main values array
                    $values = array_merge($values, $currentValues);

                    // Add current values to the main values array
                    $values2 = array_merge($values2, $currentValues2);

                    // Check if we reached the chunk size
                    if (count($placeholders) === $chunkSize) {
                        // Combine the SQL statement with the placeholders
                        $sql_insert_applicator .= implode(', ', $placeholders);
                        
                        // Prepare the statement
                        $stmt = $conn->prepare($sql_insert_applicator);
                        
                        // Execute the statement with the values
                        if (!$stmt->execute($values)) {
                            $error++;
                        }

                        // Reset for the next chunk
                        $placeholders = [];
                        $values = [];
                        $sql_insert_applicator = "INSERT INTO m_applicator 
                                        (car_maker, car_model, applicator_no, zaihai_stock_address) 
                                        VALUES ";
                    }

                    // Check if we reached the chunk size
                    if (count($placeholders2) === $chunkSize) {
                        // Combine the SQL statement with the placeholders
                        $sql_insert_applicator_list .= implode(', ', $placeholders2);
                        
                        // Prepare the statement
                        $stmt = $conn->prepare($sql_insert_applicator_list);
                        
                        // Execute the statement with the values
                        if (!$stmt->execute($values2)) {
                            $error++;
                        }

                        // Reset for the next chunk
                        $placeholders2 = [];
                        $values2 = [];
                        $sql_insert_applicator_list = "INSERT INTO t_applicator_list 
                                        (car_maker, car_model, applicator_no, location, status) 
                                        VALUES ";
                    }
                }

                // Insert any remaining rows that didn't fill a complete chunk
                if (!empty($placeholders)) {
                    $sql_insert_applicator .= implode(', ', $placeholders);
                    $stmt = $conn->prepare($sql_insert_applicator);
                    if (!$stmt->execute($values)) {
                        $error++;
                    }
                }

                // Insert any remaining rows that didn't fill a complete chunk
                if (!empty($placeholders2)) {
                    $sql_insert_applicator_list .= implode(', ', $placeholders2);
                    $stmt = $conn->prepare($sql_insert_applicator_list);
                    if (!$stmt->execute($values2)) {
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
