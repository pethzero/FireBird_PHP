<?php
// include("database.php");
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ส่งค่ามาจาก หน้าบ้าน
    $queryId001 = isset($_POST['queryId001']) ? $_POST['queryId001'] : '';
    $queryId002 = isset($_POST['queryId002']) ? $_POST['queryId002'] : '';
    $queryId003 = isset($_POST['queryId003']) ? $_POST['queryId003'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);

    try {
        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQueries = new SQLQueries();
        $SqlID001 = $sqlQueries->scanSQL($queryId001);
        $SqlID002 = $sqlQueries->scanSQL($queryId002);
        $SqlID003 = $sqlQueries->scanSQL($queryId003);

        if ($SqlID001 !== null &&  $SqlID002 !== null &&  $SqlID003 !== null) {
            $config_setting = database_config('mysqlserver');
            $selectData = new CRUDDATA(...$config_setting);
            $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData

            $resultID001 = $selectData->SelectRecord($SqlID001);
            $resultID002 = $selectData->SelectRecord($SqlID002);
            $resultID003 = $selectData->SelectRecord($SqlID003);

            if ($resultID001['status'] !== false && $resultID002['status'] !== false) {
                $response = array(
                    'status' => 'success',
                    'datamain' => $resultID001['result'],
                    'dataeuip' => $resultID002['result'],
                    'dataempl' => $resultID003['result'],
                    'message' =>  'Data success',

                );
                $selectData->data_commit->commit();
            } else {
                $response = array('status' => 'error', 'datamain' => $resultID001['result'], 'message' => 'An error occurred');
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
            'message' => $e->getMessage(),
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
