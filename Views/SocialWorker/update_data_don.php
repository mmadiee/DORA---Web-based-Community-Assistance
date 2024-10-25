<div class="container">
<div id="donation_data">
<div class="row justify-content-center">
<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $sw_id = $_POST['sw_id']; 

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

$parsedStartDate = new DateTime($start_date);
$parsedEndDate = new DateTime($end_date);
$currentDate = new DateTime();
$minStartDate = new DateTime('2023-01-01');

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

echo displayDonationData($start_date, $end_date, $sw_id);
}

function displayDonationData($start_date, $end_date, $sw_id) {
    include 'includes/config.php';

    $output = '';

    // Panel 1: Total Amount of Donations Collected
    $sql_total_amount = "SELECT SUM(t.amount) AS total_amount, DATE_FORMAT(MAX(t.submitdate), '%M %d, %Y') AS latest_submitdate
                            FROM tbl_transaction t
                            JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
                            WHERE t.stat = 'Verified' AND dp.sw_id = $sw_id";

    if ($start_date && $end_date) {
        $sql_total_amount .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
    }

    $result_total_amount = $conn->query($sql_total_amount);

    if ($result_total_amount->num_rows > 0) {
        while ($row = $result_total_amount->fetch_assoc()) {
            $output .= '<div class="col-sm-4 mb-3"><br>';
            $output .= '<div class="card-body">';
            $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
            $output .= '<h6 style="color:darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>TOTAL AMOUNT OF DONATIONS COLLECTED</b></h6>';

            $totalAmountFormatted = '₱ ' . number_format($row["total_amount"]);
            $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

            $latestSubmitDate = $row["latest_submitdate"];
            $output .= '<p>Calculated: ' . $latestSubmitDate . '</p>';

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
    }

    // Panel 2: Highest Amount Donated
    $sql_highest_amount = "SELECT MAX(CAST(amount AS DECIMAL)) AS highest_amount, DATE_FORMAT(submitdate, '%M %d, %Y') AS submitdate_formatted 
                            FROM tbl_transaction t
                            JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
                            WHERE t.stat = 'Verified' AND dp.sw_id = $sw_id";
    if ($start_date && $end_date) {
        $sql_highest_amount .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
    }

    $result_highest_amount = $conn->query($sql_highest_amount);

    if ($result_highest_amount->num_rows > 0) {
        while ($row = $result_highest_amount->fetch_assoc()) {
            $output .= '<div class="col-sm-4 mb-3"><br>';
            $output .= '<div class="card-body">';
            $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
            $output .= '<h6 style="color:darkblue" class="d-flex align-items-center mb-3"><b>HIGHEST DONATION COLLECTED</b></h6>';

            $highestAmountFormatted = '₱ ' . number_format($row["highest_amount"]);
            $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $highestAmountFormatted . '</b></p>';

            $highestSubmitDate = $row["submitdate_formatted"];
            $output .= '<p>Date Submitted: ' . $highestSubmitDate . '</p>';

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
    }

    // Panel 3: Latest Donation Collected
    $sql_latest_donation = "SELECT amount, DATE_FORMAT(submitdate, '%M %d, %Y') AS submitdate_formatted 
                            FROM tbl_transaction t
                            JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
                            WHERE t.stat = 'Verified' AND dp.sw_id = $sw_id";

    if ($start_date && $end_date) {
        $sql_latest_donation .= " AND submitdate BETWEEN '$start_date' AND '$end_date'";
    }

    $sql_latest_donation .= " ORDER BY submitdate DESC LIMIT 1";

    $result_latest_donation = $conn->query($sql_latest_donation);

    if ($result_latest_donation->num_rows > 0) {
        while ($row = $result_latest_donation->fetch_assoc()) {
            $output .= '<div class="col-sm-4 mb-3"><br>';
            $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
            $output .= '<h6 style="color: darkblue" class="d-flex align-items-center mb-3"><b>LATEST DONATION COLLECTED</h6></b>';

            $totalAmountFormatted = '₱ ' . number_format($row["amount"]);
            $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

            $latestSubmitDate = $row["submitdate_formatted"];
            $output .= '<p>Date Submitted: ' . $latestSubmitDate . '</p>';

            $output .= '</div>';
            $output .= '</div>';
        }
    }

    // PANEL 4
    $sql_donor_count = "SELECT COUNT(DISTINCT user_id) AS donor_count, DATE_FORMAT(MAX(submitdate), '%M %d, %Y') AS last_calculation_date 
                        FROM tbl_transaction t
                        JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
                        WHERE t.stat = 'Verified' AND dp.sw_id = $sw_id";
    $result_donor_count = $conn->query($sql_donor_count);

    if ($result_donor_count->num_rows > 0) {
        $row_donor_count = $result_donor_count->fetch_assoc();
        $donor_count = $row_donor_count["donor_count"];
        $last_calculation_date = $row_donor_count["last_calculation_date"];

        $output .= '<div class="col-sm-4 mb-3"><br>';
        $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
        $output .= '<h6 style="color: darkblue" class="d-flex align-items-center mb-3"><b>DONOR COUNT</h6></b>';

        $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $donor_count . '</b></p>';
        $output .= '<p>Calculated: ' . $last_calculation_date . '</p><br>';

        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    }

    // PANEL 5
    $sql_top_donation_campaign = "SELECT t.don_project_id, dp.title, SUM(t.amount) AS total_donations
                                    FROM tbl_transaction t
                                    JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
                                    WHERE t.stat = 'verified' AND sw_id = $sw_id
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
        $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>'; 
        $output .= '<h6 style="color: darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>TOP DONATION PROJECT</b></h6>';
        
        $output .= '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $top_donation_campaign_title . '</b></p>';
        $output .= '<p style="padding-bottom: 9px;">Total Donations: ₱ ' . number_format($top_donation_campaign_amount, 2) . '</p>';

        $output .= '</div>';
        $output .= '</div>'; 
        $output .= '</div>';
    }

    // PANEL 6
    $sql = "SELECT AVG(amount) AS average_donation, DATE_FORMAT(MAX(submitdate), '%M %d, %Y') AS last_calculation_date 
            FROM tbl_transaction t
            JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
            WHERE t.stat = 'Verified' AND dp.sw_id = $sw_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $averageDonation = $row["average_donation"];
        $lastCalculationDate = $row["last_calculation_date"];

        $output .= '<div class="col-sm-4 mb-3"><br>';
        $output .= '<div class="card-body">';
        $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>'; 
        $output .= '<h6 style="color: darkblue; text-align:center;" class="d-flex align-items-center mb-3"><b>AVERAGE DONATION AMOUNT</b></h6>';

        $averageDonationFormatted = '₱ ' . number_format($averageDonation, 2); 
        $output .= '<p style="font-size: 32px; color:darkblue;"><b>' . $averageDonationFormatted . '</b></p>';
        $output .= '<p>Calculated: ' . $lastCalculationDate . '</p><br>';

        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    }

    $conn->close();

    return '<div class="row justify-content-center">' . $output . '</div>';
}
?>
