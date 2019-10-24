<?php
    session_start();
    // This is a *good* example of how you can implement password-based user authentication in your web application.

    require 'database.php';

    // Use a prepared statement
    $stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_psw FROM users WHERE name=?");

    // Bind the parameter
    $user = $_GET['uname'];
    $stmt->bind_param('s', $user);
    $stmt->execute();

    // Bind the results
    $stmt->bind_result($cnt, $user_id, $pwd_hash);
    $stmt->fetch();
    
    $pwd_guess = $_GET['password'];
    // Compare the submitted password to the actual password hash

    if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
        // Login succeeded!
        $_SESSION['user_id'] = $user_id;
        $_SESSION['userLogged'] = $_GET['uname'];
        // Redirect to your target page
        header("Location: homepage.php");
        $stmt->close();
    } else{
        // Login failed; redirect back to the login screen
        echo "Log In failed, please check your credentials";
        //Back home button
        echo '<form action="homepage.php" method="POST">
        <input type="submit" value="Back To Home Page" />
        <input type="hidden" name="token" value="<?php echo $_SESSION[\'token\'];?>" />
        </form>';
        $stmt->close();
    }
?>