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
    <title>Applicant Records</title>
    <link rel="stylesheet" href="css\sidebar.css">
    <link rel="stylesheet" href="css\view-volunteer.css">
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">
  
    <style>
      /*Export Button*/
      .exp-btn .e-btn {
          position: center;
          border-radius: 5px;
          border: 2px solid #1282A2;
          padding: 12px;
          margin-bottom: 25px;
          background-color: #EFEFEF;
          color: #034078;
          font-size: small;
          width: 100%;
      }
      .exp-btn .e-btn:hover{
          color: #EFEFEF;
          background-color: #1282A2;
      }
      .fas{
        margin-right: 5px;
      }
    </style>
   </head>
<body>

<!--LOADER-->
<script src="js/loader.js"></script>
    <div class="loader"></div>

<!-- TITLE BARS -->
    <div class="header">
        <h5>RECORDS OF APPLICANTS</h5>
    </div>

  <div class="sidebar close">
    <div class="logo-details">
    <i  img src="images/dora.png" alt="doralogo"></i>
      <span class="logo_name">DORA</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="socialworker_home.php">
          <i class='bx bx-grid-alt' ></i>
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

                  <div class="container table w-75">
                      <!--Export Volunteer List Button-->
                      <div class="exp-btn" style= "text-align: center;">
                          <a href="report_assist_list.php?id=<?php echo $id; ?>" target="_blank">
                          <button class="e-btn"><i class="fas fa-download"></i> Export List</button>
                          </a>
                      </div>

                    <ul class="nav nav-underline" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">All</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="verified-tab" data-bs-toggle="tab" data-bs-target="#verified-tab-pane" type="button" role="tab" aria-controls="verified-tab-pane" aria-selected="false">Verified</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="false">Pending</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invalid-tab" data-bs-toggle="tab" data-bs-target="#invalid-tab-pane" type="button" role="tab" aria-controls="invalid-tab-pane" aria-selected="false">Invalid</button>
                      </li>

                    </ul>
            
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                        <table class="table">
                          <thead>
                            <tr>
                             
                              <th scope="col">Name</th>
                              <th scope="col">Contact No.</th>
                              <th scope="col">Email</th>
                              <th scope="col">Date</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>

                          <?php
                              $sql4 = "SELECT *,
                              CONCAT(tbl_appli_accs.fname, ' ', tbl_appli_accs.mname, ' ', tbl_appli_accs.lname) AS full_name
                              FROM tbl_applicants
                              RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id
                              WHERE tbl_applicants.assistance_id = $id
                              GROUP BY tbl_applicants.appli_id";
                            $result2 = mysqli_query($conn, $sql4);
                            while ($row = mysqli_fetch_array($result2)){
                                echo '
                                    <tr>
                                    
                                    <td>'.$row['full_name'].'</td>
                                    <td>'.$row['full_contact'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.date('F j, Y', strtotime($row['submitteddate'])).'</td> 
                                    <td>';
                                if ($row['stat'] == 'Verified') {
                                    echo '<p style="color: green">'.$row['stat'].'</p>';
                                } elseif ($row['stat'] == 'Pending') {
                                    echo '<p style="color: orange">'.$row['stat'].'</p>';
                                } elseif ($row['stat'] == 'Invalid') {
                                  echo '<p style="color: red">'.$row['stat'].'</p>';
                                }
                                echo '</td>
                                <td><a href="applicant-verification.php?applicant_id='.$row['applicant_id'].'&id='.$id.'"><button type="button" class="d-btn">Details</button></a></td>
                                </tr>
                                ';
                            }
                          ?>
                          </tbody>
                        </table>
                      
                      </div>
                      <div class="tab-pane fade" id="verified-tab-pane" role="tabpanel" aria-labelledby="verified-tab" tabindex="0">
                        <table class="table">
                          <thead>
                            <tr>
                            
                              <th scope="col">Name</th>
                              <th scope="col">Contact No.</th>
                              <th scope="col">Email</th>
                              <th scope="col">Date</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>

                          <?php
                            $sql4 = "SELECT *,
                              CONCAT(tbl_appli_accs.fname, ' ', tbl_appli_accs.mname, ' ', tbl_appli_accs.lname) AS full_name
                            FROM tbl_applicants
                            RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id
                            WHERE tbl_applicants.assistance_id = $id
                            AND stat = 'Verified'
                            GROUP BY tbl_applicants.appli_id";
                            $result2 = mysqli_query($conn, $sql4);
                            while ($row = mysqli_fetch_array($result2)){
                                echo '
                                    <tr>
                                   
                                    <td>'.$row['full_name'].'</td>
                                    <td>'.$row['full_contact'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.date('F j, Y', strtotime($row['submitteddate'])).'</td> 
                                    <td>';
                                if ($row['stat'] == 'Verified') {
                                    echo '<p style="color: green">'.$row['stat'].'</p>';
                                } 
                                echo '</td>
                                <td><a href="applicant-verification.php?applicant_id='.$row['applicant_id'].'&id='.$id.'"><button type="button" class="d-btn">Details</button></a></td>
                                </tr>
                                ';
                            }
                          ?>
                          </tbody>
                        </table>
                      </div>

                      <?php
