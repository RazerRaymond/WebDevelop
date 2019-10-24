<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
</html>
<?php
    session_start();
    require 'database.php';
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    if(isset($_POST['token'])){
        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }
    }
    echo "<h1>Welcome To Russell's Tieba</h1>";
    echo "<h2>Post Your Stories and Comments By Registering and Logging In</h2>";
    if(!isset($_SESSION['userLogged'])){
        //A login button and register button
        echo '<form action="login.html" method="GET" enctype="multipart/form-data">
                <button class = \'input\' type="submit">Login</button>
            </form>
            <form action="register.html" method="GET" enctype="multipart/form-data">
                <button class = \'input\' type="submit">Register</button>
            </form></div>';
    } else {
        //Display the logged user's name
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
        echo "Welcome home: ".$_SESSION['userLogged'];
        echo "<br>";
        echo '<form action="logout.php" method="POST" enctype="multipart/form-data">
            <input type="submit" value="logout" name="logout">
            </form>';
        echo '<form action="post.html" method="POST" enctype="multipart/form-data">
            <input type="submit" value="Post New Story" name="post">
            </form>';
        echo '<form action="viewMyPosts.php" method="POST" enctype="multipart/form-data">
            <button class = \'input\' type="submit">My Posts</button>
            </form>';
    }

    //Select data from the database
    $stmt = $mysqli->prepare("select title, post, date, id, user,user_name from posts order by id DESC");

    //Print error message if failed
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Print the posts as news
    $stmt->execute();

    $stmt->bind_result($title, $post, $date, $id,$postOwner,$postOwnerName);

    echo "<ul>\n";
    while($stmt->fetch()){

        //Print out the title and date
        echo "<p class=\"subtitlehome\">".$title." <p id=\"postby\"> Post By: ".$postOwnerName."</p></p>";
        echo $date;
        $viewButton = '<form action="viewNews.php" method="POST">'.'<button name="View"'.'type="submit" value="'.$id.'"'.' />'.'View'.'</button>'.
        '</form>';
        echo $viewButton;
        echo "<br>";
    }

    //Close stmt
    $stmt->close();

?>