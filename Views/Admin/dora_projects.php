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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/dora_projects.css">

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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
          .no-results-message {
            text-align: center;
            background-color: #f2f2f2;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 20px 0;
          }
        
          .no-results-message p {
            font-size: 18px;
            color: #777;
            margin: 0;
          }
          
        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            background-color: #034078;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px;
        }
        
        .modal-title {
            font-size: 1.5rem;
            margin: 0;
        }
  
        .modal-body {
            padding: 20px;
        }
        
        .container {
            max-width: 100%;
        }
        
        .col-md-6 {
            padding: 10px;
        }
        
        h3 {
            font-size: 1.2rem;
        }
        
        img.img-fluid {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        
        .pinfo {
            font-size: 16px;
            margin-top: 10px;
            text-align: justify;
            margin-top: 10px;
            font-weight: 400;
        }
        
        #org{
            margin-top: 40px;
        }
        
        .btn-success {
            background-color: #28a745;
            color: #fff;
            margin-top: 50px;
            margin-right: 500px;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            margin-top: -63px;
            margin-right: 270px;
        }
        
        input[type="hidden"] {
            display: none;
        }
        
        @media (max-width: 768px) {
            .modal-body {
                padding: 10px;
            }
        
            .col-md-6 {
                padding: 5px;
            }
        }
        
        .btn-close {
         color: #ffffff; 
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
        <h5>Pending Projects</h5>
    </div>

    <section class="home-section">
        <div class="container mb-5 mt-5">
            <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-donation-tab" data-bs-toggle="pill" data-bs-target="#pills-donation" type="button" role="tab" aria-controls="pills-donation" aria-selected="true">Donation</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-volunteer-tab" data-bs-toggle="pill" data-bs-target="#pills-volunteer" type="button" role="tab" aria-controls="pills-volunteer" aria-selected="false">Volunteer</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-Assistance-tab" data-bs-toggle="pill" data-bs-target="#pills-Assistance" type="button" role="tab" aria-controls="pills-Assistance" aria-selected="false">Assistance</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                
            <!-- PENDING DONATION PROJECTS TAB -->
            <div class="tab-pane fade show active" id="pills-donation" role="tabpanel" aria-labelledby="pills-donation-tab" tabindex="0">
                        
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

 //DONATION PROJECT UPDATE AND EMAIL LOGIC 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && isset($_POST["project_id"])) {
    $project_id = $_POST["project_id"];
    $action = $_POST["action"];
    $new_proj_stat = '';

    if ($action === "verify") {
        $new_proj_stat = 'ON GOING';
    } elseif ($action === "invalidate") {
        $new_proj_stat = 'INVALID';
    }

    $sql = "UPDATE tbl_don_proj SET proj_stat = ? WHERE don_project_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_proj_stat, $project_id);

    if ($stmt->execute()) {
        $email = "";
        $title = "";
        $sw_id = 0;  
        $sql = "SELECT sw_id, title FROM tbl_don_proj WHERE don_project_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        $stmt->bind_result($sw_id, $title);
        $stmt->fetch();
        $stmt->close();

        $sw_email = "";
        $sql = "SELECT email, fname, lname FROM tbl_sw_accs WHERE sw_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sw_id);
        $stmt->execute();
        $stmt->bind_result($sw_email, $fname, $lname);
        $stmt->fetch();
        $stmt->close();

        $emailSubject = "Project Status Update";
        $emailMessage = "";

        if ($action === "verify") {
            $emailMessage = "Dear $fname $lname, your donation project \"$title\" with project ID $project_id has been marked as approved and is now in an ON GOING status.";
        } elseif ($action === "invalidate") {
            $invalidation_reason = isset($_POST['invalidation_reason']) ? $_POST['invalidation_reason'] : '';
            $emailMessage = "Dear $fname $lname, your donation project \"$title\" with project ID $project_id has been marked as INVALID. Reason: $invalidation_reason";
        }

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'projectsbydora@gmail.com';
        $mail->Password = 'tdxytcpjqcrripgu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('projectsbydora@gmail.com');
        $mail->addAddress($sw_email);

        $mail->isHTML(true);
        $mail->Subject = $emailSubject;
        $message = "<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        .message {
            padding: 20px;
            text-align: center;
        }
        .button {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            background-color: #007bff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Project Status Update</h1>
        </div>
        <div class='message'>
            <p>$emailMessage</p>
        </div>
        <div class='button'>
            <a href='https://projectsbydora.com' class='btn'>
                Visit Our Website
            </a>
        </div>
    </div>
</body>
</html>";

        $mail->Body = $message;
        $mail->send();

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Project status updated successfully. Email sent to the Social Worker.",
                showConfirmButton: false,
                timer: 1500 // 1.5 seconds
            }).then(() => {
                window.location.href = window.location.href; // Redirect to the same page
            });
        </script>';
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error updating project status: ' . $stmt->error . '"
            });
        </script>';
    }

    exit;
    
     //VOLUNTEER PROJECT UPDATE AND EMAIL LOGIC 
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action2"]) && isset($_POST["project_id"])) {
    $project_id = $_POST["project_id"];
    $action = $_POST["action2"];
    $new_proj_stat = '';

    if ($action === "verify") {
        $new_proj_stat = 'ON GOING';
    } elseif ($action === "invalidate") {
        $new_proj_stat = 'INVALID';
    }

    $sql = "UPDATE tbl_vol_proj SET proj_stat = ? WHERE vol_proj_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_proj_stat, $project_id);

    if ($stmt->execute()) {
        $email = "";
        $title = "";
        $sw_id = 0;  
        $sql = "SELECT sw_id, title FROM tbl_vol_proj WHERE vol_proj_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        $stmt->bind_result($sw_id, $title);
        $stmt->fetch();
        $stmt->close();

        $sw_email = "";
        $sql = "SELECT email, fname, lname FROM tbl_sw_accs WHERE sw_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sw_id);
        $stmt->execute();
        $stmt->bind_result($sw_email, $fname, $lname);
        $stmt->fetch();
        $stmt->close();

        $emailSubject = "Project Status Update";
        $emailMessage = "";

        if ($action === "verify") {
            $emailMessage = "Dear $fname $lname, your volunteer project \"$title\" with project ID $project_id has been marked as approved and is now in an ON GOING status.";
        } elseif ($action === "invalidate") {
            $invalidation_reason = isset($_POST['invalidation_reason']) ? $_POST['invalidation_reason'] : '';
            $emailMessage = "Dear $fname $lname, your volunteer project \"$title\" with project ID $project_id has been marked as INVALID. Reason: $invalidation_reason";
        }

        $mail2 = new PHPMailer(true);

        $mail2->isSMTP();
        $mail2->Host = 'smtp.gmail.com';
        $mail2->SMTPAuth = true;
        $mail2->Username = 'projectsbydora@gmail.com';
        $mail2->Password = 'tdxytcpjqcrripgu';
        $mail2->SMTPSecure = 'ssl';
        $mail2->Port = 465;

        $mail2->setFrom('projectsbydora@gmail.com');
        $mail2->addAddress($sw_email);

        $mail2->isHTML(true);
        $mail2->Subject = $emailSubject;
        $message = "<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        .message {
            padding: 20px;
            text-align: center;
        }
        .button {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            background-color: #007bff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Project Status Update</h1>
        </div>
        <div class='message'>
            <p>$emailMessage</p>
        </div>
        <div class='button'>
            <a href='https://projectsbydora.com' class='btn'>
                Visit Our Website
            </a>
        </div>
    </div>
</body>
</html>";

        $mail2->Body = $message;
        $mail2->send();

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Project status updated successfully. Email sent to the Social Worker.",
                showConfirmButton: false,
                timer: 1500 // 1.5 seconds
            }).then(() => {
                window.location.href = window.location.href; // Redirect to the same page
            });
        </script>';
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error updating project status: ' . $stmt->error . '"
            });
        </script>';
    }

    //ASSISTANCE PROJECT UPDATE AND EMAIL LOGIC 
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action3"]) && isset($_POST["project_id"])) {
    $project_id = $_POST["project_id"];
    $action = $_POST["action3"];
    $new_proj_stat = '';

    if ($action === "verify") {
        $new_proj_stat = 'ON GOING';
    } elseif ($action === "invalidate") {
        $new_proj_stat = 'INVALID';
    }

    $sql = "UPDATE tbl_assistance SET proj_stat = ? WHERE assistance_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_proj_stat, $project_id);
    
    if ($stmt->execute()) {
        $email = "";
        $title = "";
        $sw_id = 0;  
        $sql = "SELECT sw_id, title FROM tbl_assistance WHERE assistance_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        $stmt->bind_result($sw_id, $title);
        $stmt->fetch();
        $stmt->close();

        $sw_email = "";
        $sql = "SELECT email, fname, lname FROM tbl_sw_accs WHERE sw_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sw_id);
        $stmt->execute();
        $stmt->bind_result($sw_email, $fname, $lname);
        $stmt->fetch();
        $stmt->close();

        $emailSubject = "Project Status Update";
        $emailMessage = "";

        if ($action === "verify") {
            $emailMessage = "Dear $fname $lname, your assistance project \"$title\" with project ID $project_id has been marked as approved and is now in an ON GOING status.";
        } elseif ($action === "invalidate") {
            $invalidation_reason = isset($_POST['invalidation_reason']) ? $_POST['invalidation_reason'] : '';
            $emailMessage = "Dear $fname $lname, your assistance project \"$title\" with project ID $project_id has been marked as INVALID. Reason: $invalidation_reason";
        }

        $mail3 = new PHPMailer(true);

        $mail3->isSMTP();
        $mail3->Host = 'smtp.gmail.com';
        $mail3->SMTPAuth = true;
        $mail3->Username = 'projectsbydora@gmail.com';
        $mail3->Password = 'tdxytcpjqcrripgu';
        $mail3->SMTPSecure = 'ssl';
        $mail3->Port = 465;

        $mail3->setFrom('projectsbydora@gmail.com');
        $mail3->addAddress($sw_email);

        $mail3->isHTML(true);
        $mail3->Subject = $emailSubject;
        $message = "<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        .message {
            padding: 20px;
            text-align: center;
        }
        .button {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            background-color: #007bff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Project Status Update</h1>
        </div>
        <div class='message'>
            <p>$emailMessage</p>
        </div>
        <div class='button'>
            <a href='https://projectsbydora.com' class='btn'>
                Visit Our Website
            </a>
        </div>
    </div>
</body>
</html>";

        $mail3->Body = $message;
        $mail3->send();

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Project status updated successfully. Email sent to the Social Worker.",
                showConfirmButton: false,
                timer: 1500 // 1.5 seconds
            }).then(() => {
                window.location.href = window.location.href; // Redirect to the same page
            });
        </script>';
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error updating project status: ' . $stmt->error . '"
            });
        </script>';
    }
     $stmt->close();
    $conn->close();
    exit;
}
?>


