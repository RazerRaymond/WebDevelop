<?php
    session_start();
    //Instances
    $userFile = "/home/zxun/Encrypted/Users.txt";
    $isExisted = false;
    //Check if there's a new name entered
    if(isset($_GET['newUser'])){
        //Check if the format is desired
        if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_GET['newUser'])){
            //See if the user is registered
            for($i = 0; $i < count($_SESSION['users']); $i++){
                //$newUser = filter_var($users[$i], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                $oldUser = trim($_SESSION['users'][$i]);//trim the white space
                //echo $newUser;
                if(strcmp($_GET['newUser'],$oldUser)==0){
                    $isExisted = TRUE;
                    break;
                }
            }
            if(!$isExisted){
                //Assign the new user name
                $newUser = $_GET['newUser'];
                $_SESSION['newUser']=$newUser;

                //Edit the User.txt file
                $fh = fopen($userFile,'a+');
                fwrite($fh,$newUser.PHP_EOL);
                fclose($fh);
                echo "Register success!";

                //Make the directory on server
                mkdir("/home/zxun/uploads/".$newUser);
                chmod("/home/zxun/uploads/".$newUser,0777);

                //Back home button
                echo '<form action="login.html">
                    <input type="submit" value="Back To Home Page" />
                    </form>';
            } else {
                //Err msg
                echo "Username has already been created, choose another one!";
                echo '<form action="login.html">
                    <input type="submit" value="Back To Home Page" />
                    </form>';
            }
        } else {
            //Error msg
            echo "Username must not inclulde special characters!";
            echo '<form action="login.html">
                <input type="submit" value="Back To Home Page" />
                </form>';
        }
    } else {
        //Error msg
        echo "Enter a name!";
        echo '<form action="login.html">
                <input type="submit" value="Back To Home Page" />
                </form>';
    }
?>