<?php

// ini_set('memory_limit', '512M');
require '../vendor/autoload.php'; // Include PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelGenerator
{
    private $headers;
    private $data;

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }
    public function setData($data)
    {
        $this->data = $data;
    }

    public function generateExcel($filename)
    {
        // Create a new PhpSpreadsheet spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the headers in the first row
        $col = 'A'; // setCellValue
        foreach ($this->headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Check if data is provided before setting the data in subsequent rows
        if (!empty($this->data)) {
            $row = 2; // Start with the second row
            foreach ($this->data as $rowData) {
                $col = 'A'; // Start with the first column
                foreach ($rowData as $cellData) {
                    $sheet->setCellValue($col . $row, $cellData);
                    // $sheet->setCellValue($col . $row, iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE', $cellData));
                    $col++;
                }
                $row++;
            }
        }
        // Create an Excel writer and save it to a file (or stream it to the client)
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Optionally, you can stream the file to the client for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="exported_data.xlsx"');
        readfile($filename);

        // Delete the temporary file
        unlink($filename);
    }
}

class HeadMake
{
    public function head($queryId)
    {
        switch ($queryId) {
            case "EXCEL_CUSTOMERSALE":
                return ['ลำดับ', 'วันที่', 'เลขที่เสนอราคา', 'Rev.', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'รายละเอียดสินค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'เครดิต', 'หมายเหตุ', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_ORDERHD":
                return ['ลำดับ', 'วันที่', 'เลขที่สั่งซื้อ', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'รายละเอียดสินค้า', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_INVOICE":
                return ['ลำดับ', 'วันที่', 'เลขที่ใบแจ้งหนี้', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'รายละเอียดสินค้า', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_DELYHD":
                return ['ลำดับ', 'วันที่', 'เลขที่ใบส่งสินค้า', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'รายละเอียดสินค้า', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;
            case "EXCEL_TEST":
                return ['ลำดับ', 'ราคารวม'];
            default:
                return ['ไม่มีข้อมูลเลยนะ'];
        }
    }
}

$queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
$blobData = isset($_POST['blobData']) ? $_POST['blobData'] : '';
$data = json_decode($blobData, true);

// $queryId = NULL;
// $data =  array();

// Get the data from the POST request
$filename = 'exported_data.xlsx';
$headMaker = new HeadMake();
$header = $headMaker->head($queryIdHD);
$excelGenerator = new ExcelGenerator();
$excelGenerator->setHeaders($header);
if (!empty($data)) {
    $excelGenerator->setData($data);
}
$excelGenerator->generateExcel($filename);
