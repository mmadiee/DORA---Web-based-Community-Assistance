<?php

include 'includes/config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($admin_id);
   session_destroy();
   header('location:/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Social Worker Details</title>

   <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/dn-fullproject.css">   

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!--ICONS-->
      <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">


    <style>
        .table.table-bordered th,
        .table.table-bordered td 
        {
            border: none;
        }

            .table-container table {
            width: 100%;
            table-layout: fixed; 
        }

        .table-container table tbody tr td {
            word-wrap: break-word; 
        }

        .table-container {
            max-height: 250px; 
            overflow-y: auto;
            margin-bottom: 50px; 
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
            <span class="logo_name">DORA</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="admin_home.php">
                    <i class='bx bx-home'></i>
                    <span class="link_name">Home</span>
                </a>
            </li>
               <li>
                <a href="dora_projects.php">
                    <i class='bx bx-news'></i>
                    <span class="link_name">Projects</span>
                </a>
            </li>
            <li>
                <a href="donation-funds.php">
                    <i class='bx bxs-receipt'></i>
                    <span class="link_name">Donation Funds</span>
                </a>
            </li>
            <!-- ADMINS -->
            <li>
                <a href="donation-analytics.php">
                    <i class='bx bx-money'></i>
                    <span class="link_name">Donation Analytics</span>
                </a>
            </li>
            <li>
                <a href="volunteer-analytics.php">
                    <i class='bx bx-group'></i>
                    <span class="link_name">Volunteer Analytics</span>
                </a>
            </li>
            <li>
                <a href="assistance-analytics.php">
                    <i class='bx bx-donate-heart'></i>
                    <span class="link_name">Assistance Analytics</span>
                </a>
            </li>
            <li>
                <a href="sw-analytics.php">
                    <i class='bx bx-bar-chart-alt'></i>
                    <span class="link_name">Social Worker Analytics</span>
                </a>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="socialworkers.php">
                        <i class='bx bxs-user-detail'></i>
                        <span class="link_name">Social Workers</span>
                    </a>
                </div>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="pending-accs.php">
                        <i class='bx bxs-user-plus'></i>
                        <span class="link_name">Pending Accounts</span>
                    </a>
                </div>
            </li>

            
            <li>
                <div class="iocn-link">
                    <a href="sw-activity.php">
                        <i class='bx bx-time'></i>
                        <span class="link_name">Workers Activity</span>
                    </a>
                </div>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="logout.php">
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
  <div class="header">
        <h5>Social Worker Details</h5>
  </div>

  <section class="home-section">

    <div class="wrapper">

    <div class="back-btn">
        <button type="button" class="btn" onclick="goBack()">Back</button>
        </div>

    <?php 
            $sw_id = $_GET['sw_id'];
            $sql = "SELECT * FROM tbl_sw_accs where tbl_sw_accs.sw_id = $sw_id ";
            $sql = "SELECT *, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name FROM tbl_sw_accs WHERE tbl_sw_accs.sw_id = $sw_id";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)){
                echo'
                <div class="container">
                <div class="main-body">
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body" style="border: 2px solid #000000;">
                  <div class="d-flex flex-column align-items-center text-center"><br><br>
                  <img src="/uploaded_img/'.$row['image'].'"height="150px"><br>
                  <div class="mt-3">
                      <h4>'.$row['name'].'</h4>
                      <p class="text-secondary mb-3">Social Worker Account</p><br><br>
                      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal">
                    View Valid ID
                </button>

                <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Social Worker ' . $row['idtype'] . '  </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="/uploaded_valid_id/' . $row['valid_image'] . '" style="max-width: 100%; height: auto">
                    </div>
                </div>
            </div>
        </div>

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
                <div class="card-body" style="border: 2px solid #000000;">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['full_name'].' </b></div></div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['email'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['full_contact'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Street</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['street'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Barangay</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['brgy'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Municipality</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['municipality'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">City/Province</h6><br>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['city'].'
                    </div></b>
                  </div>
                  </div>
                </div>
              </div>';}?>


        <?php
                $sql = "SELECT * FROM tbl_sw_accs WHERE sw_id = $sw_id ";
                $result = mysqli_query($conn, $sql);
                $subject = "";
                $message = "";
                while ($row = mysqli_fetch_array($result)){
                  $email = $row['email'];
                  $fname = $row['fname'];
                  $status = $row['status'];
                  if ($status == 'Invalid') {
                      $subject = 'Message from the Admin';
                      $message = " ";
                  } elseif ($status == 'Verified') {
                      $subject = 'Message from the Admin';
                      $message = "";
                  }
              }
  
              echo '<div style="text-align: center;">';
  
              echo '</div>';
              if ($status == 'Verified') {
                echo '
                <!--button to open the modal -->
    <div class="text-center" >
        <button type="button" class="btn btn-primary btn-lg" style="width: 100%" data-bs-toggle="modal" data-bs-target="#emailModal">Send Email</button>
    </div>

    <!-- email modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- Email form content -->
            <form action="send_email_sw.php" method="post">
              
              <div class="mb-3">
                <label for="recipientEmail" class="form-label"><b>Recipient Email</b></label>
                <input type="email" class="form-control" id="email" name="email" value="' . $email . '" required>
              </div>

      <div class="">
                <label for="subject" class="form-label"><b>Subject</b></label>
                <input type="text" class="form-control" name="subject" id="subject" value="' . $subject . '" required>
                            </div>

      <div class="mb-3">
                <label for="message" class="form-label"><b>Message</b></label>
                <textarea class="form-control" name="message" id="message" rows="6" required>' . $message . '</textarea>
                            </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="javascript:void(0);" onclick="confirmEmail()">
                  <button type="submit" name="send" class="btn btn-primary">Send Email</button>
                </a>
              </div>
            </form>
        </div>
      </div>
    </div>';
             }

             echo '</div>';
             ?>
             

            <!-- SOCIAL WORKER ON GOING DONATION DRIVES COUNT -->
            <?php
                  $sql = "SELECT COUNT(*) as donproj_count FROM tbl_don_proj WHERE tbl_don_proj.sw_id = $sw_id AND proj_stat = 'ON GOING'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo'<div class="col-sm-4 mb-3"><br>
                          <div class="card-body">';
                          echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                          echo '<h6 style="color:darkblue" class="d-flex align-items-center mb-3"><b>ON GOING DONATION DRIVES</h6></b>';
                          echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $row["donproj_count"] .  '</p></b>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                      }
                  } 

                // SOCIAL WORKER VOLUNTEER PROJECT COUNT
                  $sql = "SELECT COUNT(*) as volproj_count FROM tbl_vol_proj WHERE tbl_vol_proj.sw_id = $sw_id AND proj_stat = 'ON GOING'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo'<div class="col-sm-4 mb-3"><br>
                          <div class="card-body">';
                          echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                          echo '<h6 style="color:darkblue" class="d-flex align-items-center mb-3"><b>ON GOING VOLUNTEERING PROJECTS</h6></b>';
                          echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $row["volproj_count"] .  '</p></b>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                      }
                  } 


                // SOCIAL WORKER ASSISTANCE PROJECT COUNT
                  $sql = "SELECT COUNT(*) as assistproj_count FROM tbl_assistance WHERE tbl_assistance.sw_id = $sw_id AND proj_stat = 'ON GOING'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo'<div class="col-sm-4 mb-3"><br>
                          <div class="card-body">';
                          echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                          echo '<h6 style="color:darkblue" class="d-flex align-items-center mb-3"><b>ON GOING ASSISTANCE PROJECTS</h6></b>';
                          echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $row["assistproj_count"] .  '</p></b>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                      }
                  } 

                // PENDING DONATION TRANSACTIONS 
                  $sql = "SELECT COUNT(*) verified_transac FROM tbl_transaction t
                  LEFT JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
                  WHERE dp.sw_id = $sw_id and stat = 'Verified'";
                            $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo'<div class="col-sm-4 mb-3"><br>
                          <div class="card-body">';
                          echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                          echo '<h6 style="color:darkblue" class="d-flex align-items-center mb-3"><b>VERIFIED DONATION TRANSACTIONS</h6></b>';
                          echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $row["verified_transac"] .  '</p></b>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                      }
                  } 

                //  PENDING VOLUNTEER APPLICATIONS
                  $sql = "SELECT COUNT(DISTINCT CONCAT(t.user_id, '-', t.vol_proj_id)) AS pending_vols
                  FROM tbl_volunteers t
                  LEFT JOIN tbl_vol_proj dp ON t.vol_proj_id = dp.vol_proj_id
                  WHERE dp.sw_id = $sw_id AND t.stat = 'Pending'";
          
                            $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo'<div class="col-sm-4 mb-3"><br>
                          <div class="card-body">';
                          echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                          echo '<h6 style="color:darkblue" class="d-flex align-items-center mb-3"><b>PENDING VOLUNTEER APPLICATIONS</h6></b>';
                          echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $row["pending_vols"] .  '</p></b>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                      }
                  } 

                    //  PENDING ASSISTANCE APPLICATIONS 
                  $sql = "SELECT COUNT(DISTINCT CONCAT(t.appli_id, '-', t.assistance_id)) AS pending_assist
                  FROM tbl_applicants t
                  LEFT JOIN tbl_assistance dp ON t.assistance_id = dp.assistance_id
                  WHERE dp.sw_id = $sw_id AND t.stat = 'Pending'";

                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo'<div class="col-sm-4 mb-3"><br>
                          <div class="card-body">';
                          echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                          echo '<h6 style="color:darkblue" class="d-flex align-items-center mb-3"><b>PENDING ASSISTANCE APPLICATIONS</h6></b>';
                          echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $row["pending_assist"] .  '</p></b>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                      }
                  } 
                  ?>



