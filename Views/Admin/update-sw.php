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

    function sendEmailToSocialWorker($email, $subject, $message) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'projectsbydora@gmail.com';
        $mail->Password = 'tdxytcpjqcrripgu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('projectsbydora@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        try {
            if ($mail->send()) {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Social Worker status updated and email sent.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location = 'socialworkers.php';
                });
                </script>";
            } else {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Email could not be sent. Please try again.',
                    showConfirmButton: false,
                    timer: 2000
                });
                </script>";
            }
        } catch (Exception $e) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Email could not be sent. Please try again.',
                showConfirmButton: false,
                timer: 2000
            });
            </script>";
        }
    }

    if (isset($_POST['sw_id'])) {
        $sw_id = $_POST['sw_id'];

        if (isset($_POST['invalid'])) {
            $sql7 = "UPDATE tbl_sw_accs SET status = 'Invalid' WHERE sw_id = ?";
            $stmt7 = mysqli_prepare($conn, $sql7);
            mysqli_stmt_bind_param($stmt7, "i", $sw_id);
            mysqli_stmt_execute($stmt7);
            mysqli_stmt_close($stmt7);

            $sql = "SELECT * FROM tbl_sw_accs WHERE sw_id = $sw_id";
            $result = mysqli_query($conn, $sql);

            $subject = "";
            $message = "";

            while ($row = mysqli_fetch_array($result)) {
                $email = $row['email'];
                $fname = $row['fname'];
                $status = $row['status'];
                if ($status == 'Invalid') {
                    $subject = 'Invalid Account';
                    $message = "
                        <body style='font-family: Arial, sans-serif; background-color: #f2f2f2;'>
                            <div style='background-color: #ffffff; padding: 20px; text-align: center;'>
                                <div style='background-color: #007bff; color: #ffffff; padding: 10px; text-align: center;'>
                                    <h1>Your Account Update</h1>
                                </div>
                                <div style='padding: 20px; text-align: center;'>
                                    <p>Dear $fname, your application for a DORA Social Worker Account has been Denied.</p>
                                    <p>You can visit our website for more information.</p>
                                </div>
                                <div style='margin-top: 20px; text-align: center;'>
                                    <a href='https://projectsbydora.com' style='background-color: #007bff; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; color: #ffffff;'>
                                        Visit Our Website
                                    </a>
                                </div>
                            </div>
                        </body>
                    ";
                }
            }

            sendEmailToSocialWorker($email, $subject, $message);
        } elseif (isset($_POST['verify'])) {
            $sql8 = "UPDATE tbl_sw_accs SET status = 'Verified' WHERE sw_id = ?";
            $stmt8 = mysqli_prepare($conn, $sql8);
            mysqli_stmt_bind_param($stmt8, "i", $sw_id);
            mysqli_stmt_execute($stmt8);
            mysqli_stmt_close($stmt8);

            $sql = "SELECT * FROM tbl_sw_accs WHERE sw_id = $sw_id";
            $result = mysqli_query($conn, $sql);

            $subject = "";
            $message = "";

            while ($row = mysqli_fetch_array($result)) {
                $email = $row['email'];
                $fname = $row['fname'];
                $status = $row['status'];
                if ($status == 'Verified') {
                    $subject = 'Verified Account';
                    $message = "
                        <body style='font-family: Arial, sans-serif; background-color: #f2f2f2;'>
                            <div style='background-color: #ffffff; padding: 20px; text-align: center;'>
                                <div style='background-color: #007bff; color: #ffffff; padding: 10px; text-align: center;'>
                                    <h1>Your Account Update</h1>
                                </div>
                                <div style='padding: 20px; text-align: center;'>
                                    <p>Dear $fname, your application for a DORA Social Worker Account has been Verified.</p>
                                    <p>You can visit our website for more information.</p>
                                </div>
                                <div style='margin-top: 20px; text-align: center;'>
                                    <a href='https://projectsbydora.com' style='background-color: #007bff; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; color: #ffffff;'>
                                        Visit Our Website
                                    </a>
                                </div>
                            </div>
                        </body>
                    ";
                }
            }

            sendEmailToSocialWorker($email, $subject, $message);
        }

        mysqli_close($conn);
    } else {
        echo "Invalid request";
        exit;
    }
    ?>

</body>
</html>
