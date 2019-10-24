<?php 
    session_start();
    require 'database.php';
    $post_id=$_POST['Disable'];
    $disabled=TRUE;
    //Store the entered value into databses
    $stmt3 = $mysqli->prepare("update posts set disable_comment=? where id=?");
    // Bind the parameter
    $stmt3->bind_param('ii', $disabled, $post_id);

    //Print error message if failed
    if(!$stmt3){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt3->execute();
    $stmt3->close();

    //Success Msg
    echo "Comment disabled successfully!";
    //Back to post button
    $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$post_id.'"'.' />'.'Back To Post'.'</button>'.
    '</form>';
    echo $viewButton; 
?>