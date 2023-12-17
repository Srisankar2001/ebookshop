<?php
    $con = new mysqli('localhost:4306','root','','e_bookshop');
    if($con->connect_error){
        die('Connection Error:'.$con->connect_error);
    }
?>