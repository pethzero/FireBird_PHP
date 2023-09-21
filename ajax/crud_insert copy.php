<?php
include("database.php");
include("../sql_exe.php");

class InsertData
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
        $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false); // ปิด Auto Commit
    }

    public function insertRecord($data)
    {
        try {
            $this->conn->beginTransaction(); // เริ่ม Transaction
            $sql = "INSERT INTO his (name, id, age) VALUES (:name, :id, :age)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':age', $data['age']);

            $stmt->execute();
            
            $this->conn->commit(); // Commit การ Transaction
            //    if ($this->conn->inTransaction()) {
            //     $this->conn->commit(); // Commit การ Transaction ถ้ายังไม่เริ่ม Transaction จะไม่ทำอะไร
            // }
            // $this->conn->rollBack(); // Rollback การ Transaction เมื่อเกิดข้อผิดพลาด
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
    $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $runnigitem = isset($_POST['runnigitem']) ? $_POST['runnigitem'] : '';
    $uploadnamedb = isset($_POST['uploadnamedb']) ? $_POST['uploadnamedb'] : '';
    $checkvalue = isset($_POST['checkvalue']) ? $_POST['checkvalue'] : '';
    $checkname = isset($_POST['checkname']) ? $_POST['checkname'] : '';
    
    
    /// data array ///
    $paramhdJson = isset($_POST['paramhd']) ? $_POST['paramhd'] : null;
    $paramhd = json_decode($paramhdJson, true);
    // ดำเนินการกับข้อมูลตามที่คุณต้องการ
    // เช่น บันทึกลงฐานข้อมูลหรือส่งอีเมล
    // ใช้คลาส InsertData เพื่อ insert ข้อมูล

    // $insertData = new InsertData();
    // $data = array(
    //     'name' => $name,
    //     'id' => $id ,
    //     'age' =>  $age,
    // );

    // $this->conn->commit(); 
    // if ($insertData->insertRecord($data)) {
    //     $response = array('message' => 'Data received successfully');
    // } else {
    //     $response = array('error' => 'Data received Error');
    // }

    // ส่งการตอบกลับ
    // $response = array('message' => 'Data received successfully');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

