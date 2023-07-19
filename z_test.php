<?php
try {
    include("connect.php");
    include("sql.php");

    $params = null;
    $sql = sqlexec('EMPL_LIST', $params);

    if ($sql) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // Initialize an empty array to hold the employee data
        $employees = array();

        // Fetch each row one by one using a while loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
        {
            // Add the current row to the employees array
            $employees[] = $row;
        }

        // Check if any records were returned
        if (count($employees) > 0) {
            // Add the data to the response array
            $response = array(
                'status' => 'success',
                'data' => $employees
            );
        } else {
            $response = array(
                'status' => 'success',
                'data' => 'No data found.'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'SQL query is empty.'
        );
    }
} catch (PDOException $e) {
    $errorMessage = "เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage();
    $response = array(
        'status' => 'error',
        'message' => $errorMessage
    );
}

// Output the response
echo json_encode($response);
?>
