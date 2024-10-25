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
    <title>Donation Project Details</title>
    <link rel="stylesheet" href="css\sidebar.css">
    <link rel="stylesheet" href="css\donation-details.css">
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
        <h5>DONATION PROJECT DETAILS</h5>
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
          $sql = "SELECT * FROM tbl_don_proj 
          right join tbl_sw_accs on tbl_don_proj.sw_id = tbl_sw_accs.sw_id  
          where tbl_don_proj.don_project_id = '$id' ";
          $result = mysqli_query($conn, $sql);

          // Reports and Updates Data
          $reportData = array(); 

          $sqlReports = "SELECT
              r.report_id,
              r.title AS report_title,
              r.body AS report_body,
              r.date_posted AS report_date,
              i.image_id,
              i.image_path
          FROM tbl_reports r
          LEFT JOIN tbl_reports_images i ON r.report_id = i.report_id
          WHERE r.project_id = $id AND r.project_type = 1";
          $resultReports = mysqli_query($conn, $sqlReports);

          if ($resultReports) {
              while ($reportRow = mysqli_fetch_assoc($resultReports)) {
                  $reportData[] = $reportRow; // Stores report data in the array
              }
          }

          // QUERY TO KNOW THE NUMBER OF DONORS
          $sql2 = "SELECT * FROM tbl_transaction WHERE don_project_id = $id AND stat = 'verified'";
          $mysqliStatus = $conn->query($sql2);
          $donor_count = mysqli_num_rows($mysqliStatus);

          // QUERY TO KNOW THE NUMBER OF PENDING TRANSACTIONS
          $sql4 = "SELECT * FROM tbl_transaction WHERE don_project_id = $id AND stat = 'pending'";
          $mysqliStatus = $conn->query($sql4);
          $pending_donor_count = mysqli_num_rows($mysqliStatus);

          //COMPUTATION
          $sql3 = "SELECT SUM(amount) FROM tbl_transaction WHERE don_project_id = $id AND stat = 'verified'";
          $result1 = mysqli_query($conn, $sql3); 
          $roww = mysqli_fetch_assoc($result1);
          $donation = $roww['SUM(amount)']; 
          $currentDate = date('Y-m-d');

          while ($row = mysqli_fetch_array($result)){
            $projectTitle = $row['title'];

            $remaining = $row['goal'] - $donation;
            if ($remaining <= 0){
              $remaining = 0;
            }
          ?>

            <?php 
            if ($row['proj_stat'] === "PAST DUE") {
                echo '<div class="alert alert-danger text-center" role="alert" style="margin-left: 20px; margin-right: 20px;">';
                echo 'This project has reached the deadline and is no longer posted. <br><b>Extend the project deadline!</b>';
                echo '</div>';
            }
            ?>
            
            <?php 
            if ($row['proj_stat'] === "GOAL REACHED") {
                echo '<div class="alert alert-success text-center" role="alert" style="margin-left: 20px; margin-right: 20px;">';
                echo 'This project has reached its goal!<br><b> Please wait for your payout from the Admin! </b>';
                echo '</div>';
            }
            ?>
            
            <?php 
            if ($row['proj_stat'] === "FUNDED") {
                echo '<div class="alert alert-info text-center" role="alert" style="margin-left: 20px; margin-right: 20px;">';
                echo 'The admin has sent the funds for this project! <br> <b> Do not forget to mark this project as complete once you distribute the funds to those who need them. </b>';
                echo '</div>';
            }
            ?>

          <div class="container w-75">
              <div class="title text-center">
                  <p><?php echo $row['category']; ?></p>
                  <h3><a href="/donation_projects.php?id=<?php echo $id; ?>" target="_blank"><?php echo $row['title']; ?></a></h3>
                  <p>Status: <?php echo $row['proj_stat']; ?> <br> Date Uploaded: <?php echo date('F j, Y', strtotime($row['start'])); ?></p>
              </div>
          </div>

          <div class="container info w-50 text-center">
              <div class="row mb-4">
                  <div class="col-6">
                      <div class="box">
                          <div class="row">
                              <p class="title"> Total Donation </p>
                          </div>
                          <div class="row">
                              <p class="data"> &#8369; <?php echo number_format($donation); ?> </p>
                          </div>
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="box">
                          <div class="row">
                              <p class="title"> Total Number of Donors </p>
                          </div>
                          <div class="row">
                              <p class="data"><?php echo $donor_count; ?></p>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="row mb-4">
                  <div class="col-6">
                      <div class="box">
                          <div class="row">
                              <p class="title"> Pending Transactions </p>
                          </div>
                          <div class="row">
                              <p class="data"><?php echo $pending_donor_count; ?></p>
                          </div>
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="box">
                          <div class="row">
                              <p class="title"> Project Deadline </p>
                          </div>
                          <div class="row">
                              <?php if ($row['end'] > $currentDate) { ?>
                                  <p class="data"><?php echo date('F j, Y', strtotime($row['end'])); ?></p>
                              <?php } else { ?>
                                  <p class="data">Deadline Reached</p>
                              <?php } ?>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="container data w-75">
            <div class="row">
              <div class="col-8">
                      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                          <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="pills-graph-tab" data-bs-toggle="pill" data-bs-target="#pills-graph" type="button" role="tab" aria-controls="pills-graph" aria-selected="true">Graph</button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button class="nav-link" id="pills-reports-tab" data-bs-toggle="pill" data-bs-target="#pills-reports" type="button" role="tab" aria-controls="pills-reports" aria-selected="false">Reports & Updates</button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button class="nav-link" id="pills-gallery-tab" data-bs-toggle="pill" data-bs-target="#pills-gallery" type="button" role="tab" aria-controls="pills-gallery" aria-selected="false">Project Gallery</button>
                          </li>
                      </ul>

                      <div class="tab-content" id="pills-tabContent">
                          <div class="tab-pane fade show active" id="pills-graph" role="tabpanel" aria-labelledby="pills-graph-tab" tabindex="0">
                              <div class="graph-box">
                                  <div class="graph">
                                      <canvas id="myPieChart" width="100" height="100"></canvas>
                                  </div>
                                  <div>
                                      <?php if ($donation >= $row['goal']) { ?>
                                          <p class="progress-text">Goal Reached!</p>
                                      <?php } else { ?>
                                          <p class="progress-text">&#8369; <?php echo number_format($donation); ?> raised <br> &#8369; <?php echo number_format($remaining); ?> to go</p>
                                      <?php } ?>
                                  </div>
                              </div>
                          </div>

                          <div class="tab-pane fade" id="pills-reports" role="tabpanel" aria-labelledby="pills-reports-tab" tabindex="0">
                                <div class="report-box scrollable-div">
                                    <ul>
                                        <?php
                                        // Reverse the order of $reportData to display the latest post on top
                                        $reportData = array_reverse($reportData);

                                        if (empty($reportData)) {
                                            echo '<li>';
                                            echo '<div>';
                                            echo '<p>No Reports or Updates yet. </p>';
                                            echo '</div>';
                                            echo '</li>';
                                        } else {
                                            $currentReportId = null; // Initialize a variable to track the current report
                                            foreach ($reportData as $reportRow) {
                                                // Check if this is a new report
                                                if ($reportRow['report_id'] !== $currentReportId) {
                                                    // Display report title, body, and date
                                                    echo '<li>';
                                                    echo '<h4>' . $reportRow['report_title'] . '</h4>';
                                                    echo '<p>' . $reportRow['report_body'] . '</p>';

                                                    
                                                    // Format and display the date in Asia/Manila timezone
                                                    $reportDate = strtotime($reportRow['report_date']);
                                                    
                                                    // Set the timezone to Asia/Manila
                                                    date_default_timezone_set('Asia/Manila');
                                                    
                                                    // Display the date and time
                                                    echo '<p class="report-date">' . date('F j, Y g:i A', $reportDate) . '</p>';

                                                    // Reset the current report ID and close the previous report
                                                    $currentReportId = $reportRow['report_id'];
                                                }

                                                // Display associated images (if any) in columns
                                                if (!empty($reportRow['image_path'])) {
                                                    // Check if $reportRow['image_path'] is an array of image paths
                                                    if (is_array($reportRow['image_path'])) {
                                                        foreach ($reportRow['image_path'] as $imagePath) {
                                                            echo '<div class="col">';
                                                            echo '<img src="' . $imagePath . '" class="report-image">';
                                                            echo '</div>';
                                                        }
                                                    } else {
                                                        // If it's a single image path, display it
                                                        echo '<div class="col">';
                                                        echo '<img src="' . $reportRow['image_path'] . '" class="report-image">';
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                          </div>

                          <div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab" tabindex="0">
                                <div class="gallery-box scrollable-div">
                                    <?php
                                    // Query to retrieve image data
                                    $sqlGallery = "SELECT image_path, uploaded_at FROM tbl_gallery_images WHERE project_id = $id AND project_type = 1 ORDER BY uploaded_at DESC;";
                                    $resultGallery = mysqli_query($conn, $sqlGallery);

                                    // Check if there are images in the gallery
                                    if (mysqli_num_rows($resultGallery) > 0) {
                                        // Loop through the rows of the result set to display images
                                        while ($rowGallery = mysqli_fetch_assoc($resultGallery)) {
                                            $imagePath = $rowGallery['image_path'];
                                            $uploadedAt = strtotime($rowGallery['uploaded_at']); // Convert to timestamp

                                            // Format date in English
                                            $englishDate = date('F j, Y', $uploadedAt);

                                            // Format time to display only the hour and minute
                                            $timeOnly = date('h:i A', $uploadedAt);

                                            // Generate the image HTML with date and time
                                            echo '<div class="gallery-image">';
                                            echo '<img src="\Views/SocialWorker/' . $imagePath . '">';
                                            echo '<div class="overlay">';
                                            echo '<p>' . $englishDate . '</p>';
                                            echo '<p>' . $timeOnly . '</p>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        // Display a "No images yet" message
                                        echo '<div>';
                                        echo '<p>No images yet. </p>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                          </div>
                      </div>
                </div>

                <?php
                  if ($row['proj_stat'] == 'ON GOING' || $row['proj_stat'] == 'PAST DUE') {
                ?>
                    <div class="col-4">
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <a href="donation_transaction.php?id=<?php echo $row['don_project_id']; ?>"><button class="btn" type="button"> Donations Transactions </button></a>
                              </div>
                          </div>
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ReportModal">Post Report or Update </button>
                              </div>
                          </div>
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#UploadModal"> Upload Image </button>
                              </div>
                          </div>
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditModal"> Edit Project Details</button>
                              </div>
                          </div>
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <?php
                                  if ($row['ext'] < 2) {
                                  ?>
                                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Extend Project Deadline</button>
                                  <?php
                                  } else {
                                  ?>
                                      <button class="btn" type="button" disabled> Extend Project Deadline </button>
                                  <?php
                                  }
                                  ?>
                              </div>
                          </div>
                          
                        <!-- SEND DONATION PROJECT UPDATE -->
                        <div class="row mb-2">
                            <div class="com-btn">
                            <button type="button" class="c-btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal" data-projectid="<?php echo $id; ?>">Send Project Update</button>
                            </div>
                        </div>
                        <!-- Email modal -->
                        <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="send_project_updates_don.php" method="post">
                                            <!-- Input for the email subject with a predefined value -->
                                            <div class="mb-3">
                                                <label for="subject" class="form-label"><b>Subject</b></label>
                                                <input type="text" class="form-control" name="subject" id="subject" required value="Donation Project Update">
                                            </div>

                                            <div class="mb-3">
                                            <label for="message" class="form-label"><b>Message</b></label>
                                            <textarea class="form-control" name="message" id="message" rows="6" required><?php
                                            echo "Dear donors,\nWe want to provide you with an update on our project '$projectTitle'. Your contributions are greatly appreciated, and we are making significant progress. Here are the latest developments: It has garnered a total of ₱$donation.\n\n";
                                            ?></textarea>
                                            </div>

                                            <!-- Hidden input field for project ID and title (used in PHP) -->
                                            <input type="hidden" name="don_project_id" id="don_project_id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="title" id="title" value="<?php echo $projectTitle; ?>">

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="send" class="btn btn-primary">Send Email</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                
                    </div>
                    
                <?php
                  } elseif ($row['proj_stat'] == 'GOAL REACHED' || $row['proj_stat'] == 'FUNDED') {
                ?>
                    <div class="col-4">
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <a href="donation_transaction.php?id=<?php echo $row['don_project_id']; ?>"><button class="btn" type="button"> Donations Transactions </button></a>
                              </div>
                          </div>
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ReportModal">Post Report or Update </button>
                              </div>
                          </div>
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#UploadModal"> Upload Image </button>
                              </div>
                          </div>
                          
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CompleteModal">Mark as Complete</button>
                              </div>
                          </div>
                          
                        <!-- SEND DONATION PROJECT UPDATE -->
                        <div class="row mb-2">
                            <div class="com-btn">
                            <button type="button" class="c-btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal" data-projectid="<?php echo $id; ?>">Send Project Update</button>
                            </div>
                        </div>
                        
                        <!-- Email modal -->
                        <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="send_project_updates_don.php" method="post">
                                            <!-- Input for the email subject with a predefined value -->
                                            <div class="mb-3">
                                                <label for="subject" class="form-label"><b>Subject</b></label>
                                                <input type="text" class="form-control" name="subject" id="subject" required value="Donation Project Update">
                                            </div>

                                            <div class="mb-3">
                                            <label for="message" class="form-label"><b>Message</b></label>
                                            <textarea class="form-control" name="message" id="message" rows="6" required><?php
                                            echo "Dear donors,\nWe want to provide you with an update on our project '$projectTitle'. Your contributions are greatly appreciated, and we are making significant progress. Here are the latest developments: We have reached a total of ₱$donation.\n\n";
                                            ?></textarea>
                                            </div>

                                            <!-- Hidden input field for project ID and title (used in PHP) -->
                                            <input type="hidden" name="don_project_id" id="don_project_id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="title" id="title" value="<?php echo $projectTitle; ?>">

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="send" class="btn btn-primary">Send Email</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                
                    </div>
                  <?php
                    } elseif ($row['proj_stat'] == 'COMPLETED' || $row['proj_stat'] == 'GOAL REACHED' || $row['proj_stat'] == 'FUNDED') {
                  ?>
                      <div class="col-4">
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <a href="donation_transaction.php?id=<?php echo $row['don_project_id']; ?>"><button class="btn" type="button"> Donations Transactions </button></a>
                              </div>
                          </div>
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ReportModal">Post Report</button>
                              </div>
                          </div>
                          <div class="row mb-2">
                              <div class="div-btn">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#UploadModal"> Upload Image </button>
                              </div>
                          </div>


                          <!-- SEND DONATION PROJECT UPDATE -->
                            <div class="row mb-2">
                                <div class="com-btn">
                                <button type="button" class="c-btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal" data-projectid="<?php echo $id; ?>">Send Project Update</button>
                                </div>
                            </div>
                            <!-- Email modal -->
                            <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="send_project_updates_don.php" method="post">
                                                <!-- Input for the email subject with a predefined value -->
                                                <div class="mb-3">
                                                    <label for="subject" class="form-label"><b>Subject</b></label>
                                                    <input type="text" class="form-control" name="subject" id="subject" required value="Donation Project Update">
                                                </div>

                                                <div class="mb-3">
                                                <label for="message" class="form-label"><b>Message</b></label>
                                                <textarea class="form-control" name="message" id="message" rows="6" required><?php
                                                echo "Dear donors,\nWe want to provide you with an update on our project '$projectTitle'. Your contributions are greatly appreciated, and we are making significant progress. Here are the latest developments: It has garnered a total of ₱$donation.\n\n";
                                                ?></textarea>
                                                </div>

                                                <!-- Hidden input field for project ID and title (used in PHP) -->
                                                <input type="hidden" name="don_project_id" id="don_project_id" value="<?php echo $id; ?>">
                                                <input type="hidden" name="title" id="title" value="<?php echo $projectTitle; ?>">

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="send" class="btn btn-primary">Send Email</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                      </div>
                    <?php
                    }
                    ?>
            </div>
          </div>

          <div class="container w-75 text-center">
              <div class="field">
              </div>
          </div>

        <?php } ?>
        
    </section>
    
    <!--Edit Project Details-->
    <?php 
        $sql = "SELECT * FROM tbl_don_proj where don_project_id = $id AND sw_id = $sw_id";
        $result = mysqli_query($conn, $sql);
                        
        while ($row = mysqli_fetch_array($result)){
        $title = $row['title'];
        $image = $row['image'];
        $text = $row['text'];
        $totalGoal = $row['goal'];
        $dropoff = $row['dropoff'];
        $qrgcash = $row['qrgcash'];
        }
    ?>

    <!--Update Code for Editing-->
    <?php
        if (isset($_POST['save_changes'])) {
            // Get new details from the form
            $newtitle = $_POST['title'];
            $newtext = $_POST['text'];
            $newtotalGoal = $_POST['goal'];
            $newdropoff = $_POST['dropoff'];
        
            // Check if new image and qrgcash files are provided
            $newImageProvided = !empty($_FILES['image']['name']);
            $newQrgcashProvided = !empty($_FILES['qrgcash']['name']);
        
            // Initialize new file names with the old values
            $newImageName = $image;
            $newQrgcashName = $qrgcash;
        
            // If new image provided, update its name and delete the old image
            if ($newImageProvided) {
                // Delete the old image file if it exists
                if (!empty($image)) {
                    $oldImagePath = "don_img/" . $image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
        
                // Append a timestamp to make the image name unique
                $timestamp = time();
                $newImageName = $timestamp . '_' . $_FILES['image']['name'];
        
                // Move the new image file to the 'don_img' folder
                $target = "don_img/" . basename($newImageName);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $imageMsg = "Image uploaded successfully";
                } else {
                    $imageMsg = "Error uploading image";
                }
            }
        
            // If new qrgcash provided, update its name and delete the old qrgcash
            if ($newQrgcashProvided) {
                // Delete the old qrgcash file if it exists
                if (!empty($qrgcash)) {
                    $oldQrgcashPath = "qrgcash/" . $qrgcash;
                    if (file_exists($oldQrgcashPath)) {
                        unlink($oldQrgcashPath);
                    }
                }
        
                // Append a timestamp to make the qrgcash name unique
                $timestamp = time();
                $newQrgcashName = $timestamp . '_' . $_FILES['qrgcash']['name'];
        
                // Move the new qrgcash file to the 'qrgcash' folder
                $target1 = "qrgcash/" . basename($newQrgcashName);
                if (move_uploaded_file($_FILES['qrgcash']['tmp_name'], $target1)) {
                    $qrMsg = "QR uploaded successfully";
                } else {
                    $qrMsg = "Error uploading QR";
                }
            }
        
            // Update the project details in the database
            $sqlUpdate = "UPDATE tbl_don_proj SET
                title = '$newtitle',
                text = '$newtext',
                dropoff = '$newdropoff',
                image = '$newImageName'
                WHERE don_project_id = $id AND sw_id = $sw_id";
        
            $queryUpdate = mysqli_query($conn, $sqlUpdate);
        
            if ($queryUpdate) {
                // The update was successful
        
                // Show a success message and then redirect
                echo '<script>';
                echo 'Swal.fire({
                        title: "Project Updated!",
                        text: "Your project has been updated successfully.",
                        icon: "success",
                    }).then(function() {
                        window.location.href = "donation-details.php?id=' . $id . '";
                    });';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'Swal.fire({
                        title: "Error",
                        text: "There was a problem updating your project.",
                        icon: "error",
                    }).then(function() {
                        window.location.href = "donation-details.php?id=' . $id . '";
                    });';
                echo '</script>';
            }
        }
    ?>

    <!-- Modal for Editing Project Details -->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit your project details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="post" enctype="multipart/form-data">

                        <label for="title">Title of the project:</label>
                        <input type="text" name="title" class="form-control" value = "<?php echo $title; ?>" required><br>

                        <input type="hidden" name="size" value="1000000">
                        <label for="image">Project Image</label>
                        <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png"><br>

                        <label for="text">Body:</label>
                        <textarea name="text" class="form-control" rows="5" required><?php echo $text; ?></textarea><br>

                        <label for="drop-off">Drop-off Location:</label>
                        <input type="text" class="form-control" name="dropoff" value = "<?php echo $dropoff; ?>" required><br>

                        <input type="hidden" name="project_id" value="<?php echo $id; ?>">

                        <div class="modal-footer">
                            <div class="col text-end">
                                <button type="submit" name="save_changes" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Complete Project-->
    <?php

      if (isset($_POST['proj_complete'])) {

          // Get report details from the form
          $title = $_POST['title'];
          $body = $_POST['body'];
          $project_id = $_POST['project_id'];
          $project_type = 1;

          // Insert the report into the tbl_reports table
          $insert_report_query = "INSERT INTO tbl_reports (project_ID, project_type, title, body, date_posted) VALUES (?, ?, ?, ?, NOW())";
          $stmt = $conn->prepare($insert_report_query);
          $stmt->bind_param("iiss", $project_id, $project_type, $title, $body);
          
          if ($stmt->execute()) {
              $report_id = $stmt->insert_id;
          
              // Handle file uploads and insert image paths into tbl_reports_images
              foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                  $image_name = $_FILES['images']['name'][$key];
                  $image_tmp = $_FILES['images']['tmp_name'][$key];
                  $upload_dir = "reports_images/"; // Specify your upload directory
          
                  // Generate a unique name for the image to avoid overwriting
                  $unique_image_name = time() . "_" . $image_name;
                  $image_path = $upload_dir . $unique_image_name;
          
                  if (move_uploaded_file($image_tmp, $image_path)) {
                      $insert_image_query = "INSERT INTO tbl_reports_images (report_ID, image_path) VALUES (?, ?)";
                      $stmt = $conn->prepare($insert_image_query);
                      $stmt->bind_param("is", $report_id, $image_path);
                      $stmt->execute();
                  }
              }

              // Update proj_stat to 'COMPLETED' in tbl_don_proj
              $update_proj_stat_query = "UPDATE tbl_don_proj SET proj_stat = 'COMPLETED' WHERE don_project_id = ?";
              $stmt = $conn->prepare($update_proj_stat_query);
              $stmt->bind_param("i", $project_id);
              $stmt->execute();
          
              // Redirect to donation-details.php with project_ID as a query parameter
              echo '<script>';
              echo 'Swal.fire({
                      title: "Project Mark as Completed!",
                      icon: "success",
                    }).then(function() {
                        window.location.href = "donation-details.php?id=' . $project_id . '";
                    });';
              echo '</script>';
          } else {
              // Handle the case where the report insertion failed
              echo '<script>';
              echo 'Swal.fire({
                      title: "Error",
                      text: "There was a problem with marking your project as complete.",
                      icon: "error",
                    }).then(function() {
                        window.location.href = "donation-details.php?id=' . $project_id . '";
                    });';
              echo '</script>';
          }
      }
    ?>

    <!-- Modal for Complete Project -->
    <div class="modal fade" id="CompleteModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Provide a final report for your project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <p> This final report will let the donors know the turnout of the project. </p>

                    <form method="post" enctype="multipart/form-data">
                        <label for="title">Title:</label>
                        <input type="text" name="title" class="form-control" required><br>

                        <label for="body">Body:</label>
                        <textarea name="body" class="form-control" rows="4" required></textarea><br>

                        <label for="images">Provide supporting images about the turnout of your project: </label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple required><br>

                        <input type="hidden" name="project_id" value="<?php echo $id; ?>">

                        <div class="modal-footer">
                            <div class="col text-end">
                                <button type="submit" name="proj_complete" class="btn btn-primary">Post</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Post Report-->
    <?php
      if (isset($_POST['post_report'])) {

          // Get report details from the form
          $title = $_POST['title'];
          $body = $_POST['body'];
          $project_id = $_POST['project_id'];
          $project_type = 1; // Replace with your actual project type

          // Insert the report into the tbl_reports table
          $insert_report_query = "INSERT INTO tbl_reports (project_ID, project_type, title, body, date_posted) VALUES (?, ?, ?, ?, NOW())";
          $stmt = $conn->prepare($insert_report_query);
          $stmt->bind_param("iiss", $project_id, $project_type, $title, $body);
          
          if ($stmt->execute()) {
            $report_id = $stmt->insert_id;
        
            // Handle file uploads and insert image paths into tbl_reports_images
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $image_name = $_FILES['images']['name'][$key];
                $image_tmp = $_FILES['images']['tmp_name'][$key];
                $upload_dir = "reports_images/"; // Specify your upload directory
        
                // Generate a unique name for the image to avoid overwriting
                $unique_image_name = time() . "_" . $image_name;
                $image_path = $upload_dir . $unique_image_name;
        
                if (move_uploaded_file($image_tmp, $image_path)) {
                    $insert_image_query = "INSERT INTO tbl_reports_images (report_ID, image_path) VALUES (?, ?)";
                    $stmt = $conn->prepare($insert_image_query);
                    $stmt->bind_param("is", $report_id, $image_path);
                    $stmt->execute();
                }
            }
        
            // Redirect to donation-details.php with project_ID as a query parameter
            echo '<script>';
            echo 'Swal.fire({
                    title: "Report Posted!",
                    icon: "success",
                  }).then(function() {
                      window.location.href = "donation-details.php?id=' . $project_id . '";
                  });';
            echo '</script>';
        } else {
            // Handle the case where the report insertion failed
            echo '<script>';
            echo 'Swal.fire({
                    title: "Error",
                    text: "There was a problem posting your report.",
                    icon: "error",
                  }).then(function() {
                      window.location.href = "donation-details.php?id=' . $project_id . '";
                  });';
            echo '</script>';
        }
      }
    ?>

    <!-- Modal for Post Report -->
    <div class="modal fade" id="ReportModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Post a report or update about your project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <p>This post is to update donors about the your project. You can share any additional information.<p>

                    <form method="post" enctype="multipart/form-data">
                        <label for="title">Title:</label>
                        <input type="text" name="title" class="form-control" required><br>

                        <label for="body">Body:</label>
                        <textarea name="body" class="form-control" rows="4" required></textarea><br>

                        <label for="images">Image(s):</label>
                        <input type="file" name="images[]" class="form-control" id="imageInput" multiple accept="image/*"><br>

                        <input type="hidden" name="project_id" value="<?php echo $id; ?>">

                        <div class="modal-footer">
                            <div class="col text-end">
                                <button type="submit" name="post_report" class="btn btn-primary">Post</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Uploading of Images to Gallery-->
    <?php

      if (isset($_POST['upload_images'])) {
          $project_id = $_POST['project_id']; 
          $project_type = 1;

          // Define the target directory to store uploaded images
          $upload_dir = "gallery_images/";

          // Initialize an array to store the uploaded image paths
          $image_paths = [];

          // Loop through each uploaded image
          foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
              $image_name = $_FILES['images']['name'][$key];
              $image_tmp = $_FILES['images']['tmp_name'][$key];

              // Generate a unique name for the image to avoid overwriting
              $unique_image_name = time() . "_" . $image_name;
              $image_path = $upload_dir . $unique_image_name;

              // Move the uploaded image to the target directory
              if (move_uploaded_file($image_tmp, $image_path)) {
                  $image_paths[] = $image_path;
              }
          }

          // Insert the image paths and project type into tbl_gallery_images
          $insert_image_query = "INSERT INTO tbl_gallery_images (project_id, project_type, image_path) VALUES (?, ?, ?)";
          $stmt = $conn->prepare($insert_image_query);

          foreach ($image_paths as $image_path) {
              $stmt->bind_param("iis", $project_id, $project_type, $image_path);
              $stmt->execute();
          }

          // Check if images were uploaded successfully and inserted into the database
          if ($stmt->affected_rows > 0) {
              // Sweet Alert for success
              echo '<script>';
              echo 'Swal.fire({
                      title: "Images Uploaded!",
                      text: "The images have been successfully uploaded to the gallery.",
                      icon: "success",
                    }).then(function() {
                        window.location.href = "donation-details.php?id=' . $project_id . '";
                    });';
              echo '</script>';
          } else {
              // Handle the case where image insertion failed
              echo '<script>';
              echo 'Swal.fire({
                      title: "Error",
                      text: "There was a problem uploading the images.",
                      icon: "error",
                    }).then(function() {
                        window.location.href = "donation-details.php?id=' . $project_id . '";
                    });';
              echo '</script>';
          }
      }
    ?>

    <!-- Modal for Upload Image -->
    <div class="modal fade" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Images to Gallery</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Upload images to gallery for the donors to see. <p>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="image">Select Image(s):</label>
                            <input type="file" class="form-control" name="images[]" multiple accept="image/*" required>
                        </div>
                        <input type="hidden" name="project_id" value="<?php echo $id; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="upload_images" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Project Extension-->
    <?php 

      if (isset($_POST['extend_deadline'])) {
          $project_id = $_POST['project_id']; // Get the project ID from the form
          
          $update_query = "UPDATE tbl_don_proj
                            SET
                                end = DATE_ADD(end, INTERVAL 7 DAY),
                                ext = ext + 1,
                                proj_stat = 'ON GOING'
                            WHERE don_project_id = $project_id";
          
          if (mysqli_query($conn, $update_query)) {
              // Sweet Alert for extension success
              echo '<script>';
              echo 'Swal.fire({
                      title: "Project Deadline Extended!",
                      text: "The project deadline has been extended by 7 days.",
                      icon: "success",
                    }).then(function() {
                        window.location.href = "donation-details.php?id=' . $project_id . '";
                    });';
              echo '</script>';
          } else {
              // Sweet Alert for error
              echo '<script>';
              echo 'Swal.fire({
                      title: "Error",
                      text: "There was a problem extending the project deadline.",
                      icon: "error",
                    }).then(function() {
                        window.location.href = "donation-details.php?id=' . $project_id . '";
                    });';
              echo '</script>';
          }
      }
    ?>


    <!-- Modal for Extension -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Extend Project Deadline</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to extend the project deadline for 7 days? 
                    <br><br>
                    <i>**Extensions can only be done two (2) times.</i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                    <form method="POST">
                        <input type="hidden" name="project_id" value="<?php echo $id; ?>">
                        <button type="submit" name="extend_deadline" class="btn btn-primary">Extend Deadline</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  <!-- PIE CHART-->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
      var ctx = document.getElementById('myPieChart').getContext('2d');
      var myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: ['Raised', 'Remaining'],
              datasets: [{
                  label: 'Amount',
                  data: [<?php echo $donation; ?>, <?php echo $remaining; ?>],
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.6)',
                      'rgba(54, 162, 235, 0.6)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              animation: {
                  onComplete: function(animation) {
                      var chartInstance = animation.chart;
                      var ctx = chartInstance.ctx;
                      ctx.font = "30px Arial";
                      ctx.fillStyle = "Blue";
                      ctx.textAlign = "center";
                      ctx.textBaseline = "middle";

                      if (chartInstance.data.datasets[0].data[1] === 0) {
                          var centerX = (chartInstance.chartArea.left + chartInstance.chartArea.right) / 2;
                          var centerY = (chartInstance.chartArea.top + chartInstance.chartArea.bottom) / 2;
                          ctx.fillText("Completed", centerX, centerY);
                      }
                  }
              }
          }
      });
  </script>
  
  <!--Side Bar-->
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

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const imageInput = document.getElementById("imageInput");

        imageInput.addEventListener("change", function() {
            const selectedFiles = this.files;
            if (selectedFiles.length > 4) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You can only upload up to 4 images.'
                });
                this.value = ""; // Clear the selected files
            }
        });
    });
  </script>

<!-- Populate Email Panel -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var emailModal = document.getElementById("emailModal");
        emailModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget; 
            var projectID = button.getAttribute("data-projectid"); 
            document.getElementById('don_project_id').value = projectID; 
        });
    });
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
