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

// Number of records per page
$records_per_page = 10;

// Default page number
$page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;


// Calculate the starting record for the current page
$start_from = ($page - 1) * $records_per_page;


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Worker Activity</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/home.css">


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

    <!-- LINE CHART -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- BAR CHART -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

   <!-- Add these lines to the <head> section -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <style>
        .table-border-outer {
            border: 2px solid #000000;
            text-align: center;
        }
        .table-border-outer th,
        .table-border-outer td {
            border: none;
            padding: 10px; 
        }
        .table-border-outer tbody tr {
            border-bottom: 1px solid #000000;
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
        .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        justify-content: center;
      }
    
      .pagination li {
            margin: 0 5px;
        }
        
        .pagination a {
            text-decoration: none;
            color: #034078;
            padding: 8px 12px;
            border: 1px solid #034078;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        
        .pagination a:hover {
            background-color: #034078;
            color: #fff;
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
        <h5>Social Workers Activity</h5>
    </div>

    <section class="home-section">
        <!-- SEARCH FORM -->
          <div class="container mt-5" style="width: 68%;">
            <form method="GET" action="sw-activity.php" class="search-form d-flex justify-content-center">
                <div class="input-group">
                    <!-- Social worker name search input -->
                    <input type="text" name="sw_name" class="form-control" placeholder="Search by Name" value="<?php echo isset($_GET['sw_name']) ? htmlspecialchars($_GET['sw_name']) : ''; ?>">
                    <!-- Start date picker input -->
                    <input type="text" name="start_date" class="form-control datepicker-input" placeholder="Start Date" id="start_date" value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                    <!-- End date picker input -->
                    <input type="text" name="end_date" class="form-control datepicker-input" placeholder="End Date" id="end_date" value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                    <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i> Filter</button>
                    <button type="button" class="btn btn-secondary" onclick="resetSearch()"><i class='bx bx-reset'></i> Reset</button>
                </div>
            </form>
        </div>


        <!-- SOCIAL WORKER HOURS -->
        <div class="row justify-content-center mt-5">
            <div class="w-75">
                <div class="table-responsive">
                    <table class="table table-border-outer">
                        <thead>
                            <tr>
                                <th style="font-size: 18px; color: darkblue;">Name</th>
                                <th style="font-size: 18px; color: darkblue;">Login Time</th>
                                <th style="font-size: 18px; color: darkblue;">Logout Time</th>
                                <th style="font-size: 18px; color: darkblue;">Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $search_query = "";
                                $additional_conditions = "";
                                
                                if (isset($_GET['sw_name'])) {
                                    $search_query = mysqli_real_escape_string($conn, $_GET['sw_name']);
                                    $additional_conditions = "AND CONCAT_WS(' ', accs.fname, accs.mname, accs.lname) LIKE '%$search_query%'";
                                }
                                
                                if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                                    $start_date = $_GET['start_date'];
                                    $end_date = $_GET['end_date'];
                                
                                    $query = "SELECT time.sw_id, time.login_time, time.logout_time, CONCAT(accs.fname, ' ', accs.mname, ' ', accs.lname) AS full_name, accs.email, accs.image
                                            FROM social_worker_time_tracking AS time
                                            JOIN tbl_sw_accs AS accs ON time.sw_id = accs.sw_id
                                            WHERE DATE_FORMAT(time.login_time, '%m-%d-%Y') BETWEEN '$start_date' AND '$end_date'
                                            $additional_conditions
                                            ORDER BY time.login_time DESC
                                            LIMIT $start_from, $records_per_page";
                                } else {
                                    $query = "SELECT time.sw_id, time.login_time, time.logout_time, CONCAT(accs.fname, ' ', accs.mname, ' ', accs.lname) AS full_name, accs.email, accs.image
                                    FROM social_worker_time_tracking AS time
                                    JOIN tbl_sw_accs AS accs ON time.sw_id = accs.sw_id
                                    LEFT JOIN (
                                        SELECT sw_id, MAX(login_time) AS latest_login_time
                                        FROM social_worker_time_tracking
                                        GROUP BY sw_id
                                    ) AS latest_time ON time.sw_id = latest_time.sw_id AND time.login_time = latest_time.latest_login_time
                                    $additional_conditions
                                    ORDER BY time.login_time DESC
                                    LIMIT $start_from, $records_per_page";
                                }
                        
                                $req3 = mysqli_query($conn, $query);

                                if ($req3 === false) {
                                    die('Query failed: ' . mysqli_error($conn));
                                }

                                    if (mysqli_num_rows($req3) == 0) {
                                            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                                                $start_date = $_GET['start_date'];
                                                $end_date = $_GET['end_date'];
                                                $start_date = date("F d Y", strtotime($start_date));
                                                $end_date = date("F d Y", strtotime($end_date));
                                                echo '<tr><td colspan="6"><b>No Activity Hours from: ' . $start_date . ' - ' . $end_date . '</td></tr></b>';
                                            }
                                    
                                        } else {
                                            while ($row = mysqli_fetch_assoc($req3)) {
                                                $loginTime = new DateTime($row['login_time']);
                                                $logoutTime = new DateTime($row['logout_time']);
                                                $loginTime->setTimezone(new DateTimeZone('Asia/Manila'));
                                                $logoutTime->setTimezone(new DateTimeZone('Asia/Manila'));

                                                $timeDifference = $logoutTime->getTimestamp() - $loginTime->getTimestamp();

                                                $hours = floor($timeDifference / 3600);
                                                $minutes = floor(($timeDifference % 3600) / 60);
                                                $seconds = $timeDifference % 60;
                                                echo '
                                                <tr>
                                                    <td style="font-size: 16px;">' . $row['full_name'] . '</td>
                                                    <td style="font-size: 16px;">' . $loginTime->format('F d Y H:i:s') . '</td>
                                                    <td style="font-size: 16px;">' . $logoutTime->format('F d Y H:i:s') . '</td>
                                                    <td style="font-size: 16px;">' . $hours . ' hours ' . $minutes . ' minutes ' . $seconds . ' seconds</td>
                                                </tr>';
                                            }
                                        }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
