<!DOCTYPE html>
<html>
<head>
    <!-- Include SweetAlert CSS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet"></head>
<body>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'projectsbydora@gmail.com';
    $mail->Password = 'tdxytcpjqcrripgu';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('projectsbydora@gmail.com');

    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);

    $mail->Subject = $_POST["subject"];
    $message = "<html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                text-align: center;
            }
            .container {
                background-color: #ffffff;
                padding: 20px;
                display: inline-block;
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
                color: #ffffff;
            }
            .btn {
                background-color: #007bff;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>{$_POST["subject"]}</h1>
            </div>
            <div class='message'>
                <p>{$_POST["message"]}</p>
            </div>
            <div class='button'>
                <a href='https://projectsbydora.com' class='btn' style='color: #ffffff;'>
                    Visit Our Website
                </a>
            </div>
        </div>
    </body>
    </html>";

    $mail->Body = $message;

    if ($mail->send()) {
        // If the email was sent successfully, trigger a SweetAlert message
        echo '
            <script>
                Swal.fire({
                    title: "Email Sent",
                    text: "Email successfully sent!",
                    icon: "success",
                    confirmButtonColor: "#007bff",
                    timer: 2000, // Automatically close the alert after 2 seconds
                }).then(function () {
                    window.location.href = "socialworkers.php";
                });
            </script>';
    }
}
?>
</body>
</html>