<?php
// คีย์ส่วนตัวที่ได้จากการสร้าง Token ใน LINE Notify
    $accessToken = $_POST['accessToken'];
    // ตรวจสอบว่ามีการกดปุ่มส่งข้อมูลหรือไม่
    if (isset($_POST['message']))
    {
        $message = $_POST['message'];

        // ส่งข้อความไปยัง LINE Notify
        $url = 'https://notify-api.line.me/api/notify';
        $data = array('message' => $message);
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $accessToken
        );

        $options = array(
            'http' => array(
                'header'  => implode("\r\n", $headers),
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        // ตรวจสอบผลลัพธ์
        if ($result !== false) {
            echo 'ส่งข้อความแจ้งเตือนผ่าน LINE Notify สำเร็จ!';
        } else {
            echo 'เกิดข้อผิดพลาดในการส่งข้อความแจ้งเตือนผ่าน LINE Notify';
        }
    }
?>