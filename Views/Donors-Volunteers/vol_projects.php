<?php include 'includes/config.php';?>
<?php 

session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer</title>

    <link rel="stylesheet" href="css/volunteer.css">
    <link rel="stylesheet" type="text/css" href="\Views\SocialWorker\css\dn-fullproject.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/site.webmanifest">
    
</head>
<body>

    <!--LOADER-->
    <script src="js/loader.js"></script>
    <div class="loader"></div>

    <!--NAV BAR-->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php echo'
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="donation.php">Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="volunteer.php">Volunteers</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="dv_userdashboard.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                '?>
            </div>
        </div>
    </nav>

    <?php
        $id = $_GET['id'];

        // QUERY TO KNOW THE NUMBER OF DISTINCT VOLUNTEERS (per user_id)
        $sql2 = "SELECT COUNT(DISTINCT user_id) AS volunteer_count FROM tbl_volunteers WHERE vol_proj_id = $id AND stat = 'Verified'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $vol_count = $row2['volunteer_count'];

        // Reports Data
        $reportData = array(); // array to store report data

        $sqlReports = "SELECT
            r.report_id,
            r.title AS report_title,
            r.body AS report_body,
            r.date_posted AS report_date,
            i.image_id,
            i.image_path
        FROM tbl_reports r
        LEFT JOIN tbl_reports_images i ON r.report_id = i.report_id
        WHERE r.project_id = $id AND r.project_type = 2";
        $resultReports = mysqli_query($conn, $sqlReports);

        if ($resultReports) {
            while ($reportRow = mysqli_fetch_assoc($resultReports)) {
                $reportData[] = $reportRow; // Stores report data in the array
            }
        }
    ?>

    <?php
$sql = "SELECT tbl_vol_proj.*, tbl_sw_accs.*, tbl_vol_proj.image AS project_image 
        FROM tbl_vol_proj 
        RIGHT JOIN tbl_sw_accs ON tbl_vol_proj.sw_id = tbl_sw_accs.sw_id  
        WHERE tbl_vol_proj.vol_proj_id = '$id'";
$result = mysqli_query($conn, $sql);
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        //PROGRESS BAR
        $percentage = ($vol_count / $row['totalGoal']) * 100;
        $remaining = $row['totalGoal'] - $vol_count;
        ?>
        <div class="title text-center">
            <br><br>
            <p><?php echo $row['category']; ?></p>
            <h3><?php echo $row['title']; ?></h3>
            <p>Organized By: <?php echo $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']; ?>
 <br> Date Uploaded: <?php echo date('F j, Y', strtotime($row['uploadDate'])); ?> </p>
        </div>

        <div class="container w-75 content">
            <div class="row">
                <div class="col-lg-8">
                   <div class="proj-img">
    <?php
    $imagePath = '../SocialWorker/vol_img/' . $row['project_image']; // Use the alias here
    if (file_exists($imagePath)) {
        echo '<img src="' . $imagePath . '" style="width:100%">';
    } else {
        echo 'Image not found at path: ' . $imagePath;
    }
    ?>
</div>

                    <br>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill" data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about" aria-selected="true">About</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-reports-tab" data-bs-toggle="pill" data-bs-target="#pills-reports" type="button" role="tab" aria-controls="pills-reports" aria-selected="false">Reports & Updates</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-gallery-tab" data-bs-toggle="pill" data-bs-target="#pills-gallery" type="button" role="tab" aria-controls="pills-gallery" aria-selected="false">Project Gallery</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="/Views/SocialWorker/report_vol_list.php?id=<?php echo $id; ?>" target="_blank" class="nav-link">Volunteer List</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab" tabindex="0">
                                <div class="proj-desc">
                                    <p><i><b>Summary</b></i></p>
                                    <div class="details">
                                        <p><?php echo $row['text']; ?></p>
                                    </div>

                                    <div class="goal">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row"> <b><?php echo $row['totalGoal']; ?></b></div>
                                                <div class="row"> <p class="par"> Total Needed Volunteers </p></div>

                                                <div class="row"> <b><?php echo date('F j, Y', strtotime($row['eventDate'])); ?></b></div>
                                                <div class="row"> <p class="par"> Project Date </p></div>
                                            </div>

                                            <div class="col-6">
                                                <?php if ($vol_count >= $row['totalGoal']) { ?>
                                                    <div class="row"> <span>&#10003;</span> </div>
                                                    <div class="row"> <p class="par"> Goal Reached! </p></div>
                                                <?php } else { ?>
                                                    <div class="row"> <b> <?php echo number_format($remaining); ?> </b></div>
                                                    <div class="row"> <p class="par"> Remaining </p></div>
                                                <?php } ?>
                                                <div class="row"> <b><?php echo $vol_count; ?></b></div>
                                                <div class="row"> <p class="par"> Volunteers Count </p></div>
                                            </div>
                                        </div>
                                    </div>

                                    <p><i><b>Volunteer Project Information</b></i></p>
                                    <div class="additional">
                                        <p>Preferred Volunteer: <b><?php echo $row['requirement']; ?></b></p>
                                        <p>Location: <b><?php echo $row['location']; ?></b></p>
                                        <p>Contact Information: <b><?php echo $row['full_contact']; ?></b></p>
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
                                                echo '<p>No reports or Updates yet. </p>';
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

                                                        // Format and display the date
                                                        $reportDate = strtotime($reportRow['report_date']);
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
                                                                echo '<img src="/Views/SocialWorker/' . $imagePath . '" class="report-image">';
                                                                echo '</div>';
                                                            }
                                                        } else {
                                                            // If it's a single image path, display it
                                                            echo '<div class="col">';
                                                            echo '<img src="/Views/SocialWorker/' . $reportRow['image_path'] . '" class="report-image">';
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
                                    $sqlGallery = "SELECT image_path, uploaded_at FROM tbl_gallery_images WHERE project_id = $id AND project_type = 2 ORDER BY uploaded_at DESC;";
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
                                            echo '<img src="/Views/SocialWorker/' . $imagePath . '">';
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

                <div class="col-4">
                    <div class="box">
                        <p class="progress-raised"> <?php echo $vol_count; ?> registered volunteers</p>
                        <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?php echo $percentage; ?>%"></div>
                        </div>
                        <?php if ($vol_count >= $row['totalGoal']) { ?>
                            <p class="progress-to-go">Goal Reached!</p>
                        <?php } else { ?>
                            <p class="progress-to-go"> <?php echo $remaining; ?> to go </p>
                        <?php } ?>
                    </div>
                    
                    <div class="donate-now">
                        <a href = "vol_appform.php?id=<?php echo $id; ?>"><button class="btn-don">Register Now</button></a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!--FOOTER-->
    <footer class="sticky-footer">
        <!-- <h2>Footer Stick to the Bottom</h2> -->
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="donation.php">Donations</a></li>
            <li><a href="volunteer.php">Volunteers</a></li>
        </ul>
        <p> © Copyright DORA 2023.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>