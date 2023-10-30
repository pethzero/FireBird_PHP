<?php
// include("database.php");
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ส่งค่ามาจาก หน้าบ้าน
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $queryDropDown = isset($_POST['queryDropDown']) ? $_POST['queryDropDown'] : '';

    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';

    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);

    try {
        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);
        $sqlDropDown = $sqlQueries->scanSQL($queryDropDown);

        if ($sqlQuery !== null &&  $sqlDropDown !== null) {
            $selectData = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');
            $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            
            $result = $selectData->SelectRecord($sqlQuery); // ส่งค่า $message_db มาด้วย
            $DropDown = $selectData->SelectRecord($sqlDropDown); // ส่งค่า $message_db มาด้วย

            if ($result['status'] !== false && $DropDown['status'] !== false ) {
                $response = array('status' => 'success', 'datasql' => $result['result'], 'dbconnect' =>  $selectData->message_log
                , 'datdropdown' => $DropDown['result']);
                $selectData->data_commit->commit();
            } else {
                $response = array('status' => 'error', 'datasql' => $result['result'], 'message' => 'An error occurred');
                $selectData->data_commit->rollBack();
            }
        } else {
            $response = array(
                'message' => 'ไม่พบคำสั่ง SQL สำหรับ $queryId ที่ระบุ',
                'datasql' => [],
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
