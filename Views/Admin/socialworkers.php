<?php

include 'includes/config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:/login.php');
};

if (isset($_GET['logout'])) {
    unset($admin_id);
    session_destroy();
    header('location:/login.php');
}

$records_per_page = 10;
$page = (isset($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;
$start_from = ($page - 1) * $records_per_page;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Social Workers</title>

   <link rel="stylesheet" href="css/sidebar.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

   <!-- CDN LINK -->
   <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!--ICONS-->
   <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
   <link rel="manifest" href="/img/icon/site.webmanifest">

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
<div class="header">
    <h5>Social Workers</h5>
</div>

<section class="home-section">
    <div class="container table w-75 mt-5">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $sql4 = "SELECT *, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name, CONCAT(street, ', Brgy. ', brgy, ', ', municipality, ', ', city) AS location FROM tbl_sw_accs WHERE status = 'verified' LIMIT $start_from, $records_per_page";
                    $result2 = mysqli_query($conn, $sql4);

                    if (!$result2) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    while ($row = mysqli_fetch_array($result2)) {
                        echo '
                                    <tr>
                                        <th scope="row">' . $row['full_name'] . '</th>
                                        <td>' . $row['email'] . '</td>
                                        <td>' . $row['full_contact'] . '</td>
                                        <td>' . $row['location'] . '</td>';
                        echo '<td><a href="sw-details.php?sw_id=' . $row['sw_id'] . '"><button type="button" class="btn btn-info">Details</button></a></td>
                                    </tr>';
                    }
                    ?>
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <ul class="pagination">
                    <?php
                    // Calculate the total number of pages with actual data
                    $total_records_query = "SELECT COUNT(*) as total FROM tbl_sw_accs WHERE status = 'verified'";
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
                    // Display the previous arrow
                    if ($page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '"><i class="bx bx-chevron-left"></i></a></li>';
                    }


                    // Display the pagination links
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        if ($i <= $total_pages) {
                            echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">';
                            echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
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
    </div>
</section>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
