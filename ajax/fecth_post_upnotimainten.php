<?php
include("sql.php");
include("bpdata.php");
include("crud_zen.php");
// include("dataupload.php");



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    // $modify = isset($_POST['modify']) ? $_POST['modify'] : '';
    // $uploadolddb = isset($_POST['uploadolddb']) ? $_POST['uploadolddb'] : '';
    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);
    // ดำเนินการกับข้อมูลตามที่คุณต้องการ
    // เช่น บันทึกลงฐานข้อมูลหรือส่งอีเมล
    // ใช้คลาส InsertData เพื่อ insert ข้อมูล
    try {

        /// upload setting ///
        $targetDir = "../uploads/";
        $messageupload = '';
        $statusupload = false;
        // $filename_db = '';

        //UPLOAD CHECK
        // if($modify === 'T'){
        //     if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
        //         $statusupload = true;
        //         $messageupload = $_FILES["fileToUpload"]['name'];
        //     } elseif (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_NO_FILE) {
        //         // $Dataupload = array('result' =>  "No file was uploaded.");
        //         $statusupload = false;
        //         $messageupload = '';
        //     } else {
        //         $statusupload = false;
        //         $messageupload = '';
        //         // $Dataupload = array('result' =>  "File upload error.");
        //     }
        // }else{
        //     $messageupload = $uploadolddb;
        // }
  
        // // // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);

        if ($sqlQuery !== null) {
            $insertData = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');
            $insertData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            // $tableData_Json[0]['upload'] =   $messageupload;

            if ($insertData->updateRecord($tableData_Json[0], $sqlQuery, $condition))
            {
              
                // if($statusupload){
                //     $fileUploader = new FileUploader($targetDir);
                //     $Dataupload = $fileUploader->uploadFile($_FILES["fileToUpload"]);
                // }
                $response = array(
                    'message' => 'Data received successfully',
                    'status' => 'success'
                );
                $insertData->data_commit->commit();
            } else {
                $response = array(
                    'message' => $insertData->message_log,
                    'status' => 'error'
                );
                $insertData->data_commit->rollBack();
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
