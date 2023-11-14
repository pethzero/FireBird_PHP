
<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");

$selectData = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');

$selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
$run_number = $selectData->autoincrement_sql('SAN','equipment');
$selectData->data_commit->commit();


echo $selectData->message_log;
echo '<br>';   
// echo$run_number['result'];
echo json_encode($run_number);   

?>