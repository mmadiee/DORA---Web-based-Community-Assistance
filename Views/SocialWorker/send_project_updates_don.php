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
            text-align: center; /* Center align the content in the container */
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
            margin-top: 20px; /* Add space above the button */
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>$subject</h1>
        </div>
        <div class='message'>
            <p>{$_POST["message"]}</p>
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

    $mail->Body = $message;

    // Retrieve the project ID from the form
    $don_project_id = $_POST["don_project_id"];


    $sql = "SELECT DISTINCT dv.email
            FROM tbl_dv_accs AS dv
            INNER JOIN tbl_transaction AS t ON dv.user_id = t.user_id
            WHERE t.don_project_id = ? 
            AND t.stat = 'verified'"; // Only check the transaction status

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $don_project_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $recipients = array();
    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row['email'];
    }

    // Loop through the recipients and add them to the email
    foreach ($recipients as $recipient) {
        $mail->addAddress($recipient);
    }

    // Send the email
    $mail->send();

    echo "
    <script>
    alert('Email Sent Successfully');
    document.location.href = 'donation-details.php?id=$don_project_id';
    </script>
    ";
}

?>
