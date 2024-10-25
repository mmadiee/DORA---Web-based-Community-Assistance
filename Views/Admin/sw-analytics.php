<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    <title>SW Analytics</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/dl-sw.css" media="print">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- LINE CHART -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- BAR CHART -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        @media print {
            .sidebar,
            .bx-menu,
            .print-btn,
            .welcome-message {
                display: none;
            }

            #chart-container {
                width: 100%;
                height: 100%;
                margin: 0;
            }
            #occupationChart{
                transform: translateX(-26%) scale(0.3,0.7);
                width: 20%;  
                position: static;
                
            }
            #occupationChart-container{
                position: relative;
                top: 5px;
                left: 50%;
                transform: translateX(-187%) scale(2.0,0.8);
                width: 150%; 
                border: 1px solid #000; 
            }
            #genderPieChart{
                transform: translateX(-35%) scale(0.3,1.0);
                width: 20%; 
                position: static; 
            }
            #genderPieChart-container{
                position: relative;
                top: 5px;
                left: 50%;
                transform: translateX(-58%) scale(2.3,0.8);
                width: 150%; 
                border: 1px solid #000; 
            }
        
            #statusDonutChart{
                transform: translateX(-32%) scale(0.4,0.7);
                width: 20%; 
                position: static; 
            }
            #statusDonutChart-container{
                position: relative;
                top: 5px;
                left: 50%;
                transform: translateX(-180%) scale(2.1,0.9);
                width: 150%; 
                border: 1px solid #000; 
                margin-bottom: 55px;
            }
        
            #ageRangesBarChart{
                transform: translateX(-32%) scale(0.4,0.7);
                width: 20%; 
                position: static; 
            }
            #ageRangesBarChart-container{
                position: relative;
                top: 5px;
                left: 50%;
                transform: translateX(-58%) scale(2.2,0.9);
                width: 150%; 
                border: 1px solid #000; 
            }
        
            #swAverageHoursLineChart{
                transform: translateX(-30%) scale(0.3,1.0);
                width: 20%; 
                position: static; 
            }
            #swAverageHoursLineChart-container{
                position: relative;
                top: 5px;
                left: 50%;
                transform: translateX(-55%) scale(2.2,0.8);
                width: 150%; 
                border: 1px solid #000; 
            }
        
            #cityBarChart{
                display: none;
            }
            #cityBarChart-container{
                display: none;
            }
        }

        @media screen {
            .no-screen {
                display: none;
            }
        }

        #chart-container {
            text-align: center;
        }

        .d-btn{
            border-radius: 10px;
            border-color: #1282A2;
            padding: 5px;
            background-color: #EFEFEF;
        }

        .e-btn{
            border-radius: 10px;
            border-color: #1282A2;
            padding: 5px;
            background-color: #EFEFEF;
            width: 220px;
            position: right;
            margin-right: 20px;
        }
        .d-btn:hover{
            background-color: #1282A2;
            color: #EFEFEF;
        }

        .e-btn:hover{
            background-color: #1282A2;
            color: #EFEFEF;
        }
        .range-btn{
            border-radius: 10px;
            border-color: #1282A2;
            padding: 5px;
            background-color: #EFEFEF;
        }
        .fas{
        margin-right: 8px;
        }
        footer{
            background-color: white;
            padding: 10px;
            padding-left: 80px;
            text-align: center;
            color:#FEFCFB;
        }
        .sticky-footer{
            position: sticky;
            top: 100%;
            
        }
        
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
        <h5>Social Worker Analytics</h5>
    </div>

    <section class="home-section">

<!-- DATA PANELS -->
    <div class="container">
    <div class="row justify-content-center">

    <div class="container">
    <!-- SW Panel Options -->
    <div class="row justify-content-center">
        <div class="col-md-12 text-center mb-3 mt-3 ">
            <h5 id="panel_label">Social Worker Panel Options</h5>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control range-btn" id="start_date" name="start_date">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control range-btn" id="end_date" name="end_date">
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-end">
            <div class="form-group">
                <button type="button" class="range-btn" id="update_button">Update</button>

                 <!-- Download Button -->
                 <a href="javascript:window.print();" class="print-button" id="print-button">
                    <button id="" class="e-btn"><i class="fas fa-download"></i> Download as PDF</button>
                </a>
            </div>
        </div>
    </div>
</div>

    <!-- Display social worker data -->
