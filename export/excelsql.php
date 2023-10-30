<?php

ini_set('memory_limit', '512M');

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
} catch (PDOException $e) {
    // กรณีเกิดข้อผิดพลาดในการเชื่อมต่อ
    echo "เกิดข้อผิดพลาดในการเชื่อมต่อกับ Firebird: " . $e->getMessage();
}

// require '../z_excel.php';
require '../sql_exe.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// รับข้อมูลจาก AJAX
$dataname = $_POST['data'];
$queryId = isset($_POST['queryId']) ? $_POST['queryId'] : '';
$params = isset($_POST['params']) ? $_POST['params'] : '';
// สร้าง Spreadsheet ใหม่
$spreadsheet = new Spreadsheet();

// สร้างชีทใหม่
$sheet = $spreadsheet->getActiveSheet();

// รายชื่อหัวข้อ
if ($queryId == "EXCEL_CUSTOMERSALE") {
    $header = array('ลำดับ', 'วันที่', 'เลขที่เสนอราคา', 'Rev.', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'รายละเอียดสินค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'เครดิต', 'หมายเหตุ', 'จำนวน', 'หน่วยละ', 'ราคารวม');
}else if($queryId == "EXCEL_QOUT_ORDERHD"){
    $header = array(
        'ลำดับ',
        'วันที่',
        'เลขที่สั่งซื้อ',
        'เลขที่ใบสั่งซื้อ',
        'รหัสลูกค้า',
        'ชื่อเรียก',
        'ชื่อลูกค้า',
        'ผู้ติดต่อ',
        'ชื่อพนักงานขาย',
        'รายละเอียดสินค้า',
        'จำนวน',
        'หน่วยละ',
        'ราคารวม'
    );
}else if($queryId == "EXCEL_QOUT_INVOICE"){
    $header = array(
        'ลำดับ',
        'วันที่',
        'เลขที่ใบแจ้งหนี้',
        'เลขที่ใบสั่งซื้อ',
        'รหัสลูกค้า',
        'ชื่อเรียก',
        'ชื่อลูกค้า',
        'ผู้ติดต่อ',
        'ชื่อพนักงานขาย',
        'รายละเอียดสินค้า',
        'จำนวน',
        'หน่วยละ',
        'ราคารวม'
    );
}else if($queryId == "EXCEL_QOUT_DELYHD"){
    $header = array(
        'ลำดับ',
        'วันที่',
        'เลขที่ใบส่งสินค้า',
        'เลขที่ใบสั่งซื้อ',
        'รหัสลูกค้า',
        'ชื่อเรียก',
        'ชื่อลูกค้า',
        // 'ชื่อพนักงานขาย',
        'รายละเอียดสินค้า',
        'จำนวน',
        'หน่วยละ',
        'ราคารวม'
    );
}
else {
    $header = array(
        'เทส',
    );
}

// เพิ่มข้อมูลหัวข้อลงในเซลล์
$col = 'A'; // เริ่มต้นที่คอลัมน์ A
foreach ($header as $item) {
    $sheet->setCellValue($col . '1', $item);
    $col++;
}

$sql = sqlmixexe($queryId, $params);
// $sql = "SELECT QUOTHD.RECNO, QUOTHD.DOCDATE, QUOTHD.DOCNO, QUOTHD.REVISE, CUST.CODE, CUST.SNAME, CUST.NAME, CUSTCONT.CONTNAME, EMPL.EMPNAME, QUOTHD.CREDIT, QUOTHD.REMARK, QUOTDT.DETAIL, QUOTDT.QUAN, QUOTDT.UNITAMT, QUOTDT.TOTALAMT FROM QUOTHD LEFT JOIN CUST ON (QUOTHD.CUST = CUST.RECNO) LEFT JOIN CUSTCONT ON (QUOTHD.CONT = CUSTCONT.RECNO) LEFT JOIN EMPL ON (QUOTHD.SALES = EMPL.RECNO) LEFT JOIN quotdt ON (QUOTHD.RECNO = quotdt.QUOTHD) WHERE  (QUOTHD.STATUS <> 'C') AND  (QUOTDT.DETAIL <> '')  AND ( QUOTHD.RECNO BETWEEN 1 AND 10) ORDER BY QUOTHD.RECNO";
// $sql = "SELECT QUOTHD.RECNO, QUOTHD.DOCDATE, QUOTHD.DOCNO, QUOTHD.REVISE, CUST.CODE, CUST.SNAME, CUST.NAME, QUOTDT.DETAIL, CUSTCONT.CONTNAME, EMPL.EMPNAME, QUOTHD.CREDIT, QUOTHD.REMARK, QUOTDT.QUAN, QUOTDT.UNITAMT, QUOTDT.TOTALAMT FROM QUOTHD LEFT JOIN CUST ON (QUOTHD.CUST = CUST.RECNO) LEFT JOIN CUSTCONT ON (QUOTHD.CONT = CUSTCONT.RECNO) LEFT JOIN EMPL ON (QUOTHD.SALES = EMPL.RECNO) LEFT JOIN quotdt ON (QUOTHD.RECNO = quotdt.QUOTHD) WHERE  (QUOTHD.STATUS <> 'C') AND  (QUOTDT.DETAIL <> '')  ORDER BY QUOTHD.RECNO";

if ($sql) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    // ข้อมูลจาก SQL
    $counter = 2; // แถวที่ 2 เพราะแถวแรกใช้เป็นหัวข้อ
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['DOCDATE'] = date('d/m/Y', strtotime($row['DOCDATE']));
        // แปลงค่าในแต่ละคอลัมน์เป็น UTF-8
        // เพิ่มข้อมูลลงในเซลล์ตามคอลัมน์
        $col = 'A';
        foreach ($row as $value) {
            $sheet->setCellValue($col . $counter, iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE', $value));
            $col++;
        }

        $counter++;
    }
}


// กำหนดหัวของไฟล์ Excel
$spreadsheet->getActiveSheet()->setTitle('Example');

// สร้าง Writer สำหรับสร้างไฟล์ Excel
$writer = new Xlsx($spreadsheet);

// กำหนดชื่อไฟล์ด้วยตัวแปร $today
$today = date("d_m_Y"); // สร้างรูปแบบวันที่ตามที่คุณต้องการ
// $filename = "$dataname"."_$today.xlsx"; // เพิ่ม $today ในชื่อไฟล์
$filename = "../uploads/" . "$dataname" . ".xlsx";
// $filename ="../uploads/MyFilename.xls";

$writer = new Xlsx($spreadsheet);
$writer->save($filename);

$response = array(
    'status' => 'success',
    'download' => $filename
);
echo json_encode($response);

exit;
