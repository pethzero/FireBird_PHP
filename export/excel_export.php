<?php
require '../vendor/autoload.php'; // Include PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

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

    public function generateExcel($filename, $TureTotalAmt, $condition_footer)
    {
        // Create a new PhpSpreadsheet spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ปรับความสูงของเซลล์ A1
        $sheet->getRowDimension(1)->setRowHeight(25); // ปรับความสูงเป็น 30 (หน่วยเป็น point)

        // สร้างรูปแบบอักษรสำหรับเซลล์ A1
        $fontStyle = [
            'font' => [
                'name' => 'Angsana New', // ชื่อแบบอักษร
                'size' => 20, // ขนาดแบบอักษร
                'bold' => true, // ตัวหนา
            ],
        ];

        // ตั้งค่าแบบอักษรให้กับเซลล์ A1
        $sheet->getStyle('A1')->applyFromArray($fontStyle);
        $sheet->setCellValue('A1', 'REPORT');
        $sheet->mergeCells('A1:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->headers)) . '1');
        // Set the alignment for cell A1 (center)
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Set the headers in the first row
        $col = 'A'; // setCellValue
        foreach ($this->headers as $header) {
            // $sheet->setCellValue($col . '1', $header);
            $sheet->setCellValue($col . '2', $header);
            // $sheet->getColumnDimension($col)->setWidth(strlen($header));
            $col++;
        }

        // Check if data is provided before setting the data in subsequent rows
        if (!empty($this->data)) {
            // $row = 2; // Start with the second row
            $row = 3; // Start with the second row

            // Find the number of columns based on the data
            $numColumns = count($this->data[0]); // Assuming all rows have the same number of columns


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


        // Set auto size for columns (adjust column width based on content)
        foreach (range('A', \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($numColumns)) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        if ($condition_footer == 'T') {
            // Calculate the footer data (for example, sum of a column)
            $footerRow = $row + 1; // Move to the next row after the data

            // Set the footer value (assuming $TureTotalAmt is the total sum)
            $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($numColumns - 1) . $footerRow, 'ผลรวมราคา');
            $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($numColumns) . $footerRow, $TureTotalAmt);
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
    public function head($queryIdExcel)
    {
        switch ($queryIdExcel) {
            case "EXCEL_CUSTOMERSALE":
                // return ['ลำดับ', 'วันที่', 'เลขที่เสนอราคา', 'Rev.', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'รายละเอียดสินค้า', 'ชื่อพนักงานขาย', 'เครดิต', 'หมายเหตุ', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                return ['วันที่', 'เลขที่เสนอราคา', 'Rev.', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'รายละเอียดสินค้า', 'ชื่อพนักงานขาย', 'เครดิต', 'หมายเหตุ', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_ORDERHD":
                // return ['ลำดับ', 'วันที่', 'เลขที่สั่งซื้อ', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'รายละเอียดสินค้า', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                return ['วันที่', 'เลขที่สั่งซื้อ', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'รายละเอียดสินค้า', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_INVOICE":
                return ['วันที่', 'เลขที่ใบแจ้งหนี้', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'ผู้ติดต่อ', 'ชื่อพนักงานขาย', 'รายละเอียดสินค้า', 'จำนวนแจ้ง', 'จำนวนส่ง', 'หน่วยละ', 'ราคารวม'];
                break;

            case "EXCEL_QOUT_DELYHD":
                return ['วันที่', 'เลขที่ใบส่งสินค้า', 'เลขที่ใบสั่งซื้อ', 'รหัสลูกค้า', 'ชื่อเรียก', 'ชื่อลูกค้า', 'รายละเอียดสินค้า', 'จำนวน', 'หน่วยละ', 'ราคารวม'];
                break;
            case "EXCEL_QOUT_INVOICE_SUMMARY":
                return [
                    'วันที่ที่ระบุในเอกสาร',
                    'วันที่ครบกำหนด',
                    'เลขที่ใบแจ้งหนี้',
                    'ใบสั่งซื้อ',
                    'รายการ',
                    'จำนวน',
                    'หน่วยละ',
                    'ผลรวมเงิน',
                    'สกุลเงิน',
                    'อัตราแลกเปลี่ยน',
                    'ผลรวมเงินสุทธิ์บาท'
                ];
                break;
            case "PO_REPORT":
                return ['รหัสผู้จำหน่าย', 'ชื่อผู้จำหน่าย', 'ใบแจ้งหนี้', 'ใบเลขที่ใบส่งสินค้าผู้ขาย', 'วันที่', 'รหัส', 'หน่วย', 'จำนวนแจ้งหนี้', 'จำนวนรับเข้า', 'หน่วยละ', 'ผลรวม', 'ใบสั่งซื้อ', 'รายละเอียด', 'จำนวน', 'หน่วยละ', 'หน่วย', 'ผลรวม', 'ผลรวมหน่วยต่าง'];
                break;
            case "SELECT_POQC":
                return [
                    'เลขที่ใบสั่งซื้อ',
                    'สถานะ',
                    'จำนวนทั้งหมด',
                    'Q\'ty NG',
                    'คะแนนคุณภาพ',
                    'ประเภทสั่งซื้อ',
                    'งวดเดือน'
                ];
                break;
            case "EXCEL_SUMMARY_PO_RANK":
                    return ['รหัส'
                            , 'ชื่อผู้จำหน่าย'
                            , 'ราคารวม'
                            , 'จำนวนใบแจ้งหนี้'];
                    break;
            case "EXCEL_TEST":
                return ['ลำดับ', 'ราคารวม'];
                break;
            default:
                return ['ไม่มีข้อมูลเลยนะ'];
        }
    }
}



$queryIdExcel = isset($_POST['queryIdExcel']) ? $_POST['queryIdExcel'] : '';
$blobData = isset($_POST['blobData']) ? $_POST['blobData'] : '';
$TureTotalAmt = isset($_POST['TureTotalAmt']) ? $_POST['TureTotalAmt'] : '';
$condition_footer = isset($_POST['condition_footer']) ? $_POST['condition_footer'] : '';
$data = json_decode($blobData, true);

// Get the data from the POST request
$filename = 'exported_data.xlsx';
$headMaker = new HeadMake();
$header = $headMaker->head($queryIdExcel);
$excelGenerator = new ExcelGenerator();
$excelGenerator->setHeaders($header);
if (!empty($data)) {
    $excelGenerator->setData($data);
}
$excelGenerator->generateExcel($filename, $TureTotalAmt, $condition_footer);
