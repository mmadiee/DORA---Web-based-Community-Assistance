<?php
include 'includes/config.php';

session_start();
$sw_id = $_SESSION['sw_id'];

if(!isset($sw_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($sw_id);
   session_destroy();
   header('location:/index.php');
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Volunteer Verification</title>
    <link rel="stylesheet" href="css\sidebar.css">
    <link rel="stylesheet" href="css\vol-verification.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">
  
   </head>
<body>

<!--LOADER-->
<script src="js/loader.js"></script>
    <div class="loader"></div>

<!-- TITLE BARS -->
    <div class="header">
        <h5>VOLUNTEER INFORMATION</h5>
    </div>

  <div class="sidebar close">
    <div class="logo-details">
    <i  img src="images/dora.png" alt="doralogo"></i>
      <span class="logo_name">DORA</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="socialworker_home.php">
          <i class='bx bx-home' ></i>
          <span class="link_name">Home</span>
        </a>
       <!-- DONATIONS -->
       <li>
          <div class="iocn-link">
            <a href="current_donation.php">
              <i class='bx bx-collection' ></i>
              <span class="link_name">Donation</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="current_donation.php">Donation</a></li>
            <li><a href="upload_donation.php">Upload Donation Drive</a></li>
            <li><a href="donation_analytics.php">Donation Analytics</a></li>
          </ul>
        </li>
        <!-- VOLUNTEERS -->
        <li>
          <div class="iocn-link">
            <a href="current_volunteer.php">
              <i class='bx bx-book-alt' ></i>
              <span class="link_name">Volunteer</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="current_volunteer.php">Volunteer</a></li>
            <li><a href="upload_volunteer.php">Upload Volunteer</a></li>
            <li><a href="volunteer_analytics.php">Volunteer Analytics </a></li>
          </ul>
        </li>
        <!-- ASSISTANCE -->
        <li>
          <div class="iocn-link">
            <a href="assistance.php">
            <i class='bx bx-compass' ></i>
              <span class="link_name">Assistance</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="assistance.php">Assistance</a></li>
            <li><a href="upload_assistance.php">Upload Assistance</a></li>
            <li><a href="assistance_analytics.php">Assistance Analytics</a></li>
          </ul>
        </li>


      <li>
  <form method="post" action="\Views\SocialWorker\socialworker_home.php">
    <a href="/login.php" onclick="document.querySelector('button[name=\'end\']').click();">
      <i class='bx bx-log-out'></i>
      <input type="hidden" name="end" value="true">
      <span class="link_name">Logout</span>
    </a>
    <button type="submit" name="end" style="display: none;"></button>
  </form>
</li>

      <li>
    <div class="profile-details">
      <div class="profile-content">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `tbl_sw_accs` WHERE sw_id = '$sw_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="/uploaded_img/'.$fetch['image'].'">';
         }
      ?>
      </div>
    </div>
  </li>
</ul>
  </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_vol_proj RIGHT JOIN tbl_sw_accs ON tbl_vol_proj.sw_id = tbl_sw_accs.sw_id  WHERE tbl_vol_proj.vol_proj_id = '$id'";
        $result = mysqli_query($conn, $sql);

        echo '
        <div class="back-btn">
          <a href="view-volunteers.php?id='.$id.'"><button class="b-btn" type="button">Back to Records of Volunteers</button></a>
        </div>
        ';

        // QUERY TO KNOW THE NUMBER OF VERIFIED VOLUNTEERS
        $sql2 = "SELECT COUNT(*) AS verified_volunteer_count
        FROM tbl_volunteers
        WHERE stat = 'Verified' AND vol_proj_id = '$id'";

        $result_verified = mysqli_query($conn, $sql2);
        $row_verified = mysqli_fetch_assoc($result_verified);
        $verified_volunteer_count = $row_verified['verified_volunteer_count'];

        // QUERY TO KNOW THE NUMBER OF PENDING VOLUNTEERS
        $sql3 = "SELECT COUNT(*) AS pending_count
        FROM tbl_volunteers
        WHERE vol_proj_id = '$id' AND stat = 'Pending'";

        $result_pending = mysqli_query($conn, $sql3);
        $row_pending = mysqli_fetch_assoc($result_pending);
        $pending_vol_count = $row_pending['pending_count'];

        // QUERY TO KNOW THE TOTAL GOAL
        $sql4 = "SELECT totalGoal FROM tbl_vol_proj WHERE vol_proj_id = '$id'";
        $result_goal = mysqli_query($conn, $sql4);
        $row_goal = mysqli_fetch_assoc($result_goal);
        $total_goal = $row_goal['totalGoal'];

        //COMPUTATION
        while ($row = mysqli_fetch_array($result)) {
            $remaining = $total_goal - $verified_volunteer_count;
            $projectTitle = $row['title'];


            echo '
            <div class="container text-center w-75">
              <div class="row">
                <h5>'.$row['title'].'</h5>
              </div>
              <div class="row">
                <div class="data-box">
                  <div class="row">
                    <div class="col-3">
                      <p class="data">'.$total_goal.'</p>
                      <p class="data-label">Total Volunteers Needed</p>
                    </div>
                    <div class="col-3">';
            if ($verified_volunteer_count >= $total_goal) {
                echo '
                      <p class="data"> <span>&#10003;</span> </p>
                      <p class="data-label">Goal Reached!</p>
                      ';
            } else {
                echo '
                      <p class="data">'.$remaining.' </p>
                      <p class="data-label">Remaining</p>  ';
            }
            echo '
                    </div>
                    <div class="col-3">
                      <p class="data">'.$verified_volunteer_count.'</p>
                      <p class="data-label">Volunteers Count</p>
                    </div>
                    <div class="col-3">
                      <p class="data">'.$pending_vol_count.'</p>
                      <p class="data-label">Pending Volunteers</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
        }
        ?>

<?php
$volunteer_id = $_GET['volunteer_id'];
$sql5 = "SELECT *, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.mname, ' ', tbl_dv_accs.lname) AS full_name,
CONCAT(tbl_dv_accs.street, ', ', tbl_dv_accs.brgy, ', ', tbl_dv_accs.municipality, ', ', tbl_dv_accs.city) AS address,
TIMESTAMPDIFF(YEAR, tbl_dv_accs.birthday, CURDATE()) AS age
FROM tbl_volunteers RIGHT JOIN tbl_dv_accs ON tbl_volunteers.user_id = tbl_dv_accs.user_id 
WHERE tbl_volunteers.volunteer_id = '$volunteer_id'";

$result3 = mysqli_query($conn, $sql5);
$status = ''; // Initialize a variable to store the status

while ($row = mysqli_fetch_array($result3)) {
    $status = $row['stat'];

    echo '
    <div class="container table w-75">
        <div class="row">
            <div class="col-4">
                <div class="row">
                    <div class="fieldbox">
                        ' . $volunteer_id . '
                    </div>
                    Volunteer ID 
                </div>

                <div class="row">
                    <div class="fieldbox">
                        ' . $row['full_name'] . '
                    </div>
                    Name
                </div>
                
                <div class="row">
                    <div class="fieldbox">
                         ' . date('F j, Y', strtotime($row['birthday'])) . '
                    </div>
                    Birthday
                </div>

                <div class="row">
                    <div class="fieldbox">
                        ' . $row['age'] . '
                    </div>
                    Age
                </div>

                <div class="row">
                    <div class="fieldbox">
                        ' . $row['gender'] . '
                    </div>
                    Gender
                </div>

                

                <div class="row">
                    <div class="fieldbox">
                        ';
    if ($row['stat'] == 'Verified') {
        echo '<p style="color: green; margin: 0;">' . $row['stat'] . '</p>';
    } elseif ($row['stat'] == 'Pending') {
        echo '<p style="color: orange; margin: 0;">' . $row['stat'] . '</p>';
    } elseif ($row['stat'] == 'Invalid') {
        echo '<p style="color: red; margin: 0;">' . $row['stat'] . '</p>';
    }
    echo '
                    </div>
                    Status
                </div>
            </div>

            <div class="col-4">
                <div class="row">
                    <div class="fieldbox">
                        ' . $row['full_contact'] . '
                    </div>
                    Contact Number
                </div>

                <div class="row">
                    <div class="fieldbox">
                        ' . $row['address'] . '
                    </div>
                    Address
                </div>

                <div class="row">
                    <div class="fieldbox">
                        ' . $row['occupation'] . '
                    </div>
                    Occupation
                </div>

                <div class="row">
                    <div class="fieldbox">
                        ' . $row['story'] . '
                    </div>
                    Reason for Volunteering
                </div>
                
                <div class="row">
                    <div class="fieldbox">
                        ' . date('F j, Y', strtotime($row['submitteddate'])) . '
                    </div>
                    Date Submitted
                </div>


            </div>

            <div class="col-4">
                <div class="box">
                    <button type="button" class="view-button" data-bs-toggle="modal" data-bs-target="#myModal">
                        View Valid ID
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Volunteer ' . $row['idtype'] . '  </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">';
                                $validImagePath = '/valid_images/' . $row['valid_image'];
                                $defaultImagePath = '/Views/Donors-Volunteers/valid_img/' . $row['valid'];
                            
                                // Check if the "valid" column is present and has a valid file name
                                $useDefaultImage = empty($row['valid']) || !file_exists($_SERVER['DOCUMENT_ROOT'] . '/Views/Donors-Volunteers/valid_img/' . $row['valid']);
                            
                                // Display the appropriate image
                                if (!$useDefaultImage) {
                                    echo '<img src="/Views/Donors-Volunteers/valid_img/' . $row['valid'] . '" style="max-width: 100%; height: auto">';
                                } elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . $validImagePath)) {
                                    echo '<img src="' . $validImagePath . '" style="max-width: 100%; height: auto">';
                                } else {
                                    echo '<p>User Did Not Upload an Image! Notify them through Email.</p>';
                                }
                                echo '</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}
