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

require 'phpqrcode/qrlib.php'; 

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Applicant Verification</title>
    <link rel="stylesheet" href="css\sidebar.css">
    <link rel="stylesheet" href="css\vol-verification.css">
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">
    <style>
    /* Styles for large screens */
    .profile-details {
      display: flex;
      align-items: center;
    }

    .profile-details .profile-image {
      max-width: 100px;
      max-height: 100px;
      border-radius: 50%;
    }

    .profile-details .logout-button {
      background-color: #001F54;
      color: white;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      border-radius: 4px;
      margin-left: 20px;
    }

    /* Styles for small screens */
    @media (max-width: 768px) {
      .profile-details {
        flex-direction: column;
      }

      .profile-details .logout-button {
        margin-left: 0;
        margin-top: 10px;
      }
    }

    .sms-form-container {
            background-color: #fff;
            border-radius: 5px;
            border-color: #034078;
            padding: 20px;
            width: 300px;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .sms-form-container h1 {
            color: #007BFF;
        }

        .sms-form-container label {
            font-weight: bold;
        }

        .sms-form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .sms-form-container textarea {
            height: 120px;
        }
  </style>
   </head>
<body>

<!--LOADER-->
<script src="js/loader.js"></script>
    <div class="loader"></div>

<!-- TITLE BARS -->
    <div class="header">
        <h5>APPLICANT INFORMATION</h5>
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
  <div class="profile-image">
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
  </li>
</ul>
  </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

       <?php
           $id = $_GET['id'];
           $sql = "SELECT * FROM tbl_assistance right join tbl_sw_accs on tbl_assistance.sw_id = tbl_sw_accs.sw_id  where tbl_assistance.assistance_id = '$id' ";
           $result = mysqli_query($conn, $sql);
           
           echo '
            <div class="back-btn">
              <a href = "assistance-details.php?id='.$id.'"><button class="b-btn" type="button">Back to Project Details</button></a>
            </div>
            ';

            while ($row = mysqli_fetch_array($result)){

            // QUERY TO KNOW THE NUMBER OF VERIFIED BENEFICIARIES
            $sql2 = "SELECT DISTINCT appli_id FROM tbl_applicants WHERE assistance_id = $id AND stat = 'Verified'";

            $mysqliStatus = $conn->query($sql2);
            $assistance_count = mysqli_num_rows($mysqliStatus);

            // QUERY TO KNOW THE NUMBER OF PENDING APPLICANTS
            $sql3 = "SELECT DISTINCT appli_id FROM tbl_applicants WHERE assistance_id = '".$row['assistance_id']."' AND stat = 'Pending'";
            $mysqliStatus = $conn->query($sql3);
            $pending_assistance_count = mysqli_num_rows($mysqliStatus);

              $remaining = $row['avail_slot'] - $assistance_count;        
              
              echo ' 
                <div class="container text-center w-75">
                  <div class="row">
                    <h5>'.$row['title'].'</h5>
                  </div>
                  <div class="row">
                      <div class="data-box">
                        <div class="row">
                          <div class="col-3">
                            <p class = "data">'.$row['avail_slot'].'</p>
                            <p class = "data-label">Total Beneficiaries Needed</p>
                          </div>
                          <div class="col-3">
                             '; if ($assistance_count >= $row['avail_slot']){
                                echo '
                                <p class = "data"> <span>&#10003;</span> </p>
                                <p class="data-label">Goal Reached!</p>
                                ';
                                }else{ echo '    
                            <p class = "data">'.$remaining.' </p>
                            <p class = "data-label">Remaining</p>  ';} echo'
                          </div>
                          <div class="col-3">
                            <p class = "data">'.$assistance_count.'</p>
                            <p class = "data-label">Beneficiaries Count</p>
                          </div>
                          <div class="col-3">
                            <p class = "data">'.$pending_assistance_count.'</p>
                            <p class = "data-label">Pending Applicants</p>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>';
              } ?>

        <?php
            $applicant_id = $_GET['applicant_id'];
            $sql5 = "SELECT *, CONCAT(tbl_appli_accs.fname, ' ', tbl_appli_accs.mname, ' ', tbl_appli_accs.lname) AS full_name 
            FROM tbl_applicants RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id 
            WHERE tbl_applicants.applicant_id = '$applicant_id'";
            
            $result3 = mysqli_query($conn, $sql5);
            while ($row = mysqli_fetch_array($result3)){
              $contactNumber = $row['contact'];
              $status = $row['stat'];

                echo '
                <div class="container table w-75">
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="fieldbox">
                                    '.$applicant_id.'
                                </div>
                                Applicant ID
                            </div>
                       
                            <div class="row">
                            <div class="fieldbox">
                                '.$row['full_name'].'
                            </div>
                            Name
                            </div>
                        
                            <div class="row">
                                <div class="fieldbox">
                                    '.date('F j, Y', strtotime($row['submitteddate'])).'
                                </div>
                                Date Submitted
                            </div>
                            
                            <div class="row">
                                <div class="fieldbox">
                                ';
                                if ($row['stat'] == 'Verified') {
                                    echo '<p style="color: green; margin: 0;">'.$row['stat'].'</p>';
                                } elseif ($row['stat'] == 'Pending') {
                                    echo '<p style="color: orange; margin: 0;">'.$row['stat'].'</p>';
                                } elseif ($row['stat'] == 'Invalid') {
                                    echo '<p style="color: red; margin: 0;">'.$row['stat'].'</p>';
                                }
                                echo '
                                </div>
                                Status
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row">
                                <div class="fieldbox">
                                     '.$row['full_contact'].'
                                </div>
                                Contact Number
                            </div>

                            <div class="row">
                                <div class="fieldbox">
                                    '.$row['email'].'
                                </div>
                                Email
                            </div>

                            <div class="row">
                                <div class="fieldbox">
                                    '.$row['text'].'
                                </div>
                                Purpose
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="box">
                                <button type="button" class="view-button" data-bs-toggle="modal" data-bs-target="#myModal">
                                View Applicant Requirement
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Applicant Requirement</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <img src="/Views/Assistance/assistance_img/'.$row['proof'].'" style="max-width: 100%; height: auto">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            ?>

            <!-- Verify Applicant -->
            <?php
              $applicant_id = $_GET['applicant_id'];
              $id = $_GET['id'];

              if(isset($_POST['invalid'])){
                  $sql7 = "UPDATE tbl_applicants SET stat = 'Invalid' WHERE applicant_id = ".$applicant_id;
                  $query_run = mysqli_query($conn, $sql7);
              }
              elseif (isset($_POST['verify'])) {
                  $sql8 = "UPDATE tbl_applicants SET stat = 'Verified' WHERE applicant_id = ".$applicant_id;
                  $query_run = mysqli_query($conn, $sql8);
              }
              ?>

            <form method="POST">
              <?php
                $id = $_GET['id'];
                $applicant_id = $_GET['applicant_id'];
                $sql6 = "SELECT * FROM tbl_applicants WHERE tbl_applicants.applicant_id = ".$applicant_id;
                $result4 = mysqli_query($conn, $sql6);
  
                echo '<div class="container w-75 text-center">';
                while ($row = mysqli_fetch_array($result4)){

                    echo '
                      <input type="hidden" value="'.$id.'" name="id">
                      <input type="hidden" value="'.$applicant_id.'" name="applicant_id">
                    '; 
                    if ($row['stat'] == 'Pending') {
                        echo '
                            <button type="submit" class="btn btn-success" style="margin: 10px;" name="verify">Verify</button>
                        ';
                        echo '
                            <button type="submit" class="btn btn-danger" style="margin: 10px;" name="invalid">Invalid Applicant</button>
                        ';
                    } 
                }
                echo '</div>';
              ?>
            </form>


            <?php
                $number = ""; 
                $message = ""; 

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $number = isset($_POST['number']) ? $_POST['number'] : "";
                    $message = isset($_POST['message']) ? $_POST['message'] : "";

                    $ch = curl_init();
                    $parameters = array(
                        'apikey' => '1cd3f888b8ad630421357b64b0758ea1', // Your API KEY
                        'number' => $number,
                        'message' => $message,
                        'sendername' => 'DORA'
                    );

                    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                    curl_setopt($ch, CURLOPT_POST, 1);

                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec($ch);
                    curl_close($ch);
                }
            ?>

            
            <?php
                        $applicant_id = $_GET['applicant_id'];
                        $sql5 = "SELECT *, CONCAT(tbl_appli_accs.fname, ' ', tbl_appli_accs.mname, ' ', tbl_appli_accs.lname) AS full_name 
                        FROM tbl_applicants 
                        RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id 
                        WHERE tbl_applicants.applicant_id = '$applicant_id'";
                        $result3 = mysqli_query($conn, $sql5);
                        while ($row = mysqli_fetch_array($result3)) {
                          $assistance_id = $_GET['id']; 
                          $sqlAssistance = "SELECT title FROM tbl_assistance WHERE assistance_id = '$assistance_id'";
                          $resultAssistance = mysqli_query($conn, $sqlAssistance);
                          $rowAssistance = mysqli_fetch_array($resultAssistance);
                          $projectTitle = $rowAssistance['title'];
                
                          if ($row['stat'] === 'Verified') {
                            $qrContent = "Applicant ID: $applicant_id\nName: {$row['full_name']}\nContact: {$row['full_contact']}\nEmail: {$row['email']}\nStatus: {$row['stat']}\nProject Title: $projectTitle";

                            $qrFileName = "../../Views/SocialWorker/qr_codes/applicant_$applicant_id.png"; 

                            QRcode::png($qrContent, $qrFileName, QR_ECLEVEL_L, 10);

                            $qrImagePath = $qrFileName; 
                            $updateQrImageQuery = "UPDATE tbl_applicants SET qr_code_path = '$qrImagePath' WHERE applicant_id = '$applicant_id'";
                            mysqli_query($conn, $updateQrImageQuery);

                                echo '
                                <div class="container table w-75">
                                <div class="row">
                                    <div class="qr-code" style="margin-bottom: 20px;">
                                        <img src="' . $qrFileName . '" alt="QR Code" width="350" height="350">
                                    </div>
                                </div>
                                </div>
                                </div>';

                          } else {
                            echo '    <div class="container table w-75">
                            <div class="row">
                          <div class="qr-code" style="margin-top: 20px; margin-bottom: 10px;">
                            <b><p>QR CODE NOT AVAILABLE</p></b>
                            </div>
                            </div>
                            </div>';
                            }
                                                  }
                          ?>
          
<?php
if ($status == 'Verified' || $status == 'Pending' || $status == 'Invalid') {
  $sql5 = "SELECT *, CONCAT(tbl_appli_accs.fname, ' ', tbl_appli_accs.lname) AS name 
  FROM tbl_applicants RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id 
  WHERE tbl_applicants.applicant_id = '$applicant_id'";
  
  $result3 = mysqli_query($conn, $sql5);
  $number = "";
  $name = "";
  $message = "";

  while ($row = mysqli_fetch_array($result3)) {
      $number = $row['full_contact'];
      $name = $row['name'];
      $status = $row['stat'];
      // Set the subject and message based on the status
      if ($status == 'Verified') {
        $message = "Dear $name, you are now a verified beneficiary for $projectTitle. The QR Code is now available at your designated DORA Account\n\nYou can visit our website for more information: https://projectsbydora.com/index.php";
        } elseif ($status == 'Pending') {
          $message = "Dear $name, your application for $projectTitle is currently pending review.\n\nYou can visit our website for more information: https://projectsbydora.com/index.php";
          } elseif ($status == 'Invalid') {
            $message = "Dear $name, your application for $projectTitle has been marked as invalid. Please contact us for further details.\n\nYou can visit our website for more information: https://projectsbydora.com/index.php";
            }
  }
}

echo '
<div class="text-center">
    <button type="button" class="btn btn-primary btn-lg" style="width: 72%" data-bs-toggle="modal" data-bs-target="#smsModal">Send SMS</button>
</div>
</div>
</div>

<!-- SMS modal -->
<div class="modal fade" id="smsModal" tabindex="-1" aria-labelledby="smsModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="smsModalLabel">Send SMS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <!-- SMS form content -->
        <form action="" method="post" id="smsForm" class="form-container mx-auto">
            <div class="mb-3">
                <label for="number" class="form-label"><b>Recipient Number</b></label>
                <input type="text" class="form-control" name="number" id="number" value="' . $number . '" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label"><b>Message</b></label>
                <textarea class="form-control" name="message" id="message" rows="6" required>' . htmlspecialchars($message) . '</textarea>
            </div>';

if ($status == 'Invalid') {
echo '<h6>Invalid Reasons:</h6>';
echo '
                <!-- Mismatched Submission -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Not Enough Proof" id="notEnoughProofCheckbox" name="reasons[]" onchange="updateMessage()">
                    <label class="form-check-label" for="notEnoughProofCheckbox">
                        Not Enough Proof
                    </label>
                </div>

                <!-- Other checkbox options for invalid status can be added similarly -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Reasons Are not Clear" id="reasonsNotClearCheckbox" name="reasons[]" onchange="updateMessage()">
                    <label class="form-check-label" for="reasonsNotClearCheckbox">
                        Reasons Are not Clear
                    </label>
                </div>
                ';
                }
                echo '
            <input type="hidden" name="project_title" value="' . $projectTitle . '">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn">Send SMS</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
';
?>
<br>


</div>
<br><br>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function updateMessage() {
        var status = "<?php echo $status; ?>";
        if (status === 'Invalid') {
            var message = "Dear <?php echo $name; ?>, your application for <?php echo $projectTitle; ?> has been marked as Invalid for the following reasons:\n";

            var reasons = document.getElementsByName('reasons[]');
            for (var i = 0; i < reasons.length; i++) {
                if (reasons[i].checked) {
                    message += '- ' + reasons[i].value + '\n';
                }
            }

            message += "\nYou can visit our website for more information: https://projectsbydora.com/index.php";

            document.getElementById('message').value = message;
        }
    }
</script>


<script>
    <?php if (isset($_POST['invalid'])) : ?>
        Swal.fire({
            title: "Applicant Marked as Invalid",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "applicant-verification.php?applicant_id=<?= $applicant_id ?>&id=<?= $id ?>";
        });
    <?php elseif (isset($_POST['verify'])) : ?>
        Swal.fire({
            title: "Applicant Verified Successfully",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.href = "applicant-verification.php?applicant_id=<?= $applicant_id ?>&id=<?= $id ?>";
        });
    <?php endif; ?>
</script>

<script>
  <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['number']) && isset($_POST['message'])) : ?>
    <?php if ($output === 'true') : ?>
      Swal.fire({
        title: "SMS Sent Successfully",
        text: "The SMS has been sent to <?= $number ?>.",
        icon: "success",
        confirmButtonText: "OK"
      });
    <?php else : ?>
      Swal.fire({
        title: "SMS Sent Successfully",
        text: "The SMS has been sent to <?= $number ?>.",
        icon: "success",
        confirmButtonText: "OK"
      }).then(function() {
            window.location.href = "view-assistance.php?applicant_id=<?= $applicant_id ?>&id=<?= $id ?>";
        });
    <?php endif; ?>
  <?php endif; ?>
</script>

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