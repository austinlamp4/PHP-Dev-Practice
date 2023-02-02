<?php
    //Create a connection to MySQL server:
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); //You can find PW at /xampp/phpMyAdmin/config.inc.php

    if(mysqli_connect_errno()) {
        //If the above is true, connection failed. This statement will display WHY.
        echo 'Failed to connect to MySQL.' . mysqli_connect_errno();
    }

?>