<div id="social_worker_data">
    <div class="row justify-content-center">
        <?php
        // Initial display of data (without date filter)
        displaySocialWorkerData(null, null);

        function displaySocialWorkerData($start_date, $end_date) {
            // Connect to your database (replace with your database connection code)
            include 'includes/config.php';

            // Display Total Social Workers and Latest Submission Date
            $sql_total_social_workers = "SELECT COUNT(*) AS TotalSocialWorkers,
                                        DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate
                                        FROM tbl_sw_accs
                                        WHERE status = 'verified'";
            if ($start_date && $end_date) {
                $sql_total_social_workers .= " AND submit_date BETWEEN '$start_date' AND '$end_date'";
            }

            $result_total_social_workers = $conn->query($sql_total_social_workers);
            if ($result_total_social_workers->num_rows > 0) {
                while ($row = $result_total_social_workers->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>';
                    echo '<div class="card-body">';
                    echo '<div id="card1" class="card align-items-center" style="border: 2px solid #000000; height: 180px;"><br>';
                    echo '<h6 style="color:darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOTAL NUMBER OF VERIFIED SOCIAL WORKERS</h6></b>';

                    $totalSocialWorkersFormatted = number_format($row["TotalSocialWorkers"]);
                    echo '<p id="res-card" style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $totalSocialWorkersFormatted . '</b></p>';

                    $latestSubmitDate = $row["latest_submitdate"];
                    echo '<p id="txt-card">Calculated: ' . $latestSubmitDate . '</p>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

          // Display Count of Social Workers with Status "Pending"
            $sql_pending_social_workers = "SELECT COUNT(*) AS pending_social_workers,
                                            DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate
                                            FROM tbl_sw_accs
                                            WHERE status = 'pending'";
            
            $result_pending_social_workers = $conn->query($sql_pending_social_workers);
            $pendingSocialWorkersCount = 0;
            $latestSubmitDate = '';
            
            if ($result_pending_social_workers) {
                $rowPendingSocialWorkers = $result_pending_social_workers->fetch_assoc();
                $pendingSocialWorkersCount = isset($rowPendingSocialWorkers['pending_social_workers']) ? $rowPendingSocialWorkers['pending_social_workers'] : 0;
                $latestSubmitDate = isset($rowPendingSocialWorkers['latest_submitdate']) ? $rowPendingSocialWorkers['latest_submitdate'] : '';
            }
            
            echo '<div class="col-sm-4 mb-3"><br>';
            echo '<div class="card-body">';
            echo '<div id="card2" class="card align-items-center" style="border: 2px solid #000000; height: 180px;"><br>';
            echo '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>SOCIAL WORKERS WITH STATUS "PENDING"</h6></b>';
            echo '<p id="res-card" style="font-size: 32px; padding-bottom: 11px; color: darkblue;"><b>' . $pendingSocialWorkersCount . '</b></p>';
            echo '<p id="txt-card">Calculated: ' . $latestSubmitDate . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            }

            // Calculate Average Number of Projects Uploaded by Social Workers
            $sql_average_projects = "SELECT ROUND(AVG(projects_count)) AS average_projects_count
                                    FROM (
                                        SELECT sw.sw_id, COUNT(*) AS projects_count
                                        FROM tbl_sw_accs sw
                                        LEFT JOIN tbl_don_proj dp ON sw.sw_id = dp.sw_id
                                        LEFT JOIN tbl_assistance asst ON sw.sw_id = asst.sw_id
                                        LEFT JOIN tbl_vol_proj vp ON sw.sw_id = vp.sw_id
                                        GROUP BY sw.sw_id
                                    ) AS project_counts";
            
            $result_average_projects = $conn->query($sql_average_projects);
            $averageProjectsCount = 0;
            
            if ($result_average_projects) {
                $rowAverageProjects = $result_average_projects->fetch_assoc();
                $averageProjectsCount = isset($rowAverageProjects['average_projects_count']) ? $rowAverageProjects['average_projects_count'] : 0;
            }
            
            // Calculate the current time
            $currentDate = date('F d, Y');
            
            echo '<div class="col-sm-4 mb-3"><br>';
            echo '<div class="card-body">';
            echo '<div id="card3" class="card align-items-center" style="border: 2px solid #000000; height: 180px;"><br>';
            echo '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>AVERAGE NUMBER OF PROJECTS</h6></b>';
            echo '<p id="res-card" style="font-size: 32px; 11px; color: darkblue;"><b>' . $averageProjectsCount . '</b></p>';
            echo '<p id="txt-card">Calculated: ' . $currentDate . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
           // Display Social Worker with the Most Completed Donation Projects
$sql_top_social_worker = "SELECT sw_id, COUNT(DISTINCT don_project_id) AS completed_projects_count
                        FROM tbl_don_proj
                        WHERE proj_stat = 'COMPLETED'
                        GROUP BY sw_id
                        ORDER BY completed_projects_count DESC
                        LIMIT 1";

$result_top_social_worker = $conn->query($sql_top_social_worker);

if ($result_top_social_worker->num_rows > 0) {
    $rowTopSocialWorker = $result_top_social_worker->fetch_assoc();
    $topSocialWorkerId = $rowTopSocialWorker['sw_id'];
    $completedProjectsCount = $rowTopSocialWorker['completed_projects_count'];

    // Get the name of the top social worker and their latest submit date
    $sql_get_social_worker_data = "SELECT fname, lname, DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate
                                    FROM tbl_sw_accs
                                    WHERE sw_id = '$topSocialWorkerId'";
    $result_get_social_worker_data = $conn->query($sql_get_social_worker_data);

    if ($result_get_social_worker_data->num_rows > 0) {
        $rowSocialWorkerData = $result_get_social_worker_data->fetch_assoc();
        $topSocialWorkerName = $rowSocialWorkerData['fname'] . ' ' . $rowSocialWorkerData['lname'];
        $latestSubmitDate = $rowSocialWorkerData['latest_submitdate'];

        echo '<div class="col-sm-4 mb-3"><br>';
        echo '<div id="card4" class="card align-items-center" style="border: 2px solid #000000; height: 180px;"><br>';
        echo '<h6 id="tt-card" style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>SOCIAL WORKER WITH MOST COMPLETED DONATION PROJECTS</h6></b>';
        echo '<p id="res-card" style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $topSocialWorkerName . '</b></p>';
        echo '<p>Completed Donation Projects: ' . $completedProjectsCount . '</p>';
        echo '<p>Calculated: ' . $latestSubmitDate . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // Handle the case where there are no social workers with completed donation projects 
    echo '<div class="col-sm-4 mb-3"><br>';
    echo '<div id="card4" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
    echo '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOP SOCIAL WORKER WITH MOST COMPLETED DONATION PROJECTS</h6></b>';
    echo '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>No Social Workers with Completed Donation Projects</b></p>';
    echo '</div>';
    echo '</div>';
}

            
            // Display Social Worker with the Most Completed Volunteer Projects
$sql_top_social_worker = "SELECT sw_id, COUNT(DISTINCT vol_proj_id) AS completed_projects_count
                        FROM tbl_vol_proj
                        WHERE proj_stat = 'COMPLETED'
                        GROUP BY sw_id
                        ORDER BY completed_projects_count DESC
                        LIMIT 1";

$result_top_social_worker = $conn->query($sql_top_social_worker);

if ($result_top_social_worker->num_rows > 0) {
    $rowTopSocialWorker = $result_top_social_worker->fetch_assoc();
    $topSocialWorkerId = $rowTopSocialWorker['sw_id'];
    $completedProjectsCount = $rowTopSocialWorker['completed_projects_count'];

    // Get the name of the top social worker and their latest submit date
    $sql_get_social_worker_data = "SELECT fname, lname, DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate
                                    FROM tbl_sw_accs
                                    WHERE sw_id = '$topSocialWorkerId'";
    $result_get_social_worker_data = $conn->query($sql_get_social_worker_data);

    if ($result_get_social_worker_data->num_rows > 0) {
        $rowSocialWorkerData = $result_get_social_worker_data->fetch_assoc();
        $topSocialWorkerName = $rowSocialWorkerData['fname'] . ' ' . $rowSocialWorkerData['lname'];
        $latestSubmitDate = $rowSocialWorkerData['latest_submitdate'];

        echo '<div class="col-sm-4 mb-3"><br>';
        echo '<div id="card5" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
        echo '<h6 id="tt-card" style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>SOCIAL WORKER WITH MOST COMPLETED VOLUNTEER PROJECTS</h6></b>';
        echo '<p id="res-card" style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $topSocialWorkerName . '</b></p>';
        echo '<p>Completed Volunteer Projects: ' . $completedProjectsCount . '</p>';
        echo '<p>Calculated: ' . $latestSubmitDate . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // Handle the case where there are no social workers with completed volunteer projects 
    echo '<div class="col-sm-4 mb-3"><br>';
    echo '<div id="card5" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
    echo '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOP SOCIAL WORKER WITH MOST COMPLETED VOLUNTEER PROJECTS</h6></b>';
    echo '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>No Social Workers with Completed Volunteer Projects</b></p>';
    echo '</div>';
    echo '</div>';
}

// Display Social Worker with the Most Completed Assistance Projects
$sql_top_social_worker = "SELECT sw_id, COUNT(DISTINCT assistance_id) AS completed_projects_count
                        FROM tbl_assistance
                        WHERE proj_stat = 'COMPLETED'
                        GROUP BY sw_id
                        ORDER BY completed_projects_count DESC
                        LIMIT 1";

$result_top_social_worker = $conn->query($sql_top_social_worker);

if ($result_top_social_worker->num_rows > 0) {
    $rowTopSocialWorker = $result_top_social_worker->fetch_assoc();
    $topSocialWorkerId = $rowTopSocialWorker['sw_id'];
    $completedProjectsCount = $rowTopSocialWorker['completed_projects_count'];

    // Get the name of the top social worker and their latest submit date
    $sql_get_social_worker_data = "SELECT fname, lname, DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate
                                    FROM tbl_sw_accs
                                    WHERE sw_id = '$topSocialWorkerId'";
    $result_get_social_worker_data = $conn->query($sql_get_social_worker_data);

    if ($result_get_social_worker_data->num_rows > 0) {
        $rowSocialWorkerData = $result_get_social_worker_data->fetch_assoc();
        $topSocialWorkerName = $rowSocialWorkerData['fname'] . ' ' . $rowSocialWorkerData['lname'];
        $latestSubmitDate = $rowSocialWorkerData['latest_submitdate'];

        echo '<div class="col-sm-4 mb-3"><br>';
        echo '<div id="card6" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
        echo '<h6 id="tt-card" style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>SOCIAL WORKER WITH MOST COMPLETED ASSISTANCE PROJECTS</h6></b>';
        echo '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $topSocialWorkerName . '</b></p>';
        echo '<p id="res6-card">Completed Assistance Projects: ' . $completedProjectsCount . '</p>';
        echo '<p id="res6-1-card">Calculated: ' . $latestSubmitDate . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // Handle the case where there are no social workers with completed assistance projects 
    echo '<div class="col-sm-4 mb-3"><br>';
    echo '<div id="card6" class="card align-items-center" style="border: 2px solid #000000;  height: 200px;"><br>';
    echo '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOP SOCIAL WORKER WITH MOST COMPLETED ASSISTANCE PROJECTS</h6></b>';
    echo '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>No Social Workers with Completed Assistance Projects</b></p>';
    echo '</div>';
    echo '</div>';
}
            
            ?>
        </div>
    </div>
<!-- JavaScript to handle the update button click for volunteer data -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var startDate = new Date();
        startDate.setDate(startDate.getDate() - startDate.getDay() + (startDate.getDay() === 0 ? -6 : 1));
        $('#start_date').val(startDate.toISOString().substr(0, 10));

        var endDate = new Date();
        endDate.setDate(startDate.getDate() + 6);
        $('#end_date').val(endDate.toISOString().substr(0, 10));

        $('#update_button').click(function () {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            $.ajax({
                type: 'POST',
                url: 'update_data_sw.php', 
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function (response) {
                    $('#social_worker_data').html(response);
                }
            });
        });
    });
</script>


                    
                                    <!-- SW AREA CHART -->
<div id="sw-chart-container" class="chart-container" style="text-align: center; max-width: 100%; margin: 20px 0 20px 0; border: 2px solid #000;">
    <h3 id="h3font" style="margin-top:20px; color: darkblue;"><b>Social Worker Chart Options</b></h3>
    <label for="start-date">Start Date:</label>
    <input class="range-btn" type="text" id="start-date" placeholder="MM/DD/YYYY">
    <label for="end-date">End Date:</label>
    <input class="range-btn" type="text" id="end-date" placeholder="MM/DD/YYYY">
    <button class="d-btn" id="update" onclick="validateAndUpdateSWChart()">Update Chart</button>
    <div id="sw-chart" style="width: 100%; height: 300px;"></div>
</div>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });

    google.charts.setOnLoadCallback(() => {
        var currentDate = new Date();
        var startOfWeek = new Date(currentDate);
        startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());
        var endOfWeek = new Date(currentDate);
        endOfWeek.setDate(currentDate.getDate() + (6 - currentDate.getDay()));
        document.getElementById('start-date').value = formatDate(startOfWeek);
        document.getElementById('end-date').value = formatDate(endOfWeek);
        updateSWChart();
    });

    function formatDate(date) {
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        var year = date.getFullYear();
        return `${month}/${day}/${year}`;
    }

    function updateSWChart() {
        var startDatePicker = document.getElementById('start-date');
        var endDatePicker = document.getElementById('end-date');
        var startDate = startDatePicker.value;
        var endDate = endDatePicker.value;

        var startDateParts = startDate.split('/');
        var endDateParts = endDate.split('/');

        $.ajax({
            url: 'fetch_data_sw.php',
            method: 'POST',
            data: {
                startDate: startDate,
                endDate: endDate
            },
            dataType: 'json',
            success: function (chartData) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Social Worker Count');
                data.addRows(chartData);

                var options = {
                    title: 'Social Worker Chart',
                    isStacked: true,
                    legend: { position: 'bottom' },
                    vAxis: {
                        title: 'Number of Social Workers'
                    },
                    hAxis: {
                        title: 'Date'
                    },
                    tooltip: { isHtml: true },
                    pointSize: 5,
                };

                var chart = new google.visualization.AreaChart(document.getElementById('sw-chart'));
                chart.draw(data, options);
            },
            error: function (error) {
                console.log('Error fetching data:', error);
            }
        });
    }

    function validateAndUpdateSWChart() {
        var startDatePicker = document.getElementById('start-date');
        var endDatePicker = document.getElementById('end-date');
        var startDate = startDatePicker.value;
        var endDate = endDatePicker.value;

        var startDateParts = startDate.split('/');
        var endDateParts = endDate.split('/');

        var startDateObj = new Date(`${startDateParts[2]}-${startDateParts[0]}-${startDateParts[1]}`);
        var endDateObj = new Date(`${endDateParts[2]}-${endDateParts[0]}-${endDateParts[1]}`);

        var minStartDate = new Date('2023-01-01');
        var maxEndDate = new Date();

        if (isNaN(startDateObj) || isNaN(endDateObj)) {
            Swal.fire({
                icon: 'error',
                text: 'Invalid date format. Please use MM/DD/YYYY format.'
            });
            return;
        }

        if (startDateObj > maxEndDate) {
            Swal.fire({
                icon: 'error',
                text: 'Start Date cannot exceed the current date.'
            });
            return;
        }

        if (startDateObj < minStartDate) {
            Swal.fire({
                icon: 'error',
                text: 'Start Date must not go past January 1, 2023.'
            });
            return;
        }

        if (endDateObj > maxEndDate) {
            Swal.fire({
                icon: 'error',
                text: 'End Date cannot exceed the current date.'
            });
            return;
        }

        if (endDateObj < startDateObj) {
            Swal.fire({
                icon: 'error',
                text: 'End Date cannot be before Start Date.'
            });
            return;
        }

        updateSWChart();
    }
