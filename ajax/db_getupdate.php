<?php

include("sql.php");
include("bpdata.php");
include("crud_zen.php");

try {
    $id = 'superadmin';
    // $new_password = '1234'; // รหัสผ่านใหม่
    // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // echo $hashed_password;

    // Store the string into variable 
    $password = '1234';

    // Use password_hash() function to 
    // create a password hash 
    // $hash_default_salt = password_hash($password, PASSWORD_DEFAULT); 

    // $hash_variable_salt = password_hash($password, PASSWORD_DEFAULT, array('cost' => 12)); 

    // echo $hash_default_salt . "<br>";

    // echo $hash_variable_salt . "<br>";

    // // Use password_verify() function to 
    // // verify the password matches 
    // echo "Password Verify :". password_verify('1234', $hash_default_salt ) . "<br>"; 

    // echo "Password Verify :".password_verify('1234', $hash_variable_salt ) . "<br>"; 

    // echo "Password Verify :".password_verify('4657', $hash_default_salt ) . "<br>"; 

    $sqlQueries = new SQLQueries();
    $sqlQuery = $sqlQueries->scanSQL("DEV001254");
    $config_setting = database_config('mysqlserver');
    $selectData = new CRUDDATA(...$config_setting);
    $selectData->data_commit->beginTransaction();  // เริ่ม Transaction ดึงมาจาก class InsertData
    $result = $selectData->SelectRecordCondition(null, $sqlQuery, "0000"); // ส่งค่า $message_db มาด้วย
    if ($result['status'] !== false) {

        // echo json_encode($result['result']);
        // // วนลูปแปลง key
        // echo '<br>';
        // foreach ($result['result'] as &$item) {
        //     $item['id'] = $item['ID']; // เปลี่ยน key 'ID' เป็น 'id'
        //     $item['recno'] = $item['RECNO']; // เปลี่ยน key 'RECNO' เป็น 'recno'
        //     unset($item['ID']); // ลบ key 'ID'
        //     unset($item['RECNO']); // ลบ key 'RECNO'
        // }
        // // แปลงเป็น JSON และแสดงผล
      
        foreach ($result['result']  as &$item) {
            // เปลี่ยนค่าของฟิลด์ Pass ในแต่ละข้อมูล
            $item['pass'] = password_hash($item['pass'], PASSWORD_DEFAULT, array('cost' => 9));
        }
        echo json_encode($result['result'] ) . '<br>';
    } else {
        echo $result;
        $selectData->data_commit->rollBack();
    }

    // $update = $selectData->updateRecordMultiple($result['result'] , "UPDATE empl SET pass=:pass  WHERE id=:id","DEV14893"); // ส่งค่า $message_db มาด้วย
    // if ($update !== false) {
    //     echo "Update True";
    // }
    // else{
    //     echo "false";
    //     $selectData->data_commit->rollBack();
    // }
    $selectData->data_commit->commit();
} catch (Exception $e) {
    $response = array(
        'status' => 'error',
        'message' => $e->getMessage(),
        'condition' =>  ''
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
// }