<?php
    
include 'includes/config.php';

session_start();
$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:/login.php');
}

if (isset($_GET['logout'])) {
    unset($admin_id);
    session_destroy();
    header('location:/login.php');
    exit;
}

$id = $_GET['id']; 
$transac_id = $_GET['transac_id']; 

$sql = "SELECT tbl_transaction.*, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS name, tbl_dv_accs.image AS image
        FROM tbl_transaction 
        RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id 
        WHERE tbl_transaction.transac_id = $transac_id
        ";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)){
    $name = $row['name'];
    $amount = $row['amount'];
    $transaction_id = $row['transaction_id'];
    $submitdate = $row['submitdate'];
    $image_llink = $row['image'];
    $stat = $row['stat'];
}

$title_q = "SELECT * FROM tbl_don_proj RIGHT JOIN tbl_transaction ON tbl_don_proj.don_project_id = tbl_transaction.don_project_id WHERE tbl_transaction.transac_id = $transac_id";
$run = mysqli_query($conn, $title_q);
while ($get = mysqli_fetch_array($run)){
    $title = $get['title'];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Donation Details</title>
    <link rel="stylesheet" href="css\sidebar.css">
    <link rel="stylesheet" href="css\don_trans_details.css">

    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

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

    </style>
   </head>
<body>

    <!--LOADER-->
    <script src="js/loader.js"></script>
    <div class="loader"></div>

    <!-- TITLE BARS -->
    <div class="header">
        <h5>Transactions Details</h5>
    </div>

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

    <section class="home-section">
        <div class="container">
            <div class="back-btn">
                <a href = "donation_transaction.php?id=<?php echo $id ?>"><button class="btn btn-outline-primary m-3" type="button"><i class="bx bx-arrow-back"></i></button></a>
            </div>

            <div class="transaction-receipt">
                <div class="logo-section">
                    <img src="/dora_logo.png" width="100" height="25" class="centered-logo">
                </div>
                <h5 class="receipt-title">Transaction Details</h5>
                <div class="receipt-image">
                    <img src="/uploaded_img/<?php echo $image_llink; ?>" alt="Transaction Image" width="100" height="75">
                    <p> <?php echo $name; ?></p>
                </div>
                <div class="receipt-details">
                    <p class="amount"><strong>&#8369; <?php echo number_format($amount, 2); ?></strong></p>
                    <p class="donation-text">Donation for</p>
                    <p class="donation-text">"<?php echo $title; ?>"</p>
                    <hr>
                    <div class="row">
                        <div class="col-6"><p>Status</p></div>
                        <div class="col-6 text-end"><p><strong><?php echo $stat; ?></strong></p></div>
                    </div>

                    <div class="row">
                        <div class="col-6"><p>Transaction ID</p></div>
                        <div class="col-6 text-end"><p><strong><?php echo $transaction_id; ?></strong></p></div>
                    </div>

                    <div class="row">
                        <div class="col-6"><p>Date</p></div>
                        <div class="col-6 text-end"><p><strong><?php echo date('F j, Y', strtotime($submitdate)); ?></strong></p></div>
                    </div>

                </div>
            </div>

        </div>
    </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
