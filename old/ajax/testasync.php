<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $blobData = isset($_POST['blobData']) ? $_POST['blobData'] : '';
    $blobData_Json = json_decode($blobData, true);
    $response = array(
        'message' => 'TEST',
        'queryIdHD' =>  $queryIdHD,
        'blobData' =>  $blobData_Json,
        'status' => 'yes',
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
