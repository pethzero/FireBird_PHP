<?php
require 'vendor/autoload.php'; // เรียกใช้ autoload ของ Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

// กำหนด path ของไฟล์ Excel
$inputFileName = 'test.xlsx';

// อ่านไฟล์ Excel
$spreadsheet = IOFactory::load($inputFileName);

// เลือกชีทที่ต้องการอ่านข้อมูล
$worksheet = $spreadsheet->getActiveSheet();

// อ่านข้อมูลจากชีท
$data = $worksheet->toArray();

// echo 'sss';
// ตัวอย่างการแสดงข้อมูล
foreach ($data as $row) {
    foreach ($row as $cell) {
        echo $cell . "\t";
    }
    echo "<br>";
}
?>
