<?php

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$caseNew = array();
$case_new_sql = "";

if($role == 3){
    $case_new_sql = mysqli_query($con, "SELECT id FROM  cases WHERE status = 1 AND assigned_to = $user_id ORDER BY `cases`.`datecreated` DESC ");
}

if($role == 2){
    $case_new_sql = mysqli_query($con, "SELECT id FROM  cases WHERE status = 1 ORDER BY `cases`.`datecreated` DESC ");
}

while ($row = mysqli_fetch_array($case_new_sql)) {

    array_push($caseNew, $row['id']);


    

}
