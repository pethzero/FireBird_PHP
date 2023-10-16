<?php
class DatabaseFirdBird {

    private $host = '192.168.1.28';
    private $db_name = 'SAN';
    private $username = 'SYSDBA'; // ใช้ชื่อผู้ใช้ SYSDBA
    private $password = 'masterkey'; // ใช้รหัสผ่าน masterkey
    private $charset = 'NONE'; // ใช้ CHARSET เป็น NONE
    private $conn;
    public $message_log;

    public function connect() {
        $this->conn = null;
        try {
            $dsn = "firebird:dbname={$this->host}:{$this->db_name};charset={$this->charset}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false); // ปิด Auto Commit
            $this->message_log = 'Connection success FireBird';
        } catch (PDOException $e) {
            $this->message_log = "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}

$dbFireBird = new DatabaseFirdBird();
$dbFireBird->connect();
echo $dbFireBird->message_log;


?>
