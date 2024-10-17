<?php 
include '../conn.php';

switch (true) {
    case !isset($_GET['car_maker']):
    case !isset($_GET['car_model']):
    case !isset($_GET['terminal_name']):
    case !isset($_GET['line_address']):
        echo 'Query Parameters Not Set';
        exit();
}

$car_maker = addslashes(trim($_GET['car_maker']));
$car_model = addslashes(trim($_GET['car_model']));
$terminal_name = addslashes(trim($_GET['terminal_name']));
$line_address = addslashes(trim($_GET['line_address']));

$delimiter = ","; 

$filename = "ZaihaiSystem_Terminal";
if (!empty($car_maker)) {
	$filename = $filename . "_" . $car_maker;
}
if (!empty($car_model)) {
	$filename = $filename . "_" . $car_model;
}
if (!empty($terminal_name)) {
	$filename = $filename . "_" . $terminal_name;
}
if (!empty($line_address)) {
	$filename = $filename . "_" . $line_address;
}
$filename = $filename . "_" . $server_date_only . ".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// UTF-8 BOM for special character compatibility
fputs($f, "\xEF\xBB\xBF");

// Set column headers 
$fields = array('Car Maker', 'Car Model', 'Terminal Name', 'Line Address', 'Car Maker New', 'Car Model New', 'Terminal Name New', 'Line Address New'); 
fputcsv($f, $fields, $delimiter); 

$sql = "SELECT id, car_maker, car_model, terminal_name, line_address, date_updated FROM m_terminal";

if (!empty($terminal_name)) {
    $sql .= " WHERE terminal_name LIKE '$terminal_name%'";
} else {
    $sql .= " WHERE terminal_name != ''";
}
if (!empty($car_maker)) {
    $sql .= " AND car_maker LIKE '$car_maker%'";
}
if (!empty($car_model)) {
    $sql .= " AND car_model LIKE '$car_model%'";
}
if (!empty($line_address)) {
    $sql .= " AND line_address LIKE '$line_address%'";
}

$sql .= " ORDER BY date_updated DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();

// Output each row of the data, format line as csv and write to file pointer 
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 

    $lineData = array($row['car_maker'], $row['car_model'], $row['terminal_name'], $row['line_address'], '', '', '', ''); 
    fputcsv($f, $lineData, $delimiter); 
    
}

// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
//output all remaining data on a file pointer 
fpassthru($f); 

$conn = null;