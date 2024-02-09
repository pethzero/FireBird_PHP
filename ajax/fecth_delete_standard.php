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
    //CHECK
    $checkData = isset($_POST['checkData']) ? $_POST['checkData'] : '';
    $checkCondition = isset($_POST['checkCondition']) ? $_POST['checkCondition'] : '';
    try {
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);
        $sqlQueryCheck = $sqlQueries->scanSQL($checkData);

        if ($sqlQuery !== null) {
            $config_setting = database_config('mysqlserver');
            $processfecth = new CRUDDATA(...$config_setting);
            // $processfecth->data_commit->beginTransaction();  
            $result_check = $processfecth->checkExists($tableData_Json[0], $sqlQueryCheck, $checkCondition); // ส่งค่า $message_db มาด้วย
            if ($result_check['status'] !== false) {
                if ($processfecth->deleteRecord($tableData_Json[0], $sqlQuery, $condition)) {
                    $response = array('message' => 'Data received successfully', 'status' => 'success');
                    $processfecth->data_commit->commit();
                } else {
                    $response = array('message' => 'Data received Error', 'status' => 'error');
                    $processfecth->data_commit->rollBack();
                }
            } else {
                $response = array('status' => 'warning', 'message' => $result_check['message']);
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