<?php
$sql = "SELECT *, tbl_don_proj.image AS project_image
        FROM tbl_don_proj
        RIGHT JOIN tbl_sw_accs ON tbl_don_proj.sw_id = tbl_sw_accs.sw_id
        WHERE tbl_don_proj.proj_stat = 'PENDING'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="tablebox">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Project ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Organizer</th>
                        <th scope="col">Goal</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<th scope="row">' . $row['don_project_id'] . '</th>';
        echo '<td>' . $row['title'] . '</td>';
        echo '<td>' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . '</td>';
        echo '<td>' . '₱' . number_format($row['goal']) . '</td>'; 
        echo '<td>' . date('F d, Y', strtotime($row['start'])) . '</td>'; 

        $modalId = 'staticBackdrop_' . $row['don_project_id'];
        echo '<td>  
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">Details</button>
            </td>';
        echo '</tr>';

        echo '<div class="modal fade" id="' . $modalId . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Project Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Title: ' . $row['title'] . '</h3>
                                        <img src="../SocialWorker/don_img/' . $row['project_image'] . '" alt="Project Image" class="img-fluid">
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="pinfo" id="org"><b>Organizer:</b> ' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . '</h5>
                                        <h5 class="pinfo"><b>Goal: </b>' . '₱' . number_format($row['goal']) . '</h5> 
                                        <h5 class="pinfo"><b>Start Date:</b> ' . date('F d, Y', strtotime($row['start'])) . '</h5> 
                                        <h5 class="pinfo"><b>End Date: </b>' . date('F d, Y', strtotime($row['end'])) . '</h5> 
                                        <h5 class="pinfo"><b>Category:</b> ' . $row['category'] . '</h5>
                                        <h5 class="pinfo"><b>Description: </b>' . $row['text'] . '</h5>
                                        <h5 class="pinfo"><b>Drop Off Location:</b> ' . $row['dropoff'] . '</h5>
                                        <h5 class="pinfo"><b>Paypal Account: </b>' . $row['paypal_email'] . '</h5>';
                                        

                                        echo '<form method="post" action="">
                                                <input type="hidden" name="project_id" value="' . $row['don_project_id'] . '">
                                                <button type="submit" class="btn btn-success" name="action" value="verify" 
                                                    onclick="return confirm(\'Are you sure you want to verify this donation project?\')"
                                                >Verify</button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#invalidationModal_' . $row['don_project_id'] . '">
                                                Invalidate
                                              </button>
                                            </form>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        
        // Reason for invalidation modal
