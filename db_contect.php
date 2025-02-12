<?php

 $sdn = "mysql:host=localhost;dbname=resturent_db;charset=utf8mb4"; //this is the source sdn ti search for the connection or we can call it data source name
 $user = "root"; // user name
 $pass = ""; // password


try {
    $con = new PDO($sdn,$user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "connected ok";
} catch (PDOException $error) {
    echo "field " . $error->getMessage();
}

?>