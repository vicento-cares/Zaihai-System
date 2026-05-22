<?php
// MS SQL Server Connection
// $servername_emp_mgt = '172.25.112.131, 1433\SQLEXPRESS'; $username_emp_mgt = 'SA'; $password_emp_mgt = 'SystemGroup2018';
$servername_emp_mgt = '172.25.116.188'; $username_emp_mgt = 'SA'; $password_emp_mgt = 'SystemGroup@2022';

try {
    $conn_emp_mgt = new PDO ("sqlsrv:Server=$servername_emp_mgt;Database=emp_mgt_db",$username_emp_mgt,$password_emp_mgt);
    $conn_emp_mgt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'NO CONNECTION'.$e->getMessage();
}
