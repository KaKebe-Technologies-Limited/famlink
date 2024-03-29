<?php
require("../config.php");
$db = new Database();
$con = $db->getConnString();

$orderid = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

require('../session.php');
require('../queries/statsquery.php');
require("../queries/classes/User.php");
require("../queries/classes/Cases.php");
require("../queries/classes/admins.php");


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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <title>Case Detail</title>
    <style>
         .select2-container--classic .select2-dropdown {
            max-height: 200px; /* Set your desired height */
            overflow-y: auto;
        }
        .modal-content {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Close button (optional) */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>

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

          <li class="nav-link">
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
                    $order = new Cases($con, $orderid);
                    $adminUsers = new AdminUsers($con);

                    if ($order->getId() != null) :
                    ?>

                        <div class="elements">


                            <div class="activities">

                                <div class="cartitemcontainer">


                                    <div class="cartItem">


                                        <div class="sectionheading">
                                            <h3 class="sectionlable">Case Report Details</h3>

                                        </div>


                                        <div class="orderheading">

                                            <div class="ordertimediv">
                                                <h6>Case ID</h6>
                                                <h5>FLCW-<?= $order->getId() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Reported Time</h6>
                                                <h5><?= $order->getDatecreated() ?></h5>
                                            </div>

                                            <div class="ordertimediv">
                                                <h6>Case Status</h6>
                                                <h5><?= $order->getStatus() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Case category</h6>
                                                <h5><?= $order->getCategoryId() ?></h5>
                                            </div>
                                            <div class="ordertimediv">
                                                <h6>Reporter</h6>
                                                <h5><?= $order->getReportedbyUser() ?></h5>
                                            </div>

                                            <div class="ordertimediv">
                                                <h6>Phone number</h6>
                                                <h5><?= $order->getPhoneNumber() ?></h5>
                                            </div>
                                            
                                            <div class="ordertimediv">
                                                <h6>District</h6>
                                                <h5><?= $order->getDistrict() ?></h5>
                                            </div>
                                           
                                            <div class="ordertimediv">
                                                <h6>Sub county</h6>
                                                <h5><?= $order->getSubCounty() ?></h5>
                                            </div>
                                            
                                            <div class="ordertimediv">
                                                <h6>Parish</h6>
                                                <h5><?= $order->getParish() ?></h5>
                                            </div>

                                        </div>




                                        <div class="cartItemdetail">
                                            <div class="menutitle"><?= $order->getTitle() ?>
                                            </div>
                                            <div class="menu_desc"><?= $order->getDescription() ?>
                                            </div>
                                        </div>

                                        <div class="cartdetailbutton">
                                            <div class="cancebutton_parent">
                                                <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusID() ?>">
                                                <button class="cancelbutton">Delete Case</button>
                                            </div>

                                            <div class="assignCaseButton" style="margin-left:20px"  aria-disabled="true">
                                                <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusID() ?>">
                                                <button  id="modalTrigger">Assign Case</button>
                                            </div>

                                            <?php if ( $order->getStatusID() < 3) : ?>
                                            <div class="approvebutton_parent">
                                                <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusID() ?>">
                                                <button class="approvebutton">Approve Case</button>
                                            </div>
                                            <?php else :  ?>
                                                <div class="approvebutton_parent" style="display: none" aria-disabled="true">
                                                    <input class="order_id_input" type="hidden" name="orderID" value="<?= $order->getId() ?>">
                                                    <input class="order_status_id" type="hidden" name="order_status_id" value="<?= $order->getStatusID() ?>">
                                                    <button class="approvebutton">Approve Case</button>
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
                                    <!-- approving and declining a case -->
                                    <div class="approve">
                                        <div class="form-group">
                                            <input id="childnameinput" type="hidden" name="childname" class="form-control" placeholder="order_id" disabled>
                                            <input id="order_status_id" type="hidden" name="order_status" class="form-control" placeholder="order_status" disabled>
                                        </div>
    
                                        <div class="approveorderform">
                                            <h1>Approve</h1>
                                            <p>All approved Cases are accessed through the Reported Case Page </p>
                                        </div>
    
                                        <div class="deleteorder" style="display: none;">
                                            <h1>Delete Case</h1>
                                            <p>This action can not be reversed when done! </p>
                                        </div>
    
                                        <input id="feedbackinput" type="text" placeholder="Feedback" class="form-control" required name="feedback">
                                        <input style="display: none" disabled id="userID" value="<?= $order->getReportedbyId() ?>" type="text" placeholder="Feedback" class="form-control" required name="feedback">
    
                                        <div class="form-group">
                                            <input type="submit" value="Approve" style="width: 100% !important;" class="sponsorchildnowbtn">
                                        </div>
                                        <div class="form-group">
                                            <button type="reset" id="cancelbtn" style="background: #fff;border: 1px solid #000;padding: 10px 20px;width: 100%;color: #000; border-radius: 5px;" onclick="cancelsponsohip()">Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <!-- modal to assign a case to another user -->
                        <div class="modal" id="assignmodal">
                            <div class="modal-content">
                                <!-- Your modal content goes here -->
                                <form action="./processors/assign_case_query.php" method="post">
                                    <div class="form-group">
                                        <input id="childnameinput" type="hidden" name="case_id" class="form-control" value="<?= $order->getId() ?>" >
                                        <input id="order_status_id" type="hidden" name="order_status" class="form-control" value="<?= $order->getId() ?>" placeholder="order_status" >
                                    </div>

                                    <div>
                                        <h3>Assign Case</h3>
                                        <p style="font-size:16px;opacity:.6">Assign case to another admin user.</p>
                                    </div>
                                    <div style="margin-top:20px">
                                        <select id="searchableSelect" name="staff_id" class="form-control" required>
                                            <option disabled selected >Select</option>
                                            <?php  
                                                foreach ($adminUsers->getUsers() as $key ) {?>
                                                <option
                                                    value="<?php echo $key["user_id"]?>"
                                                >
                                                    <?php echo $key["full_name"];?>
                                                </option>
                                                <?php }?>
                                        </select>
                                    </div>

                                    <div class="form-group" style="margin-top:20px">
                                        <input type="submit" value="Assign" id="assignButton" style="width: 100% !important;" class="sponsorchildnowbtn">
                                    </div>
                                    <div class="form-group">
                                        <button id="cancelassignbtn" style="background: #fff;border: 1px solid #000;padding: 10px 20px;width: 100%;color: #000; border-radius: 5px;" onclick="cancelsponsohip()">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
        
                        <!-- end of the assign case modal -->
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
                        Order Detail Failed
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
        });

        
        $(".assignCaseButton").click(function(){
            $("#assignmodal").show();
            console.log("clicked");
        });
        $("#cancelassignbtn").click(function(){
            $("#assignmodal").hide();
        })

        $(document).ready(function () {
            $(".modal-overlay").fadeOut();
            $('#searchableSelect').select2({
                width: '100%', 
                height:'100px'
            });

            
            $("#cancelbtn").click(function(){
                $(".modal-overlay").fadeOut();
            })

            $("#modalTrigger").click(function () {
                $(".modal-overlay").fadeIn();
            });

            // Close the modal when the close button is clicked
            $(".close").click(function () {
                $(".modal-overlay").fadeOut();
            });

            // Close the modal when clicking outside the modal content
            $(window).click(function (event) {
                if (event.target.className === "modal-overlay") {
                    $(".modal-overlay").fadeOut();
                }
            }); 
  });

    </script>


    <script src="../js/process_case_detail.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

</body>

</html>