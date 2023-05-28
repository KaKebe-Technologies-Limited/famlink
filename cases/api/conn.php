<?php 
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databasename = "famlinkapp";
    $port_name = "3306";
    session_start();

    $con = new mysqli($hostname, $username, $password, $databasename, $port_name);
    if(!$con){
        die("Connection failed");
    }
?>