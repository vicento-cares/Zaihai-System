<?php 
include '../conn.php';

switch (true) {
    case !isset($_GET['applicator_no']):
    case !isset($_GET['terminal_name']):
        echo 'Query Parameters Not Set';
        exit();
}

$applicator_no = addslashes(trim($_GET['applicator_no']));
$terminal_name = addslashes(trim($_GET['terminal_name']));

$delimiter = ","; 

$filename = "ZaihaiSystem_ApplicatorTerminal";
if (!empty($applicator_no)) {
	$filename = $filename . "_" . $applicator_no;
}
if (!empty($terminal_name)) {
	$filename = $filename . "_" . $terminal_name;
}
$filename = $filename . "_" . $server_date_only . ".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// UTF-8 BOM for special character compatibility
fputs($f, "\xEF\xBB\xBF");

// Set column headers 
$fields = array('Applicator No.', 'Terminal Name', 'Applicator No. New', 'Terminal Name New'); 
fputcsv($f, $fields, $delimiter); 

$sql = "SELECT id, applicator_no, terminal_name, date_updated FROM m_applicator_terminal";

if (!empty($applicator_no)) {
    $sql .= " WHERE applicator_no LIKE '$applicator_no%'";
} else {
    $sql .= " WHERE applicator_no != ''";
}
if (!empty($terminal_name)) {
    $sql .= " AND terminal_name LIKE '$terminal_name%'";
}

$sql .= " ORDER BY date_updated DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();

// Output each row of the data, format line as csv and write to file pointer 
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 

    $lineData = array($row['applicator_no'], $row['terminal_name'], '', ''); 
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