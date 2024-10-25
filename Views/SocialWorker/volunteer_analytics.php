<?php
include 'includes/config.php';

session_start();
$sw_id = $_SESSION['sw_id'];

if (!isset($sw_id)) {
   header('location:/login.php');
   exit; 
}

if (isset($_GET['logout'])) {
   unset($sw_id);
   session_destroy();
   header('location:/index.php');
   exit; 
}
?>

<?php
$sw_id = $_SESSION['sw_id'];

function isSocialWorkerLoggedIn()
{
    return isset($_SESSION['sw_id']);
}


if (isset($_POST['start'])) {
    $sw_id = 1; 
    $_SESSION['sw_id'] = $sw_id;

    $login_time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO social_worker_time_tracking (sw_id, login_time) VALUES ('$sw_id', '$login_time')";
    if (mysqli_query($conn, $sql)) {
        echo "Time In: " . $login_time;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

if (isset($_POST['end'])) {
    $sw_id = $_SESSION['sw_id'];

    $logout_time = date("Y-m-d H:i:s");
    $sql = "UPDATE social_worker_time_tracking SET logout_time='$logout_time' WHERE sw_id='$sw_id' AND logout_time IS NULL";
    if (mysqli_query($conn, $sql)) {
      echo '<script type="text/javascript">';
      echo 'alert("You have logged Out!");';
      echo '</script>';
      echo '<meta http-equiv="refresh" content="3;url=login_socialworker.php">';
      echo "Time Out: " . $logout_time;
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
      session_destroy();
    header("Location: /login_socialworker.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Worker</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/buttons.css">
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
    </style>
</head>

<body>
    <!--LOADER-->
<script src="js/loader.js"></script>
    <div class="loader"></div>

  <div class="sidebar close">
    <div class="logo-details">
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
    
    <!-- TITLE BARS -->
    <div class="header no-print">
        <h3>Volunteer Analytics</h3>
    </div>

    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>

<!-- DATA PANELS -->
    <div class="container">
    <div class="row justify-content-center">

    <div class="container">
    <!-- Donation Panel Options -->
    <div class="row justify-content-center">
        <div class="col-md-12 text-center mb-3">
            <h3 id="panel_label">Volunteer Panel Options</h3>
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
                <input type="hidden" id="sw_id" value="<?php echo $sw_id; ?>"> 

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
        displayVolunteerData(null, null, $sw_id);

        function displayVolunteerData($start_date, $end_date, $sw_id) {
            // Connect to your database (replace with your database connection code)
            include 'includes/config.php';

            // Display Total Volunteers and Latest Submission Date
            $sql_total_volunteers = "SELECT COUNT(DISTINCT USER_ID) AS TotalVolunteers,
                                        DATE_FORMAT(MAX(submitteddate), '%M %d, %Y') AS latest_submitdate
                                        FROM tbl_volunteers v
                                        JOIN tbl_vol_proj vp ON v.vol_proj_id = vp.vol_proj_id
                                        WHERE STAT = 'VERIFIED' AND sw_id = $sw_id";

            if ($sw_id) {
                $sql_total_volunteers .= " AND vp.sw_id = {$sw_id}"; 
            }

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
                    echo '<p id="c_txt">Calculated: ' . $latestSubmitDate . '</p>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            // Display Top Volunteer Project
            $sql_top_volunteer_project = "SELECT v.vol_proj_id, dp.title AS project_title, COUNT(DISTINCT v.user_id) AS total_volunteers
                                            FROM tbl_volunteers v
                                            JOIN tbl_vol_proj dp ON v.vol_proj_id = dp.vol_proj_id
                                            WHERE v.stat = 'VERIFIED' AND sw_id = $sw_id
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

            echo '<p id="top_vol"style="text-align: center; font-size: 20px; color:darkblue;"><b>' . $topVolunteerProjectTitle . '</b></p>';
            echo '<p id="tot_vol">Total Volunteers: ' . $topVolunteerProjectTotalVolunteers . '</p>';

            echo '</div>';
            echo '</div>';

            // Display Ongoing Projects
            $sql_ongoing_projects = "SELECT COUNT(DISTINCT vol_proj_id) AS total_active_projects,
                                        DATE_FORMAT(MAX(uploadDate), '%M %d, %Y') AS latest_submitdate
                                        FROM tbl_vol_proj
                                        WHERE proj_stat = 'ON GOING' AND sw_id = $sw_id";

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

            echo '<p id="c_txt">Calculated: ' . $latestSubmitDate . '</p>';

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                            $(document).ready(function() {
                            var startDate = new Date();
                            startDate.setDate(startDate.getDate() - startDate.getDay() + (startDate.getDay() === 0 ? -6 : 1));
                            $('#start_date').val(startDate.toISOString().substr(0, 10));

                            var endDate = new Date();
                            endDate.setDate(startDate.getDate() + 6);
                            $('#end_date').val(endDate.toISOString().substr(0, 10));

                            $('#update_button').click(function() {
                                var startDate = $('#start_date').val();
                                var endDate = $('#end_date').val();
                                var sw_id = $('#sw_id').val(); // Retrieve sw_id dynamically

                                $.ajax({
                                    type: 'POST',
                                    url: 'update_data_vol.php',
                                    data: {
                                        start_date: startDate,
                                        end_date: endDate,
                                        sw_id: sw_id  // Include sw_id in the data
                                    },
                                    success: function(response) {
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

    var sw_id = <?php echo json_encode($sw_id); ?>;

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

        $.ajax({
            url: 'fetch_data_vol.php',
            method: 'POST',
            data: {
                startDate: startDate,
                endDate: endDate,
                sw_id: sw_id
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
</script>


 <!-- CATEGORY FREQUENCY CHART -->
 <div style="display: flex; justify-content: space-between;">
<div id="chartCanvas-container" class="chart-container1"style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Projects Category Frequency</b></h2>
        <div id="chartCanvas" style="max-height: 300px; width: 100%;" ></div>
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
                                <?php
                                include 'includes/config.php';

                                $sql = "SELECT volunteer_type, COUNT(*) AS volunteer_count
                                        FROM (SELECT CASE WHEN COUNT(user_id) = 1 THEN 'One-Time' ELSE 'Recurring'
                                                END AS volunteer_type
                                        FROM tbl_volunteers v
                                        JOIN tbl_vol_proj vp ON v.vol_proj_id = vp.vol_proj_id
                                        WHERE sw_id = $sw_id
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

                <!-- DONUT CHART -->
                <div id="volunteerDonutChart-container" class="chart-container2" style="text-align: center; width: 49%; border: 2px solid #000; margin: 30px 0; padding: 5px; height: 400px;">
                        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>One-Time VS. Recurring</b></h2>
                        <canvas id="volunteerDonutChart" style="max-height: 300px; width: 100%;"></canvas>
                    </div>
                </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            var data = <?php echo json_encode($data); ?>; 
                            var labels = <?php echo json_encode($labels); ?>; 

                            var ctx = document.getElementById('volunteerDonutChart').getContext('2d');
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
                                        text: 'Volunteer Type Distribution'
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
                                    include 'includes/config.php';

                                    $sql = "SELECT
                                    COUNT(DISTINCT v.user_id) AS volunteer_count,
                                    CASE
                                        WHEN dv.gender = 'Male' THEN 'Male'
                                        WHEN dv.gender = 'Female' THEN 'Female'
                                        ELSE 'Other'
                                    END AS gender 
                                FROM tbl_volunteers v
                                INNER JOIN tbl_dv_accs dv ON v.user_id = dv.user_id
                                INNER JOIN tbl_vol_proj vp ON v.vol_proj_id = vp.vol_proj_id
                                WHERE v.stat = 'Verified' AND sw_id = $sw_id
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
                                                        backgroundColor: ['#B88BF5', '#96A8ED'], 
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    title: {
                                                        display: true,
                                                        text: 'Volunteer Gender Distribution'
                                                    },
                                                    legend: {
                                                        display: true,
                                                        position: 'bottom'
                                                    },
                                                }
                                            });
                                        </script>

                                <?php
                                include 'includes/config.php';

                                $sql = "SELECT
                                CASE
                                    WHEN age BETWEEN 18 AND 24 THEN '18-24'
                                    WHEN age BETWEEN 25 AND 34 THEN '25-34'
                                    WHEN age BETWEEN 35 AND 44 THEN '35-44'
                                    WHEN age BETWEEN 45 AND 54 THEN '45-54'
                                    WHEN age BETWEEN 55 AND 64 THEN '55-64'
                                    ELSE '65+'
                                        END AS age_range,
                                        COUNT(DISTINCT v.user_id) AS volunteer_count
                                    FROM
                                        tbl_volunteers v
                                    INNER JOIN
                                        tbl_dv_accs dv ON v.user_id = dv.user_id
                                    INNER JOIN
                                        tbl_vol_proj vp ON v.vol_proj_id = vp.vol_proj_id  
                                    WHERE v.stat = 'Verified' AND sw_id = $sw_id
                                    GROUP BY
                                        age_range";
                    

                                $result = $conn->query($sql);

                                $ageRangeLabels = [];
                                $ageRangeData = [];

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $ageRangeLabels[] = $row['age_range'];
                                        $ageRangeData[] = $row['volunteer_count'];
                                    }
                                }
                                ?>

                               <!-- VERTICAL BAR GRAPH -->
                               <div id="ageRangesBarChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin-top: 5px; margin-bottom: 50px; padding: 5px;">
                                <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Volunteer Age Range </h2></b>
                                <canvas id="ageRangesBarChart" style="max-height: 300px; width: 100%; margin-bottom: 20px;"></canvas>
                                </div></div>

                            <script>
                                var labels = <?php echo json_encode($ageRangeLabels); ?>;
                                var data = <?php echo json_encode($ageRangeData); ?>;
                                
                                var colors = [
                                    '#3498db', // Blue 
                                    '#2ecc71', // Green 
                                    '#e74c3c', // Red 
                                    '#f39c12', // Yellow 
                                    '#9b59b6', // Purple 
                                    '#34495e'  // Dark gray
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
                                    text: 'Volunteer Age Ranges Distribution'
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
