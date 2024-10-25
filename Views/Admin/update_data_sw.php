<div class="container">
    <div id="social_worker_data">
        <div class="row justify-content-center">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

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

                echo displaySocialWorkerData($start_date, $end_date);
            }

            function displaySocialWorkerData($start_date, $end_date) {
                include 'includes/config.php';

                $output = '';

                // Panel 1: Total Amount of Social Workers
                $sql_total_social_workers = "SELECT COUNT(DISTINCT sw_id) AS TotalSocialWorkers, DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate FROM tbl_sw_accs WHERE status = 'verified'";
                if ($start_date && $end_date) {
                    $sql_total_social_workers .= " AND submit_date BETWEEN '$start_date' AND '$end_date'";
                }

                $result_total_social_workers = $conn->query($sql_total_social_workers);

                if ($result_total_social_workers->num_rows > 0) {
                    while ($row = $result_total_social_workers->fetch_assoc()) {
                        $output .= '<div class="col-sm-4 mb-3"><br>';
                        $output .= '<div class="card-body">';
                        $output .= '<div id="card1" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                        $output .= '<h6 style="color:darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOTAL NUMBER OF VERIFIED SOCIAL WORKERS</b></h6>';

                        $totalAmountFormatted = number_format($row["TotalSocialWorkers"]);
                        $output .= '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

                        $latestSubmitDate = $row["latest_submitdate"];
                        $output .= '<p id="txt-card">Calculated: ' . $latestSubmitDate . '</p>';

                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                }

                // Panel 2: Social Workers with "Pending" Status
                $sql_pending_social_workers = "SELECT COUNT(DISTINCT sw_id) AS pending_social_workers, DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate FROM tbl_sw_accs WHERE status = 'pending'";
                if ($start_date && $end_date) {
                    $sql_pending_social_workers .= " AND submit_date BETWEEN '$start_date' AND '$end_date'";
                }

                $result_pending_social_workers = $conn->query($sql_pending_social_workers);

                if ($result_pending_social_workers->num_rows > 0) {
                    while ($row = $result_pending_social_workers->fetch_assoc()) {
                        $output .= '<div class="col-sm-4 mb-3"><br>';
                        $output .= '<div class="card-body">';
                        $output .= '<div id="card2" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                        $output .= '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>SOCIAL WORKERS WITH STATUS "PENDING"</b></h6>';

                        $pendingSocialWorkersCount = number_format($row["pending_social_workers"]);
                        $output .= '<p style="font-size: 32px; padding-bottom: 11px; color: darkblue;"><b>' . $pendingSocialWorkersCount . '</b></p>';

                        $latestSubmitDate = $row["latest_submitdate"];
                        $output .= '<p id="txt-card">Calculated: ' . $latestSubmitDate . '</p>';

                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                }

                // Panel 3: Average Number of Projects Uploaded by Social Workers
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

                $output .= '<div class="col-sm-4 mb-3"><br>';
                $output .= '<div class="card-body">';
                $output .= '<div id="card3" id="card5" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                $output .= '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>AVERAGE NUMBER OF PROJECTS</b></h6>';
                $output .= '<p id="res-card" style="font-size: 32px; 11px; color: darkblue;"><b>' . $averageProjectsCount . '</b></p>';
                $output .= '<p id="txt-card">Calculated: ' . $currentDate . '</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                

                // Panel 4: Social Worker with Most Completed Donation Projects
                $sql_top_social_worker_donation = "SELECT sw_id, COUNT(DISTINCT don_project_id) AS completed_projects_count
                                        FROM tbl_don_proj
                                        WHERE proj_stat = 'COMPLETED'
                                        GROUP BY sw_id
                                        ORDER BY completed_projects_count DESC
                                        LIMIT 1";
                
                $result_top_social_worker_donation = $conn->query($sql_top_social_worker_donation);
                
                if ($result_top_social_worker_donation->num_rows > 0) {
                    $rowTopSocialWorkerDonation = $result_top_social_worker_donation->fetch_assoc();
                    $topSocialWorkerIdDonation = $rowTopSocialWorkerDonation['sw_id'];
                    $completedProjectsCountDonation = $rowTopSocialWorkerDonation['completed_projects_count'];
                
                    // Get the name of the top social worker and their latest submit date
                    $sql_get_social_worker_data_donation = "SELECT fname, lname, DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate
                                                    FROM tbl_sw_accs
                                                    WHERE sw_id = '$topSocialWorkerIdDonation'";
                    $result_get_social_worker_data_donation = $conn->query($sql_get_social_worker_data_donation);
                
                    if ($result_get_social_worker_data_donation->num_rows > 0) {
                        $rowSocialWorkerDataDonation = $result_get_social_worker_data_donation->fetch_assoc();
                        $topSocialWorkerNameDonation = $rowSocialWorkerDataDonation['fname'] . ' ' . $rowSocialWorkerDataDonation['lname'];
                        $latestSubmitDateDonation = $rowSocialWorkerDataDonation['latest_submitdate'];
                
                        $output .= '<div class="col-sm-4 mb-3"><br>';
                        $output .= '<div id="card4" class="card align-items-center" style="border: 2px solid #000000; height: 180px;"><br>';
                        $output .= '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>SOCIAL WORKER WITH MOST COMPLETED DONATION PROJECTS</h6></b>';
                        $output .= '<p id="res-card" style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $topSocialWorkerNameDonation . '</b></p>';
                        $output .= '<p>Completed Donation Projects: ' . $completedProjectsCountDonation . '</p>';
                        $output .= '<p>Calculated: ' . $latestSubmitDateDonation . '</p>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                } else {
                    // Handle the case where there are no social workers with completed donation projects 
                    $output .= '<div class="col-sm-4 mb-3"><br>';
                    $output .= '<div id="card4" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
                    $output .= '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOP SOCIAL WORKER WITH MOST COMPLETED DONATION PROJECTS</h6></b>';
                    $output .= '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>No Social Workers with Completed Donation Projects</b></p>';
                    $output .= '</div>';
                    $output .= '</div>';
                }
                
                // Panel 5: Social Worker with Most Completed Volunteer Projects
                $sql_top_social_worker_volunteer = "SELECT sw_id, COUNT(DISTINCT vol_proj_id) AS completed_projects_count
                                        FROM tbl_vol_proj
                                        WHERE proj_stat = 'COMPLETED'
                                        GROUP BY sw_id
                                        ORDER BY completed_projects_count DESC
                                        LIMIT 1";
                
                $result_top_social_worker_volunteer = $conn->query($sql_top_social_worker_volunteer);
                
                if ($result_top_social_worker_volunteer->num_rows > 0) {
                    $rowTopSocialWorkerVolunteer = $result_top_social_worker_volunteer->fetch_assoc();
                    $topSocialWorkerIdVolunteer = $rowTopSocialWorkerVolunteer['sw_id'];
                    $completedProjectsCountVolunteer = $rowTopSocialWorkerVolunteer['completed_projects_count'];
                
                    // Get the name of the top social worker and their latest submit date
                    $sql_get_social_worker_data_volunteer = "SELECT fname, lname, DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate
                                                    FROM tbl_sw_accs
                                                    WHERE sw_id = '$topSocialWorkerIdVolunteer'";
                    $result_get_social_worker_data_volunteer = $conn->query($sql_get_social_worker_data_volunteer);
                
                    if ($result_get_social_worker_data_volunteer->num_rows > 0) {
                        $rowSocialWorkerDataVolunteer = $result_get_social_worker_data_volunteer->fetch_assoc();
                        $topSocialWorkerNameVolunteer = $rowSocialWorkerDataVolunteer['fname'] . ' ' . $rowSocialWorkerDataVolunteer['lname'];
                        $latestSubmitDateVolunteer = $rowSocialWorkerDataVolunteer['latest_submitdate'];
                
                        $output .= '<div class="col-sm-4 mb-3"><br>';
                        $output .= '<div id="card5" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
                        $output .= '<h6 id="tt-card" style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>SOCIAL WORKER WITH MOST COMPLETED VOLUNTEER PROJECTS</h6></b>';
                        $output .= '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $topSocialWorkerNameVolunteer . '</b></p>';
                        $output .= '<p>Completed Volunteer Projects: ' . $completedProjectsCountVolunteer . '</p>';
                        $output .= '<p>Calculated: ' . $latestSubmitDateVolunteer . '</p>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                } else {
                    // Handle the case where there are no social workers with completed volunteer projects 
                    $output .= '<div class="col-sm-4 mb-3"><br>';
                    $output .= '<div id="card5" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
                    $output .= '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOP SOCIAL WORKER WITH MOST COMPLETED VOLUNTEER PROJECTS</h6></b>';
                    $output .= '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>No Social Workers with Completed Volunteer Projects</b></p>';
                    $output .= '</div>';
                    $output .= '</div>';
                }
                
                // Panel 6: Social Worker with Most Completed Assistance Projects
                $sql_top_social_worker_assistance = "SELECT sw_id, COUNT(DISTINCT assistance_id) AS completed_projects_count
                                        FROM tbl_assistance
                                        WHERE proj_stat = 'COMPLETED'
                                        GROUP BY sw_id
                                        ORDER BY completed_projects_count DESC
                                        LIMIT 1";
                
                $result_top_social_worker_assistance = $conn->query($sql_top_social_worker_assistance);
                
                if ($result_top_social_worker_assistance->num_rows > 0) {
                    $rowTopSocialWorkerAssistance = $result_top_social_worker_assistance->fetch_assoc();
                    $topSocialWorkerIdAssistance = $rowTopSocialWorkerAssistance['sw_id'];
                    $completedProjectsCountAssistance = $rowTopSocialWorkerAssistance['completed_projects_count'];
                
                    // Get the name of the top social worker and their latest submit date
                    $sql_get_social_worker_data_assistance = "SELECT fname, lname, DATE_FORMAT(MAX(submit_date), '%M %d, %Y') AS latest_submitdate
                                                    FROM tbl_sw_accs
                                                    WHERE sw_id = '$topSocialWorkerIdAssistance'";
                    $result_get_social_worker_data_assistance = $conn->query($sql_get_social_worker_data_assistance);
                
                    if ($result_get_social_worker_data_assistance->num_rows > 0) {
                        $rowSocialWorkerDataAssistance = $result_get_social_worker_data_assistance->fetch_assoc();
                        $topSocialWorkerNameAssistance = $rowSocialWorkerDataAssistance['fname'] . ' ' . $rowSocialWorkerDataAssistance['lname'];
                        $latestSubmitDateAssistance = $rowSocialWorkerDataAssistance['latest_submitdate'];
                
                        $output .= '<div class="col-sm-4 mb-3"><br>';
                        $output .= '<div id="card6" class="card align-items-center" style="border: 2px solid #000000;"><br>';
                        $output .= '<h6 id="tt-card" style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>SOCIAL WORKER WITH MOST COMPLETED ASSISTANCE PROJECTS</h6></b>';
                        $output .= '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $topSocialWorkerNameAssistance . '</b></p>';
                        $output .= '<p>Completed Assistance Projects: ' . $completedProjectsCountAssistance . '</p>';
                        $output .= '<p>Calculated: ' . $latestSubmitDateAssistance . '</p>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                } else {
                    // Handle the case where there are no social workers with completed assistance projects 
                    $output .= '<div class="col-sm-4 mb-3"><br>';
                    $output .= '<div id="card6" class="card align-items-center" style="border: 2px solid #000000; height: 200px;"><br>';
                    $output .= '<h6 style="color: darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOP SOCIAL WORKER WITH MOST COMPLETED ASSISTANCE PROJECTS</h6></b>';
                    $output .= '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>No Social Workers with Completed Assistance Projects</b></p>';
                    $output .= '</div>';
                    $output .= '</div>';
                }


                $conn->close();

                return '<div class="row justify-content-center">' . $output . '</div>';
            }

            ?>
        </div>
    </div>
</div>