<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-lg-4">
            <!-- SOCIAL WORKER DONATION PROJECTS HISTORY -->
            <div class="table-responsive table-container" style="border: 2px solid #000000; height: 300px;">
                <h2 style="margin-top: 20px; margin-bottom: 20px; text-align: center; color: darkblue;"><b>Donation Projects History</b></h2>
                <table class="table table-bordered">
                    <tbody>
                        <!-- Donations PHP code -->
                        <?php
                        $sql = "SELECT * FROM tbl_don_proj WHERE sw_id = $sw_id ORDER BY start DESC";
                        $req3 = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($req3) == 0) {
                          echo '<tr><td colspan="2" class="text-center">No Uploaded Content at this time</td></tr>';
                        } else {
                            while ($row = mysqli_fetch_assoc($req3)) {
                                echo '
                                <tr>
                                    <td style="text-align: center;">
                                        <b><a href="donation_projects.php?id=' . $row['don_project_id'] . '" 
                                        style="text-decoration: none; color: black;">' . $row['title'] . '</a></b>
                                    </td>
                                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- SOCIAL WORKER VOLUNTEER PROJECTS HISTORY -->
            <div class="table-responsive table-container" style="border: 2px solid #000000; height: 300px;">
                <h2 style="margin-top: 20px; margin-bottom: 20px; text-align: center; color: darkblue;"><b>Volunteer Projects History</b></h2>
                <table class="table table-bordered">
                    <tbody>
                        <!-- Volunteer Projects PHP code -->
                        <?php
                        $sql = "SELECT * FROM tbl_vol_proj WHERE sw_id = $sw_id ORDER BY uploadDate DESC";
                        $req3 = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($req3) == 0) {
                            echo '<tr><td colspan="2" class="text-center">No Uploaded Content at this time</td></tr>';
                        } else {
                            while ($row = mysqli_fetch_assoc($req3)) {
                                echo '
                                <tr>
                                    <td style="text-align: center;">
                                        <b><a href="volunteer_projects.php?id=' . $row['vol_proj_id'] . '" 
                                        style="text-decoration: none; color: black;">' . $row['title'] . '</a></b>
                                    </td>
                                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- SOCIAL WORKER ASSISTANCE PROJECTS HISTORY -->
            <div class="table-responsive table-container" style="border: 2px solid #000000; height: 300px;">
                <h2 style="margin-top: 20px; margin-bottom: 20px; text-align: center; color: darkblue;"><b>Assistance Projects History</b></h2>
                <table class="table table-bordered">
                    <tbody>
                        <!-- Assistance Projects PHP code -->
                        <?php
                        $sql = "SELECT * FROM tbl_assistance WHERE sw_id = $sw_id ORDER BY uploadDate DESC";
                        $req3 = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($req3) == 0) {
                            echo '<tr><td colspan="2" class="text-center">No Uploaded Content at this time</td></tr>';
                        } else {
                            while ($row = mysqli_fetch_assoc($req3)) {
                                echo '
                                <tr>
                                    <td style="text-align: center;">
                                        <b><a href="assistance_projects.php?id=' . $row['assistance_id'] . '" 
                                        style="text-decoration: none; color: black;">' . $row['title'] . '</a></b>
                                    </td>
                                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    

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
  
  // Back Button Functions
  function goBack() {
            window.history.back();
        }

  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>