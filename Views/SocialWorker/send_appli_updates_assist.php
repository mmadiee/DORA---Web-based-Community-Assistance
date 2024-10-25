<?php

include 'includes/config.php';

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
    $mail->isHTML(true);
    $mail->Subject = $_POST["subject"];

    // Get the message content based on the selected user status
    $selectedStatus = $_POST["status"];
    $assistance_id = $_POST["assistance_id"];

    if ($selectedStatus === 'Verified') {
        $message = "Good Day! You are now a beneficiary for the project: " . $_POST["title"] . ". The QR Code is now available at your designated DORA Account. See you soon!";
    } elseif ($selectedStatus === 'Invalid') {
        $message = "Good Day. Your application for project: " . $_POST["title"] . " has been marked as Invalid.\n\nYou can visit our website for more information.";
    } else {
        $message = "Enter Message";
    }

    $emailRecipients = getEmailRecipients($assistance_id, $selectedStatus, $conn);

    if ($emailRecipients) {
        foreach ($emailRecipients as $recipient) {
            $mail->addAddress($recipient);
        }

        $mail->Body = generateEmailBody($_POST["subject"], $message);

        // Send the email
        $mail->send();

        echo "
        <script>
        alert('Email Sent Successfully');
        document.location.href = 'assistance-details.php?id=$assistance_id';
        </script>
        ";
    } else {
        echo "No recipients found for the selected status.";
    }
}

// Function to retrieve email recipients based on assistance ID and status
function getEmailRecipients($assistance_id, $selectedStatus, $conn) {
    $sql = "SELECT DISTINCT dv.email
            FROM tbl_appli_accs AS dv
            INNER JOIN tbl_applicants AS t ON dv.appli_id = t.appli_id
            WHERE t.assistance_id = ? 
            AND t.stat = ?"; 

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $assistance_id, $selectedStatus);
    $stmt->execute();
    $result = $stmt->get_result();

    $recipients = array();
    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row['email'];
    }

    return $recipients;
}

// Function to generate the email body
function generateEmailBody($subject, $message) {
    return "
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
            }
            .button {
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
            <h1>$subject</h1>
            </div>
            <div class='message'>
            <p>$message</p>
            </div>
            <div class='button'>
                <a href='https://projectsbydora.com' style='text-decoration: none;'>
                    <button style='background-color: #007bff; color: #fff; padding: 10px 20px; border: none; cursor: pointer;'>
                        Visit Our Website
                    </button>
                </a>
            </div>
        </div>
    </body>
    </html>
    ";
}
?>
