<?php 

    require_once("./../admin/config.php");
    $database = new Database();
    $con = $database->getConnString(); 
    $error ="";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $user_action = $_POST["user_action"];
        
        // login
        if($user_action === "login"){
            try {
                if ($con == null) {
                    $error = "Connection Problems, Check your Connection and Try again";
                } else if ($con) {
                    $myuseremail = mysqli_real_escape_string($con, $_POST['username']);
                    $mypassword = mysqli_real_escape_string($con, $_POST['password']);
                    $encryptedpw = md5($mypassword);
    
                    $statement = $con->prepare('SELECT * FROM users WHERE  email=? AND password =? limit 1');
                    $statement->bind_param('ss', $myuseremail, $encryptedpw);
                    if ($statement->execute()) {
                        $result = $statement->get_result();
                        if ($result->num_rows == 1) {
                            $row = $result->fetch_assoc();
                            $_SESSION['user_email'] = $myuseremail;
                            $_SESSION['userid'] = $row["user_id"];
                            header("location: services.php");
                        }
                        else {
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

        // registration
        if($user_action === "register"){
            if(
                (isset($_POST["full_name"]) && $_POST["full_name"] != null) && (isset($_POST["email"]) && $_POST["email"] != null) && (isset($_POST["phone_number"]) && $_POST["phone_number"] != null) && (isset($_POST["location_address"]) && $_POST["location_address"] != null) && (isset($_POST["password"]) && $_POST["password"] != null)  
            ){
                    $full_name = $_POST['full_name'];
                    $email = $_POST['email'];
                    $phone_number = $_POST['phone_number'];
                    $password = md5($_POST['password']);
                    $location_address = $_POST['location_address'];
                    $profileimage = "https://media.istockphoto.com/vectors/creative-vector-seamless-pattern-vector-id975589890?k=20&m=975589890&s=612x612&w=0&h=2acWhh0ASGWI7vRqofWthsp2UqagVUCQqdmUQLyAs3Y=";
                
                    if($_POST["password"] === $_POST["confirmPassword"]){
                        
                        //checking if the user is already exist with this username or email
                        //as the email and username should be unique for every user 
                        $stmt = $con->prepare("SELECT user_id FROM users WHERE phone_number = ? OR email = ?");
                        $stmt->bind_param("ss", $phone_number, $email);
                        $stmt->execute();
                        $stmt->store_result();
    
                                    //if the user already exist in the database 
                        if ($stmt->num_rows > 0) {
                                $error = 'User already registered';
                                $stmt->close();
                        } else {
                    
                                //if user is new creating an insert query 
                                $stmt = $con->prepare("INSERT INTO users(`full_name`,`username`, `email`, `phone_number`, `address`, `profile_image`,`password`) VALUES (?, ?, ?, ?, ?, ?,?)");
                                $stmt->bind_param("sssssss", $full_name,$full_name, $email, $phone_number, $location_address, $profileimage, $password);
                    
                                //if the user is successfully added to the database 
                                if ($stmt->execute()) {
                    
                                    //fetching the user back 
                                    $stmt = $con->prepare("SELECT `user_id`, `full_name`, `email`, `phone_number`, `address`, `profile_image` FROM users WHERE phone_number = ? OR email = ?");
                                    $stmt->bind_param("ss", $phone_number, $email);
                                    $stmt->execute();
                                    $stmt->bind_result($user_id, $full_name, $email, $phone_number, $address, $profile_image);
                                    $stmt->fetch();
                                    
                                    $stmt->close();
                                    $_SESSION["userid"] = $con->insert_id;
                                    $_SESSION['user_email'] = $email;
                                    header("location: services.php");
                    
                                }else{
                                    // $error = "Signup failed";
                                    $error = $stmt->error; 
                                }
                        }
                    }else{
                        $error = "Password mismatch. Try Again";
                    }
        
            }else {
                $error = 'required parameters are not available';
            }
        }

    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Sign-Up and Sign-In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#signin">Sign In</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#signup">Sign Up</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="signup">
                <h2 style="margin-bottom: 20px;">User Sign-Up</h2>
                <i class="text-danger"> <?php echo $error ?></i>
                <form method="POST" action="#">

                    <input type="text" name="user_action" value="register" hidden>
                    <div class="form-group">
                        <label for="fullName">Full Name:</label>
                        <input type="text" class="form-control" id="fullName" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="location_address" name="location_address" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                </form>
            </div>
            <div class="tab-pane fade show active" id="signin" action="">
                <h2 style="margin-bottom: 20px;">User Sign-In</h2>
                <i class="text-center text-danger"> <?php echo $error ?></i>
                <form id="famlink-login-form" method="POST" action="#">
                    <input type="text" name="user_action" value="login" hidden>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" onclick="signIn()">Sign In</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</body>
</html>