echo '<div class="modal fade" id="invalidationModal_' . $row['don_project_id'] . '" tabindex="-1" aria-labelledby="invalidationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invalidationModalLabel">Reason for Invalidation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <input type="hidden" name="project_id" value="' . $row['don_project_id'] . '">
                        <div class="mb-3">
                            <label for="invalidationReason" class="form-label">Reason:</label>
                            <textarea class="form-control" id="invalidationReason" name="invalidation_reason" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center"> <!-- Updated this line -->
                        <button type="submit" class="btn btn-danger" name="action" value="invalidate"
                            onclick="return confirm(\'Are you sure you want to invalidate this donation project?\')"
                        >Invalidate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>';

    }
    echo '</tbody>
        </table>
    </div>';
} else {
    echo '<div class="no-results-message">
            <p>No Results Found</p>
        </div>';
}
?>
</div>

           <!-- PENDING VOLUNTEER PROJECTS TAB -->
                    <div class="tab-pane fade" id="pills-volunteer" role="tabpanel" aria-labelledby="pills-volunteer-tab" tabindex="0">
                    <?php
                    $sql = "SELECT *, tbl_vol_proj.image AS project_image
                            FROM tbl_vol_proj
                            INNER JOIN tbl_sw_accs ON tbl_vol_proj.sw_id = tbl_sw_accs.sw_id
                            WHERE tbl_vol_proj.proj_stat = 'PENDING'";

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo '<div class="tablebox">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project ID</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Organizer</th>
                                            <th scope="col">Volunteer Goal</th>
                                            <th scope="col">Event Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row['vol_proj_id'] . '</th>';
                            echo '<td>' . $row['title'] . '</td>';
                            echo '<td>' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . '</td>';
                            echo '<td>' . $row['totalGoal'] . '</td>';
                            echo '<td>' . date('F d, Y', strtotime($row['eventDate'])) . '</td>'; 

                            // Use a unique modal ID for each project
                           $modalId = 'volunteerStaticBackdrop_' . $row['vol_proj_id'];
                            echo '<td>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">Details</button>
                                  </td>';

                            // Hidden modal with dynamic content for each project
                            echo '<div class="modal fade" id="' . $modalId . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class = "modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Project Information</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h3>Title: ' . $row['title'] . '</h3>
                                                            <img src="../SocialWorker/vol_img/' . $row['project_image'] . '" alt="Project Image" class="img-fluid">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5 class="pinfo" id="org"><b>Organizer:</b> ' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . '</h5>
                                                            <h5 class="pinfo"><b>Volunteer Goal:</b> ' . $row['totalGoal'] . '</h5>
                                                            <h5 class="pinfo" ><b>Event Date:</b> ' . date('F d, Y', strtotime($row['eventDate'])) . '</h5> 
                                                            <h5 class="pinfo"><b>Category:</b> ' . $row['category'] . '</h5>
                                                            <h5 class="pinfo"><b>Description:</b> ' . $row['text'] . '</h5>
                                                            <h5 class="pinfo"><b>Venue:</b> ' . $row['location'] . '</h5>
                                                            <form method="post" action="">
                                                            <input type="hidden" name="project_id" value="' . $row['vol_proj_id'] . '">
                                                            <button type="submit" class="btn btn-success" name="action2" value="verify" 
                                                                onclick="return confirm(\'Are you sure you want to verify this volunteer project?\')"
                                                            >Verify</button>
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#volunteerInvalidationModal2_' . $row['vol_proj_id'] . '">
                                                                    Invalidate
                                                                </button>

                                                                </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';

                                        // Reason for invalidation modal
                                        echo '<div class="modal fade" id="volunteerInvalidationModal2_' . $row['vol_proj_id'] . '" tabindex="-1" aria-labelledby="volunteerInvalidationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="invalidationModalLabel">Reason for Invalidation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="">
                                                        <input type="hidden" name="project_id" value="' . $row['vol_proj_id'] . '">
                                                        <div class="mb-3">
                                                            <label for="invalidationReason" class="form-label">Reason:</label>
                                                            <textarea class="form-control" id="invalidationReason" name="invalidation_reason" rows="4" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center"> <!-- Updated this line -->
                                                        <button type="submit" class="btn btn-danger" name="action2" value="invalidate"
                                                            onclick="return confirm(\'Are you sure you want to invalidate this volunteer project?\')"
                                                        >Invalidate</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        </div>';
                                                                }
                        echo '</tbody>
                            </table>
                        </div>';
                    } else {
                    echo '<div class="no-results-message">
                            <p>No Results Found</p>
                        </div>';
                    }
                    ?>
                    </div>


           <!-- PENDING ASSISTANCE PROJECTS TAB -->
