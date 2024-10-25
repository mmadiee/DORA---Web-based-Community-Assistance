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
    <title>Admin</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" type="text/css" href="css/don_dl.css" media="print">

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
        <h5>Donation Analytics</h5>
    </div>

    <section class="home-section">

        <!-- DATA PANELS -->
        <div class="container">
        <div class="row justify-content-center">

        <div class="container">
    <!-- Donation Panel Options -->
    <div class="row justify-content-center">
        <div class="col-md-12 text-center mb-3 mt-3">
            <h5 id="panel_label">Donation Panel Options</h5>
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

    <!-- Display donation data -->
    <div id="donation_data">
    <div class="row justify-content-center">

        <?php
        // Initial display of data (without date filter)
        displayDonationData(null, null);

        function displayDonationData($start_date, $end_date) {
            include 'includes/config.php';
            
            // PANEL 1
            $sql = "SELECT SUM(amount) AS total_amount, DATE_FORMAT(MAX(submitdate), '%M %d, %Y') AS latest_submitdate FROM tbl_transaction WHERE stat = 'Verified'";
            if ($start_date && $end_date) {
                $sql .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>';
                    echo '<div class="card-body">';
                    echo '<div id="card1" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                    echo '<h6 style="color:darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>TOTAL AMOUNT OF DONATIONS COLLECTED</h6></b>';

                    $totalAmountFormatted = '₱ ' . number_format($row["total_amount"]);
                    echo '<p style="font-size: 32px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

                    $latestSubmitDate = $row["latest_submitdate"];
                    echo '<p id="txt-card">Calculated: ' . $latestSubmitDate . '</p>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
                // PANEL 2
                $sql_highest_amount = "SELECT MAX(CAST(amount AS DECIMAL)) AS highest_amount, DATE_FORMAT(submitdate, '%M %d, %Y') AS submitdate_formatted FROM tbl_transaction WHERE stat = 'Verified'";
                if ($start_date && $end_date) {
                    $sql_highest_amount .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
                }

                $result_highest_amount = $conn->query($sql_highest_amount);

                if ($result_highest_amount->num_rows > 0) {
                    while ($row = $result_highest_amount->fetch_assoc()) {
                        echo '<div class="col-sm-4 mb-3"><br>';
                        echo '<div class="card-body">';
                        echo '<div id="card2" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                        echo '<h6 style="color:darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>HIGHEST DONATION COLLECTED</b></h6>';

                        $highestAmountFormatted = '₱ ' . number_format($row["highest_amount"]);
                        echo '<p style="font-size: 32px; color:darkblue;"><b>' . $highestAmountFormatted . '</b></p>';

                        $highestSubmitDate = $row["submitdate_formatted"];
                        echo '<p id="txt-card">Date Submitted: ' . $highestSubmitDate . '</p>';

                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                    // PANEL 3
                    $sql_latest_donation = "SELECT amount, DATE_FORMAT(submitdate, '%M %d, %Y') AS submitdate_formatted FROM tbl_transaction WHERE stat = 'Verified' ORDER BY transac_id DESC LIMIT 1";
                    if ($start_date && $end_date) {
                        $sql_latest_donation .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
                    }

                    $result_latest_donation = $conn->query($sql_latest_donation);

                    if ($result_latest_donation->num_rows > 0) {
                        while ($row = $result_latest_donation->fetch_assoc()) {
                            echo '<div class="col-sm-4 mb-3"><br>';
                            echo '<div class="card-body">';
                            echo '<div id="card3" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                            echo '<h6 style="color:darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>LATEST DONATION COLLECTED</b></h6>';

                            $totalAmountFormatted = '₱ ' . number_format($row["amount"]);
                            echo '<p style="font-size: 32px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

                            $latestSubmitDate = $row["submitdate_formatted"];
                            echo '<p id="txt-card">Date Submitted: ' . $latestSubmitDate . '</p>';

                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        // PANEL 4
                        $sql_donor_count = "SELECT COUNT(DISTINCT user_id) AS donor_count, DATE_FORMAT(MAX(submitdate), '%M %d, %Y') AS last_calculation_date FROM tbl_transaction WHERE stat = 'Verified'";
                        $result_donor_count = $conn->query($sql_donor_count);

                        if ($result_donor_count->num_rows > 0) {
                            $row_donor_count = $result_donor_count->fetch_assoc();
                            $donor_count = $row_donor_count["donor_count"];
                            $last_calculation_date = $row_donor_count["last_calculation_date"];

                            echo '<div class="col-sm-4 mb-3"><br>';
                            echo '<div class="card-body">';
                            echo '<div id="card4" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                            echo '<h6 style="color:darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>TOTAL DONOR COUNT</b></h6>';

                            echo '<p style="font-size: 32px; color:darkblue;"><b>' . $donor_count . '</b></p>';
                            echo '<p id="txt-card">Calculated: ' . $last_calculation_date . '</p><br>';

                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        // PANEL 5
                        $sql_top_donation_campaign = "SELECT t.don_project_id, dp.title, SUM(t.amount) AS total_donations
                            FROM tbl_transaction t
                            JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
                            WHERE t.stat = 'verified'
                            GROUP BY t.don_project_id
                            ORDER BY total_donations DESC
                            LIMIT 1";

                        $result_top_donation_campaign = $conn->query($sql_top_donation_campaign);

                        if ($result_top_donation_campaign->num_rows > 0) {
                            $row_top_donation_campaign = $result_top_donation_campaign->fetch_assoc();
                            $top_donation_campaign_title = $row_top_donation_campaign['title'];
                            $top_donation_campaign_amount = $row_top_donation_campaign['total_donations'];

                            echo '<div class="col-sm-4 mb-3"><br>';
                            echo '<div class="card-body">';
                            echo '<div id="card5" class="card align-items-center" style="border: 2px solid #000000;"><br>'; 
                            echo '<h6 style="color: darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>TOP DONATION PROJECT</h6></b>';
                            
                            echo '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $top_donation_campaign_title . '</b></p>';
                            echo '<p id="txt-card" style="padding-bottom: 9px;">Total Donations: ₱ ' . number_format($top_donation_campaign_amount, 2) . '</p>';

                            echo '</div>';
                            echo '</div>'; 
                            echo '</div>';
                        }

                        // PANEL 6
                        $sql = "SELECT AVG(amount) AS average_donation, DATE_FORMAT(MAX(submitdate), '%M %d, %Y') AS last_calculation_date FROM tbl_transaction WHERE stat = 'Verified'";
                        $result = $conn->query($sql);
    
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $averageDonation = $row["average_donation"];
                            $lastCalculationDate = $row["last_calculation_date"];
    
                            echo '<div class="col-sm-4 mb-3"><br>';
                            echo '<div class="card-body">';
                            echo '<div id="card6"  class="card align-items-center" style="border: 2px solid #000000;"><br>'; 
                            echo '<h6 style="color: darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>AVERAGE DONATION AMOUNT</h6></b>';
    
                            $averageDonationFormatted = '₱ ' . number_format($averageDonation, 2); 
                            echo '<p style="font-size: 32px; color:darkblue;"><b>' . $averageDonationFormatted . '</b></p>';
                            echo '<p id="txt-card">Calculated: ' . $lastCalculationDate . '</p><br>';
    
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';

                        }
                     
                    }                       
                }
        ?>
    </div>

    </div>

    <!-- JavaScript to handle the update button click -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function() {
    // Set the default Start Date to the beginning of the current week
    var startDate = new Date();
    startDate.setDate(startDate.getDate() - startDate.getDay() + (startDate.getDay() === 0 ? -6 : 1));
    $('#start_date').val(startDate.toISOString().substr(0, 10));

    // Set the default End Date to the end of the current week
    var endDate = new Date();
    endDate.setDate(startDate.getDate() + 6);
    $('#end_date').val(endDate.toISOString().substr(0, 10));

    $('#update_button').click(function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        $.ajax({
            type: 'POST',
            url: 'update_data_don.php',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                $('#donation_data').html(response);
            }
        });
    });
});
    </script>

              <!-- DONATION TRANSACTION AREA CHART -->
<div id="Donationchart-container" class="chart-container" style="text-align: center; max-width: 98%; margin: 20px 0 20px 0; border: 2px solid #000;">
    <h3 id="h3font" style="margin-top:20px; color: darkblue;"><b>Donation Chart Options</b></h3>
    <label for="start-date">Start Date:</label>
    <input class="range-btn" type="text" id="start-date" placeholder="MM/DD/YYYY">
    <label for="end-date">End Date:</label>
    <input class="range-btn" type="text" id="end-date" placeholder="MM/DD/YYYY">
    <button class="d-btn" id="update" onclick="validateAndUpdateChart()">Update Chart</button>
    
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
        return `${month}/${day}/${year}`;
    }

    function updateChart() {
        var startDatePicker = document.getElementById('start-date');
        var endDatePicker = document.getElementById('end-date');
        var startDate = startDatePicker.value;
        var endDate = endDatePicker.value;

        var startDateParts = startDate.split('/');
        var startDateObj = new Date(`${startDateParts[2]}-${startDateParts[0]}-${startDateParts[1]}`);
        
        var endDateParts = endDate.split('/');
        var endDateObj = new Date(`${endDateParts[2]}-${endDateParts[0]}-${endDateParts[1]}`);

        $.ajax({
            url: 'fetch_data_don.php',
            method: 'POST',
            data: { startDate: startDateObj.toISOString(), endDate: endDateObj.toISOString() },
            dataType: 'json',
            success: function (chartData) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Amount');

                // Format the date values to display as "Month Day, Year"
                var formattedData = chartData.map(function (row) {
                    var dateParts = row[0].split('-');
                    var date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                    var formattedDate = date.toLocaleString('default', { month: 'long', day: 'numeric', year: 'numeric' });
                    return [formattedDate, row[1]];
                });

                data.addRows(formattedData);

                var options = {
                    title: 'Donation Transactions Chart',
                    isStacked: true,
                    legend: { position: 'bottom' },
                    vAxis: {
                        title: 'Amount Donated',
                        format: '₱#,##0'
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
                text: 'Start Date must not go past January 1, 2023'
            });
            return;
        }

        if (endDateObj > maxEndDate) {
            Swal.fire({
                icon: 'error',
                text: 'End Date cannot exceed the Current Date!'
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

        updateChart();
    }
</script>


<div style="display: flex; justify-content: space-between;">
    <!-- CATEGORY FREQUENCY CHART -->
    <div id="chartCanvas-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin-top: 20px; margin-bottom: 50px; padding: 5px;">
        <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>Projects Category Frequency</b></h2>
        <div id="chartCanvas" style="max-height: 300px; width: 100%; margin-bottom: 20px;"></div>
    </div>

   <?php
    $sql = "SELECT DISTINCT category FROM tbl_don_proj";
    $result = mysqli_query($conn, $sql);

    $categories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }

    $dataPoints = array();

    foreach ($categories as $category) {
        $sql = "SELECT COUNT(*) AS category_count 
        FROM tbl_don_proj 
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



<!-- RECURRING VS ONE TIME CHARTS -->
<?php
$sql = "SELECT CASE WHEN COUNT(t.user_id) = 1 THEN 'one-time' ELSE 'recurring'
        END AS donor_type, COUNT(t.user_id) AS donor_count
        FROM tbl_transaction t GROUP BY t.user_id";

$result = $conn->query($sql);

$oneTimeDonorsCount = 0;
$recurringDonorsCount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["donor_type"] === 'one-time') {
            $oneTimeDonorsCount += $row["donor_count"];
        } else if ($row["donor_type"] === 'recurring') {
            $recurringDonorsCount += $row["donor_count"];
        }
    }
}

$labels = ['One-Time Donors', 'Recurring Donors'];
$data = [$oneTimeDonorsCount, $recurringDonorsCount];

mysqli_close($conn);
?>

<!-- DONUT CHART -->
<div id="donorDonutChart-container" class="chart-container" style="text-align: center; width: 49%; border: 2px solid #000; margin-top: 20px; margin-bottom: 50px; padding: 5px;">
    <h2 id="h2font" style="margin-top: 20px; color: darkblue;"><b>One-Time VS. Recurring Donors</b></h2>
    <div id="donorDonutChart" style="max-height: 300px; width: 100%; margin-bottom: 20px;"></div>
</div>
</div>

<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    var labels = <?php echo json_encode($labels); ?>;
    var data = <?php echo json_encode($data); ?>;
    var colors = ['#3498db', '#2ecc71'];
    var trace = {
        labels: labels,
        values: data,
        type: 'pie',
        marker: { colors: colors },
    };
    var layout = {
        title: 'Donor Type Distribution',
        showlegend: false, // Hide the legend
    };
    Plotly.newPlot('donorDonutChart', [trace], layout);
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
