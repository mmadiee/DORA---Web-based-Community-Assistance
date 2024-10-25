<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to DORA</title>

    <link href="css/index.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/site.webmanifest">
</head>

<style>
.body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.message-box {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}
</style>
<body>
    <!--LOADER-->
    <script src="js/loader.js"></script>    
    <div class="loader"></div>

    <!--NAV BAR-->
    <div class="first-styles">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
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
                        <a class="nav-link" href="assistance.php">Assistance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </div>

<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Concatenate the email address with the message content
    $fullMessage = "From: $email\n\n$message";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'projectsbydora@gmail.com'; // Your Gmail email address
        $mail->Password = 'tdxytcpjqcrripgu'; // Your Gmail password or app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('projectsbydora@gmail.com', 'DORA Contact Form'); // Set "From" email and name
        $mail->addAddress('projectsbydora@gmail.com'); // Destination email address
        $mail->isHTML(true);
        $mail->Subject = 'DORA Contact Form Submission';
        $mail->Body = $fullMessage; // Use the concatenated message

        $mail->send();
        echo '<body class="body-container">
        <div class="message-box">
        Thank you for your message. We will get back to you soon!
        </div>                    
        </body>
        ';
        echo '<div class="d-flex justify-content-center">
        <a href="contact.php" class="btn btn-outline-dark px-4 py-2 fs-7 mt-4">Contact Us</a>
        </div>';
    } catch (Exception $e) {
        echo '<div class="message-box">
        Oops! Something went wrong. Please try again later. Error: {$mail->ErrorInfo}
        </div>';
    }
}
?>
    
</body>
</html>