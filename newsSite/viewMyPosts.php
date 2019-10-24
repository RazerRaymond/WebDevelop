<?php
    session_start();
    require 'database.php';
    //Select data from the database
    $stmt = $mysqli->prepare("select title, post, date, id from posts where user=?");

    //Print error message if failed
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //bind the user id
    $stmt->bind_param('i',$_SESSION['user_id']);
    //Print the posts as news
    $stmt->execute();

    $stmt->bind_result($title, $post, $date, $id);

    echo "<ul>\n";
    while($stmt->fetch()){
        echo "<p class=\"subtitlehome\">".$title."</p>";;
        echo $date;
        $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$id.'"'.' />'.'View'.'</button>'.
        '</form>';
        echo $viewButton;
        echo "<br>";
    }
    echo "</ul>\n";

    //Close stmt
    $stmt->close();

    echo '<form action="post.html" method="POST" enctype="multipart/form-data">
            <input type="submit" value="Post A New Story" name="post">
            </form>';
    //Back home button
    echo '<form action="homepage.php" method="POST">
    <input type="submit" value="Back To Home Page" />
    </form>';
?>