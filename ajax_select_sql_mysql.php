<?php
try {
    // include("connect_sql.php");    //FIRDBIRD
    session_start(); // เริ่มเซสชัน (ถ้ายังไม่ได้เปิด)

    include("connect_sql.php");   //MYSQL   
    include("sql_exe.php");

    $queryId = isset($_GET['queryId']) ? $_GET['queryId'] : '';
    $params = isset($_GET['params']) ? $_GET['params'] : '';
    $condition = isset($_GET['condition']) ? $_GET['condition'] : '';
    $count = isset($_GET['count']) ? $_GET['count'] : '';
    $countyear = isset($_GET['countyear']) ? $_GET['countyear'] : '';
    $sqlprotect = isset($_GET['sqlprotect']) ? $_GET['sqlprotect'] : '';
    $data = array();
  
    // if (true) {
    
    // if( $sqlprotect === )
    // if ($sqlprotect === $_SESSION['csrf_token']) {
    if (true) {    
    if($condition == "mix")
    {
      $sql = sqlmixexe($queryId, $params);
    }   
    else{
      $sql = sqlexec($queryId);
    }
    if ($sql) 
       {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            foreach ($row as $key => $value)
            {
                if ($key === 'IMAGE') {
                    $base64Data = base64_encode($value);
                    $row[$key] = $base64Data; 
                } 
            }
            $data[] = $row;
        }
        $response = array(
            'status' => 'success',
            // 'sql' => $sql,
            'sqlprotect' => $sqlprotect,
            'csrf_token' =>   $_SESSION['csrf_token'],
            '$params' => $params, 
            'data' => $data
        );

        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            // 'queryId' => $data,
            // 'params' => $params,
            // 'sql' => $sql,
            'sqlprotect' => $sqlprotect,
            'csrf_token' =>   $_SESSION['csrf_token'],
            'data' => $data
        );
        echo json_encode($response);
    }
}
else{
    $response = array(
        'status' => 'error',
        // 'queryId' => $data,
        // 'params' => $params,
        // 'sql' => $sql,
        'sqlprotect' => $sqlprotect,
        // 'csrf_token' =>   $_SESSION['csrf_token'],
        'data' => $data
    );
}
   

} catch (PDOException $e) {
    $errorMessage = "เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage();
    $response = array(
        'status' => 'error',
        'sql' => $sql,
        'message' => $errorMessage
    );

    echo json_encode($response);
    exit();
}
