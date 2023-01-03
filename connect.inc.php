<?php 
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sitedump1";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
        // echo "connected";
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
?>