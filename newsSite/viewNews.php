
<?php
    session_start();
    require 'database.php';
    $id = $_POST['View'];
    if(isset($_SESSION['userLogged'])){
        echo "User: ".$_SESSION['userLogged'];
    }
    //Select data from the database
    $stmt = $mysqli->prepare("select title, post, date, user, id, commentsCnt, disable_comment from posts where id=?");

    // Bind the parameter
    $stmt->bind_param('i', $id);

    //Print error message if failed
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Print the posts as news
    $stmt->execute();

    $stmt->bind_result($title, $post, $date, $postOwner, $post_id, $commentCnt, $disable_comment);
    $stmt->fetch();

    $_SESSION['disable_comment']=$disable_comment;

    echo "<ul>\n";
    echo "<p class=\"title\">".$title."</p>";
    echo "<p class=\"content\">".$post."</p><br>";
    echo "<p class=\"date\">Date Published: ".$date."</p>";

    $stmt->close();

    //Select data from the database
    $stmt2 = $mysqli->prepare("select name from users where id=?");

    // Bind the parameter
    $stmt2->bind_param('i', $postOwner);

    //Print error message if failed
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Find the username
    $stmt2->execute();
    $stmt2->bind_result($postOwnerName);
    $stmt2->fetch();
    $stmt2->close();

    echo "<p class=\"date\">Owner: ".$postOwnerName."</p>";
    //Check if there's comment
    if($commentCnt!=0){
        //Select data from the database
        $stmt3 = $mysqli->prepare("select comment, username, id from comments where post=?");

        // Bind the parameter
        $stmt3->bind_param('i', $id);

        //Print error message if failed
        if(!$stmt3){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        //Find the username
        $stmt3->execute();
        $stmt3->bind_result($comment,$commentOwnerName, $comment_id);

        //See Comment
        echo "<p class=\"subtitle\">Comments: </P>";
        while($stmt3->fetch()){
            //Show the comment and its creator
            echo "<p class=\"comment\">".$comment." Post by: ".$commentOwnerName."</p>";
            if(isset($_SESSION['userLogged'])){
                if($_SESSION['userLogged']==$commentOwnerName){
                    $deleteButton = '<form action="deleteComment.php" method="POST">'.'<button name="Delete"'.'type="submit" value="'.$comment_id.'"'.' />'.'Delete Your Comment'.'</button>'.
                                '<input type="hidden" name="token" value="<?php echo $_SESSION[\'token\'];?>" /></form>';
                    echo $deleteButton;
                    $editButton = '<form action="editCommentPage.php" method="POST">'.'<button name="Edit"'.'type="submit" value="'.$comment_id.'"'.' />'.'Edit Your Comment'.'</button>'.
                                '<input type="hidden" name="token" value="<?php echo $_SESSION[\'token\'];?>" /></form>';
                    echo $editButton;
                }
            }
        }
        
        $stmt3->close();
    } else {
        //See Comment
        echo "<p class=\"comment\">Comments: </P>";
        echo "No Comment Yet!";
    }
    
    //A disable comment button
    if(isset($_SESSION['user_id']) && !$_SESSION['disable_comment']){
        if($postOwner==$_SESSION['user_id']){
            $disableCommentButton = '<form action="disableComment.php" method="POST">'.'<button name="Disable"'.'type="submit" value="'.$post_id.'"'.' />'.'Disable Comment'.'</button>'.
                            '<input type="hidden" name="token" value="<?php echo $_SESSION[\'token\'];?>" /></form>';
            echo $disableCommentButton;
        }
    } else {
        if($postOwner==$_SESSION['user_id']){
            $disableCommentButton = '<form action="enableComment.php" method="POST">'.'<button name="Enable"'.'type="submit" value="'.$post_id.'"'.' />'.'Enable Comment'.'</button>'.
                            '<input type="hidden" name="token" value="<?php echo $_SESSION[\'token\'];?>" /></form>';
            echo $disableCommentButton;
        }
    }

    //Show delete and comment area if the user is the owner of the post
    if(isset($_SESSION['user_id'])){
        if(!$_SESSION['disable_comment']) {
            echo '<form class="textarea" action="comment.php" method="GET" enctype="multipart/form-data">
                    <textarea row ="500" col="700" name="comment"></textarea>
                    <button class = "input" type="submit" name="post_id" value="'.$id.'">Post Comment To This Story</button>
                </form>';
        } else {
            echo "Comment is disabled!";
        }
        if($postOwner==$_SESSION['user_id']){
            $deleteButton = '<form action="deleteStory.php" method="POST">'.'<button name="Delete"'.'type="submit" value="'.$post_id.'"'.' />'.'Delete Your Story'.'</button>'.
                            '<input type="hidden" name="token" value="<?php echo $_SESSION[\'token\'];?>" /></form>';
            echo $deleteButton;
            $editButton = '<form action="editStoryPage.php" method="POST">'.'<button name="Edit"'.'type="submit" value="'.$post_id.'"'.' />'.'Edit Your Story'.'</button>'.
                            '<input type="hidden" name="token" value="<?php echo $_SESSION[\'token\'];?>" /></form>';
            echo $editButton;
        }
    }
    //Back home button
    echo '<form action="homepage.php">
    <input type="submit" value="Back To Home Page" />
    </form>';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    </body>
</html>