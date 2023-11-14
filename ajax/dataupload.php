<?php 
class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function uploadFile($fileToUpload)
    {
        // $filename = pathinfo($fileToUpload["name"], PATHINFO_FILENAME);
        $extension = strtolower(pathinfo($fileToUpload["name"], PATHINFO_EXTENSION));
        // // $targetFile = $this->targetDir . $uploadnamedb . "_" . $autoIncrementValue . "." . $extension;
        $targetFile = $this->targetDir . $fileToUpload["name"] ;

        $messageupload = '';
        $uploadOk = 1;

        if (file_exists($targetFile)) {
            $messageupload = "File already exists.";
            $uploadOk = 0;
        }

        if ($fileToUpload["size"] > 500000 && $uploadOk == 1) {
            $messageupload = "Your file is too large.";
            $uploadOk = 0;
        }

        if ($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif" && $uploadOk == 1) 
        {
            $messageupload = "Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $messageupload = "Sorry, your file was not uploaded. " . "Because " . $messageupload;
        } else {
            if (move_uploaded_file($fileToUpload["tmp_name"], $targetFile)) {
                $messageupload = "The file " . htmlspecialchars(basename($fileToUpload["name"])) . " has been uploaded.";
            } else {
                $messageupload = "Sorry, there was an error uploading your file.";
            }
        }
        return array('result' =>  $messageupload);
    }
}

?>