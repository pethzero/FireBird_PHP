<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// สร้าง Spreadsheet ใหม่
$spreadsheet = new Spreadsheet();

// สร้างชีทใหม่
$sheet = $spreadsheet->getActiveSheet();

// เพิ่มข้อมูลลงในเซลล์
$sheet->setCellValue('A1', 'a1');
$sheet->setCellValue('B1', 'a2');
$sheet->setCellValue('C1', 'a3');

$sheet->setCellValue('A2', 1);
$sheet->setCellValue('B2', 2);
$sheet->setCellValue('C2', 3);

$sheet->setCellValue('A3', 11);
$sheet->setCellValue('B3', 22);
$sheet->setCellValue('C3', 33);

// กำหนดหัวของไฟล์ Excel
$spreadsheet->getActiveSheet()->setTitle('Example');

// สร้าง Writer สำหรับสร้างไฟล์ Excel
$writer = new Xlsx($spreadsheet);

// กำหนดคำสั่งสำหรับแสดงผลลัพธ์
ob_start();
$writer->save('php://output');
$output = ob_get_clean();

// ส่งผลลัพธ์กลับไปยัง JavaScript
echo $output;
?>
