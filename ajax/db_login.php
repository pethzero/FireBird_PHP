<?php

include("sql.php");
include("bpdata.php");
include("crud_zen.php");

session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $tableData = array(
        "login" => $username,
        "pass" => $password
    );

    try {
        $sqlQueries = new SQLQueries();
        $sqlQuery = $sqlQueries->scanSQL("L00000");
        if ($sqlQuery !== null) {
            $config_setting = database_config('mysqlserver');
            $selectData = new CRUDDATA(...$config_setting);
            $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
            $result = $selectData->SelectRecordCondition($tableData, $sqlQuery, "L00001"); // ส่งค่า $message_db มาด้วย

            if ($result['status'] !== false) {
                $response = array('status' => 'success', 'datamain' => $result['result'], 'condition' =>  '');
                $selectData->data_commit->commit();
                
                if (!empty($response['datamain'])) {
                    // if($response['datamain'][0]['PASS'] ===  $password){
                    if(password_verify($password, $response['datamain'][0]['PASS'] ) == 1){
                        if (json_decode($_POST["remember"])) { // ตรวจสอบว่าถูกติ๊กหรือไม่
                            // สร้างคุกกี้เก็บข้อมูลเข้าสู่ระบบ
                            setcookie("remember_username", $username, time() + 3600 * 24 * 30, "/");
                            setcookie("remember_password", $password, time() + 3600 * 24 * 30, "/");
                            setcookie("remember_check", json_decode($_POST["remember"]), time() + 3600 * 24 * 30, "/");
                            $response['condition'] = 'X REMEBER';
                        } else {
                            // ลบคุกกี้เมื่อไม่เลือก Remember me
                            setcookie("remember_username", "", time() - 3600, "/");
                            setcookie("remember_password", "", time() - 3600, "/");
                            setcookie("remember_check", "", time() - 3600, "/");
                            $response['condition'] = 'X NOT REMEBER';
                        }
        
                        $_SESSION["ID"] =   $response['datamain'][0]["ID"];
                        $_SESSION["RECNO"] =   $response['datamain'][0]["RECNO"];
                        $_SESSION["EMPNO"] =   $response['datamain'][0]["EMPNO"];
                        $_SESSION["EMPNAME"] = $response['datamain'][0]["EMPNAME"];
                        $_SESSION["USERLEVEL"] =   $response['datamain'][0]["USERLEVEL"];
                        $_SESSION["PASS"] =    $response['datamain'][0]["PASS"];
                        $_SESSION["PERMISSION"] =  $response['datamain'][0]["PERMISSION"];
        
                        if ($response['datamain'][0]["IMG"] != '') {
                            $_SESSION["IMAGEEMPL"] = '<img src="images/user/' . $response['datamain'][0]["IMG"] . '" width="40" height="40" class="rounded-circle">';
                        } else {
                            $_SESSION["IMAGEEMPL"] = '<img src="images/main/fox.jpg" width="40" height="40" class="rounded-circle">';
                        }
                        
                        $response['condition'] = 'T';
                    }else{
                        $response['condition'] = 'W';
                    }
                }else{
                    $response['condition'] = 'F';
                }

            } else {
                $response = array('status' => 'error', 'datamain' => $result['result'], 'message' => 'An error occurred', 'condition' =>  '');
                $selectData->data_commit->rollBack();
            }
        } else {
            $response = array(
                'message' => 'ไม่พบคำสั่ง SQL สำหรับ $queryId ที่ระบุ',
                'datamain' => [],
                'status' => 'error',
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => $e->getMessage(),
            'condition' =>  ''
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}