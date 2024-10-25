<?php
include 'includes/config.php';

session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:/login.php');
    exit; // Terminate script execution after redirection
}

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:/index.php');
    exit; // Terminate script execution after redirection
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
    <title>Donor/Volunteer</title>
    <link rel="stylesheet" href="css/donation.css">
    <link rel="stylesheet" href="css/donation_transaction.css"> 
    <link rel="stylesheet" href="/Views/SocialWorker/css/don_trans_details.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
        crossorigin="anonymous">

    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">
    <style>
    .download-button {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px; /* Add margin at the bottom */
    }

    .download-button a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff; /* Blue background color */
        color: #fff; /* White text color */
        text-decoration: none;
        border-radius: 5px;
    }

    .download-button a:hover {
        background-color: #0056b3; /* Darker blue color on hover */
    }
    </style>
</head>

<body>

    <!-- LOADER -->
    <script src="js/loader.js"></script>
    <div class="loader"></div>

    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                echo '
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="donation.php">Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="volunteer.php">Volunteers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="dv_userdashboard.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                '
                ?>
            </div>
        </div>
    </nav>
            <br>
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
    
</body>

</html>
