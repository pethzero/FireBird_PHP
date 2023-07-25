<?php
// ตรวจสอบว่ามีการเรียกใช้งานแบบ POST หรือไม่
include("connect.php");    
// include("sql.php");

    // ตรวจสอบค่าที่ถูกส่งมาจาก AJAX request
   // ตรวจสอบค่าที่ถูกส่งมาจาก AJAX request
    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
    $genIdHD = isset($_POST['genIdHD']) ? $_POST['genIdHD'] : '';
    $genIdDT = isset($_POST['genIdDT']) ? $_POST['genIdDT'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $paramhd = isset($_POST['paramhd']) ? $_POST['paramhd'] : array();
    $paramdt = isset($_POST['paramdt']) ? $_POST['paramdt'] : array();
    $paramlist = isset($_POST['paramlist']) ? $_POST['paramlist'] : array();
    
    // ตรวจสอบค่าที่ต้องการเพิ่มลงในฐานข้อมูล
    $status = $paramhd['STATUS'];
    $custname = $paramhd['CUSTNAME'];
    $contname = $paramhd['CONTNAME'];
    $recno_cust = $paramhd['CUST'];
    $recno_cont = $paramhd['CONT'];
    // คุณสามารถเข้าถึงค่าอื่น ๆ ในอาร์เรย์ $paramhd ได้ตามต้องการ
    // header('Content-Type: application/json');
    try {
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $pdo -> beginTransaction();
        // เตรียมคำสั่ง SQL สำหรับ INSERT ข้อมูลลงในตาราง users (ให้แก้ไขตามโครงสร้างตารางของคุณ)
        $sqlgenhd = 'SELECT NEXT VALUE FOR '.$genIdHD.' FROM RDB$DATABASE' ;
        $stmt = $pdo->prepare($sqlgenhd);
        $stmt->execute();
        $nextValueHD = $stmt->fetchColumn();
  
       
        $sql = "INSERT INTO ACTIVITYHD (RECNO,CUSTNAME) VALUES (:RECNO,:CUSTNAME)";
        $stmt = $pdo->prepare($sql);
        
        // // // ผูกค่าในอาร์เรย์กับพารามิเตอร์ในคำสั่ง SQL
        $stmt->bindParam(':RECNO', $nextValueHD);
        // $stmt->bindParam(':DOCNO', "6666");
        // $stmt->bindParam(':STATUS', $status);
        // $stmt->bindParam(':CUST', $recno_cust);
        // $stmt->bindParam(':CONT', $recno_cont);
        $stmt->bindParam(':CUSTNAME',  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $custname));
        // $stmt->bindParam(':CONTNAME', $contname);
        
        // // สั่งให้ประมวลผลคำสั่ง SQL
        $stmt->execute();
        $pdo->commit();
        // ส่งค่ากลับไปยัง AJAX request ว่าเพิ่มข้อมูลสำเร็จ
        
        
        $response = array(
          'status' => 'success', 
          'message' => 'เพิ่มข้อมูลสำเร็จ',
          'sql' => $sql,
          'sqlgenhd' => $sqlgenhd
        );
        echo json_encode($response);
    } catch (PDOException $e) {
        $pdo->rollBack(); 
        // กรณีเกิดข้อผิดพลาดในการเพิ่มข้อมูล
        $response = array('status' => 'error', 'message' => 'เกิดปัญหาในการเพิ่มข้อมูล: ' . $e->getMessage());
        echo json_encode($response);
    }


?>
