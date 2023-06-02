<?php
    // require_once("./../admin/config.php");
    // $database = new Database();
    // $con = $database->getConnString();
       
    // $category = "SELECT * from refercategories";
    // $result = $con->query($category);

    $message ="";
    // if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //     $user_action = $_POST["user_action"];

    //     if($user_action === "appointment"){
    //         $purpose = $_POST["purpose"];
    //         $appointment_date = $_POST["appointment_date"];
    //         $appointment_time = $_POST["appointment_time"];
    //         $userid = $_SESSION["userid"];

            


    //         $stmt = $con->prepare("INSERT INTO appointments(`userid`,`purpose`, `appointment_date`,`appointment_time`) VALUES(?,?,?,?)");
    //         $userid = htmlspecialchars(strip_tags($userid));
    //         $purpose = htmlspecialchars(strip_tags($purpose));
    //         $appointment_date = htmlspecialchars(strip_tags($appointment_date));
    //         $appointment_time = htmlspecialchars(strip_tags($appointment_time));
        
    //         $stmt->bind_param("isss", $userid, $purpose, $appointment_date, $appointment_time);
        
    //         if ($stmt->execute()) {
                
    //             $message = "Appointment Submitted succcesfully";
    //         } else {
              
    //             $message = "Something went wrong. Try again";
    //         }

    //     }

    //     if($user_action === "report_case"){
    //         $title = $_POST["title"];
    //         $picture = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRNsJyFJ1hSBVJ4mVkdeyNNJCTR3QyYaEHjug&amp;amp;usqp=CAU";;
    //         $description = $_POST["description"];
    //         //TO DO this should the suer id og logged user
    //         $reportedby_id = $_SESSION["userid"];
    //         $status = 1;
    //         $address = $_POST["location"];
    //         $datecreated = date('Y-m-d H:i:s');
    //         $category_id = $_POST["category"];

    //         $stmt = $con->prepare("INSERT INTO cases(`title`, `picture`, `description`, `category_id`, `location`, `reportedby_id`, `status`) VALUES(?,?,?,?,?,?,?)");
    //         $title = htmlspecialchars(strip_tags($title));
    //         $picture = htmlspecialchars(strip_tags($picture));
    //         $description = htmlspecialchars(strip_tags($description));
    //         $category_id = htmlspecialchars(strip_tags($category_id));
    //         $reportedby_id = htmlspecialchars(strip_tags($reportedby_id));
    //         $status = htmlspecialchars(strip_tags($status));
    //         $address = htmlspecialchars(strip_tags($address));

    //         $stmt->bind_param("sssssii", $title, $picture, $description, $category_id, $address, $reportedby_id, $status);

    //         if ($stmt->execute()) {
    //             // $this->exe_status = "success";
    //             $message = "Cases Submitted ";
    //         } else {
    //             // $this->exe_status = "failure";
    //             $message = "Cases failed";
    //         }

    //     }
    // }





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Link Display -->
    <meta property="og:title" content="CEWOCHR - Cases ">
    <meta property="og:description" content="The Centre for Women and Children’s Reintegration (CEWOCHR) is an organization established to address the challenges faced by girls, women and their children born outside of marriage in Uganda. These children and women often experience marginalization and discrimination from both their families and society">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://famlinkapp.com">
    <meta property="og:image" content="img/ico.jpg">
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<!--    <link rel="icon" type="image/x-icon" href="admin/pages/assets/z_favicon.png">-->
    <title>Famlink - Case</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>
<main>
    <div class="big-wrapper light">
        <img src="./img/shape.png" alt="" class="shape"/>

        <!-- <header>
            <div class="container">
                <div class="logo">
                    <a href="index.html"> <p style="text-transform: capitalize; text-decoration:none" class="text" >Famlink APP</p></a>
                   
                </div>

                <div class="links">
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="admin/">Admin</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#" class="btn">Report Case</a></li>
                    </ul>
                </div>

                <div class="overlay"></div>

                <div class="hamburger-menu">
                    <div class="bar"></div>
                </div>
            </div>
        </header> -->

      <!-- section goes here -->
      <div class="container">
        <h2>Case and Appointment Form</h2>

        <div class="text-center">
            <div class="text-center text-primary mb-3" >
                <i><?php echo $message ?></i>
            </div>
        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#caseForm">Case Form</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#appointmentForm">Appointment Form</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="caseForm">
                
                <form method="POST" action="#">
                    <input type="text" name="user_action" value="report_case" hidden>
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category" class="form-control" required>
                            <!-- <option selected disabled>Select</option> -->
                            <?php
                                while($row = $result->fetch_assoc()) {?>
                                    <option value="<?php echo $row["type"] ?>">
                                        <?php echo $row["type"] ?>
                                    </option>
                                <?php }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                </form>
            </div>
            <div class="tab-pane fade" id="appointmentForm">
                <form method="POST" action="#">
                    <input type="text" name="user_action" value="appointment" hidden>
                    <div class="form-group">
                        <label for="purpose">Purpose of Appointment:</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Appointment Date:</label>
                        <input type="date" class="form-control" id="date" name="appointment_date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <input type="time" class="form-control" id="time" name="appointment_time" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Appointment</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


        <div class="bottom-area">
            <div class="container">
                <button class="toggle-btn">
                    <i class="far fa-moon"></i>
                    <i class="far fa-sun"></i>
                </button>
            </div>
        </div>

        <div class="footer">
            <div class="container">
                <div class="contactcards">
                    <div class="footercard">
                        <div class="title">Company</div>
                        <a href="#" class="lable">
                        <p class="lable">About us</p>
                        </a>
                        <a href="#" class="lable">
                            <p class="lable">Blog</p>
                            </a>
                    </div>

                    <div class="footercard">
                        <div class="title">Contacts Us</div>
                        <p class="lable">Phone: <span>+256 772 616446</span></p>
                        <p class="lable">Email: <span>elizabetha@cewochr.org</span></p>
                    </div>

                    <div class="footercard">
                        <div class="title">Let's get social</div>
                        <div class="socialinks">
                            <a href="#" class="lable">
                                <img  src="img/instagram.png" alt="">
                            </a>
                            <a href="#" class="lable">
                                <img  src="img/whatsapp.png" alt="">
                            </a>
                            <a href="#" class="lable">
                                <img  src="img/facebook.png" alt="">
                            </a>
                        </div>
                      
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript Files -->

<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<script src="./app.js"></script>
</body>
</html>