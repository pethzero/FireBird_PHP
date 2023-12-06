<?php
include("../connect_sql.php");
include("../sql_exe.php");

function nameFile($fileToUpload, $UploadnameValue, $uploadnamedb)
{
    $filename = pathinfo($fileToUpload["name"], PATHINFO_FILENAME); // name.jpg => name
    $extension = strtolower(pathinfo($fileToUpload["name"], PATHINFO_EXTENSION)); // name.jpg => name
    // $filename_db = $filename . "_" . $UploadnameValue . "." . $extension;
    $filename_db = $uploadnamedb . "_" . $UploadnameValue . "." . $extension;
    return $filename_db;
}

function uploadFile($fileToUpload, $targetDir, $UploadnameValue, $uploadnamedb)
{
    $filename = pathinfo($fileToUpload["name"], PATHINFO_FILENAME); // name.jpg => name
    $extension = strtolower(pathinfo($fileToUpload["name"], PATHINFO_EXTENSION)); // name.jpg => name
    // $targetFile = $targetDir . $filename . "_" . $UploadnameValue . "." . $extension;
    $targetFile = $targetDir . $uploadnamedb . "_" . $UploadnameValue . "." . $extension;

    $messageupload = '';
    $uploadOk = 1;
    // if (file_exists($targetFile)) {
    //     $messageupload = "file already exists.";
    //     $uploadOk = 0;
    // }

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
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        $pdo->beginTransaction();
        //////////////////////////////////////////////////  VALUE  ////////////////////////////////////////////////////
        /// data single ///
        $queryIdHD = isset($_POST['queryIdHD']) ? $_POST['queryIdHD'] : '';
        $queryIdDT = isset($_POST['queryIdDT']) ? $_POST['queryIdDT'] : '';


        $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
        $conditionmain = isset($_POST['conditionmain']) ? $_POST['conditionmain'] : '';

        $runnigitem = isset($_POST['runnigitem']) ? $_POST['runnigitem'] : '';
        $modifycondition = isset($_POST['modifycondition']) ? $_POST['modifycondition'] : '';
        $modify = isset($_POST['modify']) ? $_POST['modify'] : '';
        $uploadnamedb = isset($_POST['uploadnamedb']) ? $_POST['uploadnamedb'] : '';
        $uploadolddb = isset($_POST['uploadolddb']) ? $_POST['uploadolddb'] : '';
        $checkvalue = isset($_POST['checkvalue']) ? $_POST['checkvalue'] : '';
        $checkoldvalue = isset($_POST['checkoldvalue']) ? $_POST['checkoldvalue'] : '';
        $checknewvalue = isset($_POST['checknewvalue']) ? $_POST['checknewvalue'] : '';
        $checkname = isset($_POST['checkname']) ? $_POST['checkname'] : '';
        $modifyIdHD = isset($_POST['modifyIdHD']) ? $_POST['modifyIdHD'] : '';

        /// data array ///
        $paramhdJson = isset($_POST['paramhd']) ? $_POST['paramhd'] : null;
        $paramhd = json_decode($paramhdJson, true);


        /// data setting ///
        $targetDir = "../uploads/";
        $messageupload = '';
        $filename_db = '';
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////  CHECK  ////////////////////////////////////////////////////
        $messageCheck = "";
        $prosscesssqlrun = "T";

        if ($checkvalue == 'T' && ($checkoldvalue != $checknewvalue)) {
            $sqlCheck = sqlmixexe($checkname, $paramhd);
            $stmtCheck  = $pdo->prepare($sqlCheck);
            $stmtCheck->execute();
            $result = $stmtCheck->fetchColumn();

            if ($result > 0) {
                // $messageCheck = "มีข้อมูล '" .  $paramhd['CUSTOMER'] . "' อยู่ในคอลัมน์ 'column1'";
                $prosscesssqlrun = 'F';
            } else {
                // $messageCheck = "ไม่มีข้อมูล '" .  $paramhd['CUSTOMER'] . "' อยู่ในคอลัมน์ 'column1'";
                $prosscesssqlrun = 'T';
            }
        }
        if ($prosscesssqlrun == 'T') {
            //////////////////////////////////////////////////  CONDITION  ////////////////////////////////////////////////////

            //////////////////////////////////////////////////  SQL UPDATE ///////////////////////////////////////////////////
            if ($modifycondition == 'draw') {
                $paramhd['REVNO'] = $paramhd['REVNO'] + 1;
            }
            $sqlhd = sqlmixexe($queryIdHD, $paramhd);
            $stmtUpdate = $pdo->prepare($sqlhd);
            if ($stmtUpdate->execute()) {

                //////////////////////////////////////////////////  SQL INSERT ///////////////////////////////////////////////////
                $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'SAN' AND TABLE_NAME = '" . $uploadnamedb . "'"; // SERVER
                $stmtAutoIncrement  = $pdo->prepare($query);
                $stmtAutoIncrement->execute();
                $row = $stmtAutoIncrement->fetch(PDO::FETCH_ASSOC);
                $autoIncrementValue = $row['AUTO_INCREMENT'];


                $itemrunnig = substr(date("Y") + 543, -2) . '/' . sprintf("%04d", $autoIncrementValue);
                $sqlmodify = sqlmixexe($modifyIdHD, $paramhd);
                $stmtInsert  = $pdo->prepare($sqlmodify);

                /////////  GET NAME /////////
                if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
                    $filename_db = nameFile($_FILES["fileToUpload"], $autoIncrementValue, $uploadnamedb);
                } elseif (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_NO_FILE) {
                    $filename_db = "";
                } else {
                    $filename_db = "";
                }
                //////////////////////////////

                //////////////////////////////////////////////////  SQL UPDATE ///////////////////////////////////////////////////
                if ($condition == "IHD") {
                    $stmtInsert->bindParam(':DOCNO', $itemrunnig);
                    $stmtInsert->bindParam(':UPLOAD', $filename_db);
                } elseif ($condition == "I_ID" || $condition == 'I_DOC') {
                    $stmtInsert->bindParam(':DOCNO', $itemrunnig);
                } elseif ($condition == "I_IMG") {
                    $stmtInsert->bindParam(':IMG', $filename_db);
                }


                if ($stmtInsert->execute()) {
                    /////// UPLOAD ///////
                    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
                        $messageupload = uploadFile($_FILES["fileToUpload"], $targetDir, $autoIncrementValue, $uploadnamedb);
                    } elseif (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_NO_FILE) {
                        $messageupload = "No file was uploaded.";
                    } else {
                        $messageupload = "File upload error.";
                    }
                    ////////////////////
                    $response = array(
                        'status' => 'success',
                        'message' => 'เพิ่มข้อมูลสำเร็จ',
                        'sqlhd' =>  $sqlhd,
                        'paramhd' =>  $paramhd,
                        // // 'itemrunnig' => $itemrunnig,
                        // 'sqlCheck' => $sqlCheck,
                        // // 'resultCheck' => $resultCheck,
                        // 'messageCheck' => $messageCheck,
                        // 'autoIncrementValue' => $autoIncrementValue,
                        // 'filename_db' => $filename_db,
                        // '$itemrunnig' => $itemrunnig
                        // // 'filename_db' => $filename_db,
                        // // 'messageupload' => $messageupload
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
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'ไม่มีการเพิ่มข้อมูล'
                );
                $pdo->rollBack();
                echo json_encode($response);
            }
            ///////// 1.AUTO INCREMENT /////////
            // $UploadnameValue = $paramhd['RECNO'];
            /////////  2.GET NAME COMMING SOON /////////
            //////////////////////////////

            ///////// 3.EXCUTE UPDATE /////////
            // $itemrunnig = "66/" . sprintf("%04d", $UploadnameValue);
            // $stmtUpdate->bindParam(':ID', $itemrunnig);


            // else {


            /////////////
            // $stmt = true;
            // if ($stmtUpdate) {
            //     /////// UPLOAD ///////
            //     // if ($modify == "T") {
            //     //     if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
            //     //         $messageupload = uploadFile($_FILES["fileToUpload"], $targetDir, $UploadnameValue, $uploadnamedb);
            //     //     } elseif (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_NO_FILE) {
            //     //         $messageupload = "No file was uploaded.";
            //     //     } else {
            //     //         $messageupload = "File upload error.";
            //     //     }
            //     // }
            //     ////////////////////
            //     $response = array(
            //         'status' => 'success',
            //         'message' => 'เพิ่มข้อมูลสำเร็จ',
            //         // 'pass' => 'pass',
            //         'modify' => $modify,
            //         'modifycondition' =>  $modifycondition,
            //         'sqlhd' => $sqlhd,

            //     );
            //     // $pdo->commit();
            //     $pdo->rollBack();
            //     echo json_encode($response);
            // } else {
            //     $response = array(
            //         'status' => 'error',
            //         'message' => 'ไม่มีการเพิ่มข้อมูล'
            //     );
            //     $pdo->rollBack();
            //     echo json_encode($response);
            // }
        } else {
            $response = array(
                'status' => 'none',
                'message' => 'มีข้อความซ้ำกัน',
                // 'sqlhd' =>  $sqlhd,
                // 'paramhd' =>  $paramhd,
                // 'messageCheck' => $messageCheck,
            );
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        $pdo->rollBack();

        // กรณีเกิดข้อผิดพลาดในการเพิ่มข้อมูล
        $response = array(
            'status' => 'error',
            'sqlhd' => $sqlhd,
            'message' => 'เกิดปัญหาในการเพิ่มข้อมูล: ' . $e->getMessage()
        );
        echo json_encode($response);
    }
}
