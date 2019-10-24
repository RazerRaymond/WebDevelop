<?php
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();

    //Back to the login page
    header("Location: login.html");
?>