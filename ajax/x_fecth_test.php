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
        ///////////////////////  FETCH   /////////////////////////////////
       
        //////////////////////////////////////////////////////////////////
        $response = array(
            'message' => $message,
            'data' =>  $apidata_Json,
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
