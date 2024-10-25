<?php

include 'includes/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])){
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
    $message = "
    <html>
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
                text-align: center; /* Center the message text */
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
    </html>
    ";

    $mail->Body = $message;
    $mail->send();

    echo 
    "
    <script>
    document.location.href = 'current_donation.php';
    </script>
    ";
}

?>
