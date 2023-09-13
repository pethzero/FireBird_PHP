<?php
try {
    include("connect_sql.php");    
    include("sql.php");
    // ดึงข้อมูลจากตารางที่ต้องการ
    $message = '';
    $queryId=$_GET['queryId']; 
    $params=$_GET['params'];
    if (isset($_GET['queryId']) && isset($_GET['params']))
    {
          // ดำเนินการส่งคำสั่ง SQL ด้วยฟังก์ชัน sqlexec จาก sql.php
          try {
            $sqlgen = 'SELECT NEXT VALUE FOR GEN_INVENT FROM RDB$DATABASE' ;
            $stmt = $pdo->prepare($sqlgen);
            $stmt->execute();
            // อ่านค่า Generator
            $nextValue = $stmt->fetchColumn();

            $params['RECNO'] = $nextValue ;
            $sql = sqlexec($queryId,$params);
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
    
            $pdo->commit();
            // $message =  $params;
            $message = 'สำเร็จ' ;
          }
          catch (PDOException $e)
          {
            $pdo->rollBack(); 
               // กรณีเกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล
            $response = array(
              'status' => 'error',
              'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: ' . $e->getMessage()
            );
            // ส่งข้อมูลกลับในรูปแบบ JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
          }
          $response = array(
            'status' => 'success',
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
      'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: ' . $e->getMessage()
    );
    // ส่งข้อมูลกลับในรูปแบบ JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    // echo "เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage();
    exit();
}
?>