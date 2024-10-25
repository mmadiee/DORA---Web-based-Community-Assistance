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

   
</head>

<body>
<div class="container">
<div id="donation_data">
<div class="row justify-content-center">
<?php

include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

 // Check if the start date is in the correct format (YYYY-MM-DD)
if (!DateTime::createFromFormat('Y-m-d', $start_date)) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Start Date Format',
                text: 'Start date should be in the format YYYY-MM-DD.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
         </script>";
    exit();
}

// Check if the end date is in the correct format (YYYY-MM-DD)
if (!DateTime::createFromFormat('Y-m-d', $end_date)) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid End Date Format',
                text: 'End date should be in the format YYYY-MM-DD.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
         </script>";
    exit();
}

// Parse the dates into PHP DateTime objects
$parsedStartDate = new DateTime($start_date);
$parsedEndDate = new DateTime($end_date);
$currentDate = new DateTime();
$minStartDate = new DateTime('2023-01-01');

// Check if the start date is before the allowed date
if ($parsedStartDate < $minStartDate) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Start Date',
                text: 'Start date cannot be before January 1, 2023.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
         </script>";
    exit();
}

// Check if the end date is after the current date
if ($parsedEndDate > $currentDate) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid End Date',
                text: 'End date cannot exceed the current date.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
         </script>";
    exit();
}

echo displayDonationData($start_date, $end_date);
}

