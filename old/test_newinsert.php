<?php
include("sql_exe.php");
include("connect_sql.php");

function nameFile($fileToUpload, $autoIncrementValue)
{
    $filename = pathinfo($fileToUpload["name"], PATHINFO_FILENAME); // name.jpg => name
    $extension = strtolower(pathinfo($fileToUpload["name"], PATHINFO_EXTENSION)); // name.jpg => name
    $filename_db = $filename . "_" . $autoIncrementValue . "." . $extension;
    return $filename_db;
}

function uploadFile($fileToUpload, $targetDir, $autoIncrementValue)
{
    $filename = pathinfo($fileToUpload["name"], PATHINFO_FILENAME); // name.jpg => name
    $extension = strtolower(pathinfo($fileToUpload["name"], PATHINFO_EXTENSION)); // name.jpg => name
    $targetFile = $targetDir . $filename . "_" . $autoIncrementValue . "." . $extension;

    $messageupload = '';
    $uploadOk = 1;
    if (file_exists($targetFile)) {
        $messageupload = "file already exists.";
        $uploadOk = 0;
    }

    if ($fileToUpload["size"] > 500000 && $uploadOk == 1) {
        $messageupload = "your file is too large.";
        $uploadOk = 0;
    }

    if (
        $extension != "jpg" && $extension != "png" && $extension != "jpeg"
        && $extension != "gif" && $uploadOk == 1
    ) {
        $messageupload = "only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $messageupload = "Sorry, your file was not uploaded." . " Because " . $messageupload;
    } else {
        if (move_uploaded_file($fileToUpload["tmp_name"], $targetFile)) {
            $messageupload = "The file " . htmlspecialchars(basename($fileToUpload["name"])) . " has been uploaded.";
        } else {
            $messageupload = "Sorry, there was an error uploading your file.";
        }
    }
    return $messageupload;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        //////////////////////////////////////////////////  VALUE  ////////////////////////////////////////////////////
        /// data single ///
        $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
        $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';
        $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
        $runnigitem = isset($_POST['runnigitem']) ? $_POST['runnigitem'] : '';
        /// data array ///
        $paramhdJson = isset($_POST['paramhd']) ? $_POST['paramhd'] : null;
        $paramhd = json_decode($paramhdJson, true);


        /// data setting ///
        $targetDir = "uploads/";
        $messageupload = '';
        $filename_db = '';
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////  CONDITION  ////////////////////////////////////////////////////
        if ($condition == "IHD") {
            $sqlhd = sqlmixexe($queryIdHD, $paramhd);
        } else {
            $sqlhd = sqlexec($queryIdHD);
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////  SQL INSERT ///////////////////////////////////////////////////
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $pdo->beginTransaction();
        /////////  AUTO INCREMENT /////////
        $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'SAN' AND TABLE_NAME = 'equipment'"; // SERVER
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $autoIncrementValue = $row['AUTO_INCREMENT'];

        /////////  GET NAME /////////
        if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
            $filename_db = nameFile($_FILES["fileToUpload"], $autoIncrementValue);
        } elseif (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_NO_FILE) {
            $filename_db = "";
        } else {
            $filename_db = "";
        }
        //////////////////////////////

        /////////  EXCUTE  /////////
        $itemrunnig = "66/" . sprintf("%04d", $autoIncrementValue);
        $stmt = $pdo->prepare($sqlhd);
        $stmt->bindParam(':ID', $itemrunnig);
        $stmt->bindParam(':UPLOAD', $filename_db);
        // $stmt->bindParam(':DOCNO', $docno);
        // if ($runnigitem == "0001") {
        //     $stmt->bindParam(':ID', $itemrunnig);
        // } else {
        //     $stmt->bindParam(':DOCNO', $docno);
        // }
        $stmt->execute();
        /////////////
        // $stmt = true;
        if ($stmt) {
            /////// UPLOAD ///////
            if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
                $messageupload = uploadFile($_FILES["fileToUpload"], $targetDir, $autoIncrementValue);
            } elseif (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_NO_FILE) {
                $messageupload = "No file was uploaded.";
            } else {
                $messageupload = "File upload error.";
            }
            ////////////////////
            $response = array(
                'status' => 'success',
                'message' => 'เพิ่มข้อมูลสำเร็จ',
                // 'pass' => 'pass',
                // 'itemrunnig' => $itemrunnig,
                // 'queryIdHD' => $queryIdHD,
                // 'queryIdDT' => $queryIdDT,
                // 'paramhd' => $paramhd,
                // 'filename_db' => $filename_db,
                // 'messageupload' => $messageupload
            );
            $pdo->commit();
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
            'message' => 'เกิดปัญหาในการเพิ่มข้อมูล: ' . $e->getMessage()
        );
        echo json_encode($response);
    }
}
