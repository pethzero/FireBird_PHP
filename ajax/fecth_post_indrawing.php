<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryId001 = isset($_POST['queryId001']) ? $_POST['queryId001'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);
    try {

     

        //UPLOAD CHECK
        $sqlQueries = new SQLQueries();
        $SqlID001 = $sqlQueries->scanSQL($queryId001);

        if ($SqlID001 !== null) {
            $config_setting = database_config('mysqlserver');
            $insertData = new CRUDDATA(...$config_setting);
			
            $insertData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            if ($insertData->insertRecord($tableData_Json[0], $SqlID001, $condition))
            {
                $response = array(
                    'message' => 'Data received successfully',
                    'status' => 'success'
                );
                $insertData->data_commit->commit();
            } else {
                $response = array(
                    'message' => $insertData->message_log,
                    'status' => 'error'
                );
                $insertData->data_commit->rollBack();
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
