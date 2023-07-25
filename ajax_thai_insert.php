<?php 
header('Content-Type: application/json');
try {
  include("connect.php"); 
  include("sql_exe.php "); 
    
  $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
  $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
  $genIdHD = isset($_POST['genIdHD']) ? $_POST['genIdHD'] : '';
  $genIdDT = isset($_POST['genIdDT']) ? $_POST['genIdDT'] : '';
  $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
  $paramhd = isset($_POST['paramhd']) ? $_POST['paramhd'] : array();
  $paramdt = isset($_POST['paramdt']) ? $_POST['paramdt'] : array();
  $paramlist = isset($_POST['paramlist']) ? $_POST['paramlist'] : array();
  
  // ตรวจสอบค่าที่ต้องการเพิ่มลงในฐานข้อมูล
  // $status = $paramhd['STATUS'];
  // $custname = $paramhd['CUSTNAME'];
  // $contname = $paramhd['CONTNAME'];
  // $recno_cust = $paramhd['CUST'];
  // $recno_cont = $paramhd['CONT'];
  
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    $custname =  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['CUSTNAME']);
    $contname =  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['CONTNAME']);
    $email =  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['EMAIL']);
    $addr =  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['ADDR']);
    // $location =  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['LOCATION']);
    $subject =  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['SUBJECT']);
    $detail =  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['DETAIL']);
    $ref =  iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['REF']);
    // $priority = '';
    // $timed = '';
    // $timeh = ''; 
    // $timem = '';
    // $startd = $paramhd['REF'];
    // $pricecost = 'your_pricecost_value';
    // $pricepwithdraw = 'your_pricepwithdraw_value';
    $ownername = iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $paramhd['OWNERNAME']);
    // $owner = 'your_owner_value';
    //////////////////////////////////////////////////////////////////////////////////////////////////////////

  $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
  $pdo->beginTransaction();

  // เตรียมคำสั่ง SQL สำหรับ INSERT ข้อมูลลงในตาราง users (ให้แก้ไขตามโครงสร้างตารางของคุณ)
  $sqlgenhd = 'SELECT NEXT VALUE FOR ' . $genIdHD . ' FROM RDB$DATABASE';
  $stmt = $pdo->prepare($sqlgenhd);
  $stmt->execute();
  $nextValueHD = $stmt->fetchColumn();


  // $sql = "INSERT INTO ACTIVITYHD (RECNO, CREATED , LASTUPD,STATUS,DOCNO,CUST, CUSTNAME, CONT, CONTNAME) VALUES (:RECNO, 'NOW', 'NOW',:STATUS,:DOCNO,:CUST, :CUSTNAME, :CONT, :CONTNAME)";
  // $sql = "INSERT INTO ACTIVITYHD (RECNO, CREATED , LASTUPD,DOCNO,CUST, CUSTNAME, CONT, CONTNAME) VALUES (:RECNO, 'NOW', 'NOW',':DOCNO',:CUST, ':CUSTNAME', :CONT, ':CONTNAME')";

  // $sql = "INSERT INTO ACTIVITYHD (RECNO, CREATED,LASTUPD,STATUS,DOCNO,CUST,CONT,CUSTNAME,CONTNAME) VALUES (:RECNO,'NOW', 'NOW',:STATUS,:DOCNO,:CUST,:CONT,:CUSTNAME,:CONTNAME)";
  // $sql = "INSERT INTO ACTIVITYHD (RECNO, CREATED,LASTUPD,STATUS,DOCNO,CUST,CONT,CUSTNAME,CONTNAME,EMAIL,ADDR,LOCATION,SUBJECT,DETAIL,REF,PRIORITY,TIMED,TIMEH,TIMEM,STARTD,PRICECOST,PRICEPWITHDRAW,OWNER,OWNERNAME) VALUES (:RECNO,'NOW', 'NOW',:STATUS,:DOCNO,:CUST,:CONT,:CUSTNAME,:CONTNAME,:EMAIL,:ADDR,:LOCATION,:SUBJECT,:DETAIL,:REF,:PRIORITY,:TIMED,:TIMEH,:TIMEM,:STARTD,:PRICECOST,:PRICEPWITHDRAW,:OWNER,:OWNERNAME)";
  // $sql = "INSERT INTO ACTIVITYHD (RECNO, CREATED, LASTUPD,STATUS,DOCNO,CUST, CONT,CUSTNAME,CONTNAME,CONTNAME,EMAIL) VALUES (:RECNO, 'NOW', 'NOW',:STATUS,:DOCNO , :CUST , :CONT ,:CUSTNAME,:CONTNAME,:EMAIL)";
  
  $sqlhd = sqlexec($queryIdHD);
  $stmt = $pdo->prepare($sqlhd);
  
  // // // // ผูกค่าในอาร์เรย์กับพารามิเตอร์ในคำสั่ง SQL
  $docno =  "66" ."/". sprintf("%04d",$nextValueHD);
  $stmt->bindParam(':RECNO', $nextValueHD);
  $stmt->bindParam(':STATUS', $paramhd['STATUS']);
  $stmt->bindParam(':DOCNO',  $docno );
  $stmt->bindParam(':CUST', $paramhd['CUST']);
  $stmt->bindParam(':CONT', $paramhd['CONT']);
  $stmt->bindParam(':CUSTNAME', $custname);
  $stmt->bindParam(':CONTNAME', $contname);
  //////////////////////////////////////////////////////////////////////////////////////////////////////////
  $stmt->bindParam(':EMAIL', $email);
  $stmt->bindParam(':ADDR', $addr);
  $stmt->bindParam(':LOCATION', $paramhd['LOCATION']);
  $stmt->bindParam(':SUBJECT', $subject);
  $stmt->bindParam(':DETAIL', $detail);
  $stmt->bindParam(':REF', $ref);
  $stmt->bindParam(':PRIORITY', $paramhd['PRIORITY']);
  $stmt->bindParam(':TIMED', $paramhd['TIMED']);
  $stmt->bindParam(':TIMEH', $paramhd['TIMEH']);
  $stmt->bindParam(':TIMEM', $paramhd['TIMEM']);
  $stmt->bindParam(':STARTD', $paramhd['STARTD']);
  $stmt->bindParam(':PRICECOST', $paramhd['PRICECOST']);
  $stmt->bindParam(':PRICEPWITHDRAW', $paramhd['PRICEPWITHDRAW']);
  $stmt->bindParam(':OWNER', $paramhd['OWNER']);
  $stmt->bindParam(':OWNERNAME', $ownername);

  // // // สั่งให้ประมวลผลคำสั่ง SQL
  $stmt->execute();
  $pdo->commit();

  // ส่งค่ากลับไปยัง AJAX request ว่าเพิ่มข้อมูลสำเร็จ
  $response = array(
      'status' => 'success',
      'message' => 'เพิ่มข้อมูลสำเร็จ',
      'sqlhd' => $sqlhd,
      'sqlgenhd' => $sqlgenhd,
      'STATUS'=>$paramhd['STATUS'],
      'CONT'=> $paramhd['CONT']
  );
  echo json_encode($response);
} catch (PDOException $e) {
  $pdo->rollBack();

  // กรณีเกิดข้อผิดพลาดในการเพิ่มข้อมูล
  $response = array('status' => 'error', 'message' => 'เกิดปัญหาในการเพิ่มข้อมูล: ' . $e->getMessage());
  echo json_encode($response);
}

?>