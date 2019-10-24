<?php
    session_start();
    require 'database.php';
    $comment_id=$_POST['Delete'];

    //Select data from the database
    $stmt2 = $mysqli->prepare("select post from comments where id=?");

    // Bind the parameter
    $stmt2->bind_param('i', $comment_id);

    //Print error message if failed
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Find the username
    $stmt2->execute();
    $stmt2->bind_result($post_id);
    $stmt2->fetch();
    $stmt2->close();
    
    //Store the entered value into databses
    $stmt3 = $mysqli->prepare("update posts set commentsCnt=commentsCnt-1 where id=?");
    // Bind the parameter
    $stmt3->bind_param('i', $post_id);

    //Print error message if failed
    if(!$stmt3){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt3->execute();
    $stmt3->close();

    //Select data from the database
    $stmt = $mysqli->prepare("delete from comments where id=?");

    // Bind the parameter
    $stmt->bind_param('i', $comment_id);

    //Print error message if failed
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    $stmt->close();

    //Msg
    echo "Comments deleted";
    //Back to post button
    $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$post_id.'"'.' />'.'Back To Post'.'</button>'.
    '</form>';
    echo $viewButton; 
?>