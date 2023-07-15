<?php
// กำหนดตัวแปรสำหรับการเชื่อมต่อฐานข้อมูล
$servername = "ชื่อเซิร์ฟเวอร์";
$username = "ชื่อผู้ใช้ MySQL";
$password = "รหัสผ่าน MySQL";
$dbname = "ชื่อฐานข้อมูล";

// การเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการเลือกไฟล์รูปภาพหรือไม่
if (isset($_FILES["image"])) {
    $file = $_FILES["image"];

    // ตรวจสอบว่าไม่มีข้อผิดพลาดในการอัพโหลด
    if ($file["error"] === UPLOAD_ERR_OK) {
        // สร้างชื่อไฟล์ใหม่สำหรับการบันทึก
        $filename = uniqid() . "_" . $file["name"];

        // อัพโหลดไฟล์ไปยังโฟลเดอร์ที่ต้องการเก็บ
        move_uploaded_file($file["tmp_name"], "doc/" . $filename);

        // เพิ่มลิงก์ไฟล์รูปภาพในฐานข้อมูล
        $sql = "INSERT INTO images (filename) VALUES ('$filename')";
        if ($conn->query($sql) === TRUE) {
            echo "อัพโหลดรูปภาพเรียบร้อยแล้ว";
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มลิงก์รูปภาพ: " . $conn->error;
        }
    } else {
        echo "เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ: " . $file["error"];
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>