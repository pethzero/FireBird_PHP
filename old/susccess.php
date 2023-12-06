<?php
// ตั้งค่าหัวข้อการตอบสนอง HTTP เพื่อบอกว่าเป็น JSON
header('Content-Type: application/json');

// ตัวอย่างข้อมูล JSON ที่คุณต้องการส่งกลับ
$response = array(
    'status' => 'success',
    'message' => 'ข้อมูล JSON จากเซิร์ฟเวอร์',
    'data' => array(
        'name' => 'John Doe',
        'email' => 'john@example.com',
    )
);

// แปลงข้อมูลในอาเรย์เป็น JSON และส่งกลับไปยัง client
echo json_encode($response);
?>
