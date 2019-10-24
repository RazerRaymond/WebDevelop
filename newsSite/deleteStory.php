<?php
    session_start();
    require 'database.php';
    $post_id=$_POST['Delete'];

    //Select data from the database
    $stmt2 = $mysqli->prepare("delete from comments where post=?");

    // Bind the parameter
    $stmt2->bind_param('i', $post_id);

    //Print error message if failed
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Find the username
    $stmt2->execute();
    $stmt2->close();

    //Select data from the database
    $stmt = $mysqli->prepare("delete from posts where id=?");

    // Bind the parameter
    $stmt->bind_param('i', $post_id);

    //Print error message if failed
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    $stmt->close();

    //Msg
    echo "Story deleted";
    //Back home button
    echo '<form action="homepage.php">
    <input type="submit" value="Back To Home Page" />
    </form>'
?>
