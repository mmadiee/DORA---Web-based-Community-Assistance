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
    <title>Volunteer Analytics</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/vol_dl.css" media="print">

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
            top: 100%;}
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
        <h5>Volunteer Analytics</h5>
    </div>

    <section class="home-section">

<!-- DATA PANELS -->
    <div class="container">
    <div class="row justify-content-center">

    <div class="container">
    <!-- Donation Panel Options -->
    <div class="row justify-content-center">
        <div class="col-md-12 text-center mb-3 mt-3 ">
            <h5 id="panel_label">Volunteer Panel Options</h5>
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

    <!-- Display volunteer data -->
<div id="volunteer_data">
    <div class="row justify-content-center">
        <?php
        // Initial display of data (without date filter)
        displayVolunteerData(null, null);

        function displayVolunteerData($start_date, $end_date) {
            // Connect to your database (replace with your database connection code)
            include 'includes/config.php';

            // Display Total Volunteers and Latest Submission Date
            $sql_total_volunteers = "SELECT COUNT(DISTINCT USER_ID) AS TotalVolunteers,
                                        DATE_FORMAT(MAX(submitteddate), '%M %d, %Y') AS latest_submitdate
                                        FROM tbl_volunteers
                                        WHERE STAT = 'VERIFIED'";
            if ($start_date && $end_date) {
                $sql_total_volunteers .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
            }

            $result_total_volunteers = $conn->query($sql_total_volunteers);
            if ($result_total_volunteers->num_rows > 0) {
                while ($row = $result_total_volunteers->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>';
                    echo '<div class="card-body">';
                    echo '<div id="card1" class="card align-items-center" style="border: 2px solid #000000; height: 210px;"><br>';
                    echo '<h6 style="color:darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOTAL AMOUNT OF VOLUNTEERS GARNERED</h6></b>';

                    $totalAmountFormatted = number_format($row["TotalVolunteers"]);
                    echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

                    $latestSubmitDate = $row["latest_submitdate"];
                    echo '<p id="c1_txt">Calculated: ' . $latestSubmitDate . '</p>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            // Display Top Volunteer Project
            $sql_top_volunteer_project = "SELECT v.vol_proj_id, dp.title AS project_title, COUNT(DISTINCT v.user_id) AS total_volunteers
                                        FROM tbl_volunteers v
                                        JOIN tbl_vol_proj dp ON v.vol_proj_id = dp.vol_proj_id
                                        WHERE v.stat = 'VERIFIED'
                                        GROUP BY v.vol_proj_id
                                        ORDER BY total_volunteers DESC
                                        LIMIT 1";

            $result_top_volunteer_project = $conn->query($sql_top_volunteer_project);
            $topVolunteerProjectTitle = '';
            $topVolunteerProjectTotalVolunteers = 0;

            if ($result_top_volunteer_project->num_rows > 0) {
                $rowTopVolunteerProject = $result_top_volunteer_project->fetch_assoc();
                $topVolunteerProjectTitle = $rowTopVolunteerProject['project_title'];
                $topVolunteerProjectTotalVolunteers = $rowTopVolunteerProject['total_volunteers'];
            }

            echo '<div class="col-sm-4 mb-3"><br>';
            echo '<div id="card2" class="card align-items-center" style="border: 2px solid #000000; height: 210px;"><br>';
            echo '<h6 style="color: darkblue" class="d-flex align-items-center mb-3"><b>TOP VOLUNTEER PROJECT</h6></b>';

            echo '<p id="top_vol" style="text-align: center; font-size: 20px; color:darkblue;"><b>' . $topVolunteerProjectTitle . '</b></p>';
            echo '<p id="tot_vol">Total Volunteers: ' . $topVolunteerProjectTotalVolunteers . '</p>';

            echo '</div>';
            echo '</div>';

            // Display Ongoing Projects
            $sql_ongoing_projects = "SELECT COUNT(DISTINCT vol_proj_id) AS total_active_projects,
                                    DATE_FORMAT(MAX(uploadDate), '%M %d, %Y') AS latest_submitdate
                                    FROM tbl_vol_proj
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
            echo '<div id="card3" class="card align-items-center" style="border: 2px solid #000000; height: 210px;"><br>';
            echo '<h6 style="color: darkblue" class="d-flex align-items-center mb-3"><b>ON GOING PROJECTS</h6></b>';

            echo '<p style="text-align: center; font-size: 32px; color: darkblue; padding-bottom: 11px;"><b>' . $totalActiveProjects . '</b></p>';

            echo '<p id="c3_txt">Calculated: ' . $latestSubmitDate . '</p>';

            echo '</div>';
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
                url: 'update_data_vol.php', 
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function (response) {
                    $('#volunteer_data').html(response);
                }
            });
        });
    });
