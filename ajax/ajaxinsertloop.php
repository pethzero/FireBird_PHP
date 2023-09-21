<?php
include("../connect_sql.php");
include("../sql_exe.php");

class FileUploader
{
    private $pdo;
    private $targetDir;

    public function __construct($pdo, $targetDir)
    {
        $this->pdo = $pdo;
        $this->targetDir = $targetDir;
    }

    public function uploadFile($fileToUpload, $autoIncrementValue, $uploadnamedb)
    {
        // Implement your uploadFile function here
    }

    public function insertData($queryIdHD, $paramhd, $condition, $uploadnamedb, $fileToUpload)
    {
        // Implement your insertData function here
    }

    private function nameFile($fileToUpload, $autoIncrementValue, $uploadnamedb)
    {
        // Implement your nameFile function here
    }

    private function checkValue($checkvalue, $checkname, $paramhd)
    {
        // Implement your checkValue function here
    }

    // Add other helper methods as needed
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = new PDO("..."); // Initialize your database connection here
        $targetDir = "../uploads/";
        
        $fileUploader = new FileUploader($pdo, $targetDir);

        // Extract and validate POST data as needed

        $fileUploader->insertData($queryIdHD, $paramhd, $condition, $uploadnamedb, $_FILES["fileToUpload"]);
    } catch (PDOException $e) {
        // Handle database errors here
    }
}
?>
