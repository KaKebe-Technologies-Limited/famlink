<?php
require("../config.php");
$db = new Database();
$con = $db->getConnString();

$orderid = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

require('../session.php');
require('../queries/statsquery.php');
require("../queries/classes/User.php");
require("../queries/classes/Appointment.php");
require('../queries/appointment_new_query.php');
require('../queries/appointment_approved_query.php');
require('../queries/appointment_canceled_query.php');

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

    <title>Appointment Detail</title>

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

            <li class="nav-link ">
                <a href="cases.php">
                <i class='bx bx-bar-chart-alt-2 icon'></i>
                <span class="text nav-text">Cases</span>
                </a>
            </li>

            <li class="nav-link active">
                <a href="appointments.php">
                <i class='bx bx-bell icon'></i>
                <span class="text nav-text">Appointments</span>
                </a>
            </li>

            <?php 
                if($_SESSION["role"] == "2"){?>

                    <li class="nav-link">
                        <a href="users.php">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Users</span>
                        </a>
                    </li>
                    
                    <li class="nav-link">
                        <a href="manage_users.php">
                        <i class='bx bx-user icon'></i>
                        <span class="text nav-text">Manage Users</span>
                        </a>
                    </li>
                    
                <?php }
            ?>

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

    <section class="home">
        <div class="mainpanel">
            <div class="elements">
                <div class="activities">
                    <?php
                    $order = new Appointment($con, $orderid);

                    if ($order->getId() != null) :
                    ?>
                        <div class="elements">
                            <div class="activities">
                                <div class="cartitemcontainer">
                                    <div class="cartItem">
                                        <div class="sectionheading">
                                            <h3 class="sectionlable">Appointment Details</h3>
                                        </div>

                                        <div class="orderheading">
                                            <div class="ordertimediv">
                                                <h6>ID</h6>
                                                <h5><?= $order->getId() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Date & Time</h6>
                                                <h5><?= $order->getAppointmentDate() ?></h5>
                                            </div>

                                            <div class="ordertimediv">
                                                <h6>Status</h6>
                                                <h5><?= $order->getStatus() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Contact Name</h6>
                                                <h5><?= $order->getName() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Contact Email</h6>
                                                <h5><?= $order->getEmail() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Contact Phone</h6>
                                                <h5><?= $order->getPhone() ?></h5>
                                            </div>
                                        </div>




                                        <div class="cartItemdetail">
                                            <p style="color: #0052e9; font-weight: bold;">Purpose</p>
                                            <div class="menu_desc"><?= $order->getPurpose() ?>
                                            </div>
                                        </div>



                                        <div class="cartdetailbutton">
                                            <div class="cancebutton_parent">
                                                <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusId() ?>">
                                                <button class="cancelbutton">Delete</button>
                                            </div>

                                            <?php if ( $order->getStatusId() < 3) : ?>
                                                <div class="approvebutton_parent">
                                                    <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                    <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusId() ?>">
                                                    <button class="approvebutton">Approve</button>
                                                </div>
                                            <?php else :  ?>
                                                <div class="approvebutton_parent" style="display: none" aria-disabled="true">
                                                    <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                    <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusId() ?>">
                                                    <button class="approvebutton">Approve</button>
                                                </div>
                                            <?php endif ?>

                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>


                        <div class="sponserdiv">
                            <div class="sponsorshipform">
                                <div class="sponsormessagediv">

                                </div>
                                <form id="approveform" action="" method="POST">

                                    <div class="form-group">
                                        <input id="childnameinput" type="hidden" name="childname" class="form-control" placeholder="order_id" disabled>
                                        <input id="order_status_id" type="hidden" name="order_status" class="form-control" placeholder="order_status" disabled>
                                    </div>

                                    <div class="approveorderform">
                                        <h1>Approve</h1>
                                        <p>All approved Appointments are accessed through the Reported Case Page </p>
                                    </div>

                                    <div class="deleteorder" style="display: none;">
                                        <h1>Delete</h1>
                                        <p>This action can not be reversed when done! </p>
                                    </div>

                                    <input id="feedbackinput" type="text" placeholder="Feedback" class="form-control" required name="feedback">
                                    <input style="display: none" disabled id="userID" value="<?= $order->getUserid() ?>" type="text" placeholder="Feedback" class="form-control" required name="feedback">

                                    <div class="form-group">
                                        <input type="submit" value="Approve" style="width: 100% !important;" class="sponsorchildnowbtn">
                                    </div>
                                    <div class="form-group">
                                        <button type="reset" id="cancelbtn" style="background: #fff;border: 1px solid #000;padding: 10px 20px;width: 100%;color: #000; border-radius: 5px;" onclick="cancelsponsohip()">Cancel
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <!--        loader-->
                        <div class="loaderdiv">
                            <div class="loader-container">
                                <div class="dot dot-1"></div>
                                <div class="dot dot-2"></div>
                                <div class="dot dot-3"></div>
                                <div class="dot dot-4"></div>
                            </div>
                        </div>


                    <?php else : ?>
                       No Appointments
                    <?php endif ?>

                </div>

            </div>
        </div>

    </section>

    <script>
        const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            searchBtn = body.querySelector(".search-box"),
            // modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");


        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        })

        searchBtn.addEventListener("click", () => {
            sidebar.classList.remove("close");
        })

    </script>

    <script src="../js/process_appointment_detail.js"></script>

</body>

</html>