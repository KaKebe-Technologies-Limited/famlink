<?php 
    include("./../../admin/config.php");

class dbmethods {

    function register(){
        $stmt = $this->conn->prepare("INSERT INTO " . $this->appointments . "(`userid`,`purpose`, `appointment_date`,`appointment_time`) VALUES(?,?,?,?)");
        $stmt->bind_param("isss", $this->userid, $this->purpose, $this->appointment_date, $this->appointment_time);
    
        if ($stmt->execute()) {
            $this->exe_status = "success";
        } else {
            $this->exe_status = "failure";
        }
    
    
        if ($this->exe_status == "success") {
            return true;
        }
    }
    
    function login($username,$password){
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
            $feedback = [];
            try {
                if ($con == null) {
                    $error = "Connection Problems, Check your Connection and Try again";
                } else if ($con) {
                    $myuseremail = mysqli_real_escape_string($con, $_POST['useremail']);
                    $mypassword = mysqli_real_escape_string($con, $_POST['password']);
                    $encryptedpw = md5($mypassword);
    
                    $statement = $con->prepare('SELECT * FROM users WHERE  email=? AND password =? limit 1');
                    $statement->bind_param('ss', $myuseremail, $encryptedpw);
                    if ($statement->execute()) {
                        $statement->store_result();
                        $statement->fetch();
                        if ($statement->num_rows == 1) {
                            $_SESSION['login_user'] = $myuseremail;
                            header("location: index");
                        } else {
                            $error = "Login Failed, Ensure Password and Email is Correct and Try Again";
                            echo "<script>showerror();</script>";
                        }
                    } else {
                        $error = "Login Failed, Ensure Password and Email is Correct and Try Again";
                        echo "<script>showerror();</script>";
                    }
                }
            } catch (\Throwable $th) {
                $error = $th->getMessage();
            }
        }
    }
    
    function create_appointments(){
    
        $stmt = $this->conn->prepare("INSERT INTO " . $this->appointments . "(`userid`,`purpose`, `appointment_date`,`appointment_time`) VALUES(?,?,?,?)");
    
        $this->userid = htmlspecialchars(strip_tags($this->userid));
        $this->purpose = htmlspecialchars(strip_tags($this->purpose));
        $this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));
        $this->appointment_time = htmlspecialchars(strip_tags($this->appointment_time));
    
    
        $stmt->bind_param("isss", $this->userid, $this->purpose, $this->appointment_date, $this->appointment_time);
    
        if ($stmt->execute()) {
            $this->exe_status = "success";
        } else {
            $this->exe_status = "failure";
        }
    }
    
    function create_case(){
        $stmt = $this->conn->prepare("INSERT INTO " . $this->cases . "(`title`, `picture`, `description`, `category_id`, `location`, `reportedby_id`, `status`) VALUES(?,?,?,?,?,?,?)");
    
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->picture = htmlspecialchars(strip_tags($this->picture));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->reportedby_id = htmlspecialchars(strip_tags($this->reportedby_id));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->address = htmlspecialchars(strip_tags($this->address));
    
    
        $stmt->bind_param("sssssii", $this->title, $this->picture, $this->description, $this->category_id, $this->address, $this->reportedby_id, $this->status);
    
        if ($stmt->execute()) {
            $this->exe_status = "success";
        } else {
            $this->exe_status = "failure";
        }
    
    
        if ($this->exe_status == "success") {
            return true;
        }
    
    }
}



?>