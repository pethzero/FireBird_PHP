<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

$selectData = new CRUDDATA('firebird','192.168.1.28', 'SAN', 'SYSDBA', 'masterkey');

$queryIdHD = 'EXCEL_CUSTOMERSALE';

$data = '{
    "0": {
        "datebegin": "2023.08.01",
        "dateend": "2023.08.30"
    }
}';

$dataArray = json_decode($data, true);
echo $dataArray[0]['datebegin'];
echo '<br>';
$condition = 'DATEBE';

$sqlQueries = new SQLQueries();
$sqlQuery = $sqlQueries->scanSQL($queryIdHD);


echo $sqlQuery;
echo '<br>';    
$selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            
// $result = $selectData->SelectRecordFireBird($sqlQuery); 
$result = $selectData->SelectRecordFireBirdCodition($dataArray[0],$sqlQuery,$condition); 
$selectData->data_commit->commit();


echo $selectData->message_log;
echo '<br>';   
echo json_encode($result);

?>