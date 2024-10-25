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

<?php
    // For ON GOING status
    $query_ongoing = "SELECT dp.don_project_id AS proj_ID, dp.title AS title, dp.goal AS goal, dp.ext AS ext,
            CONCAT(sw.fname, ' ', sw.lname) AS sw_name, 
            (   SELECT SUM(amount) 
                FROM tbl_transaction t 
                WHERE dp.don_project_id = t.don_project_id 
                AND t.stat = 'Verified'
            ) AS total_donation 
        FROM tbl_don_proj dp
        JOIN tbl_sw_accs sw ON dp.sw_id = sw.sw_id
        WHERE dp.proj_stat = 'ON GOING'";

    $run_ongoing = mysqli_query($conn, $query_ongoing);

    if (!$run_ongoing) {
        die("SQL Error: " . mysqli_error($conn));
    }

    // For GOAL REACHED status
    $query_goal_reached = "SELECT dp.don_project_id AS proj_ID, dp.title AS title, dp.goal AS goal,
            CONCAT(sw.fname, ' ', sw.lname) AS sw_name, 
            (   SELECT SUM(amount) 
                FROM tbl_transaction t 
                WHERE dp.don_project_id = t.don_project_id 
                AND t.stat = 'Verified'
            ) AS total_donation 
        FROM tbl_don_proj dp
        JOIN tbl_sw_accs sw ON dp.sw_id = sw.sw_id
        WHERE dp.proj_stat = 'GOAL REACHED'";

    $run_goal_reached = mysqli_query($conn, $query_goal_reached);

    if (!$run_goal_reached) {
        die("SQL Error: " . mysqli_error($conn));
    }

    // For PAST DUE status
    $query_past_due = "SELECT dp.don_project_id AS proj_ID, dp.title AS title, dp.goal AS goal, dp.ext AS ext,
    CONCAT(sw.fname, ' ', sw.lname) AS sw_name, 
    (   SELECT SUM(amount) 
        FROM tbl_transaction t 
        WHERE dp.don_project_id = t.don_project_id 
        AND t.stat = 'Verified'
    ) AS total_donation 
    FROM tbl_don_proj dp
    JOIN tbl_sw_accs sw ON dp.sw_id = sw.sw_id
    WHERE dp.proj_stat = 'PAST DUE'";

    $run_past_due = mysqli_query($conn, $query_past_due);

    if (!$run_past_due) {
    die("SQL Error: " . mysqli_error($conn));
    }

    // For FUNDED status
    $query_funded = "SELECT
                        dp.don_project_id AS proj_ID,
                        dp.title AS title,
                        dp.goal AS goal,
                        CONCAT(sw.fname, ' ', sw.lname) AS sw_name,
                        (
                            SELECT SUM(amount)
                            FROM tbl_transaction t
                            WHERE dp.don_project_id = t.don_project_id AND t.stat = 'Verified'
                        ) AS total_donation
                    FROM tbl_don_proj dp
                    JOIN tbl_sw_accs sw ON dp.sw_id = sw.sw_id
                    WHERE dp.proj_stat = 'FUNDED' OR dp.proj_stat = 'COMPLETED';
                    ";

    $run_funded = mysqli_query($conn, $query_funded);

    if (!$run_funded) {
        die("SQL Error: " . mysqli_error($conn));
    }

    // Set default values
    $total_funds = 0.00;
    $total_sent = 0.00;
    
    // Fetch and calculate the total funds
    $sum_query = "SELECT SUM(amount) AS total_funds
                  FROM tbl_transaction t 
                  WHERE t.stat = 'Verified'";
    
    $run_sum = mysqli_query($conn, $sum_query);
    
    if ($run_sum) {
        $result = mysqli_fetch_assoc($run_sum);
        $total_funds = $result['total_funds'];
    
        // If $total_funds is null, set it to 0
        // If it's a valid numeric value, format it using number_format()
        if ($total_funds === null) {
            $total_funds = 0; // Set $total_funds to 0 if it's null
        } else if (is_numeric($total_funds)) {
            $total_funds = number_format($total_funds, 2);
        }
    }
    
    // Fetch and calculate the total sent
    $outgoing_query = "SELECT SUM(t.amount) AS total_outgoing
                        FROM tbl_don_proj dp
                        RIGHT JOIN tbl_transaction t ON dp.don_project_id = t.don_project_id
                        WHERE t.stat = 'Verified' AND (dp.proj_stat = 'FUNDED' OR dp.proj_stat = 'COMPLETED');
                        ";
    
    $run_outgoing = mysqli_query($conn, $outgoing_query);
    
    if ($run_outgoing) {
        $result = mysqli_fetch_assoc($run_outgoing);
        $total_sent = $result['total_outgoing'];
    
        // If $total_sent is a valid numeric value, format it using number_format()
        if ($total_sent === null) {
            $total_sent = 0; // Set $total_sent to 0 if it's null
        } else {
            $total_sent = number_format($total_sent, 2);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Funds</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
        <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/donation-funds.css">

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
    
    <style>

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
    th, td {
    text-align: left; /* Higher specificity */
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
        <h5>Donation Funds</h5>
    </div>

    <section class="home-section">
        <div class="container mt-5 mb-2">
            <div class="row align-items-stretch">
                <div class="col-lg-5 col-md-5 mb-4">
                    <div class="d-box box-funds">
                        <div class="box-content">
                            <div class="title">Total Funds Gathered</div>
                            <div class="amount">&#8369; <?php echo $total_funds; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 mb-4">
                    <div class="d-box box-funds">
                        <div class="box-content">
                            <div class="title">Total Funds Sent</div>
                            <div class="amount">&#8369; <?php echo $total_sent; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-5 mb-4">
                    <div class="d-box box-link">
                        <a href="https://www.paypal.com/signin" class="custom-stretched-link" target="_blank">
                            <i class='bx bxl-paypal'></i>
                            Account
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="container mb-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="goal-reached-tab" data-bs-toggle="tab" data-bs-target="#goal-reached-tab-pane" type="button" role="tab" aria-controls="goal-reached-tab-pane" aria-selected="true">Goal Reached</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="on-going-tab" data-bs-toggle="tab" data-bs-target="#on-going-tab-pane" type="button" role="tab" aria-controls="on-going-tab-pane" aria-selected="false">On-going</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="past-due-tab" data-bs-toggle="tab" data-bs-target="#past-due-tab-pane" type="button" role="tab" aria-controls="past-due-tab-pane" aria-selected="false">Past Due</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="funded-tab" data-bs-toggle="tab" data-bs-target="#funded-tab-pane" type="button" role="tab" aria-controls="funded-tab-pane" aria-selected="false">Funded</button>
                </li>
            </ul>
            <div class="tab-content border" id="myTabContent">
                <div class="tab-pane fade show active" id="goal-reached-tab-pane" role="tabpanel" aria-labelledby="goal-reached-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                               
                                <th scope="col" style="width: 35%;">Title</th>
                                <th scope="col" style="width: 20%;">Organizer</th>
                                <th scope="col" style="width: 15%;">Donations</th>
                                <th scope="col" style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (mysqli_num_rows($run_goal_reached) == 0) {
                                    echo "<tr><td colspan='6'>No project has reached its goal</td></tr>";
                                } else {
                                    while ($row = mysqli_fetch_assoc($run_goal_reached)) {
                                        echo '<tr>';
                                       
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['sw_name'] . "</td>";
                                        echo "<td>&#8369; " . number_format($row['total_donation']) . "</td>";
                                        echo '<td><a href="donation_transaction.php?id=' . $row['proj_ID'] . '" class="btn btn-outline-info"><i class="bx bx-list-ul"></i></a></td>';
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="on-going-tab-pane" role="tabpanel" aria-labelledby="on-going-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                                
                                <th scope="col" style="width: 25%;">Title</th>
                                <th scope="col" style="width: 20%;">Organizer</th>
                                <th scope="col" style="width: 15%;">Donations</th>
                                <th scope="col" style="width: 10%;">Ext. Left</th>
                                <th scope="col" style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (mysqli_num_rows($run_ongoing) == 0) {
                                    echo "<tr><td colspan='6'>No on-going projects</td></tr>";
                                } else {
                                    while ($row = mysqli_fetch_assoc($run_ongoing)) {
                                        echo '<tr>';
                                       
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['sw_name'] . "</td>";
                                        echo "<td>&#8369; " . number_format($row['total_donation']) . "</td>";
                                        echo "<td>" . $row['ext'] . "</td>";
                                        echo '<td><a href="donation_transaction.php?id=' . $row['proj_ID'] . '" class="btn btn-outline-info"><i class="bx bx-list-ul"></i></a></td>';
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="past-due-tab-pane" role="tabpanel" aria-labelledby="past-due-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                                
                                <th scope="col" style="width: 25%;">Title</th>
                                <th scope="col" style="width: 20%;">Organizer</th>
                                <th scope="col" style="width: 15%;">Donations</th>
                                <th scope="col" style="width: 10%;">Ext. Left</th>
                                <th scope="col" style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (mysqli_num_rows($run_past_due) == 0) {
                                    echo "<tr><td colspan='6'>There are no projects past the deadline</td></tr>";
                                } else {
                                    while ($row = mysqli_fetch_assoc($run_past_due)) {
                                        echo '<tr>';
                                        
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['sw_name'] . "</td>";
                                        echo "<td>&#8369; " . number_format($row['total_donation']) . "</td>";
                                        echo "<td>" . $row['ext'] . "</td>";
                                        echo '<td><a href="donation_transaction.php?id=' . $row['proj_ID'] . '" class="btn btn-outline-info"><i class="bx bx-list-ul"></i></a></td>';
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="funded-tab-pane" role="tabpanel" aria-labelledby="funded-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                                
                                <th scope="col" style="width: 35%;">Title</th>
                                <th scope="col" style="width: 20%;">Organizer</th>
                                <th scope="col" style="width: 15%;">Donations</th>
                                <th scope="col" style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (mysqli_num_rows($run_funded) == 0) {
                                    echo "<tr><td colspan='6'>No funded projects yet</td></tr>";
                                } else {
                                    while ($row = mysqli_fetch_assoc($run_funded)) {
                                        echo '<tr>';
                                       
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['sw_name'] . "</td>";
                                        echo "<td>&#8369; " . number_format($row['total_donation']) . "</td>";
                                        echo '<td><a href="donation_transaction.php?id=' . $row['proj_ID'] . '" class="btn btn-outline-info"><i class="bx bx-list-ul"></i></a></td>';
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableRows = document.querySelectorAll('#clickableTable tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    const modal = new bootstrap.Modal(document.getElementById('staticBackdropView'));
                    modal.show();
                });
            });
        });
    </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>