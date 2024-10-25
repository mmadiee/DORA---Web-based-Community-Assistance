<div class="container">
    <div id="assistance_data">
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

                echo displayAssistanceData($start_date, $end_date, $sw_id);
            }

            function displayAssistanceData($start_date, $end_date, $sw_id) {
                include 'includes/config.php';

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $output = '';

                // Panel 1: Total Amount of benefs
                $sql_total_applicants = "SELECT COUNT(DISTINCT APPLI_ID) AS TotalApplicants,
                                            DATE_FORMAT(MAX(submitteddate), '%M %d, %Y') AS latest_submitdate
                                            FROM tbl_applicants a
                                            JOIN tbl_assistance ap ON a.assistance_id = ap.assistance_id
                                            WHERE stat = 'verified' AND sw_id = $sw_id";
            if ($start_date && $end_date) {
                $sql_total_applicants .= " AND submitteddate BETWEEN '$start_date' AND '$end_date'";
            }

            $result_total_applicants = $conn->query($sql_total_applicants);
            if ($result_total_applicants->num_rows > 0) {
                while ($row = $result_total_applicants->fetch_assoc()) {
                    echo '<div class="col-sm-4 mb-3"><br>';
                    echo '<div class="card-body">';
                    echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                    echo '<h6 style="color:darkblue; height:50px; text-align: center;" class="d-flex align-items-center mb-3"><b>TOTAL AMOUNT OF BENEFICIARIES</h6></b>';

                    $totalAmountFormatted = number_format($row["TotalApplicants"]);
                    echo '<p style="font-size: 32px; padding-bottom: 11px; color:darkblue;"><b>' . $totalAmountFormatted . '</b></p>';

                    $latestSubmitDate = $row["latest_submitdate"];
                    echo '<p>Calculated: ' . $latestSubmitDate . '</p>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

                // Panel 2: Top Assistance Project
            $sql_top_assistance_project = "SELECT v.assistance_id, dp.title AS project_title, COUNT(DISTINCT v.appli_id) AS total_benefs
                                            FROM tbl_applicants v
                                            JOIN tbl_assistance dp ON v.assistance_id = dp.assistance_id
                                            WHERE v.stat = 'VERIFIED' AND sw_id = $sw_id
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
            echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
            echo '<h6 style="color: darkblue; height:50px;" class="d-flex align-items-center mb-3"><b>TOP ASSISTANCE PROJECT</h6></b>';

            echo '<p style="text-align: center; font-size: 20px; color:darkblue;"><b>' . $topAssistanceProjectTitle . '</b></p>';
            echo '<p>Total Volunteers: ' . $topAssistanceProjectTotalBenefs . '</p>';

            echo '</div>';
            echo '</div>';
        }
    

                // Panel 3: Ongoing Projects
                $sql_ongoing_projects = "SELECT COUNT(DISTINCT assistance_id) AS total_active_projects,
                                            DATE_FORMAT(MAX(uploadDate), '%M %d, %Y') AS latest_submitdate
                                            FROM tbl_assistance
                                            WHERE proj_stat = 'ON GOING' AND sw_id = $sw_id" ;
    
                $result_ongoing_projects = $conn->query($sql_ongoing_projects);
                $totalActiveProjects = 0;
                $latestSubmitDate = '';
    
                if ($result_ongoing_projects) {
                    $rowActiveProjects = $result_ongoing_projects->fetch_assoc();
                    $totalActiveProjects = isset($rowActiveProjects['total_active_projects']) ? $rowActiveProjects['total_active_projects'] : 0;
                    $latestSubmitDate = isset($rowActiveProjects['latest_submitdate']) ? $rowActiveProjects['latest_submitdate'] : '';
                }
    
                echo '<div class="col-sm-4 mb-3"><br>';
                echo '<div class="card align-items-center" style="border: 2px solid #000000;"><br>';
                echo '<h6 style="color: darkblue; height:50px;" class="d-flex align-items-center mb-3"><b>ON GOING PROJECTS</h6></b>';
                echo '<p style="text-align: center; font-size: 32px; color: darkblue; padding-bottom: 11px;"><b>' . $totalActiveProjects . '</b></p>';
    
                echo '<p>Calculated: ' . $latestSubmitDate . '</p>';
    
                echo '</div>';
                echo '</div>';
                echo '</div>';
                $conn->close();
            
            ?>
        </div>
    </div>
</div>
