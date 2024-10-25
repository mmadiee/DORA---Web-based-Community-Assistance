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


</head>

<body>
<div class="container">
    <div id="assistance_data">
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

                echo displayAssistanceData($start_date, $end_date);
            }

            function displayAssistanceData($start_date, $end_date) {
                include 'includes/config.php';

                $output = '';

                // Panel 1: Total Amount of benefs
                $sql_total_applicants = "SELECT COUNT(DISTINCT APPLI_ID) AS TotalApplicants,
            DATE_FORMAT(MAX(submitteddate), '%M %d, %Y') AS latest_submitdate
            FROM tbl_applicants
            WHERE STAT = 'VERIFIED'";
            if ($start_date && $end_date) {
                $sql_total_applicants .= " AND submitteddate BETWEEN '$start_date' AND '$end_date'";
            }

            $result_total_applicants = $conn->query($sql_total_applicants);
            if ($result_total_applicants->num_rows > 0) {
                while ($row = $result_total_applicants->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>';
                    echo '<div class="card-body">';
                    echo '<div id="card1" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
                    echo '<h6 style="color:darkblue; height:50px; text-align: center;" class="d-flex align-items-center mb-3"><b>TOTAL AMOUNT OF BENEFICIARIES</h6></b>';

                    $totalAmountFormatted = number_format($row["TotalApplicants"]);
                    echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

                    $latestSubmitDate = $row["latest_submitdate"];
                    echo '<p id="card-txt">Calculated: ' . $latestSubmitDate . '</p>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

                // Panel 2: Top Assistance Project
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
            echo '<div id="card2" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
            echo '<h6 id="txt-card" style="color: darkblue; height:50px;" class="d-flex align-items-center mb-3"><b>TOP ASSISTANCE PROJECT</h6></b>';

            echo '<p style="text-align: center; font-size: 20px; color:darkblue;"><b>' . $topAssistanceProjectTitle . '</b></p>';
            echo '<p id="card-txt2">Total Volunteers: ' . $topAssistanceProjectTotalBenefs . '</p>';

            echo '</div>';
            echo '</div>';
        }
    

                // Panel 3: Ongoing Projects
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
                echo '<div id="card3" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
                echo '<h6 style="color: darkblue; height:50px;" class="d-flex align-items-center mb-3"><b>ON GOING PROJECTS</h6></b>';
                echo '<p style="text-align: center; font-size: 32px; color: darkblue; padding-bottom: 11px;"><b>' . $totalActiveProjects . '</b></p>';
    
                echo '<p id="card-txt">Calculated: ' . $latestSubmitDate . '</p>';
    
                echo '</div>';
                echo '</div>';
                echo '</div>';
        

                $conn->close();
            
            ?>
        </div>
    </div>
</div>

</body>
</html>
