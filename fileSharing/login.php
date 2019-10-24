<?php
    session_start();
    //Instance variable
    $users = file("/home/zxun/Encrypted/Users.txt");
    $_SESSION['users'] = $users;
    $isAUser = FALSE;

    //Check is there's a name entered
    if(isset($_GET['uname'])){
        $userToLog = $_GET['uname'];
        //echo $userToLog;
        //See if the user is registered
        for($i = 0; $i < count($users); $i++){
            //$newUser = filter_var($users[$i], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $newUser = trim($users[$i]);//trim the white space
            //echo $newUser;
            if(strcmp($userToLog,$newUser)==0){
                $isAUser = TRUE;
                break;
            }
        }
        //If login successfully
        if($isAUser){
            //Identify the user
            $_SESSION['userLogged'] = $userToLog;
            $directory = "/home/zxun/uploads/".$userToLog."/";
            $_SESSION['fileStream'] = $directory;
            //Redirect to the logged in page
            header("Location: logged_in.php");
        } else {
            //Show error otherwise
            echo "You are not registered!";
        }
    } else {
        //If the field was left empty
        echo "Enter a name!";
    }
?>