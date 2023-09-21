<?php
include("database.php");
include("sql.php");

class bindParamData {
    public static function bindParams($stmt, $data, $condition) {
        switch ($condition) {
            case '001':
                $stmt->bindParam(':name', $data['name']);
                break;
            case '002':
                $stmt->bindParam(':a', $data['a']);
                $stmt->bindParam(':b', $data['b']);
                break;
            // เพิ่มเงื่อนไขเพิ่มเติมตามความต้องการ
            default:
                // ไม่มีเงื่อนไขที่ตรงกัน
                break;
        }
    }
}

class InsertData
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
        $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false); // ปิด Auto Commit
    }

    public function insertRecord($data,$sqlQuery, $condition)
    {
        try {
            $this->conn->beginTransaction(); // เริ่ม Transaction
            $stmt = $this->conn->prepare($sqlQuery);
            bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
            $stmt->execute();
            $this->conn->commit(); // Commit การ Transaction
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack(); // Rollback การ Transaction เมื่อเกิดข้อผิดพลาด
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function insertRecordMultiple($dataArray,$sqlQuery, $condition)
    {
        try {
            $this->conn->beginTransaction(); // เริ่ม Transaction
            foreach ($dataArray as $data) {
                $stmt = $this->conn->prepare($sqlQuery);
                bindParamData::bindParams($stmt, $data, $condition); // เรียกใช้งาน bindParamData
                $stmt->execute();
            }
            $this->conn->commit(); // Commit การ Transaction
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack(); // Rollback การ Transaction เมื่อเกิดข้อผิดพลาด
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';

    $tableData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
    $tableData_Json = json_decode($tableData, true);
    // ดำเนินการกับข้อมูลตามที่คุณต้องการ
    // เช่น บันทึกลงฐานข้อมูลหรือส่งอีเมล
    // ใช้คลาส InsertData เพื่อ insert ข้อมูล
    try {
        $sqlQueries = new SQLQueries();

        // ใช้เมทอด scanSQL() เพื่อรับคำสั่ง SQL ตาม $queryId
        $sqlQuery = $sqlQueries->scanSQL($queryIdHD);
        if ($sqlQuery !== null) {

            $insertData = new InsertData();
            if ($insertData->insertRecordMultiple($tableData_Json,$sqlQuery, $condition)) {
                $response = array('message' => 'Data received successfully');
            } else {
                $response = array('message' => 'Data received Error');
            }


            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            $response = array(
                'message' => 'ไม่พบคำสั่ง SQL สำหรับ $queryId ที่ระบุ',
            );
        }

        // $response = array(
        //     'message' => 'Data received successfully',
        //     'sql' =>  $sql,
        //     'tableData' =>  $tableData,
        //     'tableData_Json' =>  $tableData_Json
        // );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    //catch exception
    catch (Exception $e) {
        // echo 'Message: ' .$e->getMessage();
        $response = array(
            'message' => $e->getMessage(),
            // 'message' => 'Data received successfully'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
