<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

// $selectData = new CRUDDATA('firebird','192.168.1.28', 'SAN', 'SYSDBA', 'masterkey');
$selectData = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');

// $queryIdHD = 'EXCEL_CUSTOMERSALE';
$queryIdHD = 'CHK_APPPOINTMENT';
// $data = array(
//     'recno' => 2,
// );

$data = '{
    "0": {
        "name": "name",
        "recno": 1
    }
}';

$dataArray = json_decode($data, true);

echo $dataArray["0"]["name"]; // แสดงชื่อ "NAME"
echo $dataArray["0"]["recno"]; // แสดงค่า RECNO คือ 866

// $data = array(
//     'datebegin' => '2023.08.01',
//     'dateend' => '2023.08.03'
// );
$condition = 'DT000';

$sqlQueries = new SQLQueries();
$sqlQuery = $sqlQueries->scanSQL($queryIdHD);


echo $sqlQuery;
echo '<br>';    
$selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            
// $result = $selectData->SelectRecordFireBird($sqlQuery); 
$result = $selectData->checkExists($dataArray[0],$sqlQuery,$condition); 
$selectData->data_commit->commit();


echo $selectData->message_log;
echo '<br>';   
echo json_encode($result);

?>