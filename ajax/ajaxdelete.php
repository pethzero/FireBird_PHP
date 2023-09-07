<?php
  include("../connect_sql.php"); 
  include("../sql_exe.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        //////////////////////////////////////////////////  VALUE  ////////////////////////////////////////////////////
        /// data single ///
        $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
        $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
        $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
        $runnigitem = isset($_POST['runnigitem']) ? $_POST['runnigitem'] : '';
        $uploadnamedb = isset($_POST['uploadnamedb']) ? $_POST['uploadnamedb'] : '';
        /// data array ///
        $paramhdJson = isset($_POST['paramhd']) ? $_POST['paramhd'] : null;
        $paramhd = json_decode($paramhdJson, true);


        /// data setting ///
        $targetDir = "../uploads/";
        $messageupload = '';
        $filename_db = '';
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////  CONDITION  ////////////////////////////////////////////////////
        // if ($condition == "IHD") {
        //     $sqlhd = sqlmixexe($queryIdHD, $paramhd);
        // } else {
        //     $sqlhd = sqlexec($queryIdHD);
        // }
        $sqlhd = sqlmixexe($queryIdHD, $paramhd);
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////  SQL INSERT ///////////////////////////////////////////////////
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $pdo->beginTransaction();
        /////////  AUTO INCREMENT /////////
        // $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'SAN' AND TABLE_NAME = '".$uploadnamedb."'"; // SERVER
        // $stmt = $pdo->prepare($query);
        // $stmt->execute();
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // $autoIncrementValue = $row['AUTO_INCREMENT'];

        /////////  GET NAME /////////
        // if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
        //     $filename_db = nameFile($_FILES["fileToUpload"], $autoIncrementValue,$uploadnamedb);
        // } elseif (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_NO_FILE) {
        //     $filename_db = "";
        // } else {
        //     $filename_db = "";
        // }
        //////////////////////////////

        /////////  EXCUTE  /////////
        // $itemrunnig = substr( date("Y")+543, -2) .'/'. sprintf("%04d", $autoIncrementValue);
        $stmt = $pdo->prepare($sqlhd);

        // if ($condition == "IHD") {
        //     // $sqlhd = sqlmixexe($queryIdHD, $paramhd);
        //     $stmt->bindParam(':DOCNO', $itemrunnig);
        //     $stmt->bindParam(':UPLOAD', $filename_db);
        // } elseif ($condition == "I_ID" || $condition == 'I_DOC') {
        //     $stmt->bindParam(':DOCNO', $itemrunnig);  
        // } elseif ($condition == "I_IMG") {
        //     $stmt->bindParam(':IMG', $filename_db);  
        // } 
        
        $stmt->execute();
        /////////////
        // $stmt = true;
        if ($stmt) {
            /////// UPLOAD ///////
        
            ////////////////////
            $response = array(
                'status' => 'success',
                'message' => 'เพิ่มข้อมูลสำเร็จ',
                'sqlhd' =>  $sqlhd,

            );
            $pdo->commit();
            // $pdo->rollBack();
            echo json_encode($response);
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'ไม่มีการเพิ่มข้อมูล'
            );
            $pdo->rollBack();
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        $pdo->rollBack();

        // กรณีเกิดข้อผิดพลาดในการเพิ่มข้อมูล
        $response = array(
            'status' => 'error',
            'sqlhd' =>  $sqlhd,
            'message' => 'เกิดปัญหาในการเพิ่มข้อมูล: ' . $e->getMessage()
        );
        echo json_encode($response);
    }
}
