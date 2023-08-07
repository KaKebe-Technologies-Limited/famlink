<?php
    require("../config.php");
    $db = new Database();
    $con = $db->getConnString();

    $role = $_POST["role"];
    $user_id = $_POST["user_id"];

    $sql = "UPDATE users SET userRole=$role WHERE user_id=$user_id";

    if (mysqli_query($con, $sql)) {
        echo "success";
      } else {
        echo "something went wrong";
      }
      
      mysqli_close($con);
?>