?>



<?php

use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    
$volunteer_id = $_GET['volunteer_id'];
$id = $_GET['id'];

if (isset($_POST['invalid'])) {
    // Update volunteer status to 'Invalid'
    $sql7 = "UPDATE tbl_volunteers SET stat = 'Invalid' WHERE volunteer_id = " . $volunteer_id;
    $query_run = mysqli_query($conn, $sql7);

    // Get volunteer's information from tbl_dv_accs
    $dvQuery = "SELECT fname, lname FROM tbl_dv_accs WHERE user_id IN (SELECT user_id FROM tbl_volunteers WHERE volunteer_id = $volunteer_id)";
    $dvResult = mysqli_query($conn, $dvQuery);
    $dvRow = mysqli_fetch_assoc($dvResult);

    // Assign values to variables
    $fname = $dvRow['fname'];
    $lname = $dvRow['lname'];

    // Get project title from tbl_vol_proj based on vol_proj_id
    $projQuery = "SELECT title FROM tbl_vol_proj WHERE vol_proj_id = $id";
    $projResult = mysqli_query($conn, $projQuery);
    $projRow = mysqli_fetch_assoc($projResult);

    // Assign value to variable
    $projectTitle = $projRow['title'];

    // Get volunteer's email from tbl_dv_accs using user_id
    $emailQuery = "SELECT email FROM tbl_dv_accs WHERE user_id IN (SELECT user_id FROM tbl_volunteers WHERE volunteer_id = $volunteer_id)";
    $emailResult = mysqli_query($conn, $emailQuery);
    $emailRow = mysqli_fetch_assoc($emailResult);
    $volunteerEmail = $emailRow['email'];

    // Send email to volunteer
    $subject = "Volunteer Status Update";
    $message = "
    <body style='font-family: Arial, sans-serif; background-color: #f2f2f2;'>
        <div style='background-color: #ffffff; padding: 20px; text-align: center;'>
            <div style='background-color: #007bff; color: #ffffff; padding: 10px; text-align: center;'>
                <h1>Your Account Update</h1>
            </div>
            <div style='padding: 20px; text-align: center;'>
                <p>Dear $fname $lname, your volunteer application for project: $projectTitle has been marked as Invalid.</p>
            </div>
            <div style='margin-top: 20px; text-align: center;'>
                <a href='https://projectsbydora.com' style='background-color: #007bff; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; color: #ffffff;'>
                    Visit Our Website
                </a>
            </div>
        </div>
    </body>
";


    sendEmailToVolunteer($volunteerEmail, $subject, $message);

    // Show success message and redirect
    echo '<script>';
    echo 'Swal.fire({
            title: "Volunteer Marked as Invalid",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "vol-verification.php?volunteer_id=' . $volunteer_id . '&id=' . $id . '";
        });';
    echo '</script>';
} elseif (isset($_POST['verify'])) {
    // Update volunteer status to 'Verified'
    $sql8 = "UPDATE tbl_volunteers SET stat = 'Verified' WHERE volunteer_id = " . $volunteer_id;
    $query_run = mysqli_query($conn, $sql8);

    // Get volunteer's information from tbl_dv_accs
    $dvQuery = "SELECT fname, lname FROM tbl_dv_accs WHERE user_id IN (SELECT user_id FROM tbl_volunteers WHERE volunteer_id = $volunteer_id)";
    $dvResult = mysqli_query($conn, $dvQuery);
    $dvRow = mysqli_fetch_assoc($dvResult);

    // Assign values to variables
    $fname = $dvRow['fname'];
    $lname = $dvRow['lname'];

    // Get project title from tbl_vol_proj based on vol_proj_id
    $projQuery = "SELECT title FROM tbl_vol_proj WHERE vol_proj_id = $id";
    $projResult = mysqli_query($conn, $projQuery);
    $projRow = mysqli_fetch_assoc($projResult);

    // Assign value to variable
    $projectTitle = $projRow['title'];

    // Get volunteer's email from tbl_dv_accs using user_id
    $emailQuery = "SELECT email FROM tbl_dv_accs WHERE user_id IN (SELECT user_id FROM tbl_volunteers WHERE volunteer_id = $volunteer_id)";
    $emailResult = mysqli_query($conn, $emailQuery);
    $emailRow = mysqli_fetch_assoc($emailResult);
    $volunteerEmail = $emailRow['email'];

    // Send email to volunteer
    $subject = "Volunteer Status Update";
    $message = "
    <body style='font-family: Arial, sans-serif; background-color: #f2f2f2;'>
        <div style='background-color: #ffffff; padding: 20px; text-align: center;'>
            <div style='background-color: #007bff; color: #ffffff; padding: 10px; text-align: center;'>
                <h1>Your Account Update</h1>
            </div>
            <div style='padding: 20px; text-align: center;'>
                <p>Good Day! Dear $fname $lname, your volunteer application for project: $projectTitle has been marked as Verified. The Electronic ID is now available at your designated DORA Account. See you soon!</p>
            </div>
            <div style='margin-top: 20px; text-align: center;'>
                <a href='https://projectsbydora.com' style='background-color: #007bff; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; color: #ffffff;'>
                    Visit Our Website
                </a>
            </div>
        </div>
    </body>
    ";

    sendEmailToVolunteer($volunteerEmail, $subject, $message);

    // Show success message and redirect
    echo '<script>';
    echo 'Swal.fire({
            title: "Volunteer Verified Successfully and Email Sent to Volunteer",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "vol-verification.php?volunteer_id=' . $volunteer_id . '&id=' . $id . '";
        });';
    echo '</script>';
}

