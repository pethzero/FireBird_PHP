<?php
$tableData_Json = [["name","f","ff"],["rock","fff","fff"]];
$ms = '';
foreach ($tableData_Json as $row) {
    $ms .= $row[0];
}
echo $ms;
?>