<div class="tab-pane fade" id="pills-Assistance" role="tabpanel" aria-labelledby="pills-Assistance-tab" tabindex="0">

<?php
$sql = "SELECT *, tbl_assistance.image AS project_image
        FROM tbl_assistance
        INNER JOIN tbl_sw_accs ON tbl_assistance.sw_id = tbl_sw_accs.sw_id
        WHERE tbl_assistance.proj_stat = 'PENDING'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="tablebox">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Project ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Organizer</th>
                        <th scope="col">Available Slot</th>
                        <th scope="col">Distribution Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<th scope="row">' . $row['assistance_id'] . '</th>';
        echo '<td>' . $row['title'] . '</td>';
        echo '<td>' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . '</td>';
        echo '<td>' . $row['avail_slot'] . '</td>';
        echo '<td>' . date('F d, Y', strtotime($row['deadline'])) . '</td>'; 

        // Use a unique modal ID for each project
        $modalId = 'assistanceStaticBackdrop_' . $row['assistance_id'];
        echo '<td>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">Details</button>
            </td>';
        echo '</tr>';

        // Hidden modal with dynamic content for each project
        echo '<div class="modal fade" id="' . $modalId . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header"> 
                            <h5 class="modal-title" id="staticBackdropLabel">Project Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Title: ' . $row['title'] . '</h3>
                                        <img src="../SocialWorker/assist_img/' . $row['project_image'] . '" alt="Project Image" class="img-fluid">
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="pinfo" id="org"><b>Organizer:</b> ' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . '</h5>
                                        <h5 class="pinfo"><b>Available Slot:</b> ' . $row['avail_slot'] . '</h5>
                                        <h5 class="pinfo"><b>Distribution Date:</b> ' . date('F d, Y', strtotime($row['deadline'])) . '</h5> 
                                        <h5 class="pinfo"><b>Category:</b> ' . $row['category'] . '</h5>
                                        <h5 class="pinfo"><b>Description:</b> ' . $row['text'] . '</h5>
                                        <h5 class="pinfo"><b>Venue:</b> ' . $row['location'] . '</h5>
                                        <form method="post" action="">
                                        <input type="hidden" name="project_id" value="' . $row['assistance_id'] . '">
                                        <button type="submit" class="btn btn-success" name="action3" value="verify" 
                                            onclick="return confirm(\'Are you sure you want to verify this assistance project?\')"
                                        >Verify</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#assistanceInvalidationModal_' . $row['assistance_id'] . '">
                                                                    Invalidate
                                                                </button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

            // Reason for invalidation modal
            echo '<div class="modal fade" id="assistanceInvalidationModal_' . $row['assistance_id'] . '" tabindex="-1" aria-labelledby="assistanceInvalidationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="invalidationModalLabel">Reason for Invalidation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="">
                            <input type="hidden" name="project_id" value="' . $row['assistance_id'] . '">
                            <div class="mb-3">
                                <label for="invalidationReason" class="form-label">Reason:</label>
                                <textarea class="form-control" id="invalidationReason" name="invalidation_reason" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center"> <!-- Updated this line -->
                            <button type="submit" class="btn btn-danger" name="action3" value="invalidate"
                                onclick="return confirm(\'Are you sure you want to invalidate this assistance project?\')"
                            >Invalidate</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>';
    }
    echo '</tbody>
        </table>
    </div>';
} else {
echo '<div class="no-results-message">
        <p>No Results Found</p>
    </div>';
}
?>

                </div>
            </div>
        </div>
        
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<!-- Populate Email Panel -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var emailModal = document.getElementById("emailModal");
        emailModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget; 
            var projectID = button.getAttribute("data-projectid"); 
            document.getElementById('don_project_id').value = projectID; 
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('verifyButton').addEventListener('click', function (event) {
            var confirmation = confirm('Are you sure you want to verify this donation project?');
            if (!confirmation) {
                event.preventDefault(); // Prevent form submission if confirmation is not given
            }
        });
    });
</script>


</body>
</html>