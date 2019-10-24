<?php
    session_start();
    require 'database.php';
    //Check if there's inputs
    if(isset($_GET['story']) && isset($_GET['posttitle'])){
        //Assign variables 
        $story=$_GET['story'];
        $title=$_GET['posttitle'];
        $user_id=$_SESSION['user_id'];
        $userLogged=$_SESSION['userLogged'];

        //Store the entered value into databses
        $stmt = $mysqli->prepare("insert into posts (title,post,user,user_name) values (?,?,?,?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('ssis', $title, $story, $user_id, $userLogged);
        $stmt->execute();
        $stmt->close();
        //Success Msg
        echo "Story added successfully!";
        //Back home button
        echo '<form action="homepage.php">
        <input type="submit" value="Back To Home Page" />
        </form>';
    } else {
        echo "Story and Title cannot be empty!";
        //Back home button
        echo '<form action="homepage.php">
        <input type="submit" value="Back To Home Page" />
        </form>';
    }

?>