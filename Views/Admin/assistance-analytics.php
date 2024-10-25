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
    <title>Assistance Analytics</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/dl-ass.css" media="print">


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


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
        }

        @media screen {
            .no-screen {
                display: none;
            }
        }

        #chart-container {
            text-align: center;
        }
  
        .canvasjs-chart-credit {
            display: none;
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
        <h5>Assistance Analytics</h5>
    </div>

    <section class="home-section">
        <!-- DATA PANELS -->
    <div class="container">
    <div class="row justify-content-center">

    <div class="container">
    <!-- Donation Panel Options -->
    <div class="row justify-content-center">
        <div class="col-md-12 text-center mb-3 mt-3">
            <h5 id="panel_label">Assistance Panel Options</h5>
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

<div id="assistance_data">
    <div class="row justify-content-center">
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Initial display of data (without date filter)
        displayAssistanceData(null, null);

        function displayAssistanceData($start_date, $end_date) {
            include 'includes/config.php';

            // Display Total Volunteers and Latest Submission Date
            $sql_total_applicants = "SELECT COUNT(DISTINCT APPLI_ID) AS TotalApplicants,
            DATE_FORMAT(MAX(submitteddate), '%M %d, %Y') AS latest_submitdate
            FROM tbl_applicants
            WHERE STAT = 'VERIFIED'";
            if ($start_date && $end_date) {
                $sql_total_applicants .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
            }

            $result_total_applicants = $conn->query($sql_total_applicants);
            if ($result_total_applicants->num_rows > 0) {
                while ($row = $result_total_applicants->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>';
                    echo '<div class="card-body">';
                    echo '<div id="card1" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                    echo '<h6 style="color:darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOTAL AMOUNT OF BENEFICIARIES</h6></b>';

                    $totalAmountFormatted = number_format($row["TotalApplicants"]);
                    echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

                    $latestSubmitDate = $row["latest_submitdate"];
                    echo '<p id="card-txt">Calculated: ' . $latestSubmitDate . '</p>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

           // Display Top Assistance Project
            $sql_top_assistance_project = "SELECT v.assistance_id, dp.title AS project_title, COUNT(DISTINCT v.appli_id) AS total_benefs
            FROM tbl_applicants v
            JOIN tbl_assistance dp ON v.assistance_id = dp.assistance_id
            WHERE v.stat = 'VERIFIED'
            GROUP BY v.assistance_id
            ORDER BY total_benefs DESC
            LIMIT 1";

            $result_top_assistance_project = $conn->query($sql_top_assistance_project);
            $topAssistanceProjectTitle = '';
            $topAssistanceProjectTotalBenefs = 0;

            if ($result_top_assistance_project->num_rows > 0) {
            $rowTopAssistanceProject = $result_top_assistance_project->fetch_assoc();
            $topAssistanceProjectTitle = $rowTopAssistanceProject['project_title'];
            $topAssistanceProjectTotalBenefs = $rowTopAssistanceProject['total_benefs'];
            }

            echo '<div class="col-sm-4 mb-3"><br>';
            echo '<div id="card2" class="card align-items-center" style="border: 2px solid #000000;"><br>';
            echo '<h6 style="color: darkblue; height:50px;" class="d-flex align-items-center mb-3"><b>TOP ASSISTANCE PROJECT</h6></b>';

            echo '<p style="text-align: center; font-size: 20px; color:darkblue;"><b>' . $topAssistanceProjectTitle . '</b></p>';
            echo '<p id="card-txt">Total Volunteers: ' . $topAssistanceProjectTotalBenefs . '</p>';

            echo '</div>';
            echo '</div>';


            // Display Ongoing Projects
            $sql_ongoing_projects = "SELECT COUNT(DISTINCT assistance_id) AS total_active_projects,
            DATE_FORMAT(MAX(uploadDate), '%M %d, %Y') AS latest_submitdate
            FROM tbl_assistance
            WHERE proj_stat = 'ON GOING'";

            $result_ongoing_projects = $conn->query($sql_ongoing_projects);
            $totalActiveProjects = 0;
            $latestSubmitDate = '';

            if ($result_ongoing_projects) {
                $rowActiveProjects = $result_ongoing_projects->fetch_assoc();
                $totalActiveProjects = isset($rowActiveProjects['total_active_projects']) ? $rowActiveProjects['total_active_projects'] : 0;
                $latestSubmitDate = isset($rowActiveProjects['latest_submitdate']) ? $rowActiveProjects['latest_submitdate'] : '';
            }

            echo '<div class="col-sm-4 mb-3"><br>';
            echo '<div id="card3" class="card align-items-center" style="border: 2px solid #000000;"><br>';
            echo '<h6 style="color: darkblue" class="d-flex align-items-center mb-3"><b>ON GOING PROJECTS</h6></b>';

            echo '<p style="text-align: center; font-size: 32px; color: darkblue; padding-bottom: 11px;"><b>' . $totalActiveProjects . '</b></p>';

            echo '<p id="card-txt">Calculated: ' . $latestSubmitDate . '</p>';

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>
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
                url: 'update_data_assist.php', 
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function (response) {
                    $('#assistance_data').html(response);
                }
            });
        });
    });
