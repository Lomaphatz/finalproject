<?php

include_once 'dbConfig.php';
$statusMsg = "";

// File upload path
$targetDir= "uploads/";

if (isset($_POST['submit'])){
    if(!empty($_FILES["file"]["name"])){
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        //Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){
                $insert = $db->query("INSERT INTO images(file_name, upload_on) VALUE ('".$fileName."', NOW())");
                if ($insert){
                    $statusMsg = "The file <b>" . $fileName . "</b> has been uploaded success.";
                    header("location: index.php");
                }else{
                    $statusMsg = "File upload failed.";
                    header("location: index.php");
                }
            }else{
                $statusMsg = "Oop!, there was an error uploading your file.";
                header("location: index.php");
            }
        }else{
            $statusMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
            header("location: index.php");
        }
    }else{
        $statusMsg = "Please select a file to upload.";
        header("location: index.php");
    }
}
?>