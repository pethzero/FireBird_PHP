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
    // ใช้คลาส InsertData เพื่อ insert ข้อมูล
    //CHECK
    $checkData = isset($_POST['checkData']) ? $_POST['checkData'] : '';
    $checkCondition = isset($_POST['checkCondition']) ? $_POST['checkCondition'] : '';
    try {
        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);
        $sqlQueryCheck = $sqlQueries->scanSQL($checkData);
        if ($sqlQueryCheck !== null && $sqlQueries !== null) {
            $config_setting = database_config('mysqlserver');
            $processfecth = new CRUDDATA(...$config_setting);
            $processfecth->data_commit->beginTransaction();

            $result_check = $processfecth->checkExistsNEW($tableData_Json[0], $sqlQueryCheck, $checkCondition); // ส่งค่า $message_db มาด้วย
            
            if ($result_check['status']) {
                $result_uniquecondition = uniquecondition($queryIdHD, $result_check, $tableData_Json[0]);

                if ($result_uniquecondition['condition']) {
                    $response = array(
                        'message' =>  $result_uniquecondition['message'],
                        'status' => 'warnning'
                    );
                } else {
                    if (($processfecth->updateRecord($tableData_Json[0], $sqlQuery, $condition))) {
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
                }
            } else {
                $response = array(
                    'message' => $processfecth->message_log,
                    'status' => 'error'
                );
            }
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