</script>


        

                   <!-- BENEFICIARIES AREA CHART -->
<div id="beneficiaries-container" class="chart-container"style="text-align: center; max-width: 100%; margin: 20px 0 20px 0; border: 2px solid #000;">
    <h3 id="h3font" style="margin-top:20px; color: darkblue;"><b>Beneficiary Chart Options</b></h3>
    <label for="start-date">Start Date:</label>
    <input class="range-btn" type="text" id="start-date" placeholder="MM-DD-YYYY">
    <label for="end-date">End Date:</label>
    <input class="range-btn" type="text" id="end-date" placeholder="MM-DD-YYYY">
    <button id="update" class="d-btn" onclick="validateAndUpdateChart()">Update Chart</button>
  
    <div id="my-chart" style="width: 100%; height: 300px;"></div>
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
        updateChart();
    });

    function formatDate(date) {
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        var year = date.getFullYear();
        return `${month}-${day}-${year}`;
    }

    function updateChart() {
        var startDatePicker = document.getElementById('start-date');
        var endDatePicker = document.getElementById('end-date');
        var startDate = startDatePicker.value;
        var endDate = endDatePicker.value;

        var startDateParts = startDate.split('-');
        var startDateObj = new Date(`${startDateParts[2]}-${startDateParts[0]}-${startDateParts[1]}`);
        
        var endDateParts = endDate.split('-');
        var endDateObj = new Date(`${endDateParts[2]}-${endDateParts[0]}-${endDateParts[1]}`);

        $.ajax({
            url: 'fetch_data_assist.php',
            method: 'POST',
            data: { startDate: startDateObj.toISOString(), endDate: endDateObj.toISOString() },
            dataType: 'json',
            success: function (chartData) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Beneficiary Count');

                // No need to format the date in JavaScript since it's already in the desired format
                data.addRows(chartData);

                var options = {
                    title: 'Beneficiary Transactions Chart',
                    isStacked: true,
                    legend: { position: 'bottom' },
                    vAxis: {
                        title: 'Number of Beneficiaries'
                    },
                    hAxis: {
                        title: 'Date'
                    },
                    tooltip: { isHtml: true },
                    pointSize: 5,
                };

                var chart = new google.visualization.AreaChart(document.getElementById('my-chart'));
                chart.draw(data, options);
            },
            error: function (error) {
                console.log('Error fetching data:', error);
            }
        });
    }

    function validateAndUpdateChart() {
    var startDatePicker = document.getElementById('start-date');
    var endDatePicker = document.getElementById('end-date');
    var startDate = startDatePicker.value;
    var endDate = endDatePicker.value;

    var startDateParts = startDate.split('-');
    var endDateParts = endDate.split('-');

    var startDateObj = new Date(`${startDateParts[2]}-${startDateParts[0]}-${startDateParts[1]}`);
    var endDateObj = new Date(`${endDateParts[2]}-${endDateParts[0]}-${endDateParts[1]}`);

    var minDate = new Date('2023-01-01');
    if (startDateObj < minDate) {
        startDateObj = minDate;
        startDatePicker.value = formatDate(minDate);
        Swal.fire({
            icon: 'error',
            text: "Start Date cannot be before January 1, 2023."
        });
    }

    var currentDate = new Date();
    if (endDateObj > currentDate) {
        endDateObj = currentDate;
        endDatePicker.value = formatDate(currentDate);
        Swal.fire({
            icon: 'error',
            text: "End Date cannot exceed the current date."
        });
    }

    updateChart();
}
</script>

                      <!-- CATEGORY FREQUENCY CHART -->
