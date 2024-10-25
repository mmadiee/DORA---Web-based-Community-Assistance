<div class="container">
    <div id="volunteer_data">
        <div class="row justify-content-center">
            <?php

            include 'includes/config.php';
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $sw_id = $_POST['sw_id']; 

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

                echo displayVolunteerData($start_date, $end_date, $sw_id);
            }

            function displayVolunteerData($start_date, $end_date, $sw_id) {
                include 'includes/config.php';

                $output = '';

                // Panel 1: Total Amount of Volunteers
                $sql_total_volunteers = "SELECT COUNT(DISTINCT USER_ID) AS TotalVolunteers,
                                            DATE_FORMAT(MAX(submitteddate), '%M %d, %Y') AS latest_submitdate
                                            FROM tbl_volunteers v
                                            JOIN tbl_vol_proj vp ON v.vol_proj_id = vp.vol_proj_id
                                            WHERE STAT = 'VERIFIED' AND sw_id = $sw_id";
                if ($start_date && $end_date) {
                    $sql_total_volunteers .= " AND submitteddate BETWEEN '$start_date' AND '$end_date'";
                }

                $result_total_volunteers = $conn->query($sql_total_volunteers);

                if ($result_total_volunteers->num_rows > 0) {
                    while ($row = $result_total_volunteers->fetch_assoc()) {
                        $output .= '<div class="col-sm-4 mb-3"><br>';
                        $output .= '<div class="card-body">';
                        $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                        $output .= '<h6 style="color:darkblue; text-align: center;" class="d-flex align-items-center mb-3"><b>TOTAL AMOUNT OF VOLUNTEERS GARNERED</b></h6>';

                        $totalAmountFormatted = number_format($row["TotalVolunteers"]);
                        $output .= '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

                        $latestSubmitDate = $row["latest_submitdate"];
                        $output .= '<p>Calculated: ' . $latestSubmitDate . '</p>';

                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }
                }

                // Panel 2: Top Volunteer Project
                $sql_top_volunteer_project = "SELECT v.vol_proj_id, dp.title AS project_title, COUNT(DISTINCT v.user_id) AS total_volunteers
                                                FROM tbl_volunteers v
                                                JOIN tbl_vol_proj dp ON v.vol_proj_id = dp.vol_proj_id
                                                WHERE v.stat = 'VERIFIED' AND sw_id = $sw_id
                                                GROUP BY v.vol_proj_id
                                                ORDER BY total_volunteers DESC
                                                LIMIT 1";

                $result_top_volunteer_project = $conn->query($sql_top_volunteer_project);

                if ($result_top_volunteer_project->num_rows > 0) {
                    $row_top_volunteer_project = $result_top_volunteer_project->fetch_assoc();
                    $topVolunteerProjectTitle = $row_top_volunteer_project['project_title'];
                    $topVolunteerProjectTotalVolunteers = $row_top_volunteer_project['total_volunteers'];

                    $output .= '<div class="col-sm-4 mb-3"><br>';
                    $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                    $output .= '<h6 style="color: darkblue" class="d-flex align-items-center mb-3"><b>TOP VOLUNTEER PROJECT</b></h6>';

                    $output .= '<p style="text-align: center; font-size: 20px; color: darkblue;"><b>' . $topVolunteerProjectTitle . '</b></p>';
                    $output .= '<p>Total Volunteers: ' . $topVolunteerProjectTotalVolunteers . '</p>';

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                }

                // Panel 3: Ongoing Projects
                $sql_ongoing_projects = "SELECT COUNT(DISTINCT vol_proj_id) AS total_active_projects,
                                            DATE_FORMAT(MAX(uploadDate), '%M %d, %Y') AS latest_submitdate
                                            FROM tbl_vol_proj
                                            WHERE proj_stat = 'ON GOING' AND sw_id = $sw_id";
                                            
                $result_active_projects = $conn->query($sql_ongoing_projects);

                if ($result_active_projects) {
                    $row_active_projects = $result_active_projects->fetch_assoc();
                    $totalActiveProjects = isset($row_active_projects['total_active_projects']) ? $row_active_projects['total_active_projects'] : 0;

                    $output .= '<div class="col-sm-4 mb-3"><br>';
                    $output .= '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                    $output .= '<h6 style="color: darkblue" class="d-flex align-items-center mb-3"><b>ON GOING PROJECTS</b></h6>';

                    $output .= '<p style="text-align: center; font-size: 32px; color: darkblue; padding-bottom: 11px;"><b>' . $totalActiveProjects . '</b></p>';

                    $latestSubmitDate = isset($row_active_projects['latest_submitdate']) ? $row_active_projects['latest_submitdate'] : '';
                    $output .= '<p>Calculated: ' . $latestSubmitDate . '</p>';

                    $output .= '</div>';
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
