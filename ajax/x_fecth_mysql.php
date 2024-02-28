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
        $type = 'T';
        $message = '';
        $status = true;
        $dummy = null;
        //////////////////////// CONFIG  /////////////////////////////////
        $config_setting = database_config('mysqlserver');
        $fecthData = new CRUDDATA(...$config_setting);
        $sqlQueries = new SQLQueries();
        $tbanmeInstance = new TBname();
        ///////////////////////  FETCH   /////////////////////////////////
        $fecthData->data_commit->beginTransaction();  // เริ่ม Transaction 

        foreach ($apidata_Json as $data) {
            $tbanmeData = $tbanmeInstance->getTBName($data['tbanme']);
            $sqlQuery = $sqlQueries->scanSQL($data['queryID']);
            if ($data['method'] === 'GET_NEW') {
                $result = $fecthData->SELECTID_MUTIPLE($data['listdata'], $sqlQuery, $data['condition']);
            } else if ($data['method'] === 'POST_0001') {
                $result = $fecthData->FetchMySQL_IUD($data['listdata'], $sqlQuery, $data['condition']);
            }
            else if ($data['method'] === 'POST_CHECK') {
                $checksqlQuery = $sqlQueries->scanSQL($tbanmeData['checkqueryid']);
                $result_check = $fecthData->checkExistsNEW($data['listdata'][0],  $sqlQueries->scanSQL($tbanmeData['checkqueryid']), $tbanmeData['checkcondition']);
                $result_uniquecondition = uniquecondition($data['queryID'], $result_check, $data['listdata'][0]);
                if ($result_uniquecondition['condition']) {
                    $type = 'W';
                    $message = $result_uniquecondition['message'];
                    break;
                }
                $dummy = [$data['listdata'], $sqlQuery, $data['condition']];
                $result = $fecthData->FetchMySQL_IUD($data['listdata'], $sqlQuery, $data['condition']);
            } 
    
            $datasql[] = $result['result'];
            if (!$result['status']) {
                $fecthData->data_commit->rollBack();
                throw new Exception('error');
            } 
        }
        $fecthData->data_commit->commit();
        //////////////////////////////////////////////////////////////////
        $response = array(
            'message' => $message,
            'data' =>  $datasql,
            'status' => $status,
            '$dummy' => $dummy,
            'type' => $type
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
