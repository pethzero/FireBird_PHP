<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $checkRecno = isset($_POST['checkRecno']) ? $_POST['checkRecno'] : '';
    $checkCondition = isset($_POST['checkCondition']) ? $_POST['checkCondition'] : '';


    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);

    $DataEdit = isset($_POST['DataEdit']) ? $_POST['DataEdit'] : null;
    $DataEdit_Json = json_decode($DataEdit, true);

    try {
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);
        $sqlQueryCheck = $sqlQueries->scanSQL($checkRecno);

        if ($sqlQuery !== null) {
            $updateData = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');
            $updateData->data_commit->beginTransaction();

            $result_check = $updateData->checkExists($DataEdit_Json[0], $sqlQueryCheck, $checkCondition); // ส่งค่า $message_db มาด้วย

            if ($result_check['status'] !== false) {
                // $response = array('status' => 'success', 'message' => $result_check['message'] );
                if ($updateData->updateRecord($DataEdit_Json[0], $sqlQuery, $condition)) {
                    $response = array('message' => 'Data received successfully', 'status' => 'success');
                    $updateData->data_commit->commit();
                } else {
                    $response = array('message' => 'Data received Error', 'status' => 'error');
                    $updateData->data_commit->rollBack();
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
