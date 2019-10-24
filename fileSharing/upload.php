<?php
    session_start();
    if(isset($_POST['submit'])){
        $file = $_FILES['uploadedFile'];
        $fileStream = array();
        // get details of the uploaded file
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileError = $_FILES['uploadedFile']['error'];
        
        //Get the extension of the file
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        //Identify the user
        if(isset($_SESSION['userLogged'])){
            $userLogged = $_SESSION['userLogged'];
        }
        
        //Specify limits
        $allowed = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc','docx','java','pdf');
        $fileSizeLimit = 1000000;
        if(in_array($fileExtension,$allowed)){
            if($fileError === 0){
                if ($fileSize < $fileSizeLimit){
                    $fileDestination = '/home/zxun/uploads/'.$userLogged.'/'.$fileName;
                    move_uploaded_file($fileTmpPath,$fileDestination);
                    echo "Upload Success!";
                } else {
                    echo "Your file is too big!";
                }
            } else {
                echo "There was an error uplodaing your file!";
            }

        } else {
            echo "You cannot uploade files of this type!";
        }
    }
?>
<!--Create a go back button-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Go Back Button</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form action="logged_in.php">
            <input type="submit" value="Back To Home Page" />
        </form>
    </body>
</html>