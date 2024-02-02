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
        $config_setting = database_config('fbserver');

        $fecthData = new CRUDDATA(...$config_setting);
        $sqlQueries = new SQLQueries();
        $tbanmeInstance = new TBname();

        ///////////////////////// SPEACAIL Value /////////////////////////
        $datasql = [];
        $newdatalist;
        $idhead1 = 0;
        $listhead = [];
        /////////////////////////////////////////////////////////////////
        $fecthData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData

        foreach ($apidata_Json as $data) {
            $tbanmeData = $tbanmeInstance->getTBName($data['tbanme']);
            $sqlQuery = $sqlQueries->scanSQL($data['queryID']);
            if ($data['method'] === "POSTHEAD1") {
                $newdatalist = $fecthData->RecnoFireBirdMultiple($data['listdata'], $tbanmeData, $listhead);
                $result = $fecthData->ProcessFBMultiple($newdatalist['result'], $sqlQuery, $data['condition']);
                $listhead  = $newdatalist['listhead'];
            } else if ($data['method'] === "POSTHEAD2") {
                $newdatalist = $fecthData->RecnoFireBirdMultiple($data['listdata'], $tbanmeData, $listhead);
                $result = $fecthData->ProcessFBMultiple($newdatalist['result'], $sqlQuery, $data['condition']);
            } else if ($data['method'] === "UPDATA") {
                $result = $fecthData->ProcessFBMultiple($data['listdata'], $sqlQuery, $data['condition']);
            } else if ($data['method'] === "GET")
             {
                $result = $fecthData->SelectRecordFireBirdConditionMultipleNew($data['listdata'], $sqlQuery, $data['condition']);
            } else {
                $result = array('result' => 'Data Error', 'status' => false, 'message' => 'Data Error');
            }

            if (!$result['status']) {
                $fecthData->data_commit->rollBack();
                throw new Exception($result['result']);
            }
   
            $datasql[] = $result;
        }

        $fecthData->data_commit->commit();

        $response = array(
            'message' => 'Data suscess',
            'data' =>   $datasql,
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
