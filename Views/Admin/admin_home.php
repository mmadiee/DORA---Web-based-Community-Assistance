<?php

include 'includes/config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:/login.php');
    exit;
}

if (isset($_GET['logout'])) {
    unset($admin_id);
    session_destroy();
    header('location:/login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/home.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">

    <!-- LINE CHART -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    
    <style>
/* Your existing CSS */
.nav-links li a:hover::before {
    content: attr(data-title);
    position: absolute;
    background: #034078;
    color: #fff;
    border-radius: 5px;
    padding: 10%;
    margin-left: -10px;
    z-index: 1;
    top: 50%;
    left: 110%;
    transform: translateY(-50%);
    white-space: nowrap;
}

.nav-links li a {
    text-decoration: none;
}



    </style>
</head>

<body>
    <!--LOADER-->
    <script src="js/loader.js"></script>
    <div class="loader"></div>

    <!-- SIDEBAR -->
   <div class="sidebar close no-print">
    <div class="logo-details">
        <span class="logo_name"></span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="admin_home.php" data-title="Home">
                <i class='bx bx-home'></i>
                <span class="link_name">Home</span>
            </a>
        </li>
        <li>
            <a href="dora_projects.php" data-title="Pending Projects">
                <i class='bx bx-news'></i>
                <span class="link_name">Projects</span>
            </a>
        </li>
        <li>
            <a href="donation-funds.php" data-title="Donation Funds">
                <i class='bx bxs-receipt'></i>
                <span class="link_name">Donation Funds</span>
            </a>
        </li>
        <!-- ADMINS -->
        <li>
            <a href="donation-analytics.php" data-title="Donation Analytics">
                <i class='bx bx-money'></i>
                <span class="link_name">Donation Analytics</span>
            </a>
        </li>
        <li>
            <a href="volunteer-analytics.php" data-title="Volunteer Analytics">
                <i class='bx bx-group'></i>
                <span class="link_name">Volunteer Analytics</span>
            </a>
        </li>
        <li>
            <a href="assistance-analytics.php" data-title="Assistance Analytics">
                <i class='bx bx-donate-heart'></i>
                <span class="link_name">Assistance Analytics</span>
            </a>
        </li>
        <li>
            <a href="sw-analytics.php" data-title="Social Worker Analytics">
                <i class='bx bx-bar-chart-alt'></i>
                <span class="link_name">Social Worker Analytics</span>
            </a>
        </li>
        <li>
            <div class="iocn-link">
                <a href="socialworkers.php" data-title="Social Workers">
                    <i class='bx bxs-user-detail'></i>
                    <span class="link_name">Social Workers</span>
                </a>
            </div>
        </li>
        <li>
            <div class="iocn-link">
                <a href="pending-accs.php" data-title="Pending Accounts">
                    <i class='bx bxs-user-plus'></i>
                    <span class="link_name">Pending Accounts</span>
                </a>
            </div>
        </li>
        <li>
            <div class="iocn-link">
                <a href="sw-activity.php" data-title="Workers Activity">
                    <i class='bx bx-time'></i>
                    <span class="link_name">Workers Activity</span>
                </a>
            </div>
        </li>
        <li>
            <div class="iocn-link">
                <a href="logout.php" data-title="Logout">
                    <i class='bx bx-log-out'></i>
                    <span class="link_name">Logout</span>
                </a>
            </div>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <?php
                    $select = mysqli_query($conn, "SELECT * FROM tbl_admin_accs WHERE admin_id = '$admin_id'")
                        or die('query failed');
                    if (mysqli_num_rows($select) > 0) {
                        $fetch = mysqli_fetch_assoc($select);
                    }
                    if ($fetch['image'] == '') {
                        echo '<img src="images/default-avatar.png">';
                    } else {
                        echo '<img src="/uploaded_img/' . $fetch['image'] . '">';
                    }
                    ?>
                </div>
            </div>
        </li>
    </ul>
</div>

    <!-- TITLE BARS -->
    <div class="header no-print">
        <h5>HOME</h5>
    </div>

    <section class="home-section">
            <div class="home-content" style="text-align: center;">
                <span class="text welcome-message">Welcome Admin, <?php echo $fetch['name']; ?> ! </span>
            </div>


                <!-- Profile View of Admin Worker-->
        
                <?php 
                    $sql = "SELECT * FROM tbl_admin_accs where tbl_admin_accs.admin_id = $admin_id";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_array($result)){
                        echo'
                        <div class="container">
                        <div class="main-body">

                    <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center"><br><br>
                        <img src="/uploaded_img/'.$row['image'].'"height="150px"><br>
                        <div class="mt-3">
                            <h4>'.$row['name'].'</h4>
                            <p class="text-secondary mb-3">Admin Account</p><br><br>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="">
                        
                        </ul>
                    </div>
                    </div>
                    <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            '.$row['name'].' 
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            '.$row['email'].'
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            '.$row['contact'].'
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Street</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            '.$row['address'].'
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">Barangay</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            '.$row['barangay'].'
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">District</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            '.$row['district'].'
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                            <h6 class="mb-0">City</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            '.$row['city'].'
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>';}?>

            <!-- TOTAL DONATION DRIVES COUNT -->
            <?php
                $sql = "SELECT COUNT(*) as donproj_count, MAX(start) as last_updated 
                FROM tbl_don_proj 
                WHERE proj_stat = 'ON GOING'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>
                            <div class="card-body">';
                    echo '<div class="card align-items-center"><br>';
                    echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["donproj_count"] .  '</p>';
                    echo '<p style="color:#001F54; font-size: 15px;" class="d-flex align-items-center mb-3">On Going Donation Drives</p>';

                    // Get the last update timestamp
                    $lastUpdatedTimestamp = strtotime($row["last_updated"]);
                    if ($lastUpdatedTimestamp !== false) {
                        $formattedLastUpdated = date('F j, Y', $lastUpdatedTimestamp);
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: ' . $formattedLastUpdated . '</i></p>';
                    } else {
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: Invalid Date</i></p>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    }
                }
                ?>


            <!-- TOTAL VOLUNTEER PROJECT COUNT -->
            <?php
                $sql = "SELECT COUNT(*) as volproj_count, MAX(uploadDate) as last_updated 
                FROM tbl_vol_proj 
                WHERE proj_stat = 'ON GOING'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>
                            <div class="card-body">';
                    echo '<div class="card align-items-center"><br>';
                    echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["volproj_count"] .  '</p>';
                    echo '<p style="color:#001F54; font-size: 15px;" class="d-flex align-items-center mb-3">On Going Volunteering Projects</p>';

                    // Get the last update timestamp
                    $lastUpdatedTimestamp = strtotime($row["last_updated"]);
                    if ($lastUpdatedTimestamp !== false) {
                        $formattedLastUpdated = date('F j, Y', $lastUpdatedTimestamp);
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: ' . $formattedLastUpdated . '</i></p>';
                    } else {
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: Invalid Date</i></p>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    }
                }
                ?>

            <!-- TOTAL ASSISTANCE PROJECT COUNT -->
            <?php
                $sql = "SELECT COUNT(*) as assistproj_count, MAX(deadline) as last_updated 
                FROM tbl_assistance 
                WHERE proj_stat = 'ON GOING'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>
                            <div class="card-body">';
                    echo '<div class="card align-items-center"><br>';
                    echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["assistproj_count"] .  '</p>';
                    echo '<p style="color:#001F54; font-size: 15px;" class="d-flex align-items-center mb-3">On Going Assistance Projects</p>';
            
                    // Get the last update timestamp
                    $lastUpdatedTimestamp = strtotime($row["last_updated"]);
                    if ($lastUpdatedTimestamp !== false) {
                        $formattedLastUpdated = date('F j, Y', $lastUpdatedTimestamp);
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: ' . $formattedLastUpdated . '</i></p>';
                    } else {
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: Invalid Date</i></p>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    }
                }
                ?>


            <!-- TOTAL VERIFIED DONATION TRANSACTIONS -->
            <?php
                $sql = "SELECT COUNT(*) verif_transac, MAX(submitdate) as last_updated
                FROM tbl_transaction t
                WHERE stat = 'Verified'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>
                            <div class="card-body">';
                    echo '<div class="card align-items-center"><br>';
                    echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["verif_transac"] .  '</p>';
                    echo '<p style="color:#001F54; font-size: 15px;" class="d-flex align-items-center mb-3">Verified Donation Transactions</p>';

                    // Get the last update timestamp
                    $lastUpdatedTimestamp = strtotime($row["last_updated"]);
                    if ($lastUpdatedTimestamp !== false) {
                        $formattedLastUpdated = date('F j, Y', $lastUpdatedTimestamp);
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: ' . $formattedLastUpdated . '</i></p>';
                    } else {
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: Invalid Date</i></p>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    }
                }
                ?>


                  <!-- TOTAL PENDING VOLUNTEER APPLICATIONS  -->
                  <?php
                      $sql = "SELECT COUNT(DISTINCT user_id) AS pending_assist, MAX(submitteddate) AS last_updated
                      FROM tbl_volunteers
                      WHERE stat = 'Pending'";
                    
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-sm-4 mb-3"><br>
                                <div class="card-body">';
                        echo '<div class="card align-items-center"><br>';
                        echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["pending_assist"] .  '</p>';
                        echo '<p style="color:#001F54; font-size: 15px;" class="d-flex align-items-center mb-3">Pending Volunteer Applications</p>';


                    // Get the last update timestamp
                    $lastUpdatedTimestamp = strtotime($row["last_updated"]);
                    if ($lastUpdatedTimestamp !== false) {
                        $formattedLastUpdated = date('F j, Y', $lastUpdatedTimestamp);
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: ' . $formattedLastUpdated . '</i></p>';
                    } else {
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: Invalid Date</i></p>';
                    }

                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        }
                    }
                    ?>
                     <!-- TOTAL PENDING ASSISTANCE APPLICATIONS -->
                    <?php
                    $sql = "SELECT COUNT(DISTINCT appli_id) AS pending_assist, MAX(submitteddate) AS last_updated
                            FROM tbl_applicants
                            WHERE stat = 'Pending'";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '<div class="col-sm-4 mb-3"><br>
                                <div class="card-body">';
                        echo '<div class="card align-items-center"><br>';
                        echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["pending_assist"] .  '</p>';
                        echo '<p style="color:#001F54; font-size: 15px;" class="d-flex align-items-center mb-3">Pending Assistance Applications</p>';


                    // Get the last update timestamp
                    $lastUpdatedTimestamp = strtotime($row["last_updated"]);
                    if ($lastUpdatedTimestamp !== false) {
                        $formattedLastUpdated = date('F j, Y', $lastUpdatedTimestamp);
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: ' . $formattedLastUpdated . '</i></p>';
                    } else {
                        echo '<p style="font-size: 13px; color: #6C757D; margin-top: -12px;"><i>Last Updated: Invalid Date</i></p>';
                    }

                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // If there are no pending assistance applications, display a message
                        echo '<p>No pending assistance applications.</p>';
                    }
        ?>

    <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
   arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
  });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>