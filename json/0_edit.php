<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Param = isset($_POST['Param']) ? $_POST['Param'] : null;
    $Param_Json = json_decode($Param, true);


    try {
        $jsonData = file_get_contents('setting.json');
        $dataArray = json_decode($jsonData, true);

        $response = array(
            'message' => 'ok',
            'status' => 'error',
            'data' => $dataArray,
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
