<?php
// ini_set('memory_limit', '512M');
include("sql.php");
include("bpdata.php");
include("crud_zen.php");
include("systemfuc.php");

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
            $config_setting = database_config('fbserver');
            // $config_setting = database_config('fbtest');
            $selectData = new CRUDDATA(...$config_setting);

            $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            $result = $selectData->SelectRecordFireBirdCodition($tableData_Json[0], $SqlID001, $condition);

            if ($result['status'] !== false) {
                $response = array('status' => 'success', 'datasql' => $result['result'], 'dbconnect' =>  $selectData->message_log);
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
            'message error' => $e->getMessage(),
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
