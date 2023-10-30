<?php 
header('Content-Type: application/json');
try {
  include("../connect_sql.php"); 
  include("../sql_exe.php"); 

  $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
  $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
  $genIdHD = isset($_POST['genIdHD']) ? $_POST['genIdHD'] : '';
  $genIdDT = isset($_POST['genIdDT']) ? $_POST['genIdDT'] : '';
  $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
  $paramhd = isset($_POST['paramhd']) ? $_POST['paramhd'] : array();
  $paramdt = isset($_POST['paramdt']) ? $_POST['paramdt'] : array();
  $paramlist = isset($_POST['paramlist']) ? $_POST['paramlist'] : array();

  $sqlhd = '';
  if($condition == "UHD"){
    $sqlhd = sqlmixexe($queryIdHD, $paramhd);
    // $sqlhd = 'UHD';
  }   
  else{
    $sqlhd = sqlexec($queryIdHD);
    // $sqlhd = 'UHD';
  }

  $response = array(
    'status' => 'success',
    'message' => 'เพิ่มข้อมูลสำเร็จ',
    'sqlhd' => $sqlhd,
    '$queryId' =>$queryIdHD,
  );
  echo json_encode($response);

} catch (PDOException $e) {
  $response = array('status' => 'error', 'message' => 'เกิดปัญหาในการเพิ่มข้อมูล: ' . $e->getMessage());
  echo json_encode($response);
}

?>