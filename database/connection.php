<?php

$host = "localhost";
$uname = "root";
$upassword = "";

$db_name = "db_connection";
$connection =  mysqli_connect($host, $uname, $upassword, $db_name);

    if(!$connection){
        echo "Connection Failed";
    }

?>