<?php

include("sql.php");
include("bpdata.php");
include("crud_zen.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $tableData = array(
        "login" => $username,
        "pass" => $password
    );

    try {
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL("L00000");
        if ($sqlQuery !== null) {
            $config_setting = database_config('mysqlserver');
            $selectData = new CRUDDATA(...$config_setting);
            $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            $result = $selectData->SelectRecordCondition($tableData, $sqlQuery, "L00001"); // ส่งค่า $message_db มาด้วย

            if ($result['status'] !== false) {
                $response = array('status' => 'success', 'datamain' => $result['result'], 'condition' =>  '');
                $selectData->data_commit->commit();
                
                if (!empty($datamain)) {
                    $response['condition'] = 'T';
                }else{
                    $response['condition'] = 'P';
                }

            } else {
                $response = array('status' => 'error', 'datamain' => $result['result'], 'message' => 'An error occurred');
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
            'status' => 'error',
            'message' => $e->getMessage(),
            'condition' =>  ''
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}