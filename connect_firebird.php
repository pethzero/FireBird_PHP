<?php
// การเชื่อมต่อกับฐานข้อมูล Firebird
// $host = 'localhost'; // หรือชื่อโฮสต์ของเซิร์ฟเวอร์ Firebird
// $database = 'SAN'; // ชื่อฐานข้อมูลที่คุณต้องการเชื่อมต่อ

// $host = '192.168.1.205';
// $database = 'SAN_001'; // ชื่อฐานข้อมูลที่คุณต้องการเชื่อมต่อ

$host = '192.168.1.28';
$database = 'SAN'; // ชื่อฐานข้อมูลที่คุณต้องการเชื่อมต่อ



$username = 'SYSDBA'; // ชื่อผู้ใช้ที่มีสิทธิ์ในการเข้าถึงฐานข้อมูล
$password = 'masterkey'; // รหัสผ่านสำหรับผู้ใช้
$charset = 'NONE';  

// เชื่อมต่อกับ Firebird
$dsn = "firebird:dbname=$host:$database;charset=$charset";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // เพิ่มคำสั่งเพิ่มเติมตามความต้องการ
    // เชื่อมต่อสำเร็จแสดงข้อความ
    // echo "การเชื่อมต่อกับฐานข้อมูล Firebird เรียบร้อยแล้ว";
} catch (PDOException $e) {
    // กรณีเกิดข้อผิดพลาดในการเชื่อมต่อ
    echo "เกิดข้อผิดพลาดในการเชื่อมต่อกับ Firebird: " . $e->getMessage();
}
?>