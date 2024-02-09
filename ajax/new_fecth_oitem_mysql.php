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
        ///////////////////////////VARAIBLE////////////////////////////////
        $datasql = [];
        //////////////////////// CONFIG  /////////////////////////////////
        $config_setting = database_config('mysqlserver');
        $fecthData = new CRUDDATA(...$config_setting);
        $sqlQueries = new SQLQueries();
        ///////////////////////  FETCH   /////////////////////////////////
        $fecthData->data_commit->beginTransaction();  // เริ่ม Transaction 

        foreach ($apidata_Json as $data) {
            $sqlQuery = $sqlQueries->scanSQL($data['queryID']);
            if ($data['method'] === 'GET_NEW') {
                $result = $fecthData->SELECTID_MUTIPLE($data['listdata'], $sqlQuery, $data['condition']);
            } else {
                $result = array('result' => 'Data Error', 'status' => false, 'message' => 'Data Error');
            }

            $datasql = $result;
            if (!$result['status']) {
                $fecthData->data_commit->rollBack();
                throw new Exception('error');
            }
        }
        $fecthData->data_commit->commit();
        //////////////////////////////////////////////////////////////////
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
