<?php
$host = 'localhost';
$db_name = 'SAN';
$username = 'root';
$password = '1234';

$empno = '0001';
$group = 'account';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$sql = "SELECT PERMISSON FROM userpermissions WHERE EMPNO =:EMPNO AND NAMEP = :NAMEP";

$query = $pdo->prepare($sql);
// ผูกค่าพารามิเตอร์
$query->bindParam(':EMPNO', $empno, PDO::PARAM_STR);
$query->bindParam(':NAMEP', $group, PDO::PARAM_STR);
$query->execute();

// Fetch the result
$result = $query->fetch(PDO::FETCH_ASSOC);

// Check if the result exists and if PERMISSON is not equal to 'T'
if ($result && $result['PERMISSON'] !== 'T') {
    echo 'YES';
    // Do something if the condition is true
} else {
    echo 'WOW';
    // Do something else if the condition is false
}

?>
