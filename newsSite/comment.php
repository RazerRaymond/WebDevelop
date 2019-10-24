<?php
    session_start();
    require 'database.php';
    
    if(isset($_GET['comment'])){
        //Assign variables 
        $comment=$_GET['comment'];
        $post_id=$_GET['post_id'];
        $user_id=$_SESSION['user_id'];

        //Store the entered value into databses
        $stmt = $mysqli->prepare("insert into comments (comment,user,username,post) values (?,?,?,?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            //Back to post button
            $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$post_id.'"'.' />'.'Back To Post'.'</button>'.
            '</form>';
            echo $viewButton;
            exit;
        }

        $stmt->bind_param('sisi', $comment, $user_id, $_SESSION['userLogged'],$post_id);

        $stmt->execute();

        $stmt->close();

        //Store the entered value into databses
        $stmt2 = $mysqli->prepare("update posts set commentsCnt=commentsCnt+1 where id=?");
        // Bind the parameter
        $stmt2->bind_param('i', $post_id);

        //Print error message if failed
        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        //Print the posts as news
        $stmt2->execute();
        $stmt2->close();
        //Success Msg
        echo "Commented successfully!";
        //Back to post button
        $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$post_id.'"'.' />'.'Back To Post'.'</button>'.
        '</form>';
        echo $viewButton;
    } else {
        //Err Msg
        echo "Comment cannot be empty!";
        //Back to post button
        $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$post_id.'"'.' />'.'Back To Post'.'</button>'.
        '</form>';
        echo $viewButton;
    }

?>