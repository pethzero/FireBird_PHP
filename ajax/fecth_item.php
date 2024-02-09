<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");
include("systemfuc.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ส่งค่ามาจาก หน้าบ้าน
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);

    try {
        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);

        if ($sqlQuery !== null) {
            $config_setting = database_config('mysqlserver');
            $processfecth = new CRUDDATA(...$config_setting);
            // $processfecth = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');
            $processfecth->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            $result = $processfecth->SelectRecordCondition($tableData_Json[0], $sqlQuery, $condition); // ส่งค่า $message_db มาด้วย

            if ($result['status'] !== false) {
                $response = array('status' => 'success', 'datamain' => $result['result'], 'dbconnect' =>  $processfecth->message_log);
                $processfecth->data_commit->commit();
            } else {
                $response = array('status' => 'error', 'datamain' => $result['result'], 'message' => 'An error occurred');
                $processfecth->data_commit->rollBack();
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
