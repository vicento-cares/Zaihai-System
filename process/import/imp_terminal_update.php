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

    $row_valid_arr = array(0);

    $notExiststTerminalArr = array();

    $message = "";
    $check_csv_row = 0;

    // CHECK CSV BASED ON HEADER
    $first_line = preg_replace('/[\t\n\r]+/', '', $first_line);
    $valid_first_line = "Car Maker,Car Model,Terminal Name,Line Address,Car Maker New,Car Model New,Terminal Name New,Line Address New";
    $valid_first_line2 = '"Car Maker","Car Model","Terminal Name","Line Address","Car Maker New","Car Model New","Terminal Name New","Line Address New"';
    if ($first_line == $valid_first_line || $first_line == $valid_first_line2) {
        while (($line = fgetcsv($csvFile)) !== false) {
            // Check if the row is blank or consists only of whitespace
            if (empty(implode('', $line))) {
                continue; // Skip blank lines
            }

            $check_csv_row++;
            
            $car_maker = $line[0];
            $car_model = $line[1];
            $terminal_name = $line[2];
            $line_address = $line[3];
            $car_maker_new = $line[4];
            $car_model_new = $line[5];
            $terminal_name_new = $line[6];
            $line_address_new = $line[7];

            if (empty($car_maker_new) && empty($car_model_new) 
                && empty($terminal_name_new) && empty($line_address_new)) {
                continue; // Skip blank lines
            }
            if (empty($car_maker_new)) {
                $car_maker_new = $car_maker;
            }
            if (empty($car_model_new)) {
                $car_model_new = $car_model;
            }
            if (empty($terminal_name_new)) {
                $terminal_name_new = $terminal_name;
            }
            if (empty($line_address_new)) {
                $line_address_new = $line_address;
            }

            if ($car_maker == '' || $car_model == '' || 
                $terminal_name == '' || $line_address == '') {
                // IF BLANK DETECTED ERROR += 1
                $hasBlankError++;
                $hasError = 1;
                array_push($hasBlankErrorArr, $check_csv_row);
            }

            // CHECK ROW VALIDATION
            // 0
            $sql = "SELECT id FROM m_applicator_terminal 
                    WHERE terminal_name = ?";
            $stmt = $conn -> prepare($sql);
            $params = array($terminal_name_new);
            $stmt -> execute($params);

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $hasError = 1;
                $row_valid_arr[0] = 1;
                array_push($notExiststTerminalArr, $check_csv_row);
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
            // $sql = "SELECT id FROM m_terminal 
            //         WHERE line_address = ?";
            // $stmt = $conn -> prepare($sql);
            // $params = array($line_address);
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
            $message = $message . 'Terminal Name not found on row/s ' . implode(", ", $notExiststTerminalArr) . '. ';
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
                    $terminal_name = $line[2];
                    $line_address = $line[3];
                    $car_maker_new = $line[4];
                    $car_model_new = $line[5];
                    $terminal_name_new = $line[6];
                    $line_address_new = $line[7];

                    if (empty($car_maker_new) && empty($car_model_new) 
                        && empty($terminal_name_new) && empty($line_address_new)) {
                        continue; // Skip blank lines
                    }
                    if (empty($car_maker_new)) {
                        $car_maker_new = $car_maker;
                    }
                    if (empty($car_model_new)) {
                        $car_model_new = $car_model;
                    }
                    if (empty($terminal_name_new)) {
                        $terminal_name_new = $terminal_name;
                    }
                    if (empty($line_address_new)) {
                        $line_address_new = $line_address;
                    }

                    $sql = "UPDATE m_terminal 
                            SET car_maker = ?, car_model = ?, 
                            terminal_name = ?, line_address = ?
                            WHERE line_address = ?";

                    $stmt = $conn->prepare($sql);
                    $params = array($car_maker_new, $car_model_new, 
                                    $terminal_name_new, $line_address_new, $line_address);
                    if (!$stmt->execute($params)) {
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