</script>



                                <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                                    <!-- OCCUPATION FREQUENCY CHART -->
                                    <div id="occupationChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Social Worker Occupation Frequency</b></h2>
                                        <div id="occupationChart" style="max-height: 300px; width: 100%;"></div>
                                    </div>
                                
                                <?php
                                // Modify the SQL query to retrieve occupation data
                                $sql = "SELECT DISTINCT occupation FROM tbl_sw_accs";
                                $result = mysqli_query($conn, $sql);
                                
                                $occupations = array();
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $occupations[] = $row['occupation'];
                                }
                                
                                $dataPoints = array();
                                
                                foreach ($occupations as $occupation) {
                                    $sql = "SELECT COUNT(*) AS occupation_count 
                                    FROM tbl_sw_accs 
                                    WHERE occupation = '$occupation'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $occupationCount = $row['occupation_count'];
                                    $dataPoints[] = array("Occupation" => $occupation, "y" => $occupationCount);
                                }
                                ?>
                                
                                <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
                                <script>
                                    window.onload = function () {
                                        var occupations = <?php echo json_encode(array_column($dataPoints, 'Occupation')); ?>;
                                        var counts = <?php echo json_encode(array_column($dataPoints, 'y')); ?>;
                                        
                                        // Generate an array of dynamic colors based on the number of occupations
                                        var colors = generateDynamicColors(occupations.length);
                                
                                        function generateDynamicColors(numColors) {
                                            var dynamicColors = [];
                                            for (var i = 0; i < numColors; i++) {
                                                var r = Math.floor(Math.random() * 255);
                                                var g = Math.floor(Math.random() * 255);
                                                var b = Math.floor(Math.random() * 255);
                                                var color = 'rgba(' + r + ', ' + g + ', ' + b + ', 0.7)';
                                                dynamicColors.push(color);
                                            }
                                            return dynamicColors;
                                        }
                                
                                        var data = [{
                                            type: 'bar',
                                            x: counts,
                                            y: occupations,
                                            orientation: 'h',
                                            marker: {
                                                color: colors
                                            }
                                        }];
                                
                                        var layout = {
                                            title: 'Social Worker Occupation Frequency',
                                            xaxis: {
                                                title: 'Frequency',
                                                automargin: true,
                                                tickangle: -45
                                            },
                                            margin: {
                                                l: 150
                                            },
                                            barmode: 'stack',
                                            legend: {
                                                x: -0.2,
                                                y: 1.0,
                                                orientation: 'h'
                                            }
                                        };
                                
                                        var config = {
                                            displayModeBar: false
                                        };
                                
                                        Plotly.newPlot('occupationChart', data, layout, config);
                                    };
                                </script>

                                    
                                     <!-- GENDER DISTRIBUTION CHART-->
                                    <div id="genderPieChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Gender Distribution</b></h2>
                                <div id="genderPieChart" style="max-height: 300px; width: 100%;"></div>
                            </div>
     
                            
                            <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
                            <?php
                                $sql = "SELECT
                                    COUNT(*) AS gender_count,
                                    gender
                                    FROM tbl_sw_accs
                                    WHERE status = 'Verified'
                                    GROUP BY gender";
                                $result = $conn->query($sql);
                                
                                $genderLabels = [];
                                $genderData = [];
                                
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $genderLabels[] = $row['gender'];
                                        $genderData[] = $row['gender_count'];
                                    }
                                }
                                ?>
                                
                                                            
                                                            <script>
                                    var labels = <?php echo json_encode($genderLabels); ?>;
                                    var data = <?php echo json_encode($genderData); ?>;
                                    
                                    var plotData = [{
                                        labels: labels,
                                        values: data,
                                        type: 'pie',
                                        marker: {
                                            colors: ['#B88BF5', '#96A8ED'], // Blue for Male, Red for Female
                                        }
                                    }];
                                
                                    var layout = {
                                        title: 'Social Worker Gender Distribution',
                                        showlegend: true,
                                    };
                                
                                    Plotly.newPlot('genderPieChart', plotData, layout);
                                    </script>
                                    
                                    <!-- AGE RANGES BAR CHART -->
                                    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
                                    
                                    <?php
                                    $sql = "SELECT
                                        CASE
                                            WHEN TIMESTAMPDIFF(DAY, birthday, CURDATE()) / 365 BETWEEN 18 AND 24 THEN '18-24'
                                            WHEN TIMESTAMPDIFF(DAY, birthday, CURDATE()) / 365 BETWEEN 25 AND 34 THEN '25-34'
                                            WHEN TIMESTAMPDIFF(DAY, birthday, CURDATE()) / 365 BETWEEN 35 AND 44 THEN '35-44'
                                            WHEN TIMESTAMPDIFF(DAY, birthday, CURDATE()) / 365 BETWEEN 45 AND 54 THEN '45-54'
                                            WHEN TIMESTAMPDIFF(DAY, birthday, CURDATE()) / 365 BETWEEN 55 AND 64 THEN '55-64'
                                            ELSE '65+'
                                        END AS age_range,
                                        COUNT(DISTINCT v.sw_id) AS volunteer_count
                                    FROM
                                        tbl_sw_accs v
                                    WHERE v.status = 'Verified'
                                    GROUP BY
                                        age_range;
                                    ";
                                    
                                    $result = $conn->query($sql);
                                    
                                    $ageRangeLabels = [];
                                    $ageRangeData = [];
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $ageRangeLabels[] = $row['age_range'];
                                            $ageRangeData[] = $row['volunteer_count'];
                                        }
                                    }
                                    
                                    $backgroundColors = [
                                        '#34495e', // Blue
                                        '#9b59b6', // Green
                                        '#e74c3c', // Red
                                        '#f39c12', // Yellow
                                        '#2ecc71', // Purple
                                        '#3498db'  // Dark gray
                                    ];
                                    ?>
                                    
                                    <!-- DONUT CHART FOR SW STATUSES -->
                                    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
                                    
                                    <?php
                                    $sql = "SELECT status, COUNT(*) AS count FROM tbl_sw_accs GROUP BY status";
                                    
                                    $result = $conn->query($sql);
                                    
                                    $statusLabels = [];
                                    $statusData = [];
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $statusLabels[] = $row['status'];
                                            $statusData[] = $row['count'];
                                        }
                                    }
                                    
                                    $colors = [
                                        '#34495e', // Blue
                                        '#9b59b6', // Green
                                        '#e74c3c', // Red
                                        '#f39c12', // Yellow
                                        '#2ecc71', // Purple
                                        '#3498db'  // Dark gray
                                    ];
                                    ?>
                                    
                                    <!-- STATUS DONUT CHART -->
                                    <div id="statusDonutChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Social Worker Status Distribution</h2></b>
                                        <div id="statusDonutChart" style="max-height: 300px; width: 100%;"></div>
                                    </div>
                                    
                                    <script>
                                        var labels = <?php echo json_encode($statusLabels); ?>;
                                        var data = <?php echo json_encode($statusData); ?>;
                                        
                                        var colors = [
                                            '#34495e', // Blue
                                            '#9b59b6', // Green
                                            '#2ecc71', // Red 
                                            '#3498db', // Yellow
                                            '#e74c3c', // Purple
                                            '#f39c12'  // Dark gray f39c12
                                        ];
                                    
                                        var trace = {
                                            labels: labels,
                                            values: data,
                                            type: 'pie',
                                            marker: {
                                                colors: colors
                                            },
                                            hole: 0.4
                                        };
                                    
                                        var layout = {
                                            title: 'Social Worker Status Distribution',
                                            showlegend: true
                                        };
                                    
                                        Plotly.newPlot('statusDonutChart', [trace], layout);
                                    </script>

                                    
                                    <!-- AGE RANGES BAR CHART -->
                                        <div id="ageRangesBarChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Social Worker Age Range</h2></b>
                                        <div id="ageRangesBarChart" style="max-height: 300px; width: 100%;"></div>
                                    </div>

                                    <script>
                                        var labels = <?php echo json_encode($ageRangeLabels); ?>;
                                        var data = <?php echo json_encode($ageRangeData); ?>;
                                        
                                        var colors = [
                                                        '#ff9999', // Light Red
                                                        '#99ff99', // Light Green
                                                        '#9999ff', // Light Blue
                                                        '#ffcc99', // Light Orange
                                                        '#cc99ff', // Light Purple
                                                        '#99ccff'  // Light Cyan
                                                    ];

                                    
                                        var trace = {
                                            x: labels,
                                            y: data,
                                            type: 'bar',
                                            marker: {
                                                color: colors
                                            }
                                        };
                                    
                                        var layout = {
                                            title: 'Social Worker Age Ranges Distribution',
                                            xaxis: {
                                                title: 'Age Range'
                                            },
                                            yaxis: {
                                                title: 'Social Worker Age Count'
                                            }
                                        };
                                    
                                        Plotly.newPlot('ageRangesBarChart', [trace], layout);
                                    </script>


                                    <!-- SOCIAL WORKER AVERAGE HOURS LINE CHART -->
                                    <div id="swAverageHoursLineChart-container" class="chart-container" style="text-align: center; width: 100%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Social Worker Average Hours</b></h2>
                                        <div id="swAverageHoursLineChart" style="max-height: 300px; width: 100%;"></div>
                                    </div>
                                    </div>
                                    
                                    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
                                    <?php
                                    $sql = "SELECT sw.sw_id, sw.fname, sw.lname, stt.login_time, stt.logout_time
                                            FROM tbl_sw_accs sw
                                            INNER JOIN social_worker_time_tracking stt ON sw.sw_id = stt.sw_id
                                            WHERE sw.status = 'Verified'";
                                    $result = $conn->query($sql);
                                    
                                    $swAverageHoursData = [];
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // Check if login_time and logout_time are not empty or null
                                            if (!empty($row['login_time']) && !empty($row['logout_time'])) {
                                                // Calculate the hours worked by each social worker
                                                $loginTime = strtotime($row['login_time']);
                                                $logOutTime = strtotime($row['logout_time']);
                                                $hoursWorked = ($logOutTime - $loginTime) / 3600; // Convert to hours
                                    
                                                $swAverageHoursData[] = [
                                                    'sw_id' => $row['sw_id'],
                                                    'fname' => $row['fname'],
                                                    'lname' => $row['lname'],
                                                    'hours_worked' => $hoursWorked
                                                ];
                                            }
                                        }
                                    }
                                    
                                    // Calculate average hours per social worker
                                    $averageHours = [];
                                    foreach ($swAverageHoursData as $record) {
                                        $swId = $record['sw_id'];
                                        $hoursWorked = $record['hours_worked'];
                                    
                                        if (!isset($averageHours[$swId])) {
                                            $averageHours[$swId] = [
                                                'fname' => $record['fname'],
                                                'lname' => $record['lname'],
                                                'total_hours' => 0,
                                                'count' => 0
                                            ];
                                        }
                                    
                                        $averageHours[$swId]['total_hours'] += $hoursWorked;
                                        $averageHours[$swId]['count']++;
                                    }
                                    
                                    $averageHoursData = [];
                                    foreach ($averageHours as $swId => $data) {
                                        $averageHoursData[] = [
                                            'sw_id' => $swId,
                                            'fname' => $data['fname'],
                                            'lname' => $data['lname'],
                                            'average_hours' => $data['total_hours'] / $data['count']
                                        ];
                                    }
                                    ?>
                                    
                                    <script>
                                        var swData = <?php echo json_encode($averageHoursData); ?>;
                                        
                                        var trace = {
                                            x: swData.map(function (record) { return record.fname + ' ' + record.lname; }),
                                            y: swData.map(function (record) { return record.average_hours; }),
                                            type: 'line'
                                        };
                                    
                                        var layout = {
                                            title: 'Social Worker Average Hours Worked',
                                            xaxis: {
                                                title: 'Social Worker'
                                            },
                                            yaxis: {
                                                title: 'Average Hours Worked'
                                            }
                                        };
                                    
                                        Plotly.newPlot('swAverageHoursLineChart', [trace], layout);
                                    </script>





                               <!-- CITY VERTICAL BAR CHART -->
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<div id="cityBarChart-container" class="chart-container" style="text-align: center; width: 80%; border: 2px solid #000; margin: 30px auto; padding: 5px;">
    <h2 style="color: darkblue;"><b>Social Worker City Distribution</b></h2>
    <div id="cityBarChart" style="height: 400px;"></div>
