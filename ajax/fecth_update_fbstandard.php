<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");
include("systemfuc.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);
    try {
        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);
        if ($sqlQuery !== null) {
            $config_setting = database_config('fbserver');
            // $config_setting = database_config('fbtest');
            $processfecth = new CRUDDATA(...$config_setting);
            // $processfecth = new CRUDDATA('firebird','192.168.1.28', 'SAN', 'SYSDBA', 'masterkey');
            $processfecth->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            if ($processfecth->updateRecord($tableData_Json[0], $sqlQuery, $condition)) {
                $response = array(
                    'message' => 'Data received successfully',
                    'status' => 'success'
                );
                $processfecth->data_commit->commit();
            } else {
                $response = array(
                    'message' => $processfecth->message_log,
                    'status' => 'error'
                );
                $processfecth->data_commit->rollBack();
            }
        } else {
            $response = array(
                'message' => 'ไม่พบคำสั่ง SQL สำหรับ $queryId ที่ระบุ',
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
