<?php 
     $hostname = "localhost";
     $username = "root";
     $password = "";
     $databasename = "famlinkapp";
     $port_name = "3306";
     
     $con = new mysqli($hostname, $username, $password, $databasename, $port_name);
     if(!$con){
        die("Connection failed");
     }
?>