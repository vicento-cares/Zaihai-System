<?php
require '../../conn.php';
include '../../lib/main.php';

$method = $_GET['method'];

if ($method == 'get_ac_details') {
    $applicator_no = $_GET['applicator_no'];

    $data = [];

    if (is_valid_applicator_no($applicator_no) == false) {
        $data = ['message' => 'Invalid Applicator No.'];
    } else {
        $sql = "DECLARE @applicator_no NVARCHAR(255) = ?;

                SELECT TOP(1) *
                FROM 
                    t_applicator_c
                WHERE
                    equipment_no = SUBSTRING(@applicator_no, 1, CHARINDEX('/', @applicator_no) - 1) AND
                    machine_no = SUBSTRING(@applicator_no, CHARINDEX('/', @applicator_no) + 1, LEN(@applicator_no))
                ORDER BY
                    inspection_date_time DESC";
        $params[] = $applicator_no;

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        if ($row) { 
            if (empty($row['pd_verified_by'])) {
                $inspection_date = '';
                $inspection_time = '';

                if (!empty($row['inspection_date_time'])) {
                    $inspection_date_time = new DateTime($row['inspection_date_time']);
                    $inspection_date = $inspection_date_time->format('Y-m-d');
                    $inspection_time = $inspection_date_time->format('H:i:s');
                }
                
                $data = [
                    'serial_no' => $row['serial_no'],
                    'equipment_no' => $row['equipment_no'],
                    'applicator_no' => $row['machine_no'],
                    'terminal_name' => $row['terminal_name'],
                    'inspection_date' => $inspection_date,
                    'inspection_time' => $inspection_time,
                    'inspection_shift' => $row['inspection_shift'],
                    'adjustment_content' => $row['adjustment_content'],
                    'adjustment_content_remarks' => $row['adjustment_content_remarks'],
                    'cross_section_result' => intval($row['cross_section_result']),
                    'inspected_by' => $row['inspected_by'],
                    'checked_by' => $row['checked_by'],
                    'confirmed_by' => $row['confirmed_by'],
                    'judgement' => intval($row['judgement']),
                    'ac1' => intval($row['ac1']),
                    'ac2' => intval($row['ac2']),
                    'ac3' => intval($row['ac3']),
                    'ac4' => intval($row['ac4']),
                    'ac5' => intval($row['ac5']),
                    'ac6' => intval($row['ac6']),
                    'ac7' => intval($row['ac7']),
                    'ac8' => intval($row['ac8']),
                    'ac9' => intval($row['ac9']),
                    'ac10' => intval($row['ac10']),
                    'ac1_s' => $row['ac1_s'],
                    'ac2_s' => $row['ac2_s'],
                    'ac3_s' => $row['ac3_s'],
                    'ac4_s' => $row['ac4_s'],
                    'ac5_s' => $row['ac5_s'],
                    'ac6_s' => $row['ac6_s'],
                    'ac7_s' => $row['ac7_s'],
                    'ac8_s' => $row['ac8_s'],
                    'ac9_s' => $row['ac9_s'],
                    'ac10_s' => $row['ac10_s'],
                    'ac1_r' => $row['ac1_r'],
                    'ac2_r' => $row['ac2_r'],
                    'ac3_r' => $row['ac3_r'],
                    'ac4_r' => $row['ac4_r'],
                    'ac5_r' => $row['ac5_r'],
                    'ac6_r' => $row['ac6_r'],
                    'ac7_r' => $row['ac7_r'],
                    'ac8_r' => $row['ac8_r'],
                    'ac9_r' => $row['ac9_r'],
                    'ac10_r' => $row['ac10_r'],
                    'message' => 'success'
                ];
            } else {
                $data = [
                            'message' => 'Applicator Already PD Verified! Verified Date: ' . $row['pd_verified_date_time'] . 
                                        ' Verified By: ' . $row['pd_verified_by'] . 
                                        ' Verified By ID Number: ' . $row['pd_verified_by_id_no']
                        ];
            }
        }

        if (empty($data)) {
            $data = ['message' => 'Checksheet Not Found'];
        }
    }

    echo json_encode($data);
}