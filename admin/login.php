<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Famlink</title>
    <meta charset="utf-8">

    <link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Overpass:300,400,400i,600,700" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="loginassets/stylesheet/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="loginassets/javascript/main.js"></script>

</head>

<?php
$db = new Database();
$con = $db->getConnString();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $feedback = [];
    try {
        if ($con == null) {
            $error = "Connection Problems, Check your Connection and Try again";
        } else if ($con) {
            $myuseremail = mysqli_real_escape_string($con, $_POST['useremail']);
            $mypassword = mysqli_real_escape_string($con, $_POST['password']);
            $encryptedpw = md5($mypassword);

            //i have added the userRole 3
            // 1 - ordinary user
            // 2 - superadmin
            //3 - admin

            $statement = $con->prepare('SELECT * FROM users WHERE  email=? AND password =? AND (userRole = "2" OR userRole = "3") limit 1');
            $statement->bind_param('ss', $myuseremail, $encryptedpw);
            if ($statement->execute()) {
                $result = $statement->get_result();
                // $statement->store_result();
                // $statement->fetch();
                if ($result) {
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $_SESSION['login_user'] = $myuseremail;
                        $_SESSION['role'] = $row["userRole"];
                        $_SESSION['username'] = $row["full_name"];
                        $_SESSION['user_id'] = $row["user_id"];
                        header("location: index.php");
                        exit;
                    }else{
                        $error = "Login Failed, Ensure Password and Email is Correct and Try Again";
                        echo "<script>showerror();</script>";
                    }
                }
            } else {
                $error = "Login Failed, Ensure Password and Email is Correct and Try Again";
                echo "<script>showerror();</script>";
            }
        }
    } catch (\Throwable $th) {
        $error = $th->getMessage();
    }

    if ($error != null) {

?>

        <div id="erroshow" class="erroshow">
            <div class="errorinnerdiv">
                <p class="errotext"><?php echo $error; ?></p>
            </div>
        </div>
        <div id="erroroverlay" style="height: 100%; opacity: 0.4; position: absolute; top: 0px; left: 0px; background-color: black; width: 100%; z-index: 5000;"></div>



<?php

    }
}

?>

<body>


    <section class="ftco-section">
        <div class="container">
            <div class="cardcomponent">

                <div class="designview " style="display: none;">
                    <img src="loginassets/images/mwonyaapattern.svg" alt="mwonyaapattern">

                </div>

                <div class="loginpagesite align-self-stretch">

                    <div class="formtitle">

                    <!-- <img class="zodongologinlogo" src="pages/assets/zodongo_logo.png" alt=""> -->
                        <p class="logintext">Famlink Admin Login</p>

                    </div>

                    <form action="" method="post">

                        <label for="useremailid" class="labeltext">Email</label>
                        <input id="useremailid" style="margin-bottom: 2em;" type="email" name="useremail" class="inputbox" placeholder="Email address" required />
                        <label for="userpasswordid" class="labeltext">Password</label>
                        <input id="userpasswordid" type="password" name="password" class="inputbox" placeholder="Password" required />

                        <input class="inputsubmit" type="submit" value=" LOG IN " /><br />

                    </form>

                </div>

            </div>


        </div>
    </section>

</body>

</html>