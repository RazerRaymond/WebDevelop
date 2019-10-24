<?php
    session_start();
    require 'database.php';
    $comment_id=$_POST['Edit'];

    //Select data from the database
    $stmt = $mysqli->prepare("select comment from comments where id=?");

    // Bind the parameter
    $stmt->bind_param('i', $comment_id);

    //Print error message if failed
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Print the posts as news
    $stmt->execute();

    $stmt->bind_result($comment);
    $stmt->fetch();

    echo '<form action="editComment.php" method="GET" enctype="multipart/form-data">
        <div class="post">
            <label for=\'newComment\'><b>New Story</b></label>
            <br>
            Comment:
            <textarea row ="500" col="700" name="newComment">'.$comment.'</textarea>
            <button class = \'input\' type="submit" name="comment_id" value="'.$comment_id.'">Submit</button>
        </div>
        </form>';

    //Back to post button
    $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$comment_id.'"'.' />'.'Back To Post'.'</button>'.
    '</form>';
    echo $viewButton;
?>