</div>

<?php
$sql = "SELECT city, COUNT(*) AS city_count FROM tbl_sw_accs GROUP BY city";
$result = $conn->query($sql);

$cityLabels = [];
$cityData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cityLabels[] = $row['city'];
        $cityData[] = $row['city_count'];
    }
}
?>

<!-- JavaScript code to create the bar chart -->
<script>
    var cityLabels = <?php echo json_encode($cityLabels); ?>;
    var cityData = <?php echo json_encode($cityData); ?>;

    // Function to generate random colors
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    var colors = cityLabels.map(function () {
        return getRandomColor();
    });

    var trace = {
        x: cityLabels,
        y: cityData,
        type: 'bar',
        marker: {
            color: colors
        }
    };

    var layout = {
        title: 'Social Worker City Distribution',
        xaxis: {
            title: 'City'
        },
        yaxis: {
            title: 'Count'
        }
    };

    Plotly.newPlot('cityBarChart', [trace], layout);
</script>



            <!-- FOOTER-->
            <footer id="footer" class="sticky-footer"  >
                <h3 id="h3footer"> © Copyright DORA 2023.</h3>
                <p id="current-date"></p>
            </footer>

</section>
        <!--Print/Download as PDF--->
        <script>
            function printPage() {
                window.print();
            }
        </script>

        <script>
            var currentDate = new Date();
            var options = { year: 'numeric', month: 'long', day: 'numeric' };
            var formattedDate = currentDate.toLocaleDateString('en-US', options);

            document.getElementById("current-date").textContent = "Date: " + formattedDate;
        </script>

    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
