<?php
// ini_set('memory_limit', '512M');
include("sql.php");
include("bpdata.php");
include("crud_zen.php");
include("systemfuc.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ส่งค่ามาจาก หน้าบ้าน
    $apidata = isset($_POST['apidata']) ? $_POST['apidata'] : null;
    $apidata_Json = json_decode($apidata, true);
    try {
        $config_setting = database_config('sanserver');
        $fecthData = new CRUDDATA(...$config_setting);
        $sqlQueries = new SQLQueries();
        $datasql = [];
        $fecthData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
        foreach ($apidata_Json as $data) {

            $sqlQuery = $sqlQueries->scanSQL($data['queryID']);
            if($data['method'] === 'GET')
            {
                $result = $fecthData->SelectRecordConditionMultipleNew($data['listdata'], $sqlQuery, $data['condition']);
                $datasql[] = $result['result'];
            }

            if (!$result['status']) {
                $fecthData->data_commit->rollBack();
                throw new Exception('error');
            } 
        }

        $fecthData->data_commit->commit();

        $response = array(
                    'message' => 'Data suscess',
                    'data' =>  $datasql,
                    'status' => 'suscess',
                );

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