</script>


                    <!-- VOLUNTEER AREA CHART -->
<div id="volunteer-chart-container" class="chart-container" style="text-align: center; max-width: 100%; margin: 20px 0 20px 0; border: 2px solid #000;">
    <h3 id="h3font" style="margin-top:20px; color: darkblue;"><b>Volunteer Chart Options</b></h3>
    <label for="start-date">Start Date:</label>
    <input class="range-btn" type="text" id="start-date" placeholder="MM/DD/YYYY">
    <label for="end-date">End Date:</label>
    <input class="range-btn" type="text" id="end-date" placeholder="MM/DD/YYYY">
    <button class="d-btn" id="update" onclick="validateAndUpdateVolunteerChart()">Update Chart</button>
    
    <div id="volunteer-chart" style="width: 100%; height: 300px;"></div>
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
        updateVolunteerChart();
    });

    function formatDate(date) {
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        var year = date.getFullYear();
        return `${month}/${day}/${year}`;
    }

    function updateVolunteerChart() {
        var startDatePicker = document.getElementById('start-date');
        var endDatePicker = document.getElementById('end-date');
        var startDate = startDatePicker.value;
        var endDate = endDatePicker.value;

        var startDateParts = startDate.split('/');
        var endDateParts = endDate.split('/');

        var startDateObj = new Date(`${startDateParts[2]}-${startDateParts[0]}-${startDateParts[1]}`);
        var endDateObj = new Date(`${endDateParts[2]}-${endDateParts[0]}-${endDateParts[1]}`);

        // Proceed to update the chart if dates are valid
        $.ajax({
            url: 'fetch_data_vol.php',
            method: 'POST',
            data: {
                startDate: startDateObj.toISOString(),
                endDate: endDateObj.toISOString()
            },
            dataType: 'json',
            success: function (chartData) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Volunteer Count');
                data.addRows(chartData);

                var options = {
                    title: 'Volunteer Chart',
                    isStacked: true,
                    legend: { position: 'bottom' },
                    vAxis: {
                        title: 'Number of Volunteers'
                    },
                    hAxis: {
                        title: 'Date'
                    },
                    tooltip: { isHtml: true },
                    pointSize: 5,
                };

                var chart = new google.visualization.AreaChart(document.getElementById('volunteer-chart'));
                chart.draw(data, options);
            },
            error: function (error) {
                console.log('Error fetching data:', error);
            }
        });
    }

    function validateAndUpdateVolunteerChart() {
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

        updateVolunteerChart();
    }
    
    function exportVolunteerData() {
        var startDate = document.getElementById('start-date').value;
        var endDate = document.getElementById('end-date').value;

        // Redirect to the export-don-chart.php file with the start and end dates as parameters
        window.location.href = 'export-vol-chart.php?startDate=' + startDate + '&endDate=' + endDate;
    }
