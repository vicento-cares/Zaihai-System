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

    $message = "";
    $check_csv_row = 0;

    // CHECK CSV BASED ON HEADER
    $first_line = preg_replace('/[\t\n\r]+/', '', $first_line);
    $valid_first_line = "Car Maker,Car Model,Applicator No.,Location";
    $valid_first_line2 = '"Car Maker","Car Model","Applicator No.",Location';
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
            $location = addslashes($line[3]);

            if ($car_maker == '' || $car_model == '' || $applicator_no == '' || $location == '') {
                // IF BLANK DETECTED ERROR += 1
                $hasBlankError++;
                $hasError = 1;
                array_push($hasBlankErrorArr, $check_csv_row);
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
            $sql = "SELECT id FROM t_applicator_list 
                    WHERE applicator_no = '$applicator_no'";
            $stmt = $conn -> prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt -> execute();
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

                $sql = "INSERT INTO t_applicator_list (car_maker, car_model, applicator_no, location, status) VALUES ";
                $values = [];
                $placeholders = [];

                while (($line = fgetcsv($csvFile)) !== false) {
                    // Check if the row is blank or consists only of whitespace
                    if (empty(implode('', $line))) {
                        continue; // Skip blank lines
                    }

                    $car_maker = $line[0];
                    $car_model = $line[1];
                    $applicator_no = $line[2];
                    $location = $line[3];

                    // Create placeholders for each row
                    $placeholders[] = "(?, ?, ?, ?, ?)";
                    $values[] = $car_maker;
                    $values[] = $car_model;
                    $values[] = $applicator_no;
                    $values[] = $location;
                    $values[] = 'Ready To Use';

                    // Check if we reached the chunk size
                    if (count($placeholders) === $chunkSize) {
                        // Combine the SQL statement with the placeholders
                        $sql .= implode(', ', $placeholders);
                        
                        // Prepare the statement
                        $stmt = $conn->prepare($sql);
                        
                        // Execute the statement with the values
                        if (!$stmt->execute($values)) {
                            $error++;
                        }

                        // Reset for the next chunk
                        $placeholders = [];
                        $values = [];
                        $sql = "INSERT INTO t_applicator_list (car_maker, car_model, applicator_no, location, status) VALUES ";
                    }
                }

                // Insert any remaining rows that didn't fill a complete chunk
                if (!empty($placeholders)) {
                    $sql .= implode(', ', $placeholders);
                    $stmt = $conn->prepare($sql);
                    if (!$stmt->execute($values)) {
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
