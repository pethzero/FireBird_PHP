<?php
try {
    include("connect.php");    
    include("sql.php");
    // ดึงข้อมูลจากตารางที่ต้องการ
    $message = '';

    $queryId = isset($_POST['queryId']) ? $_POST['queryId'] : '';
    $params = isset($_POST['params']) ? $_POST['params'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';

    $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
    $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
    $paramhd = isset($_POST['paramhd']) ? $_POST['paramhd'] : null;
    $paramdt = isset($_POST['paramdt']) ? $_POST['paramdt'] : null;
    $paramlist = isset($_POST['paramlist']) ? $_POST['paramlist'] : null;
    // $DataJSON  = json_decode($_POST['DataJSON'], true);
    $DataJSON = isset($_POST['DataJSON']) ? json_decode($_POST['DataJSON'], true) : null;

    // if (isset($_POST['queryId']) && isset($_POST['params']))
    if (isset($_POST['queryIdHD']))
    { 
          try {
            // ดำเนินการส่งคำสั่ง SQL ด้วยฟังก์ชัน sqlexec จาก sql.php
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
            $pdo -> beginTransaction();
            if($condition == "U")
            {
            
              $sqlhd = sqlexec($queryIdHD,$paramhd);
              $stmt = $pdo->prepare($sqlhd);
              $stmt->execute();
            }
            $pdo->commit();
            $message = 'สำเร็จ';
          }
          catch (PDOException $e)
          {
            $pdo->rollBack(); 
            // กรณีเกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล
            $response = array(
              'status' => 'error',
              'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: ' . $e->getMessage(),
            );
            // ส่งข้อมูลกลับในรูปแบบ JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
          }
          $response = array(
            'status' => 'success',
            // 'DataJSON' =>$DataJSON,
            // 'sqldt' => $sqldt,
            'message' =>  $message
          );
            
    } else {
      $response = array(
        'status' => 'success',
        'message' => 'ไม่ได้รับข้อมูลที่เพียงพอ'
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e)
   {
    // กรณีเกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล
    $response = array(
      'status' => 'error',
      'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: ' . $e->getMessage(),
    );
    // ส่งข้อมูลกลับในรูปแบบ JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    // echo "เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage();
    exit();
}
?>