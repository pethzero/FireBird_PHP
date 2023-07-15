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
    // $paramdt = isset($_POST['paramdt']) ? $_POST['paramdt'] : null;
    // $paramlist = isset($_POST['paramlist']) ? $_POST['paramlist'] : null;
    $DataJSON  = json_decode($_POST['DataJSON'], true);
    
    // if (isset($_POST['queryId']) && isset($_POST['params']))
    if (isset($_POST['queryIdHD']))
    { 
          try {
            // ดำเนินการส่งคำสั่ง SQL ด้วยฟังก์ชัน sqlexec จาก sql.php
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
            $pdo -> beginTransaction();
            if($condition == "I")
            {
              // เพิ่ม Generator hd
              $sqlgenhd = 'SELECT NEXT VALUE FOR GEN_INVREQHD FROM RDB$DATABASE' ;
              $stmt = $pdo->prepare($sqlgenhd);
              $stmt->execute();
              // อ่านค่า Generator hd
              $nextValueHD = $stmt->fetchColumn();
              $paramhd['RECNO'] = $nextValueHD ;
              //insert hd
              $sqlhd = sqlexec($queryIdHD,$paramhd);
              $stmt = $pdo->prepare($sqlhd);
              $stmt->execute();

              //รับค่าเพื่อส่งต่อ INVREQHD
              $paramdt['INVREQHD']  = $nextValueHD;
              
              $count = 0;
              foreach ($DataJSON as $row)
              {
              // เพิ่ม Generator dt
              $sqlgendt = 'SELECT NEXT VALUE FOR GEN_INVREQDT FROM RDB$DATABASE' ;
              $stmt = $pdo->prepare($sqlgendt);
              $stmt->execute();
              // อ่านค่า Generator
              $nextValueDT = $stmt->fetchColumn();
              $paramdt['RECNO'] = $nextValueDT ;

                $paramdt = array(
                  'RECNO' => $nextValueDT,
                  'IO' => 'O',
                  'STATUS' => 'D',
                  'CORP' => 1,
                  'INVREQHD' => $nextValueHD,
                  'IO' => 'O',
                  'REQTYPE' => 5,
                  'REFDOCHD' => null,
                  'REFDOCDT' => null,
                  'LINENO' => $count,
                  'ITEMNO' => $count+1,
                  'QUANORD' => $row[4],
                  'QUANDLY' => $row[5],
                  'INVENT' => $row[2],
                  'LISTUNIT' => $row[6],  
                );
                
                $paramlist= array(
                  'RECNO' => $row[2],
                  'QUAN' => $row[5],
                );
                // สร้างคำสั่ง SQL สำหรับแทรกข้อมูล
                // $sql = "INSERT INTO your_table (column1, column2) VALUES ('$column1', '$column2')";
                $sqldt = sqlexec($queryIdDT,$paramdt);
                $stmt = $pdo->prepare($sqldt);
                $stmt->execute();

                $sqlwithdraw = sqlexec('withdrawstock',$paramlist);
                $stmt = $pdo->prepare($sqlwithdraw);
                $stmt->execute();

                $count++; 
               }

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