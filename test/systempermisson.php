<?php

function webpermissions($empno, $group)
{
    $host = 'localhost';
    $db_name = 'SAN';
    $username = 'root';
    $password = '1234';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $sql = "SELECT PERMISSON FROM userpermissions WHERE EMPNO =:EMPNO AND NAMEP = :NAMEP";

    $query = $pdo->prepare($sql);
    // ผูกค่าพารามิเตอร์
    $query->bindParam(':EMPNO', $empno, PDO::PARAM_STR);
    $query->bindParam(':NAMEP', $group, PDO::PARAM_STR);
    $query->execute();

    // Fetch the result
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        // ถ้ามีผลลัพธ์จาก query
        $permission = $result['PERMISSON'];
        if ($permission !== 'T') {
            // // ถ้าค่า PERMISSON ไม่เท่ากับ 'T'
            // echo "มีค่า PERMISSON แต่ไม่เท่ากับ 'T'";
            header("Location: 404.php");
            exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
        }
        // else {
        //     // ถ้าค่า PERMISSON เท่ากับ 'T'
        //     // echo "มีค่า PERMISSON เท่ากับ 'T'";
        // }
    } else {
        // ถ้าไม่มีผลลัพธ์จาก query
        header("Location: 404.php");
        exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    }
}
