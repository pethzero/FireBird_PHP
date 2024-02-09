<?php
// include("database.php");
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $checkRecno = isset($_POST['checkRecno']) ? $_POST['checkRecno'] : '';
    $checkCondition = isset($_POST['checkCondition']) ? $_POST['checkCondition'] : '';

    $DataRemove = isset($_POST['DataRemove']) ? $_POST['DataRemove'] : null;
    $DataRemove_Json = json_decode($DataRemove, true);
    try {
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);
        $sqlQueryCheck = $sqlQueries->scanSQL($checkRecno);
        if ($sqlQuery !== null) {

            // $deleteData = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');
            $config_setting = database_config('mysqlserver');
            $deleteData = new CRUDDATA(...$config_setting);
            $deleteData->data_commit->beginTransaction();  

            $result_check = $deleteData->checkExists($DataRemove_Json[0], $sqlQueryCheck, $checkCondition); // ส่งค่า $message_db มาด้วย

            if ($result_check['status'] !== false) {
                if ($deleteData->deleteRecord($DataRemove_Json[0], $sqlQuery, $condition)) {
                    $response = array('message' => 'Data received successfully', 'status' => 'success');
                    $deleteData->data_commit->commit();
                } else {
                    $response = array('message' => 'Data received Error', 'status' => 'error');
                    $deleteData->data_commit->rollBack();
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
