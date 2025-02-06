<?php
    $host = "localhost";
    $username = "root";
    $password = ""; 
    $db ="joomdev_db";

    $conn = new mysqli($host, $username, $password, $db);

    if($conn->connect_error) {
        print_r("connection failed". $conn->connect_error);
    }
?>