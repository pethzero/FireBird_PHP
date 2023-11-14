<?php

class ConfigDataBaseEnv {
    private $engine;
    private $host;
    private $db_name;
    private $username;
    private $password;

    public function getConfig($type) {
        // ตรวจสอบ $type เพื่อกำหนดค่าต่าง ๆ ของฐานข้อมูล
        if ($type === 'sql') {
            $this->engine = 'mysql';
            $this->host = 'localhost';
            $this->db_name = 'SAN';
            $this->username = 'root';
            $this->password = '1234';
        } else {
            // สามารถเพิ่มเงื่อนไขสำหรับชนิดอื่น ๆ ของฐานข้อมูลได้ตามต้องการ
        }

        return [
            'engine' => $this->engine,
            'host' => $this->host,
            'db_name' => $this->db_name,
            'username' => $this->username,
            'password' => $this->password
        ];
    }
}

// ใช้ class ConfigDataBaseEnv เพื่อกำหนดค่าของฐานข้อมูล
$type = 'sql'; // สามารถเปลี่ยนค่านี้ตามที่ต้องการ
$config = new ConfigDataBaseEnv();
$databaseConfig = $config->getConfig($type);

// เข้าถึงค่าของฐานข้อมูล
echo "Engine: " . $databaseConfig['engine'] . "<br>";
echo "Host: " . $databaseConfig['host'] . "<br>";
echo "Database Name: " . $databaseConfig['db_name'] . "<br>";
echo "Username: " . $databaseConfig['username'] . "<br>";
echo "Password: " . $databaseConfig['password'] . "<br>";


?>