function displayDonationData($start_date, $end_date) {
    include 'includes/config.php';
    
    $output = '';

    // Panel 1: Total Amount of Donations Collected
    $sql_total_amount = "SELECT SUM(amount) AS total_amount, DATE_FORMAT(MAX(submitdate), '%M %d, %Y') AS latest_submitdate FROM tbl_transaction WHERE stat = 'Verified'";
    if ($start_date && $end_date) {
        $sql_total_amount .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
    }

    $result_total_amount = $conn->query($sql_total_amount);

    if ($result_total_amount->num_rows > 0) {
        while ($row = $result_total_amount->fetch_assoc()) {
            $output .= '<div class="col-sm-4 mb-3"><br>';
            $output .= '<div class="card-body">';
            $output .= '<div id="card1" class="card align-items-center" style="border: 2px solid #000000;"><br>';
            $output .= '<h6 style="color:darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>TOTAL AMOUNT OF DONATIONS COLLECTED</b></h6>';

            $totalAmountFormatted = '₱ ' . number_format($row["total_amount"]);
            $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

            $latestSubmitDate = $row["latest_submitdate"];
            $output .= '<p id="txt-card">Calculated: ' . $latestSubmitDate . '</p>';

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
    }

    // Panel 2: Highest Amount Donated
    $sql_highest_amount = "SELECT MAX(CAST(amount AS DECIMAL)) AS highest_amount, DATE_FORMAT(submitdate, '%M %d, %Y') AS submitdate_formatted FROM tbl_transaction WHERE stat = 'Verified'";
    if ($start_date && $end_date) {
        $sql_highest_amount .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
    }

    $result_highest_amount = $conn->query($sql_highest_amount);

    if ($result_highest_amount->num_rows > 0) {
        while ($row = $result_highest_amount->fetch_assoc()) {
            $output .= '<div class="col-sm-4 mb-3"><br>';
            $output .= '<div class="card-body">';
            $output .= '<div id="card2" class="card align-items-center" style="border: 2px solid #000000;"><br>';
            $output .= '<h6 id="txt-card" style="color:darkblue" class="d-flex align-items-center mb-3"><b>HIGHEST DONATION COLLECTED</b></h6>';

            $highestAmountFormatted = '₱ ' . number_format($row["highest_amount"]);
            $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $highestAmountFormatted . '</b></p>';

            $highestSubmitDate = $row["submitdate_formatted"];
            $output .= '<p id="txt-card">Date Submitted: ' . $highestSubmitDate . '</p>';

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
    }

    // Panel 3: Latest Donation Collected
    $sql_latest_donation = "SELECT amount, DATE_FORMAT(submitdate, '%M %d, %Y') AS submitdate_formatted FROM tbl_transaction WHERE stat = 'Verified'";
    if ($start_date && $end_date) {
        $sql_latest_donation .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
    }
    $sql_latest_donation .= " ORDER BY transac_id DESC LIMIT 1";

    $result_latest_donation = $conn->query($sql_latest_donation);

    if ($result_latest_donation->num_rows > 0) {
        while ($row = $result_latest_donation->fetch_assoc()) {
            $output .= '<div class="col-sm-4 mb-3"><br>';
            $output .= '<div id="card3"class="card align-items-center" style="border: 2px solid #000000;"><br>';
            $output .= '<h6 id="txt-card" style="color: darkblue" class="d-flex align-items-center mb-3"><b>LATEST DONATION COLLECTED</h6></b>';

            $totalAmountFormatted = '₱ ' . number_format($row["amount"]);
            $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

            $latestSubmitDate = $row["submitdate_formatted"];
            $output .= '<p id="txt-card">Date Submitted: ' . $latestSubmitDate . '</p>';

            $output .= '</div>';
            $output .= '</div>';
        }
    }

    // PANEL 4
    $sql_donor_count = "SELECT COUNT(DISTINCT user_id) AS donor_count, DATE_FORMAT(MAX(submitdate), '%M %d, %Y') AS last_calculation_date FROM tbl_transaction WHERE stat = 'Verified'";
    $result_donor_count = $conn->query($sql_donor_count);

    if ($result_donor_count->num_rows > 0) {
        $row_donor_count = $result_donor_count->fetch_assoc();
        $donor_count = $row_donor_count["donor_count"];
        $last_calculation_date = $row_donor_count["last_calculation_date"];

        $output .= '<div class="col-sm-4 mb-3"><br>';
        $output .= '<div class="card-body">';
        $output .= '<div id="card4"class="card align-items-center" style="border: 2px solid #000000;"><br>';
        $output .= '<h6 style="color:darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>TOTAL DONOR COUNT</b></h6>';

        $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $donor_count . '</b></p>';
        $output .= '<p id="txt-card">Calculated: ' . $last_calculation_date . '</p><br>';

        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
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

        $output .= '<div class="col-sm-4 mb-3"><br>';
        $output .= '<div class="card-body">';
        $output .= '<div id="card5" class="card align-items-center" style="border: 2px solid #000000;"><br>'; 
        $output .= '<h6 style="color: darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>TOP DONATION PROJECT</b></h6>';
        
        $output .= '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $top_donation_campaign_title . '</b></p>';
        $output .= '<p id="txt-card" style="padding-bottom: 9px;">Total Donations: ₱ ' . number_format($top_donation_campaign_amount, 2) . '</p>';

        $output .= '</div>';
        $output .= '</div>'; 
        $output .= '</div>';
    }

    // PANEL 6
    $sql = "SELECT AVG(amount) AS average_donation, DATE_FORMAT(MAX(submitdate), '%M %d, %Y') AS last_calculation_date FROM tbl_transaction WHERE stat = 'Verified'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $averageDonation = $row["average_donation"];
        $lastCalculationDate = $row["last_calculation_date"];

        $output .= '<div class="col-sm-4 mb-3"><br>';
        $output .= '<div class="card-body">';
        $output .= '<div id="card6" class="card align-items-center" style="border: 2px solid #000000;"><br>'; 
        $output .= '<h6 style="color: darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>AVERAGE DONATION AMOUNT</b></h6>';

        $averageDonationFormatted = '₱ ' . number_format($averageDonation, 2); 
        $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $averageDonationFormatted . '</b></p>';
        $output .= '<p id="txt-card">Calculated: ' . $lastCalculationDate . '</p><br>';

        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    }

    $conn->close();

    return '<div class="row justify-content-center">' . $output . '</div>';
}
?>

</body>
</html>
