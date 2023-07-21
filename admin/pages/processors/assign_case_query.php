<?php
    include("../../config.php");

    $db = new Database();
    $con = $db->getConnString();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $user_id = mysqli_real_escape_string($con, $_POST['staff_id']);
        $case_id = mysqli_real_escape_string($con, $_POST['case_id']);
        $status_id = mysqli_real_escape_string($con, $_POST['status_id']);

        $sql = "UPDATE cases set assigned_to = ? where id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii",$user_id,$case_id);

        if($stmt->execute()){
            echo json_encode("success");

            $to = "matianyanzi@gmail.com";
            $subject = "Test Email";

            $headers = "From: matianyanzi@gmail.com\r\n";
            $headers .= "Reply-To: nyanzimathiaz@gmail.com\r\n";

            $message = "This is a test email sent from PHP.";

            if (mail($to, $subject, $message,$headers)) {
                echo "Email sent successfully.";
            } else {
                echo "Failed to send email.";
            }

        }else{
            echo json_encode("Failured");
        }

        $stmt->close();
        $con->close();
    }


    
?>