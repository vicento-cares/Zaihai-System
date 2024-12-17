<?php 
include '../conn.php';

switch (true) {
    case !isset($_GET['car_maker']):
    case !isset($_GET['car_model']):
    case !isset($_GET['applicator_no']):
    case !isset($_GET['zaihai_stock_address']):
        echo 'Query Parameters Not Set';
        exit();
}

$car_maker = trim($_GET['car_maker']);
$car_model = trim($_GET['car_model']);
$applicator_no = trim($_GET['applicator_no']);
$zaihai_stock_address = trim($_GET['zaihai_stock_address']);

$delimiter = ","; 

$filename = "ZaihaiSystem_Applicator";
if (!empty($car_maker)) {
	$filename = $filename . "_" . $car_maker;
}
if (!empty($car_model)) {
	$filename = $filename . "_" . $car_model;
}
if (!empty($applicator_no)) {
	$filename = $filename . "_" . $applicator_no;
}
if (!empty($zaihai_stock_address)) {
	$filename = $filename . "_" . $zaihai_stock_address;
}
$filename = $filename . "_" . $server_date_only . ".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// UTF-8 BOM for special character compatibility
fputs($f, "\xEF\xBB\xBF");

// Set column headers 
$fields = array('Car Maker', 'Car Model', 'Applicator No.', 'Zaihai Stock Address', 'Car Maker New', 'Car Model New', 'Applicator No. New', 'Zaihai Stock Address New'); 
fputcsv($f, $fields, $delimiter); 

$sql = "SELECT id, car_maker, car_model, applicator_no, zaihai_stock_address, date_updated 
        FROM m_applicator 
        WHERE applicator_no != ''";
$params = [];

if (!empty($applicator_no)) {
    $sql .= " AND applicator_no LIKE ?";
    $params[] = $applicator_no . '%';
}

if (!empty($car_maker)) {
    $sql .= " AND car_maker LIKE ?";
    $params[] = $car_maker . '%';
}

if (!empty($car_model)) {
    $sql .= " AND car_model LIKE ?";
    $params[] = $car_model . '%';
}

if (!empty($zaihai_stock_address)) {
    $sql .= " AND zaihai_stock_address LIKE ?";
    $params[] = $zaihai_stock_address . '%';
}

$sql .= " ORDER BY date_updated DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);

// Output each row of the data, format line as csv and write to file pointer 
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 

    $lineData = array($row['car_maker'], $row['car_model'], $row['applicator_no'], $row['zaihai_stock_address'], '', '', '', ''); 
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