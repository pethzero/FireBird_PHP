<?php 
header('Content-Type: application/json');
try {
  include("connect.php"); 
  include("sql_exe.php"); 
  include("0_functions.php"); // เพิ่ม include เข้ามาเพื่อเรียกใช้งานฟังก์ชั่นที่สร้างไว้ใน functions.php
  include("0_fucinchd.php");
  $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
  $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
  $genIdHD = isset($_POST['genIdHD']) ? $_POST['genIdHD'] : '';
  $genIdDT = isset($_POST['genIdDT']) ? $_POST['genIdDT'] : '';
  $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
  $paramhd = isset($_POST['paramhd']) ? $_POST['paramhd'] : array();
  $paramdt = isset($_POST['paramdt']) ? $_POST['paramdt'] : array();
  $paramlist = isset($_POST['paramlist']) ? $_POST['paramlist'] : array();
  
  // ตรวจสอบค่าที่ต้องการเพิ่มลงในฐานข้อมูล
  //////////////////////////////////////////////////////////////////////////////////////////////////////////
  // สร้างฟังก์ชั่น getvalue() ในไฟล์ 0_functions.php
  // $result_hd = getvalue($queryIdHD, $paramhd);
  //////////////////////////////////////////////////////////////////////////////////////////////////////////
  $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
  $pdo->beginTransaction();

  // เตรียมคำสั่ง SQL สำหรับ INSERT ข้อมูลลงในตาราง users (ให้แก้ไขตามโครงสร้างตารางของคุณ)
  $sqlgenhd = 'SELECT NEXT VALUE FOR ' . $genIdHD . ' FROM RDB$DATABASE';
  $stmt = $pdo->prepare($sqlgenhd);
  $stmt->execute();
  $nextValueHD = $stmt->fetchColumn();

  $sqlhd = sqlexec($queryIdHD);
  $stmt = $pdo->prepare($sqlhd);
  //////////////////////////////////////////// BEGIN HEAD DATA //////////////////////////////////////////////////////////////
  // // // // ผูกค่าในอาร์เรย์กับพารามิเตอร์ในคำสั่ง SQL
  // ทำการเรียกใช้ฟังก์ชั่น getvalue() และเก็บค่าที่ได้กลับมาไว้ในตัวแปร $result_hd
  $result_hd = getvalue($queryIdHD, $paramhd);
  tranexe($queryIdHD, $paramhd, $result_hd, $stmt, $nextValueHD);

 //////////////////////////////////////////// START HEAD DATA //////////////////////////////////////////////////////////////
  // // // สั่งให้ประมวลผลคำสั่ง SQL
  $stmt->execute();
  if($stmt){
    $response = array(
      'status' => 'success',
      'message' => 'เพิ่มข้อมูลสำเร็จ'
      // ,'sqlhd' => $sqlhd,
      // 'sqlgenhd' => $sqlgenhd,
      // 'STATUS'=>$paramhd['STATUS'],
      // 'CONT'=> $paramhd['CONT']
  );
  $pdo->commit();
  echo json_encode($response);
  }
  else{
    $response = array(
      'status' => 'error',
      'message' => 'ไม่มีการเพิ่มข้อมูล');
    $pdo->rollBack();
    echo json_encode($response);
  }
  // ส่งค่ากลับไปยัง AJAX request ว่าเพิ่มข้อมูลสำเร็จ
 
} catch (PDOException $e) {
  $pdo->rollBack();

  // กรณีเกิดข้อผิดพลาดในการเพิ่มข้อมูล
  $response = array('status' => 'error', 'message' => 'เกิดปัญหาในการเพิ่มข้อมูล: ' . $e->getMessage());
  echo json_encode($response);
}

?>