<?php
include 'server_date_time.php';

// MS SQL Server Connection
$servername = '172.25.116.188'; $username = 'SA'; $password = 'SystemGroup@2022';

try {
    $conn = new PDO ("sqlsrv:Server=$servername;Database=zaihai_db;TrustServerCertificate=1",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
