<?php
class Database {

    private $engine = 'mysql';
    private $host = 'localhost';
    private $db_name = 'SAN';
    private $username = 'root';
    private $password = '1234';
    private $conn;
    public $message_log;
    public function connect() {
        $this->conn = null;

        try {

            $this->conn = new PDO("$this->engine:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            // $this->conn = new PDO("$this->engine:host=$this->host;dbname=$this->db_name;charset=NONE", $this->username, $this->password);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this-> message_log = 'Connection success';
        } catch (PDOException $e) {
            // echo "Connection failed: " . $e->getMessage();
            $this-> message_log = "Connection failed: " . $e->getMessage(); // เก็บข้อความ error ในตัวแปร error_message
        }

        return $this->conn;
    }
}
?>
