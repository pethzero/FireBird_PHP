<?php
try {
    include("connect.php");
    include("sql.php");

    $params = null;
    $sql = sqlexec('EMPL_LIST', $params);

    if ($sql) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any records were returned
        if (count($employees) > 0) {
            // Display the data
            foreach ($employees as $employee) {
                echo "Employee ID: " . $employee['RECNO'] . ", Name: " . $employee['EMPNAME'] . "<br>";
            }
        } else {
            echo "No data found.";
        }
    } else {
        echo "SQL query is empty.";
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
