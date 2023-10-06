<?php
require '../vendor/autoload.php'; // Include PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Get the data from the POST request
$queryId = isset($_POST['queryId']) ? $_POST['queryId'] : '';
$data = json_decode($_POST['data'], true);

// Create a new PhpSpreadsheet spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Loop through the data and set it in the spreadsheet
$row = 1;
foreach ($data as $rowData) {
    $col = 1;
    foreach ($rowData as $cellData) {
        $sheet->setCellValueByColumnAndRow($col, $row, $cellData);
        $col++;
    }
    $row++;
}

// Create an Excel writer and save it to a temporary file
$writer = new Xlsx($spreadsheet);
$filename = tempnam(sys_get_temp_dir(), 'exported_data_');
$writer->save($filename);

// Send the Excel file to the client
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="exported_data.xlsx"');
readfile($filename);

// Delete the temporary file
unlink($filename);
