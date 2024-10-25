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
    <title>Volunteer Projects</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/dn-fullproject.css">

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

    <!-- BAR CHART -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <style>
        .pie-chart-section {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .progress-section,
        .pie-chart-section {
            flex: 1;
            padding: 20px;
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
    <div class="header">
        <h5>Volunteer Project Details</h5>
  </div>

    <section class="home-section">
        <div class="back-btn">
        <button type="button" class="btn" onclick="goBack()">Back</button>
        </div>

        <?php
    $id = $_GET['id'];
    // Query to fetch the project details along with the social worker info
    
   $sql = "SELECT *, CONCAT(tbl_sw_accs.fname, ' ', tbl_sw_accs.lname) AS organizer_name, tbl_vol_proj.image AS project_image
    FROM tbl_vol_proj
    RIGHT JOIN tbl_sw_accs ON tbl_vol_proj.sw_id = tbl_sw_accs.sw_id
    WHERE tbl_vol_proj.vol_proj_id = '$id'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result)) {

        // Query to get the distinct count of volunteers based on their user_id
        $sql2 = "SELECT COUNT(DISTINCT user_id) AS distinct_volunteers FROM tbl_volunteers WHERE vol_proj_id = $id AND stat = 'Verified'";
        $distinct_volunteers_result = mysqli_query($conn, $sql2);
        $distinct_volunteers_row = mysqli_fetch_array($distinct_volunteers_result);
        $distinct_volunteers = $distinct_volunteers_row['distinct_volunteers'];

        // Progress bar calculation
        $percentage = ($distinct_volunteers / $row['totalGoal']) * 100;
        $remaining = $row['totalGoal'] - $distinct_volunteers;

        echo '
        <div class="title text-center">
            <p>' . $row['category'] . '</p>
            <h3>' . $row['title'] . '</h3>
            <p>Organized By: ' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . '<br>
                    Date Uploaded: ' . date('F j, Y', strtotime($row['uploadDate'])) . '</p>
        </div>

        <div class="container w-75 content">
            <div class="row">
                <div class="col-lg-8">
                    <div class="proj-img">
                        <img src="../SocialWorker/vol_img/' . $row['project_image'] . '" style="width: 100%">
                    </div>

                    <div class="proj-desc">
                        <p><i><b>Summary</b></i></p>
                        <div class="details">
                            <p>' . $row['text'] . '</p>
                        </div>

                        <div class="goal">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row"> <b>' . $row['totalGoal'] . '</b></div>
                                    <div class="row"> <p class="par"> Total Needed Volunteers </p></div>

                                    <div class="row"> <b>' . $row['eventDate'] . '</b></div>
                                    <div class="row"> <p class="par"> Project Date </p></div>
                                </div>

                                <div class="col-6">';
        if ($distinct_volunteers >= $row['totalGoal']) {
            echo '
                <div class="row"> <span>&#10003;</span> </div>
                <div class="row"> <p class="par"> Goal Reached! </p></div> 
            ';
        } else {
            echo '
                <div class="row"> <b> ' . number_format($remaining) . ' </b></div>
                <div class="row"> <p class="par"> Remaining </p></div> 
            ';
        }
        echo '
                                    <div class="row"> <b>' . $distinct_volunteers . '</b></div>
                                    <div class="row"> <p class="par"> Volunteers Count </p></div>
                                </div>
                            </div>
                        </div>

                        <p><i><b>Volunteer Project Information</b></i></p>
                        <div class="additional">
                            <p>Location: <b>' . $row['location'] . '</p></b>
                            <p>Contact Information: <b>' . $row['full_contact'] . '</p></b>
                        </div>

                    </div>
                </div>

                <div class="col-4">
                    <div class="box">
                        <p class="progress-raised"> ' . $distinct_volunteers . ' registered volunteers</p>
                        <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: ' . $percentage . '%"></div>
                        </div>';
        if ($distinct_volunteers >= $row['totalGoal']) {
            echo '<p class="progress-to-go">Goal Reached!</p>';
        } else {
            echo '<p class="progress-to-go"> ' . $remaining . ' to go </p>';
        }
        echo '
                        </div>

                        <!-- Add the pie chart container below the project details -->
                        <div class="row justify-content-center mt-3">
                            <div class="col-lg-8">
                                <canvas id="myPieChart-' . $row['vol_proj_id'] . '" style="max-width: 400px; margin: auto;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';

        // Include the Chart.js library and pie chart script for each project separately
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        echo '<script>
            var ctx' . $row['vol_proj_id'] . ' = document.getElementById("myPieChart-' . $row['vol_proj_id'] . '").getContext("2d");
            var myPieChart' . $row['vol_proj_id'] . ' = new Chart(ctx' . $row['vol_proj_id'] . ', {
                type: "pie",
                data: {
                    labels: ["Raised", "Remaining"],
                    datasets: [{
                        label: "Amount",
                        data: [' . $distinct_volunteers . ', ' . $remaining . '],
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.6)",
                            "rgba(54, 162, 235, 0.6)"
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)"
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        onComplete: function (animation) {
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
        </script>';
    }
    ?>
  

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

             // Back Button Functions
             function goBack() {
            window.history.back();
        }
        </script>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>