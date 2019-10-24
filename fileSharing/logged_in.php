<?php
    //Display the logged user's name
    session_start();
    echo $_SESSION['userLogged']."'s Files:";
    echo "<br>";
    //Display the user's files
    $dir = $_SESSION['fileStream'];
    // Open a directory, and read its contents
    if (is_dir($dir)){
        if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
                if(strcmp($file,".") !== 0 && strcmp($file,"..") !==0){
                    //Set the buttion with associated file name
                    $deleteButton = '<form action="deleteFile.php" method="POST">'.'<button name="Delete"'.'type="submit" value="'.$file.'"'.' />'.'Delete'.'</button>'.
                            '</form>';
                    $viewButton = '<form action="viewFile.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$file.'"'.' />'.'View'.'</button>'.
                    '</form>';
                    echo "File Name:" . $file . $viewButton . $deleteButton . "<br>";
                }
            }
        closedir($dh);
        }
    }
    $files = glob('/home/zxun/public_html/module2_group/temp/*'); //get all file names
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //delete file
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Logged In Page</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- The upload form -->
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            Select file to upload:
            <input type="file" name="uploadedFile" id="uploadedFile">
            <input type="submit" value="Upload File" name="submit">
        </form>
        <!-- The log out form -->
        <form action="logout.php" method="POST" enctype="multipart/form-data">
            <input type="submit" value="logout" name="logout">
        </form>
    </body>
</html>