<?php
    session_start();
    // check if the logout is set 
    if(isset($_GET["logout"])){
        // remove the session and redirect to login page
        session_destroy();
        header("Location: ../pages/Login.php");
        exit();
    }
?>