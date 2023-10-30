<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ส่งค่ามาจาก หน้าบ้าน
    $queryIdGET = isset($_POST['queryIdGET']) ? $_POST['queryIdGET'] : '';

    try {
        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdGET);

        
        if ($sqlQuery !== null) {
            $selectData = new CRUDDATA('firebird','192.168.1.28', 'SAN', 'SYSDBA', 'masterkey');
            $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            
            $result = $selectData->SelectRecordFireBird($sqlQuery); 

            if ($result['status'] !== false ) {
                $response = array('status' => 'success', 'datasql' => $result['result'],'sql'=>$sqlQuery, 'dbconnect' =>  $selectData->message_log);
                // $selectData->data_commit->commit();
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
