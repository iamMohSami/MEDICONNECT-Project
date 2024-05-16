<?php

    $database= new mysqli("localhost","root","","mediconnect");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>



