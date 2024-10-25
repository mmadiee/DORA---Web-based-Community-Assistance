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
$id = $_GET['id']; 

// SQL query to retrieve transaction details
$sql = "SELECT tbl_transaction.transac_id, tbl_transaction.transaction_id, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS dv_name, tbl_transaction.amount, tbl_transaction.submitdate AS date
        FROM tbl_transaction
        RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id
        WHERE tbl_transaction.don_project_id = $id AND stat = 'Verified'";


$result = $conn->query($sql);

// Donation Details, Amount, and Donor Count
$sql1 = "SELECT dp.title AS title, dp.goal AS goal, dp.start AS start, dp.proj_stat AS proj_stat, dp.end AS end, CONCAT(sw.fname, ' ', sw.lname) AS sw_name, sw.email AS email, SUM(t.amount) AS total_donation, COUNT(t.transac_id) AS donor_count
        FROM tbl_don_proj dp
        RIGHT JOIN tbl_sw_accs sw ON dp.sw_id = sw.sw_id
        LEFT JOIN tbl_transaction t ON dp.don_project_id = t.don_project_id
        WHERE dp.don_project_id = $id AND t.stat = 'verified'";

$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();

$total_donation = $row1['total_donation'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/donation_transaction.css">

    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">

    <!-- LINE CHART -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
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
        <h5>Project Details</h5>
    </div>

    <section class="home-section">
        <div class="container">
            <div class="back-btn">
                <a href = "donation-funds.php"><button class="btn btn-outline-primary m-3" type="button"><i class="bx bx-arrow-back"></i></button></a>
            </div>
            <?php
                if ($result && $result1->num_rows > 0) {
                    echo '<div class="container text-center w-75">';
                    echo '<div class="row">
                            <a href="/donation_projects.php?id=' . $id . '" target="blank"><h3>' . $row1['title'] . '</h3></a>
                            <p>Project by: <strong>' . $row1['sw_name'] . ' </strong>
                            <br>Status: <strong>' . $row1['proj_stat'] . ' </strong>
                            ';
                            
                    $title = $row1['title'];
                    $paypal_email = $row1['email'];
                    $status = $row1['proj_stat'];
                    $ext = $row1['ext'];
                    $dateUploaded = date('F j, Y', strtotime($row1['start']));
                    $deadline = date('F j, Y', strtotime($row1['end']));
                    echo '<br>' . $dateUploaded . ' - ' . $deadline . '</p>';
                    echo '</div>';

                    echo '<div class="row">
                            <div class="data-box">
                                <div class="row">
                                    <div class="col-3">
                                        <p class="data"> &#8369;' . number_format($row1['goal']) . '</p>
                                        <p class="data-label">Total Goal</p>
                                    </div>
                                    <div class="col-3">
                                        <p class="data"> &#8369;' . number_format($row1['total_donation']) . '</p>
                                        <p class="data-label">Donations</p>
                                    </div>
                                    <div class="col-3">';
                                    if ($row1['total_donation'] >= $row1['goal']) {
                                        echo '<p class="data"><span>&#10003;</span></p>
                                            <p class="data-label">Goal Reached!</p>';
                                    } else {
                                        $remaining = $row1['goal'] - $row1['total_donation'];
                                        echo '<p class="data"> &#8369;' . number_format($remaining) . '</p>
                                            <p class="data-label">Remaining</p>';
                                    }
                                    echo' 
                                </div>
                                <div class="col-3">
                                    <p class="data">' . $row1['donor_count'] . '</p>
                                    <p class="data-label">Donors Count</p>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            ?>
        </div>
        
        
        <div class="container">
                <!--Export Donation List Button-->
                <div style="display: flex; justify-content: center;">
                    <a href="report_don_list.php?id=<?php echo $id; ?>" target="_blank">
                        <button class="btn btn-outline-primary mt-3 mb-3">Export List</button>
                    </a>

                    <?php 
                        if ($status == "GOAL REACHED"){
                            echo '
                            <!--Paypal Send Money Link -->
                            <button class="btn btn-warning ms-3 mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">Send Funds to Organizer</button>
                            ';
                        }
                    ?>
                    
                    <?php 
                        if ($status == "PAST DUE" && $ext == 0){
                            echo '
                            <!--Paypal Send Money Link-->
                            <button class="btn btn-warning ms-3 mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">Send Funds to Organizer</button>
                            ';
                        }
                    ?>
                    
                    <!--Project Update-->
                    <?php
                    
                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\Exception;
                    
                    require 'phpmailer/src/Exception.php';
                    require 'phpmailer/src/PHPMailer.php';
                    require 'phpmailer/src/SMTP.php';
                    
                    function sendEmailToSocialWorker($social_worker_email, $don_project_id, $title) {
                        $mail = new PHPMailer(true);
                    
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'projectsbydora@gmail.com';
                        $mail->Password = 'tdxytcpjqcrripgu';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;
                    
                        $mail->setFrom('projectsbydora@gmail.com');
                        $mail->addAddress($social_worker_email);
                        $mail->isHTML(true);
                        $mail->Subject = "Project Status Update";
                        $mail->Body = "
                            <body style='font-family: Arial, sans-serif; background-color: #f2f2f2;'>
                                <div style='background-color: #ffffff; padding: 20px; text-align: center;'>
                                    <div style='background-color: #007bff; color: #ffffff; padding: 10px; text-align: center;'>
                                        <h1>Project Funds Update</h1>
                                    </div>
                                    <div style='padding: 20px; text-align: center;'>
                                        <p>Your project \"$title\" with project ID $don_project_id has been marked as FUNDED.</p>
                                    </div>
                                    <div style='margin-top: 20px; text-align: center;'>
                                        <a href='https://projectsbydora.com' style='background-color: #007bff; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; color: #ffffff;'>
                                            Visit Our Website
                                        </a>
                                    </div>
                                </div>
                            </body>
                        </html>";
                    
                        try {
                            if ($mail->send()) {
                                // Email sent successfully
                                return true;
                            } else {
                                // Email not sent
                                return false;
                            }
                        } catch (Exception $e) {
                            // Email sending exception
                            return false;
                        }
                    }
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $don_project_id = $_POST['don_project_id'];
                        $title = $_POST['title'];
                    
                        // Update the project status to 'FUNDED'
                        $update = "UPDATE tbl_don_proj SET proj_stat = 'FUNDED' WHERE don_project_id = ?";
                        $stmt = $conn->prepare($update);
                    
                        if ($stmt === false) {
                            // SQL preparation error
                            echo "Error in SQL preparation: " . $conn->error;
                        } else {
                            $stmt->bind_param("i", $don_project_id);
                    
                            if ($stmt->execute()) {
                                // Check if the project status is updated to 'FUNDED'
                                if ($stmt->affected_rows > 0) {
                                    // Retrieve the social worker's email address from the tbl_sw_accs table
                                    $select_email_query = "SELECT tbl_sw_accs.email FROM tbl_sw_accs INNER JOIN tbl_don_proj ON tbl_sw_accs.sw_id = tbl_don_proj.sw_id WHERE tbl_don_proj.don_project_id = ?";
                                    $stmt_select_email = $conn->prepare($select_email_query);
                    
                                    if ($stmt_select_email !== false) {
                                        $stmt_select_email->bind_param("i", $don_project_id);
                                        $stmt_select_email->execute();
                                        $stmt_select_email->bind_result($social_worker_email);
                    
                                        if ($stmt_select_email->fetch()) {
                                            // Email sent and project updated successfully
                                            if (sendEmailToSocialWorker($social_worker_email, $don_project_id, $title)) {
                                                // Use JavaScript to show SweetAlert
                                                echo '<script>
                                                    Swal.fire({
                                                        title: "Success!",
                                                        text: "Project funded successfully!",
                                                        icon: "success",
                                                        showConfirmButton: true
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = "/Views/Admin/donation-funds.php";
                                                        }
                                                    });
                                                </script>';
                                            } else {
                                                // Email not sent
                                                echo "Error sending the email to the social worker.";
                                            }
                                        } else {
                                            // Error fetching the social worker's email address from the database
                                            echo "Error fetching the social worker's email address from the database.";
                                        }
                    
                                        $stmt_select_email->close();
                                    } else {
                                        // SQL preparation error for email address retrieval
                                        echo "Error in SQL preparation for email address retrieval: " . $conn->error;
                                    }
                                } else {
                                    // Project status not updated to 'FUNDED'
                                    echo "Project status not updated to 'FUNDED'.";
                                }
                            } else {
                                // Error updating the project status
                                echo "Error updating the project status.";
                            }
                        }
                    }
                    ?>


                    <!-- First Modal -->
                    <div class="modal fade" id="exampleModalToggle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalToggleLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Send Funds to Organizer</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Looks like this project has reached its goal! You can now send the funds to the organizer.</p>
                                    <p>Take note of the Social Worker's PayPal email and the project title below. Use these when you send the money using PayPal.</p>
                                     <p>Project Title: <strong><?php echo $title;?></strong><br>Total Donation: <strong><?php echo '&#8369;' . number_format($total_donation);?></strong><br>Paypal Email: <strong><?php echo $paypal_email;?></strong> </p>
                                </div>
                                <div class="modal-footer">
                                    <a href="https://www.paypal.com/myaccount/transfer/homepage/pay" target="_blank">
                                        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Go to PayPal</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Modal -->
                    <div class="modal fade" id="exampleModalToggle2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalToggleLabel2" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Project Update</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Project Title: <strong><?php echo $title;?></strong><br>Total Donation: <strong><?php echo '&#8369;' . number_format($total_donation);?></strong><br>Paypal Email: <strong><?php echo $paypal_email;?></strong> </p>
                                    <hr>
                                    <p>If you already sent the funds, you can now set the status of this project to "Funded" by clicking the button below. </p>
                                    <p>This will also let the organizer know about the payout for their donation project via automated email. </p>
                                </div>
                                <div class="modal-footer">
                                    <form action="" method="post">
                                        <input type="hidden" name="don_project_id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="title" value="<?php echo $title; ?>">
                                        <button type="submit" class="btn btn-primary">Mark as Funded</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="con-table pb-3">
                    <ul class="nav nav-underline" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">All</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="verified-tab" data-bs-toggle="tab" data-bs-target="#verified-tab-pane" type="button" role="tab" aria-controls="verified-tab-pane" aria-selected="false">Verified</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="false">Pending</button>
                      </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%;">ID</th>
                                        <th scope="col" style="width: 20%;">Name</th>
                                        <th scope="col" style="width: 10%;">Amount</th>
                                        <th scope="col" style="width: 15%;">Date</th>
                                        <th scope="col" style="width: 15%;">Transaction ID</th>
                                        <th scope="col" style="width: 10%;">Status</th>
                                        <th scope="col" style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql4 = "SELECT tbl_transaction.*, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS dv_name 
                                                FROM tbl_transaction 
                                                RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id 
                                                WHERE tbl_transaction.don_project_id = $id
                                                ";
                                        $result2 = mysqli_query($conn, $sql4);
                                        while ($row = mysqli_fetch_array($result2)){
                                            echo '
                                                <tr>
                                                    <th scope="row">'.$row['transac_id'].'</th>
                                                    <td>'.$row['dv_name'].'</td>
                                                    <td>&#8369;'.number_format($row['amount']).'</td>
                                                    <td>'.date('F j, Y', strtotime($row['submitdate'])).'</td>
                                                    <td>'.$row['transaction_id'].'</td>
                                                    <td>';
                                                    if ($row['stat'] == 'Verified') {
                                                    echo '<p style="color: green">'.$row['stat'].'</p>';
                                                } elseif ($row['stat'] == 'Pending') {
                                                    echo '<p style="color: orange">'.$row['stat'].'</p>';
                                                } elseif ($row['stat'] == 'Invalid') {
                                                    echo '<p style="color: red">'.$row['stat'].'</p>';
                                                }
                                            echo '</td>
                                                <td><a href="don_trans_details.php?transac_id='.$row['transac_id'].'&id='.$id.'"><button type="button" class="btn btn-info">Details</button></td>
                                                </tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>     
                        </div>
                        <div class="tab-pane fade" id="verified-tab-pane" role="tabpanel" aria-labelledby="verified-tab" tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%;">ID</th>
                                        <th scope="col" style="width: 20%;">Name</th>
                                        <th scope="col" style="width: 10%;">Amount</th>
                                        <th scope="col" style="width: 15%;">Date</th>
                                        <th scope="col" style="width: 15%;">Transaction ID</th>
                                        <th scope="col" style="width: 10%;">Status</th>
                                        <th scope="col" style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql4 = "SELECT tbl_transaction.*, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS dv_name 
                                                FROM tbl_transaction 
                                                RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id 
                                                WHERE tbl_transaction.don_project_id = $id AND stat = 'Verified'
                                                ";
                                        $result2 = mysqli_query($conn, $sql4);
                                        while ($row = mysqli_fetch_array($result2)){
                                            echo '
                                            <tr>
                                                <th scope="row">'.$row['transac_id'].'</th>
                                                <td>'.$row['dv_name'].'</td>
                                                <td>&#8369;'.number_format($row['amount']).'</td>
                                                <td>'.date('F j, Y', strtotime($row['submitdate'])).'</td>
                                                <td>'.$row['transaction_id'].'</td>
                                                <td>';
                                                if ($row['stat'] == 'Verified') {
                                                    echo '<p style="color: green">'.$row['stat'].'</p>';
                                                }
                                                echo '</td>
                                                <td><a href="don_trans_details.php?transac_id='.$row['transac_id'].'&id='.$id.'"><button type="button" class="btn btn-info">Details</button></td>
                                            </tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%;">ID</th>
                                        <th scope="col" style="width: 20%;">Name</th>
                                        <th scope="col" style="width: 10%;">Amount</th>
                                        <th scope="col" style="width: 15%;">Date</th>
                                        <th scope="col" style="width: 15%;">Transaction ID</th>
                                        <th scope="col" style="width: 10%;">Status</th>
                                        <th scope="col" style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php
                                        $sql4 = "SELECT tbl_transaction.*, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS dv_name 
                                        FROM tbl_transaction 
                                        RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id 
                                        WHERE tbl_transaction.don_project_id = $id AND stat = 'Pending'
                                        ";
                                        $result2 = mysqli_query($conn, $sql4);
                                        while ($row = mysqli_fetch_array($result2)){
                                            echo '
                                            <tr>
                                                <th scope="row">'.$row['transac_id'].'</th>
                                                <td>'.$row['dv_name'].'</td>
                                                <td>&#8369;'.number_format($row['amount']).'</td>
                                                <td>'.date('F j, Y', strtotime($row['submitdate'])).'</td>
                                                <td>'.$row['transaction_id'].'</td>
                                                <td>';
                                                if ($row['stat'] == 'Pending') {
                                                    echo '<p style="color: orange">'.$row['stat'].'</p>';
                                                }
                                                echo '</td>
                                                <td><a href="don_trans_details.php?transac_id='.$row['transac_id'].'&id='.$id.'"><button type="button" class="btn btn-info">Details</button></td>
                                            </tr>
                                            ';
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </section>

    <script>
        function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        }
    </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>