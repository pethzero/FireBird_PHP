<?php 
header('Content-Type: application/json');
try {
  include("../connect_sql.php"); 
  include("../sql_exe.php"); 
  // include("../0_functions_mysql.php"); // เพิ่ม include เข้ามาเพื่อเรียกใช้งานฟังก์ชั่นที่สร้างไว้ใน functions.php
  // include("../0_fucinchd_mysql.php");
  $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
  $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
  $genIdHD = isset($_POST['genIdHD']) ? $_POST['genIdHD'] : '';
  $genIdDT = isset($_POST['genIdDT']) ? $_POST['genIdDT'] : '';
  $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
  $paramhd = isset($_POST['paramhd']) ? $_POST['paramhd'] : array();
  $paramdt = isset($_POST['paramdt']) ? $_POST['paramdt'] : array();
  $paramlist = isset($_POST['paramlist']) ? $_POST['paramlist'] : array();
  
  $nextValueHD = '';
  // ตรวจสอบค่าที่ต้องการเพิ่มลงในฐานข้อมูล
  //////////////////////////////////////////////////////////////////////////////////////////////////////////
  // สร้างฟังก์ชั่น getvalue() ในไฟล์ 0_functions.php
  // $result_hd = getvalue($queryIdHD, $paramhd);
  //////////////////////////////////////////////////////////////////////////////////////////////////////////
  $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
  $pdo->beginTransaction();

  if($condition == "UHD"){
    $sqlhd = sqlmixexe($queryIdHD, $paramhd);
  }   
  else{
    $sqlhd = sqlexec($queryIdHD);
  }

//   // เตรียมคำสั่ง SQL สำหรับ UPDATE ข้อมูลลงในตาราง users (ให้แก้ไขตามโครงสร้างตารางของคุณ)
$stmt = $pdo->prepare($sqlhd);
//   // // // สั่งให้ประมวลผลคำสั่ง SQL
  $stmt->execute();
  // $stmt = true;
  if($stmt){
    $response = array(
      'status' => 'success',
      'message' => 'เพิ่มข้อมูลสำเร็จ'
      ,'sqlhd' => $sqlhd
      ,'$queryIdHD' => $queryIdHD
      ,'$stmt' => $stmt
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