<?php
    session_start();
    //Determine which delete button is pressed
    $fileToDelete = $_POST['Delete'];
    //The path of the file to be deleted
    $deletePath = "/home/zxun/uploads/".$_SESSION['userLogged']."/".$fileToDelete;
    if(isset($_POST['Delete'])){
        if (!unlink($deletePath)) {
            echo ("Error deleting $fileToDelete");
          } else {
            echo ("Deleted $fileToDelete");
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