<?php
// ข้อมูลเชื่อมต่อฐานข้อมูล
$host = 'localhost';
$dbname = 'SAN';
$username = 'root';
$password = '1234';

try {
    // สร้างการเชื่อมต่อ PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // ตั้งค่า PDO ให้ใช้โหมดการรายงานข้อผิดพลาด
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ดึงวันนี้
    $today = date("Y-m-d");
    // echo  $today;

    // $today = '2023-08-26';

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลโดยไม่รวมค่า '0000-00-00'
    // $sql = "SELECT * FROM activityhd WHERE STARTD = :today AND STARTD != '0000-00-00'";
    $sql = "SELECT * FROM activityhd WHERE WARND = :today ";

    // เตรียมคำสั่ง SQL ด้วย PDO
    $stmt = $pdo->prepare($sql);

    // ผูกค่าพารามิเตอร์
    $stmt->bindParam(':today', $today, PDO::PARAM_STR);

    // ทำคำสั่ง SQL
    $stmt->execute();
    
    $rowCount = $stmt->rowCount();

    // echo $rowCount;
    // // ดึงข้อมูลเป็น associative array
    if ($rowCount > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $message = "";
        $number = 0;
        // แสดงผลลัพธ์
        foreach ($result as $row) {
            // echo "RECNO: " . $row['RECNO'] . ", STARTD: " . $row['STARTD'] . "<br>";
            $number +=1; 
            $message .= "หัวข้อเรื่อง  " . $row['SUBJECT'] . "\n"
                . "บริษัท" . $row['CUSTNAME'] . "\n"
                . "วันที่นัด คือ " . $row['STARTD'] . "\n"
                . "\n";
            // เพิ่มโค้ดสำหรับแสดงข้อมูลอื่น ๆ ตามความต้องการ
        }    
        // Set your access token
        // $accessToken = 'Hh0ura2RMQuxyHutazonFsR4SdKT5f6ASoAGGEInuXv'; //
        $accessToken = 'UWQeqRDaeOqyhYkzdtkFqKrsMarFL6aIWxz9Z5kDYgO';



        // Set the message you want to send
        // $message = 'Hello, Line TEST!';

        // API endpoint URL
        $url = 'https://notify-api.line.me/api/notify';

        // Set the headers
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $accessToken,
        ];

        // Set the message data
        $data = [
            'message' => $message,
        ];

        // Send the notification
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        // Check the response
        if ($response === false) {
            echo 'Error occurred: ' . curl_error($ch);
        } else {
            echo 'Notification sent!';
        }
    }


} catch (PDOException $e) {
    echo "เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: " . $e->getMessage();
}

// ปิดการเชื่อมต่อ
$pdo = null;
