<?php
require("../config.php");
$db = new Database();
$con = $db->getConnString();

require('../session.php');
require('../queries/statsquery.php');
require('../queries/case_new_query.php');
require "../queries/classes/User.php";
require("../queries/classes/all_users.php");

?>


<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/z_favicon.png">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Cases</title>

</head>

<body>
<nav class="sidebar">
    <header>
        <div class="image-text">
        <span class="image">
          <img src="assets/famlink.png" alt="">
        </span>

            <div class="text logo-text">
                <span class="name">Famlink</span>
                <span class="profession">CEWOCHR ADMIN</span>
            </div>
        </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

            <li class="search-box" style="display: none;">
                <i class='bx bx-search icon'></i>
                <input type="text" placeholder="Search...">
            </li>

            <ul class="menu-links">
                <li class="nav-link ">
                    <a href="../index.php">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link active">
                    <a href="cases.php">
                        <i class='bx bx-bar-chart-alt-2 icon'></i>
                        <span class="text nav-text">Cases</span>
                    </a>
                </li>

                <li class="nav-link ">
                    <a href="appointments.php">
                        <i class='bx bx-bell icon'></i>
                        <span class="text nav-text">Appointments</span>
                    </a>
                </li>

                <li class="nav-link">
                  <a href="users.php">
                    <i class='bx bx-pie-chart-alt icon'></i>
                    <span class="text nav-text">Users</span>
                  </a>
                </li>
            </ul>
        </div>

        <div class="bottom-content">
            <li class="">
                <a href="../logout.php">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>
        </div>
    </div>
</nav>

<?php
    $users = new AllUsers($con);
?>

<section class="home">
    <div class="mainpanel">
        <div class="elements">
            <div class="activities">
                <div class="sectionheading">
                    <h3 class="sectionlable">Registered users</h3>
                    <h6 class="sectionlable">View all signed up users.</h6>
                </div>

                <div class="orderfilter">
                    <a href="#">
                        <div class="filterorder filter_active">Total<span class="noti circle"><?= $users->getTotal() ?></span></div>
                    </a>
                    <a href="cases_approved.php">
                        <div class="filterorder">SuperAdmin <span class="noti circlenotactive"><?= $users->countSuperAdmin() ?></span></div>
                    </a>
                    <a href="cases_handled.php">
                        <div class="filterorder">Admins <span class="noti circlenotactive"><?= $users->countAdmin() ?></span></div>
                    </a>
                </div>


                <div >
                   
                    <table class="table table-responsive table-stripped">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>                            
                            <th>Contact</th>
                            <th>Permissions</th>
                            <td></td>
                        </thead>
                        <tbody>
                            <?php 
                                
                                foreach($users->getUsers() as $user){?>
                                    <tr>
                                        <td><?php echo $user["full_name"]?></td>
                                        <td><?php echo $user["email"]?></td>
                                        <td><?php echo $user["phone_number"]?></td>
                                        <td>
                                            <?php 
                                                if($user["userRole"] == 2){
                                                    echo "Super Admin";
                                                }
                                                if($user["userRole"] == 3){
                                                    echo "Admin";
                                                }                                                
                                                if($user["userRole"] == 1){
                                                    echo "User";
                                                }                                        
                                            ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary">Manage User</button>
                                        </td>
                                    </tr>
                                <?php }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Modal Title</h2>
            <p>This is a simple modal example.</p>
        </div>
    </div>
</section>

<script src="../js/process_case_detail.js"></script>
<script>
    $(document).ready(function () {
       
    })
</script>

</body>
</html>