</script>



                                <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                                    <!-- CATEGORY FREQUENCY CHART -->
                                    <div id="chartCanvas-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Projects Category Frequency</b></h2>
                                        <div id="chartCanvas" style="max-height: 300px; width: 100%;"></div>
                                    </div>
                                
                                
                                    <?php
                                    $sql = "SELECT DISTINCT category FROM tbl_vol_proj";
                                    $result = mysqli_query($conn, $sql);
                                
                                    $categories = array();
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $categories[] = $row['category'];
                                    }
                                
                                    $dataPoints = array();
                                
                                    foreach ($categories as $category) {
                                        $sql = "SELECT COUNT(*) AS category_count 
                                        FROM tbl_vol_proj 
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

      
                  

                         <!-- RECURRING VS ONE TIME CHART -->
                            <div id="volunteerDonutChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>One-Time VS. Recurring</b></h2>
                                <div id="volunteerDonutChart" style="max-height: 300px; width: 100%;"></div>
                            </div>

                            <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

                                <!-- RECURRING VS ONE TIME CHART -->
                                <?php
                                $sql = "SELECT volunteer_type, COUNT(*) AS volunteer_count
                                        FROM (SELECT CASE WHEN COUNT(user_id) = 1 THEN 'One-Time' ELSE 'Recurring'
                                                END AS volunteer_type
                                        FROM tbl_volunteers
                                        GROUP BY user_id) AS subquery
                                        GROUP BY volunteer_type";

                                $result = $conn->query($sql);

                                $oneTimeVolunteersCount = 0;
                                $recurringVolunteersCount = 0;

                                $labels = [];
                                $data = [];

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["volunteer_type"] === 'One-Time') {
                                            $oneTimeVolunteersCount = $row["volunteer_count"];
                                        } else if ($row["volunteer_type"] === 'Recurring') {
                                            $recurringVolunteersCount = $row["volunteer_count"];
                                        }
                                    }

                                    $labels = ['One-Time Volunteers', 'Recurring Volunteers'];
                                    $data = [$oneTimeVolunteersCount, $recurringVolunteersCount];
                                }
                                ?>


                                  <script>
                                        var labels = <?php echo json_encode($labels); ?>;
                                        var data = <?php echo json_encode($data); ?>;
                                    
                                        var trace = {
                                            labels: labels,
                                            values: data,
                                            type: 'pie',
                                            textinfo: 'value+percent',
                                            textposition: 'inside',
                                            hoverinfo: 'label',
                                            hole: 0.4, // Adjust this value to control the size of the hole in the donut chart
                                        };
                                    
                                        var data = [trace];
                                    
                                        var layout = {
                                            title: 'Volunteer Type Distribution',
                                        };
                                    
                                        Plotly.newPlot('volunteerDonutChart', data, layout);
                                    </script>
                                    
                                    
                                     <!-- GENDER DISTRIBUTION CHART-->
                                    <div id="genderPieChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                                <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Gender Distribution</b></h2>
                                <div id="genderPieChart" style="max-height: 300px; width: 100%;"></div>
                            </div>
     
                            
                            <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
                            <?php
                            $sql = "SELECT
                                COUNT(DISTINCT v.user_id) AS volunteer_count,
                                CASE
                                    WHEN dv.gender = 'Male' THEN 'Male'
                                    WHEN dv.gender = 'Female' THEN 'Female'
                                    ELSE 'Other'
                                END AS gender FROM tbl_volunteers v
                                INNER JOIN tbl_dv_accs dv ON v.user_id = dv.user_id
                                WHERE v.stat = 'Verified'
                                GROUP BY gender";
                            
                            $result = $conn->query($sql);
                            
                            $genderLabels = [];
                            $genderData = [];
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $genderLabels[] = $row['gender'];
                                    $genderData[] = $row['volunteer_count'];
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
                                    title: 'Volunteer Gender Distribution',
                                    showlegend: true,
                                };
                            
                                Plotly.newPlot('genderPieChart', plotData, layout);
                            </script>



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
    COUNT(DISTINCT v.user_id) AS volunteer_count
FROM
    tbl_volunteers v
INNER JOIN
    tbl_dv_accs dv ON v.user_id = dv.user_id
WHERE v.stat = 'Verified'
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

<!-- AGE RANGES BAR CHART -->
                                        <div id="ageRangesBarChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
    <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Volunteer Age Range</h2></b>
    <div id="ageRangesBarChart" style="max-height: 300px; width: 100%;"></div>
</div>
</div>

<script>
    var labels = <?php echo json_encode($ageRangeLabels); ?>;
    var data = <?php echo json_encode($ageRangeData); ?>;
    
    var colors = [
        '#34495e', // Blue
        '#9b59b6', // Green
        '#e74c3c', // Red
        '#f39c12', // Yellow
        '#2ecc71', // Purple
        '#3498db'  // Dark gray
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
        title: 'Volunteer Age Ranges Distribution',
        xaxis: {
            title: 'Age Range'
        },
        yaxis: {
            title: 'Volunteer Count'
        }
    };

    Plotly.newPlot('ageRangesBarChart', [trace], layout);
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
