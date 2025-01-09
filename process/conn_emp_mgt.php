<?php
// MS SQL Server Connection
// $servername = '172.25.112.131, 1433\SQLEXPRESS'; $username = 'SA'; $password = 'SystemGroup2018';
$servername = '172.25.116.188'; $username = 'SA'; $password = 'SystemGroup@2022';

try {
    $conn_emp_mgt = new PDO ("sqlsrv:Server=$servername;Database=emp_mgt_db",$username,$password);
    $conn_emp_mgt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
