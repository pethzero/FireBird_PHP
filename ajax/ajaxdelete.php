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


        $targetDir = "../uploads/";
        $messageupload = '';
        $filename_db = '';
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////  CONDITION  ////////////////////////////////////////////////////
        $sqlhd = sqlmixexe($queryIdHD, $paramhd);
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////  SQL INSERT ///////////////////////////////////////////////////
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $pdo->beginTransaction();
      
        $stmt = $pdo->prepare($sqlhd);


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
