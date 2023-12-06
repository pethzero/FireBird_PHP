<?php
try {
    include("connect_sql.php");    
    include("sql.php");

    $queryId = isset($_GET['queryId']) ? $_GET['queryId'] : '';
    $params = isset($_GET['params']) ? $_GET['params'] : '';
    $condition = isset($_GET['condition']) ? $_GET['condition'] : '';
    $count = isset($_GET['count']) ? $_GET['count'] : '';
    $countyear = isset($_GET['countyear']) ? $_GET['countyear'] : '';
    $data = array();


    $sql = sqlexec($queryId, $params);


    if ($sql) {
        if($condition === 'Mouth')
        {
            for ($year = 0; $year < $countyear; $year++) {
                for ($mouth = 0; $mouth < $count; $mouth++)
                {
                    $params = array(
                        'MONTHSPAN' => json_decode($_GET['params']['datasend'], true)['MONTHSPAN'][$mouth],
                        'YEARSPAN' => json_decode($_GET['params']['datasend'], true)['YEARSPAN'][$year]
                    );
                                    
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);
                                
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $newRow = array();
                        // $newRow['Year' . strval(json_decode($_GET['params']['datasend'], true)['YEARSPAN'][$year])] = strval(json_decode($_GET['params']['datasend'], true)['YEARSPAN'][$year]);
                        $newRow['Year'] = strval(json_decode($_GET['params']['datasend'], true)['YEARSPAN'][$year]);
                        $newRow['Mouth'] = strval(json_decode($_GET['params']['datasend'], true)['MONTHSPAN'][$mouth]);
                        foreach ($row as $key => $value) {
                            if ($key === 'IMAGE') {
                                $base64Data = base64_encode($value);
                                $newRow[$key] = $base64Data;
                            } else {
                                $newRow[$key] = iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE', $value);
                            }
                        }
                        
                        $data[] = $newRow;
                    }
                }
            }
            }
        else
        {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                foreach ($row as $key => $value) {
                    if ($key === 'IMAGE') {
                        $base64Data = base64_encode($value);
                        $row[$key] = $base64Data; 
                    } else {
                        $row[$key] = iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE', $value);
                    }
                }
                $data[] = $row;
            }
        }
        $response = array(
            'status' => 'success',
            'data' => $data
        );

        echo json_encode($response);
    } else {
        $response = array(
            'status' => 'error',
            'data' => $data
        );

        echo json_encode($response);
    }
} catch (PDOException $e) {
    $errorMessage = "เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage();
    $response = array(
        'status' => 'error',
        'message' => $errorMessage
    );

    echo json_encode($response);
    exit();
}
?>
