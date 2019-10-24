<?php
    session_start();
    $filename = $_POST['View'];
    copy("/home/zxun/uploads/".$_SESSION["userLogged"]."/".$filename,"/home/zxun/public_html/module2_group/temp/".$filename);

    //Determine the path for the file
    $full_path="/home/zxun/public_html/module2_group/temp/".$filename;
    //Extract the extension
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($full_path);
    header("Content-Type: ".$mime);
    //Read file
    readfile($full_path);
?>