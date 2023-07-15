<?php
// ตรวจสอบว่ามีการอัพโหลดไฟล์รูปภาพหรือไม่
if(isset($_FILES['image'])){
    $targetDir = "doc/"; // โฟลเดอร์ปลายทางสำหรับเก็บไฟล์รูปภาพ
    $targetFile = $targetDir . basename($_FILES['image']['name']); // ตำแหน่งของไฟล์ที่จะถูกย้าย
    
    // ย้ายไฟล์ไปยังโฟลเดอร์ปลายทาง
	$response = 0;
    if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
        echo "อัพโหลดรูปภาพสำเร็จ";
		$response = 1;
    } else {
        echo "เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ";
    }
}
?>

<?php

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    }

?>