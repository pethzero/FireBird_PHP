<?php 
header('Content-Type: application/json');

function convertToTIS620($data) {
  return iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $data);
}


try {
  include("connect.php"); 
  // include("sql_exe.php"); 
  // include("0_functions.php"); // เพิ่ม include เข้ามาเพื่อเรียกใช้งานฟังก์ชั่นที่สร้างไว้ใน functions.php
  // include("0_fucinchd.php");


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
  // $ = getvalue($queryIdHD, $paramhd);
  //////////////////////////////////////////////////////////////////////////////////////////////////////////
  $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
  $pdo->beginTransaction();

  // เตรียมคำสั่ง SQL สำหรับ INSERT ข้อมูลลงในตาราง users (ให้แก้ไขตามโครงสร้างตารางของคุณ)
  $sqlgenhd = 'SELECT NEXT VALUE FOR ' . $genIdHD . ' FROM RDB$DATABASE';
  $stmt = $pdo->prepare($sqlgenhd);
  $stmt->execute();
  $nextValueHD = $stmt->fetchColumn();

  $custname = convertToTIS620($paramhd['CUSTNAME']);
  $contname = convertToTIS620($paramhd['CONTNAME']);
  $tel = convertToTIS620($paramhd['TEL']);
  $email = convertToTIS620($paramhd['EMAIL']);
  $addr = convertToTIS620($paramhd['ADDR']);
  $subject = convertToTIS620($paramhd['SUBJECT']);
  $detail = convertToTIS620($paramhd['DETAIL']);
  $ref = convertToTIS620($paramhd['REF']);
  $ownername = convertToTIS620($paramhd['OWNERNAME']);


  $stmt = $pdo->prepare("INSERT INTO ACTIVITYHD (RECNO, CREATED,LASTUPD,STATUS,DOCNO,CUST,CONT,CUSTNAME,CONTNAME,TEL,EMAIL,ADDR,LOCATION,SUBJECT,DETAIL,REF,PRIORITY,TIMED,TIMEH,TIMEM,STARTD,PRICECOST,PRICEPWITHDRAW,OWNER,OWNERNAME) VALUES (:RECNO,'NOW', 'NOW',:STATUS,:DOCNO,:CUST,:CONT,:CUSTNAME,:CONTNAME,:TEL,:EMAIL,:ADDR,:LOCATION,:SUBJECT,:DETAIL,:REF,:PRIORITY,:TIMED,:TIMEH,:TIMEM,:STARTD,:PRICECOST,:PRICEPWITHDRAW,:OWNER,:OWNERNAME)");
  //////////////////////////////////////////// BEGIN HEAD DATA //////////////////////////////////////////////////////////////
  // // // // ผูกค่าในอาร์เรย์กับพารามิเตอร์ในคำสั่ง SQL
  // ทำการเรียกใช้ฟังก์ชั่น getvalue() และเก็บค่าที่ได้กลับมาไว้ในตัวแปร $
  $docno = "66" . "/" . sprintf("%04d", $nextValueHD);
  $stmt->bindParam(':RECNO', $nextValueHD);
  $stmt->bindParam(':STATUS', $paramhd['STATUS']);
  $stmt->bindParam(':DOCNO', $docno);
  $stmt->bindParam(':CUST', $paramhd['CUST']);
  $stmt->bindParam(':CONT', $paramhd['CONT']);
  $stmt->bindParam(':CUSTNAME',$custname);
  $stmt->bindParam(':CONTNAME', $contname);
  $stmt->bindParam(':TEL',  $tel);
  $stmt->bindParam(':EMAIL', $email );
  $stmt->bindParam(':ADDR', $addr);
  $stmt->bindParam(':LOCATION', $paramhd['LOCATION']);
  $stmt->bindParam(':SUBJECT', $subject );
  $stmt->bindParam(':DETAIL', $detail );
  $stmt->bindParam(':REF',  $ref );
  $stmt->bindParam(':PRIORITY', $paramhd['PRIORITY']);
  $stmt->bindParam(':TIMED', $paramhd['TIMED']);
  $stmt->bindParam(':TIMEH', $paramhd['TIMEH']);
  $stmt->bindParam(':TIMEM', $paramhd['TIMEM']);
  $stmt->bindParam(':STARTD', $paramhd['STARTD']);
  $stmt->bindParam(':PRICECOST', $paramhd['PRICECOST']);
  $stmt->bindParam(':PRICEPWITHDRAW', $paramhd['PRICEPWITHDRAW']);
  $stmt->bindParam(':OWNER', $paramhd['OWNER']);
  $stmt->bindParam(':OWNERNAME',$ownername);
 //////////////////////////////////////////// START HEAD DATA //////////////////////////////////////////////////////////////
  // // // สั่งให้ประมวลผลคำสั่ง SQL
  $stmt->execute();
  if($stmt){
    $response = array(
      'status' => 'success',
      'message' => 'เพิ่มข้อมูลสำเร็จ'
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