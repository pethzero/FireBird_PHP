<?php
include("excel_header.php");
require '../vendor/autoload.php'; // Include PhpSpreadsheet library
// require 'excel_export.php';
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
            // $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($numColumns) . $footerRow, $TureTotalAmt);
            $cellCoordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($numColumns) . $footerRow;
            $sheet->setCellValue($cellCoordinate, $TureTotalAmt);
            // Get the style object for the cell
            $cellStyle = $sheet->getStyle($cellCoordinate);
            // Get the alignment object for the cell style
            $alignment = $cellStyle->getAlignment();
            $alignment->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            // Apply the updated style to the cell
            // $cellStyle->setAlignment($alignment);
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


$queryIdExcel = "EXCEL_TEST"; //
$TureTotalAmt = 0;
$condition_footer = 'F';
// แก้ไขให้ JSON object ถูกล้อมรอบด้วย {}
$blobData = '[
    {"CODE":"001","จำนวนผลิต":1500,"จำนวนส่งออก":1000}
  ]';
  
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
