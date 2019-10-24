<?php
    session_start();
    require 'database.php';

    //Get the information entered
    $username = $_GET['username'];
    $password = $_GET['password'];
    $nameExists=false;

    //Hash the password
    $hashed_psw = password_hash($password, PASSWORD_DEFAULT);

    //Select data from the database
    $stmt1 = $mysqli->prepare("select name from users");

    //Print error message if failed
    if(!$stmt1){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    //Check if the user exists
    $stmt1->execute();

    $stmt1->bind_result($existedNames);

    while($stmt1->fetch()){
        if($username==$existedNames){
            echo "Name Existed!";
            //Back to register button
            echo '<form action="register.html">
            <input type="submit" value="Back To Register Page" />
            </form>';
            $nameExists=true;
        }
    }
    echo "</ul>\n";

    if(!$nameExists){
        //Close stmt
        $stmt1->close();

        //Store the entered value into databses
        $stmt = $mysqli->prepare("insert into users (name, hashed_psw) values (?, ?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('ss', $username, $hashed_psw);

        $stmt->execute();

        $stmt->close();

        echo "Register Success!";
        //Back to register button
        echo '<form action="login.html">
        <input type="submit" value="Log In" />
        </form>';
    }

    
    
?>