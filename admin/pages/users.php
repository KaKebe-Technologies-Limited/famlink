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
<style>
.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}
/* .modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
} */

.modal {
    display:none;
  width: 400px;
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

h2 {
  margin-top: 0;
}

button {
  margin-top: 10px;
}
</style>
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

                <li class="nav-link ">
                    <a href="appointments.php">
                        <i class='bx bx-bell icon'></i>
                        <span class="text nav-text">Appointments</span>
                    </a>
                </li>

                <li class="nav-link active">
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
                    <h3 class="sectionlable">Registered cases</h3>
                    <h6 class="sectionlable">View all signed up users.</h6>
                </div>

                <div class="orderfilter">
                    <a href="#">
                        <div class="filterorder filter_active">Total<span class="noti circle"><?= $users->getTotal() ?></span></div>
                    </a>
                    <a href="#">
                        <div class="filterorder">SuperAdmin <span class="noti circlenotactive"><?= $users->countSuperAdmin() ?></span></div>
                    </a>
                    <a href="#">
                        <div class="filterorder">Admins <span class="noti circlenotactive"><?= $users->countAdmin() ?></span></div>
                    </a>
                </div>


                <div >
                   
                    <table class="table table-responsive table-stripped">
                        <thead>
                            <th>Reported By</th>
                            <th>Location</th>                            
                            <th>Region</th>
                            <th>Contact</th>
                            <th>Gender</th> 
                            <th>Age</th> 
                            <th>Village</th>
                            <th>Parish</th>
                            <th>Sub County</th>
                            <th>District</th>
                            <th>Reported On</th>
                        </thead>
                        <tbody>
                            <?php 
                                
                                foreach($users->userReportedCases() as $user){?>
                                    <tr>
                                        <td><?php echo $user["username"]?></td>
                                        <td><?php echo $user["location"]?></td>
                                        <td><?php echo $user["region"]?></td>
                                        <td><?php echo $user["contact"]?></td>
                                        <td><?php echo $user["victim_gender"]?></td>
                                        <td><?php echo $user["victim_age"]?></td>
                                        <td><?php echo $user["village"]?></td>
                                        <td><?php echo $user["parish"]?></td>
                                        <td><?php echo $user["sub_county"]?></td>
                                        <td><?php echo $user["district"]?></td>
                                        <td><?php echo $user["datecreated"]?></td>
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

    <div class="modal-overlay" v-if="showModal">
        <div class="modal">
            <h3>Set Role</h3>
            <select v-model="selectedRole" class="form-control">
                <option value="3">Admin</option>
                <option value="2">Super Admin</option>
                <option value="1">User</option>
            </select>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-success" onclick="closeModal()">Submit</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-danger" onclick="closeModal()">Close</button>
                </div>
            </div>
            
        </div>
  </div>
</section>

<script src="../js/process_case_detail.js"></script>
<script>
    $(document).ready(function () {
       
    });
    function manageMember(id){
        console.log(id)
    }
</script>

</body>
</html>