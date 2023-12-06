<?php
// include("database.php");
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ส่งค่ามาจาก หน้าบ้าน
    $queryId001 = isset($_POST['queryId001']) ? $_POST['queryId001'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);

    try {
        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQueries = new SQLQueries();
        $SqlID001 = $sqlQueries->scanSQL($queryId001);

        if ($SqlID001 !== null) {
            $selectData = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');
            $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            $resultID001 = $selectData->SelectRecord($SqlID001);
            if ($resultID001['status'] !== false ) {
                $response = array(
                    'status' => 'success',
                    'datamain' => $resultID001['result'],
                    'message' =>  'Data success',
                );
                $selectData->data_commit->commit();
            } else {
                $response = array('status' => 'error', 'datamain' => $resultID001['result'], 'message' => 'An error occurred');
                $selectData->data_commit->rollBack();
            }
        } else {
            $response = array(
                'message' => 'ไม่พบคำสั่ง SQL สำหรับ $queryId ที่ระบุ',
                'datamain' => [],
                'status' => 'error',
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    } catch (Exception $e) {
        $response = array(
            'message' => $e->getMessage(),
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
