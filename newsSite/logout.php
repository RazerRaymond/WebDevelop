<?php
    require 'database.php';
    session_start();
    // remove all session variables
    unset($_SESSION);

    // destroy the session
    session_destroy();
    session_write_close();

    //Back to the login page
    header("Location: homepage.php");
    die;

?>