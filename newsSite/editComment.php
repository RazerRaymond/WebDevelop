<?php
    session_start();
    require 'database.php';
    $comment_id=$_GET['comment_id'];
    $newComment=$_GET['newComment'];
    
    //Store the entered value into databses
    $stmt3 = $mysqli->prepare("update comments set comment=? where id=?");
    // Bind the parameter
    $stmt3->bind_param('si', $newComment, $comment_id);

    //Print error message if failed
    if(!$stmt3){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt3->execute();
    $stmt3->close();

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

    //Success Msg
    echo "Comment edited successfully!";
    //Back to post button
    $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$post_id.'"'.' />'.'Back To Post'.'</button>'.
    '</form>';
    echo $viewButton; 
?>