// Email function to send an email to a volunteer
function sendEmailToVolunteer($volunteerEmail, $subject, $message) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'projectsbydora@gmail.com';
    $mail->Password = 'tdxytcpjqcrripgu';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('projectsbydora@gmail.com');
    $mail->addAddress($volunteerEmail);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    try {
        if ($mail->send()) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Volunteer status updated and email sent.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location = 'vol-verification.php?volunteer_id=' . $volunteer_id . '&id=' . $id . ';
            });
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Email could not be sent. Please try again.',
                showConfirmButton: false,
                timer: 2000
            });
            </script>";
        }
    } catch (Exception $e) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Email could not be sent. Please try again.',
            showConfirmButton: false,
            timer: 2000
        });
        </script>";
    }
}

?>


            <form method="POST">
              <?php
                $id = $_GET['id'];
                $volunteer_id = $_GET['volunteer_id'];
                $sql6 = "SELECT * FROM tbl_volunteers WHERE tbl_volunteers.volunteer_id = ".$volunteer_id;
                $result4 = mysqli_query($conn, $sql6);
                echo '<div class="container w-75 text-center">';
                while ($row = mysqli_fetch_array($result4)){
                    echo '
                      <input type="hidden" value="'.$id.'" name="id">
                      <input type="hidden" value="'.$volunteer_id.'" name="volunteer_id">
                    ';
                    if ($row['stat'] == 'Pending') {
                        echo '
                            <button type="submit" class="btn btn-success" style="margin: 10px;" name="verify">Verify</button>
                        ';
                        echo '
                            <button type="submit" class="btn btn-danger" style="margin: 10px;" name="invalid">Invalid Applicant</button>
                        ';
                    } elseif ($row['stat'] == 'Verified') {
                        echo '
                            <button type="submit" class="btn btn-danger" style="margin: 10px;" name="invalid">Invalid Applicant</button>
                        ';
                    }
                }
                echo '</div>';             
              ?>
            </form>

            <?php
              $volunteer_id = $_GET['volunteer_id'];
              $sql5 = "SELECT * FROM tbl_volunteers RIGHT JOIN tbl_dv_accs ON tbl_volunteers.user_id = tbl_dv_accs.user_id WHERE tbl_volunteers.volunteer_id = '$volunteer_id'";
              $result3 = mysqli_query($conn, $sql5);
              $email = ""; 


              while ($row = mysqli_fetch_array($result3)) {
                $email = $row['email']; 

                echo '<div class="container table w-75">';
                echo '<div class="col-4 text-center mt-4 mb-4">';
                echo '<div class="box">';
            
                if ($row['stat'] == 'Verified') {
                    echo '<a href="electronic_id.php?volunteer_id=' . $row['volunteer_id'] . '&id=' . $id . '" class="btn btn-primary view-button" style="color: black;">';
                    echo 'Generate Electronic ID';
                    echo '</a>';
                } else {
                  echo '<b>No Electronic ID Available</b>';
                }
            
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>

<?php
if ($status == 'Pending') {
    $sql5 = "SELECT *, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS full_name
    FROM tbl_volunteers RIGHT JOIN tbl_dv_accs ON tbl_volunteers.user_id = tbl_dv_accs.user_id WHERE tbl_volunteers.volunteer_id = '$volunteer_id'";
    $result3 = mysqli_query($conn, $sql5);
    $email = "";
    $name = "";
    $subject = "";
    $message = "";

    while ($row = mysqli_fetch_array($result3)) {
        $email = $row['email'];
        $name = $row['full_name'];
        $status = $row['stat'];
        if ($status == 'Pending') {
            $subject = 'Pending Application';
            $message = "Dear $name, your volunteer application for project: $projectTitle is currently pending review.\n\nYou can visit our website for more information.";
            }
          }
    
    echo '
    <!--button to open the modal -->
    <div class="text-center">
        <button type="button" class="btn btn-primary btn-lg mb-5" style="width: 72%" data-bs-toggle="modal" data-bs-target="#emailModal">Send Email</button>
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
            <form action="send_email_vol.php" method="post">
              
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

             <!-- Hidden input field for project title -->
              <input type="hidden" name="project_title" value="' . $projectTitle . '">

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="javascript:void(0);" onclick="confirmEmail()">
                  <button type="submit" name="send" class="btn btn-primary">Send Email</button>
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>';
    }
    ?>

<?php
if ($status == 'Invalid') {
    $sql5 = "SELECT *, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS full_name
    FROM tbl_volunteers RIGHT JOIN tbl_dv_accs ON tbl_volunteers.user_id = tbl_dv_accs.user_id WHERE tbl_volunteers.volunteer_id = '$volunteer_id'";
    $result3 = mysqli_query($conn, $sql5);
    $email = "";
    $name = "";
    $subject = "";
    $message = "";

    while ($row = mysqli_fetch_array($result3)) {
        $email = $row['email'];
        $name = $row['full_name'];
        $status = $row['stat'];
        if ($status == 'Invalid') {
            $subject = 'Invalid Application';
            $message = "Dear $name, your volunteer application for project: $projectTitle has been marked Invalid.\n\nYou can visit our website for more information.";
            }
          }
    
    echo '
    <!--button to open the modal -->
    <div class="text-center" >
        <button type="button" class="btn btn-primary btn-lg" style="width: 72%" data-bs-toggle="modal" data-bs-target="#emailModal">Send Email</button>
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
            <form action="send_email_vol.php" method="post">
              
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

             <!-- Hidden input field for project title -->
              <input type="hidden" name="project_title" value="' . $projectTitle . '">

              <!-- Checkbox for age not appropriate -->
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Did not meet Age Requirements" id="ageCheckbox" name="reasons[]" onchange="updateMessage()">
                  <label class="form-check-label" for="ageCheckbox">
                      Did not meet Age Requirements
                  </label>
              </div>
          
              <!-- Checkbox for invalid ID -->
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Valid ID submitted is invalid" id="idInvalidCheckbox" name="reasons[]" onchange="updateMessage()">
                  <label class="form-check-label" for="idInvalidCheckbox">
                      Valid ID submitted is Invalid
                  </label>
              </div>
          
              <!-- Checkbox for male volunteers only -->
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Reason for Volunteering is Invalid" id="reasonCheckbox" name="reasons[]" onchange="updateMessage()">
                  <label class="form-check-label" for="maleCheckbox">
                      Reason for Volunteering is Invalid
                  </label>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="javascript:void(0);" onclick="confirmEmail()">
                  <button type="submit" name="send" class="btn btn-primary">Send Email</button>
                </a>
              </div><br>
            </form>
          </div>
        </div>
      </div>
    </div>';
    }
    ?>

<script>
    function updateMessage() {
    var status = "<?php echo $status; ?>";
    if (status === 'Invalid') {
    var message = "Dear <?php echo $name; ?>, your volunteer application for project: <?php echo $projectTitle; ?> has been marked as Invalid for the following reasons:\n";
      var checkboxesHTML = '';
      var reasons = document.getElementsByName('reasons[]');
      for (var i = 0; i < reasons.length; i++) {
        if (reasons[i].checked) {
          checkboxesHTML += '<input type="checkbox" checked disabled> ' + reasons[i].value + '<br>';
        }
      }

      message += checkboxesHTML;

      message += "\n\nYou can visit our website for more information: https://projectsbydora.com/index.php";

      document.getElementById('message').value = message;
    }
  }

  function confirmEmail() {
    Swal.fire({
      title: "Email Sent Successfully",
      text: "The email has been sent successfully.",
      icon: "success",
      confirmButtonText: "OK"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'view-volunteers.php?id=<?php echo $id; ?>';
      }
    });
  }
</script>

</section>
  
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;
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
