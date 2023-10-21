<?php
// รับค่าพารามิเตอร์จาก MySQL TRIGGER
if (isset($argv[1]) && isset($argv[2]) && isset($argv[3])) {
    $param1 = $argv[1];
    $param2 = $argv[2];
    $param3 = $argv[3];

    // ดำเนินการตามความต้องการของคุณ
    // เช่น บันทึกข้อมูลลงในไฟล์, ส่งอีเมล, เข้าระบบฐานข้อมูล, หรืออื่น ๆ
    // ตัวอย่าง:
    echo "Received param1: $param1, param2: $param2, param3: $param3";
} else {
    echo "Missing parameters.";
}
?>
