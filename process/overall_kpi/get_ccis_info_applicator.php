<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: *');
    require '../conn.php';
    $stmt = $conn -> prepare("SELECT TOP 1 * FROM v_m_apri_ccis_data WHERE APRINO = :applicator");
    $stmt -> execute(['applicator' => $_GET['applicator']]);
    header('Content-Type: application/json');
    echo json_encode(['data'=> $stmt->fetch(PDO::FETCH_ASSOC)]);
    exit();