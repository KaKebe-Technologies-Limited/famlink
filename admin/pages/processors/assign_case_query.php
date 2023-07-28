<?php
    include("../../config.php");

    $db = new Database();
    $con = $db->getConnString();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $user_id = mysqli_real_escape_string($con, $_POST['staff_id']);
        $case_id = mysqli_real_escape_string($con, $_POST['case_id']);
        $status_id = mysqli_real_escape_string($con, $_POST['order_status']);

        $sql = "UPDATE cases set assigned_to = ? where id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii",$user_id,$case_id);

        if($stmt->execute()){
            echo json_encode("success");
            header('location:../cases.php');
            exit;
        }else{
            echo json_encode("Failured");
            header('location:../case_detail.php?id='.$case_id);
            
        }

        $stmt->close();
        $con->close();
    }


    
?>