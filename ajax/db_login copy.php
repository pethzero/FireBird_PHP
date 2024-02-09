<?php

include("sql.php");
include("bpdata.php");
include("crud_zen.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo 'start';
    // ส่งค่ามาจาก หน้าบ้าน
    // $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    // $queryDropDown = isset($_POST['queryDropDown']) ? $_POST['queryDropDown'] : '';

    // $condition = isset($_POST['condition']) ? $_POST['condition'] : '';

    // $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;


    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $tableData = array(
        "login" => $username,
        "pass" => $password
    );


    // $tableData_Json = json_decode($tableData, true);
    // $tableData_Json = json_encode($tableData); // แก้จาก json_decode เป็น json_encode

    //json_encode() เพื่อเปลี่ยนข้อมูลในอาร์เรย์เป็น JSON string ที่สามารถใช้ในการสื่อสารกับเว็บแอปพลิเคชันอื่นๆ ได้
    //และถูกต้องตามรูปแบบของ JSON และทำให้เหมาะกับการใช้งานกับ json_decode() 
    //นส่วนอื่นของโปรแกรมของคุณ หรือกับโปรแกรมอื่นที่รับ JSON string นี้เป็นข้อมูลนำเข้าได้อย่างถูกต้อง

    try {
        echo 'sqlQueries';

        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL("L00000");
        if ($sqlQuery !== null) {
            // $selectData = new CRUDDATA('mysql', 'localhost', 'SAN', 'root', '1234');
            $config_setting = database_config('mysqlserver');
            $selectData = new CRUDDATA(...$config_setting);

            $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            $result = $selectData->SelectRecordCondition($tableData, $sqlQuery, "L00001"); // ส่งค่า $message_db มาด้วย

            if ($result['status'] !== false) {
                $response = array('status' => 'success', 'datamain' => $result['result'], 'dbconnect' =>  $selectData->message_log);
                $selectData->data_commit->commit();
                
                if (!empty($datamain)) {
                    echo "<script>";
                    echo "alert(\" WTF\");";
                    echo "</script>";
                }else{
                    echo "<script>";
                    echo "alert(\" ท่านไม่ได้รับสิทธิเข้าใช้งานระบบ\");";
                    echo "window.history.back()";
                    echo "</script>";
                }

            } else {
                $response = array('status' => 'error', 'datamain' => $result['result'], 'message' => 'An error occurred');
                $selectData->data_commit->rollBack();
            }
        } else {
            $response = array(
                'message' => 'ไม่พบคำสั่ง SQL สำหรับ $queryId ที่ระบุ',
                'datamain' => [],
                'status' => 'error',
            );
        }

        echo 'wow';
        // $response = array(
        //     'message' => 'Login',
        //     'status' => 'what',
        //     'tableData' => $tableData,
        // );

        // header('Content-Type: application/json');
        // echo json_encode($response);
    } catch (Exception $e) {
        $response = array(
            'message' => $e->getMessage(),
        );
        // header('Content-Type: application/json');
        // echo json_encode($response);
        exit;
    }
}
