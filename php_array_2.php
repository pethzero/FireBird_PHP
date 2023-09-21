<?php
include("sql_exe.php");
// $tableData_Json = [["name","f","ff"],["rock","fff","fff"]];

// $a_arry = (
//     'NAME' => '555'
// )

$a_arry = array(
    'name' => 'aaa'
  );

$b_arry = array(
    'name' => 'bbb'
 );

 $tableData_Json = [$a_arry,$b_arry];


 foreach ($tableData_Json as $item) {
    // $item เป็นอาร์เรย์แบบแอสโซซิเอตที่มีคีย์ 'NAME'
    $name = $item['NAME'];
    // echo "Name: $name<br>";
    // echo $item;
    $sql = sqlmixexe("TEST2",$item);
    echo $sql;
}
?>