if (isset($_POST['bulk_action'])) {
    if (isset($_POST['applicant_ids']) && is_array($_POST['applicant_ids'])) {
        $applicantIds = $_POST['applicant_ids'];
        $action = $_POST['bulk_action'];
        
        if ($action === 'verify') {
            $status = 'Verified';
            $successMessage = "Applicants Verified Successfully";
        } elseif ($action === 'invalidate') {
            $status = 'Invalid';
            $successMessage = "Applicants Invalidated Successfully";
        }
        
        $sql = "UPDATE tbl_applicants SET stat = ? WHERE applicant_id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            foreach ($applicantIds as $applicantId) {
                mysqli_stmt_bind_param($stmt, 'si', $status, $applicantId);
                mysqli_stmt_execute($stmt);
            }

            echo '<script>';
            echo 'var successMessage = "' . $successMessage . '";';
            echo 'alert(successMessage);'; 
            echo 'window.location.href = window.location.href;';
            echo '</script>';
        }
    }
}
?>

<div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
    <form method="POST">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th> 
                  
                    <th scope="col">Name</th>
                    <th scope="col">Contact No.</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = $_GET['id'];
                $sql4 = "SELECT *,
                CONCAT(tbl_appli_accs.fname, ' ', tbl_appli_accs.mname, ' ', tbl_appli_accs.lname) AS full_name
                FROM tbl_applicants
                RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id
                WHERE tbl_applicants.assistance_id = $id
                AND stat = 'Pending'
                GROUP BY tbl_applicants.appli_id";
                
                $result2 = mysqli_query($conn, $sql4);
                while ($row = mysqli_fetch_array($result2)){
                echo '
                    <tr>
                        <td>
                            <input type="checkbox" name="applicant_ids[]" value="' . $row['applicant_id'] . '">
                        </td>
                     
                        <td>' . $row['full_name'] . '</td>
                        <td>' . $row['full_contact'] . '</td>
                        <td>' . $row['email'] . '</td>
                        <td>' . date('F j, Y', strtotime($row['submitteddate'])) . '</td>
                        <td>';
                if ($row['stat'] == 'Pending') {
                    echo '<p style="color: orange">' . $row['stat'] . '</p>';
                }
                echo '</td>
                        <td>
                            <a href="applicant-verification.php?applicant_id=' . $row['applicant_id'] . '&id=' . $id . '">
                                <button type="button" class="d-btn">Details</button>
                            </a>
                        </td>
                    </tr>
                ';
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-success" name="bulk_action" value="verify">Verify Selected</button>
        <button type="submit" class="btn btn-danger" name="bulk_action" value="invalidate">Invalidate Selected</button>
        <button type="button" class="btn btn-primary select-all-btn">Select All</button>
    </form>
</div>


                         
                      <div class="tab-pane fade" id="invalid-tab-pane" role="tabpanel" aria-labelledby="invalid-tab" tabindex="0">
                        <table class="table">
                          <thead>
                            <tr>
                             
                              <th scope="col">Name</th>
                              <th scope="col">Contact No.</th>
                              <th scope="col">Email</th>
                              <th scope="col">Date</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                            
                          <tbody>

                             <?php
                              $sql4 = "SELECT *,
                              CONCAT(tbl_appli_accs.fname, ' ', tbl_appli_accs.mname, ' ', tbl_appli_accs.lname) AS full_name
                              FROM tbl_applicants
                              RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id
                              WHERE tbl_applicants.assistance_id = $id
                              AND stat = 'Invalid'
                              GROUP BY tbl_applicants.appli_id";
                            $result2 = mysqli_query($conn, $sql4);
                            while ($row = mysqli_fetch_array($result2)){
                                echo '
                                    <tr>
                                
                                    <td>'.$row['full_name'].'</td>
                                    <td>'.$row['full_contact'].'</td>
                                    <td>'.$row['email'].'</td>
                                    <td>'.date('F j, Y', strtotime($row['submitteddate'])).'</td> 
                                    <td>';
                                if ($row['stat'] == 'Invalid') {
                                    echo '<p style="color: red">'.$row['stat'].'</p>';
                                } 
                                echo '</td>
                                <td><a href="applicant-verification.php?applicant_id='.$row['applicant_id'].'&id='.$id.'"><button type="button" class="d-btn">Details</button></a></td>
                                </tr>
                                ';
                            }
                            ?>
                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>
                    </div>
                  </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bulk Verification and Invalidation -->
<script>
    $(document).ready(function() {
        $(".select-all-btn").click(function() {
            $("input[name='applicant_ids[]']").prop('checked', true);
        });
    });
</script>

  
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
