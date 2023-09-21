<?php
// ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาผ่าน POST หรือไม่

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ดึงข้อมูลที่ถูกส่งมาจาก FormData ใน JavaScript
    // $key1 = $_POST["key1"];
    // $key2 = $_POST["key2"];

    // ตรวจสอบว่าข้อมูลถูกส่งมาหรือไม่
    if (!empty($key1) && !empty($key2)) {
        // ทำงานกับข้อมูลที่ถูกส่งมา
        // เช่น บันทึกข้อมูลลงในฐานข้อมูลหรือประมวลผลข้อมูลตามที่คุณต้องการ
        $data = "ข้อมูลที่ถูกส่งมาคือ: key1=$key1, key2=$key2";
    } else {
        // กรณีข้อมูลไม่ถูกส่งมา
        $data = "ไม่มีข้อมูลที่ถูกส่งมา";
    }
} else {
    // กรณีไม่ใช่การร้องขอ POST
    $data = "ไม่มีการร้องขอ POST";
}

$response = array(
    'message' => 'Data received successfully',
    'data' => $data
);
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