<div style="display: flex; justify-content: space-between;">
    <div id="chartCanvas-container" class="chart-container1" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Projects Category Frequency</b></h2>
        <div id="chartCanvas" style="max-height: 300px; width: 100%;"></div>
    </div>

   <?php
    $sql = "SELECT DISTINCT category FROM tbl_assistance";
    $result = mysqli_query($conn, $sql);

    $categories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }

    $dataPoints = array();

    foreach ($categories as $category) {
        $sql = "SELECT COUNT(*) AS category_count 
        FROM tbl_assistance 
        WHERE category = '$category'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $categoryCount = $row['category_count'];
        $dataPoints[] = array("Category" => $category, "y" => $categoryCount);
    }
?>

<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    window.onload = function () {
        var categories = <?php echo json_encode(array_column($dataPoints, 'Category')); ?>;
        var counts = <?php echo json_encode(array_column($dataPoints, 'y')); ?>;

        // Generate an array of dynamic colors based on the number of categories
        var colors = generateDynamicColors(categories.length);

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
            y: categories,
            orientation: 'h',
            marker: {
                color: colors
            }
        }];

        var layout = {
            title: 'Project Category Frequency',
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

        Plotly.newPlot('chartCanvas', data, layout, config);
    }
</script>


                                <?php
                                $sql = "SELECT applicant_type, COUNT(*) AS applicant_count
                                        FROM (SELECT CASE WHEN COUNT(appli_id) = 1 THEN 'One-Time' ELSE 'Recurring'
                                                END AS applicant_type
                                        FROM tbl_applicants
                                        GROUP BY appli_id) AS subquery
                                        GROUP BY applicant_type";

                                $result = $conn->query($sql);

                                $oneTimeApplicantCount = 0;
                                $recurringApplicantCount = 0;

                                $labels = [];
                                $data = [];

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["applicant_type"] === 'One-Time') {
                                            $oneTimeApplicantCount = $row["applicant_count"];
                                        } else if ($row["applicant_type"] === 'Recurring') {
                                            $recurringApplicantCount = $row["applicant_count"];
                                        }
                                    }

                                    $labels = ['One-Time Applicants', 'Recurring Applicants'];
                                    $data = [$oneTimeApplicantCount, $recurringApplicantCount];
                                }
                                ?>


                            <!-- DONUT CHART -->
                            <div id="applicantDonutChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>One-Time VS. Recurring</h2></b>
                                <canvas id="applicantDonutChart" style="max-height: 300px; width: 100%; margin-bottom: 20px;"></canvas>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            var data = <?php echo json_encode($data); ?>; 
                            var labels = <?php echo json_encode($labels); ?>; 

                            var ctx = document.getElementById('applicantDonutChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        data: data,
                                        backgroundColor: ['#3498db', '#2ecc71'],
                                        borderColor: 'white',
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    title: {
                                        display: true,
                                        text: 'Applicant Type Distribution'
                                    },
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    },
                                    animation: {
                                        animateScale: true,
                                        animateRotate: true
                                    },
                                    tooltips: {
                                        enabled: true,
                                        mode: 'single',
                                        callbacks: {
                                            label: function (tooltipItems, data) {
                                                return data.labels[tooltipItems.index] + ': ' + data.datasets[0].data[tooltipItems.index];
                                            }
                                        }
                                    }
                                }
                            });
                        </script>

                    <div style="display: flex; justify-content: space-between;">
                    <!-- PIE CHART -->
                    <div id="genderPieChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin-top: 5px; margin-bottom: 50px; padding: 5px;">
                            <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Gender Distribution </h2></b>
                            <canvas id="genderPieChart" style="max-height: 300px; width: 100%; margin-bottom: 20px;"></canvas>
                        </div>
                                    <?php
                                    $sql = "SELECT
                                            CASE
                                            WHEN dv.gender = 'Male' THEN 'Male'
                                            WHEN dv.gender = 'Female' THEN 'Female' ELSE 'Other'
                                            END AS gender, COUNT(DISTINCT v.appli_id) AS applicant_count
                                            FROM tbl_applicants v INNER JOIN tbl_appli_accs dv ON v.appli_id = dv.appli_id
                                            WHERE v.stat = 'Verified'
                                            GROUP BY gender";

                                    $result = $conn->query($sql);

                                    $genderLabels = [];
                                    $genderData = [];

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $genderLabels[] = $row['gender'];
                                            $genderData[] = $row['applicant_count'];
                                        }
                                    }
                                    ?>

                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <script>
                                            var labels = <?php echo json_encode($genderLabels); ?>;
                                            var data = <?php echo json_encode($genderData); ?>;

                                            var ctx = document.getElementById('genderPieChart').getContext('2d');
                                            var chart = new Chart(ctx, {
                                                type: 'pie',
                                                data: {
                                                    labels: labels,
                                                    datasets: [{
                                                        data: data,
                                                        backgroundColor: ['#B88BF5', '#96A8ED'], // Blue for male, Red for female
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    title: {
                                                        display: true,
                                                        text: 'Applicant Gender Distribution'
                                                    },
                                                    legend: {
                                                        display: true,
                                                        position: 'bottom'
                                                    },
                                                }
                                            });
                                        </script>

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
                                    COUNT(DISTINCT v.appli_id) AS applicant_count
                                FROM
                                    tbl_applicants v
                                INNER JOIN
                                    tbl_appli_accs dv ON v.appli_id = dv.appli_id
                                WHERE v.stat = 'Verified'
                                GROUP BY
                                    age_range

                                    ";

                                $result = $conn->query($sql);

                                $ageRangeLabels = [];
                                $ageRangeData = [];

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $ageRangeLabels[] = $row['age_range'];
                                        $ageRangeData[] = $row['applicant_count'];
                                    }
                                }
                                ?>

                               <!-- VERTICAL BAR GRAPH -->
                               <div id="ageRangesBarChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin-top: 5px; margin-bottom: 50px; padding: 5px;">
                                <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Applicant Age Range </h2></b>
                                <canvas id="ageRangesBarChart" style="max-height: 300px; width: 100%; margin-bottom: 20px;"></canvas>
                                </div></div>

                            <script>
                                var labels = <?php echo json_encode($ageRangeLabels); ?>;
                                var data = <?php echo json_encode($ageRangeData); ?>;
                                
                                var colors = [
                                    '#34495e', // Green 
                                    '#9b59b6', // Blue 
                                    '#f39c12', // Red 
                                    '#e74c3c', // Yellow 
                                    '#3498db', // Purple 
                                    '#2ecc71'  // Dark gray
                                ];

                                var backgroundColors = labels.map((label, index) => colors[index]);

                                var ctx = document.getElementById('ageRangesBarChart').getContext('2d');
                                var chart = new Chart(ctx, {
                            type: 'bar',  
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Age Group',  
                                    data: data,
                                    backgroundColor: backgroundColors, 
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                title: {
                                    display: true,
                                    text: 'Applicant Age Ranges Distribution'
                                },
                                legend: {
                                    display: true,
                                    position: 'bottom'
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true,
                                        },
                                    }],
                                },
                            }
                        });
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