<!-- Pagination Links -->
<div class="row justify-content-center mt-5">
    <div class="w-75">
        <ul class="pagination">
            <?php
            // Calculate the total number of pages with actual data
            $total_records_query = "SELECT COUNT(*) as total FROM social_worker_time_tracking";
            $total_records_result = mysqli_query($conn, $total_records_query);
            $total_records = mysqli_fetch_assoc($total_records_result)['total'];

            // Calculate the total number of pages based on the actual number of records
            $total_pages = ceil($total_records / $records_per_page);
            $total_pages = max($total_pages, 1);

            // Limit the number of visible pagination buttons
            $visible_pages = min($total_pages, 5);

            // Determine the start and end page numbers
            $start_page = max(1, $page - floor($visible_pages / 2));
            $end_page = min($total_pages, $start_page + $visible_pages - 1);

            // Display the previous arrow
            if ($page > 1) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '"><i class="bx bx-chevron-left"></i></a></li>';
            }

            // Display the pagination links
            for ($i = $start_page; $i <= $end_page; $i++) {
                if ($i <= $total_pages) {
                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">';
                    echo '<a class="page-link" href="?page=' . $i;
                    if (isset($_GET['start_date'])) {
                        echo '&start_date=' . $_GET['start_date'];
                    }
                    if (isset($_GET['end_date'])) {
                        echo '&end_date=' . $_GET['end_date'];
                    }
                    echo '">' . $i . '</a>';
                    echo '</li>';
                }
            }

            // Display the next arrow
            if ($page < $total_pages) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '"><i class="bx bx-chevron-right"></i></a></li>';
            }
            ?>
        </ul>
    </div>
</div>



        
        
    </section>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

  function validateSearchForm() {
            const nameInput = document.querySelector("input[name='sw_name']").value;
            if (nameInput.trim() === '' || !nameInput.includes(' ')) {
                swal('Invalid Input', 'Please enter a full name for the search.', 'error');
                return false;
            }

            return true;
        }

        function validateDateInputs() {
            const startDateInput = document.querySelector("input[name='start_date']").value;
            const endDateInput = document.querySelector("input[name='end_date']").value;

            if (startDateInput.trim() === '' || endDateInput.trim() === '') {
                swal('Invalid Dates', 'Please provide both start date and end date.', 'error');
                return false;
            }

            const startDate = new Date(startDateInput);
            const endDate = new Date(endDateInput);
            const currentDate = new Date();

            if (startDate < new Date('2023-01-01')) {
                swal('Invalid Start Date', 'Start date cannot be earlier than January 1, 2023.', 'error');
                return false;
            }

            if (endDate > currentDate) {
                swal('Invalid End Date', 'End date cannot exceed the current date.', 'error');
                return false;
            }

            return true;
        }

        document.querySelector('.search-form').addEventListener('submit', (event) => {
            if (!validateSearchForm() || !validateDateInputs()) {
                event.preventDefault(); 
            }
        });
        
        $(function () {
        $('.datepicker-input').datepicker({
            format: 'mm-dd-yyyy', 
            autoclose: true 
        });
    });

    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement;
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });

   function resetSearch() {
    const startDateInput = document.querySelector("input[name='start_date']");
    const endDateInput = document.querySelector("input[name='end_date']");
    
    const currentDate = new Date();
    const januaryFirst2023 = new Date("2023-01-01");
    
    startDateInput.value = januaryFirst2023.toISOString().split('T')[0];
    endDateInput.value = currentDate.toISOString().split('T')[0];
    
    document.querySelector(".search-form").submit();
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>