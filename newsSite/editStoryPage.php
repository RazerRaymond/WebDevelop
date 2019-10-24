<?php
    session_start();
    require 'database.php';
    $post_id=$_POST['Edit'];

    //Select data from the database
    $stmt = $mysqli->prepare("select title, post from posts where id=?");

    // Bind the parameter
    $stmt->bind_param('i', $post_id);

    //Print error message if failed
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Print the posts as news
    $stmt->execute();

    $stmt->bind_result($title, $post);
    $stmt->fetch();

    //Form for editing
    echo '<form action="editStory.php" method="GET" enctype="multipart/form-data">
        <div class="post">
            <label for=\'newStory\'><b>New Story</b></label>
            <br>
            Title:
            <input class = \'input\' id = \'newTitle\' type="text" name=\'newTitle\' value="'.$title.'"required><br>
            Story:
            <textarea row ="500" col="700" name="newStory">'.$post.'</textarea>
            <button class = \'input\' type="submit" name="post_id" value="'.$post_id.'">Submit</button>
        </div>
        </form>';

    //Back to post button
    $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$post_id.'"'.' />'.'Back To Post'.'</button>'.
    '</form>';
    echo $viewButton;
?>